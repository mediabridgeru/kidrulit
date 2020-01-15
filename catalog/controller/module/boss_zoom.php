<?php
class ControllerModuleBossZoom extends Controller {
	protected function index($setting) {
		if($setting['status']){
			$this->load->language('module/boss_zoom');

			$this->data['text_view_zoom'] = $this->language->get('text_view_zoom');
			
			$this->data['status'] = $setting['status']; 
			$this->data['thumb_image_width'] = $setting['thumb_image_width']; 
			$this->data['thumb_image_heigth'] = $setting['thumb_image_heigth']; 
			$this->data['zoom_image_width'] = $setting['zoom_image_width']; 
			$this->data['zoom_image_heigth'] = $setting['zoom_image_heigth']; 
			$this->data['zoom_area_width'] = $setting['zoom_area_width']; 
			$this->data['zoom_area_heigth'] = $setting['zoom_area_heigth']; 
			$this->data['addition_image_width'] = $setting['addition_image_width']; 
			$this->data['addition_image_heigth'] = $setting['addition_image_heigth']; 
			$this->data['position_zoom_area'] = $setting['position_zoom_area']; 
			$this->data['adjustX'] = $setting['adjustX']; 
			$this->data['adjustY'] = $setting['adjustY']; 
			$this->data['title_image'] = $setting['title_image']; 
			$this->data['title_opacity'] = $setting['title_opacity']; 
			$this->data['tint'] = $setting['tint']; 
			$this->data['tintOpacity'] = $setting['tintOpacity']; 
			$this->data['softfocus'] = $setting['softfocus']; 
			$this->data['lensOpacity'] = $setting['lensOpacity']; 
			$this->data['smoothMove'] = $setting['smoothMove']; 
			
			if (isset($this->request->get['product_id'])) {
				$product_id = (int)$this->request->get['product_id'];
			} else {
				$product_id = 0;
			}
			
			$this->load->model('catalog/product');
			$product_info = $this->model_catalog_product->getProduct($product_id);
			$this->data['heading_title'] = $product_info['name'];

            $this->data['product_stickers'] = $this->getStickers($product_id);
			
			$this->load->model('tool/image');

			//Thumb Image
            if ($product_info['image']) {
                $popup = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
                $thumb = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
                $addition = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height'));
            } else {
                $popup = false;
                $thumb = false;
                $addition = false;
            }

            if (!$popup) {
                $popup = $this->model_tool_image->resize('no_image.jpg', $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
            }
            if (!$thumb) {
                $thumb = $this->model_tool_image->resize('no_image.jpg', $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
            }
            if (!$addition) {
                $addition = $this->model_tool_image->resize('no_image.jpg', $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height'));
            }

            $this->data['popup'] = $popup;
            $this->data['thumb'] = $thumb;

            $this->data['images'] = array();

            $results = $this->model_catalog_product->getProductImages($product_id);

            //addition image
            if ($product_info['image']) {
                $this->data['images'][] = array(
                    'popup' => $popup,
                    'addition' => $addition,
                    'thumb' => $thumb
                );
            }

            foreach ($results as $result) {
                if ($result['image']) {
                    $popup = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
                    $thumb = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
                    $addition = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height'));
                } else {
                    $popup = false;
                    $thumb = false;
                    $addition = false;
                }

                if (!$popup) {
                    $popup = $this->model_tool_image->resize('no_image.jpg', $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
                }
                if (!$thumb) {
                    $thumb = $this->model_tool_image->resize('no_image.jpg', $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
                }
                if (!$addition) {
                    $addition = $this->model_tool_image->resize('no_image.jpg', $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height'));
                }

                $this->data['images'][] = array(
                    'popup' => $popup,
                    'addition' => $addition,
                    'thumb' => $thumb
                );
            }
		}
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/boss_zoom.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/boss_zoom.tpl';
		} else {
			$this->template = 'default/template/module/boss_zoom.tpl';
		}

		$this->render();
	}

    private function getStickers($product_id) {

        $stickers = $this->model_catalog_product->getProductStickerbyProductId($product_id) ;

        if (!$stickers) {
            return;
        }

        $this->data['stickers'] = array();

        foreach ($stickers as $sticker) {
            $this->data['stickers'][] = array(
                'position' => $sticker['position'],
                'image'    => HTTP_SERVER . 'image/' . $sticker['image']
            );
        }


        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/stickers.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/product/stickers.tpl';
        } else {
            $this->template = 'default/template/product/stickers.tpl';
        }

        return $this->render();

    }
}
?>