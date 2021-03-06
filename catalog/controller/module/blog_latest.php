<?php
class ControllerModuleBlogLatest extends Controller {
	protected function index($setting) {
		$this->language->load('module/blog_latest');
		
      	$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_views'] = $this->language->get('text_views');
				
		$this->load->model('blog/article');
		
		$this->load->model('tool/image');
		
		$this->data['articles'] = array();
		
		$data = array(
			'sort'  => 'p.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => $setting['limit']
		);
		
		if ($setting['text_limit'] > 0) {
			$text_limit = $setting['text_limit'];
		} else {
			$text_limit = 50;
		}

		$results = $this->model_blog_article->getArticles($data);

        $imagewidth = $setting['image_width'];
        $imageheight = $setting['image_height'];

		foreach ($results as $result) {
            if ($result['image']) {
                $image = $this->model_tool_image->resize($result['image'], $imagewidth, $imageheight);
            } else {
                $image = false;
            }

            if (!$image) {
                $image = $this->model_tool_image->resize('no_image.jpg', $imagewidth, $imageheight);
            }

			if (($this->config->get('config_blog_review_status'))and($result['article_review']==1)) {
				$rating = (int)$result['rating'];
			} else {
				$rating = false;
			}
			
			$this->data['articles'][] = array(
				'article_id' => $result['article_id'],
				'thumb'   	 => $image,
				'name'    	 => $result['name'],
				'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $text_limit) . '',
				'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'viewed'      => $result['viewed'],
				'rating'     => $rating,
				'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
				'href'    	 => $this->url->link('blog/article', 'article_id=' . $result['article_id']),
			);
		}

		if ((file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/blog_latest.tpl'))and (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/blog_latest_middle.tpl')))     {
			$this->template = $this->config->get('config_template') . '/template/module/blog_latest.tpl';
			
			if (($setting['position']=='content_top') or ($setting['position']=='content_bottom'))  {$this->template = $this->config->get('config_template') . '/template/module/blog_latest_middle.tpl';};
			
		
		} else {
			$this->template = 'default/template/module/blog_latest.tpl';
		}

		$this->render();
	}
}
?>