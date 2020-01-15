<?php echo $header; ?>
<div class="col-xs-24 col-sm-24 col-md-24">
	<div    id="breadcrumb">	
	<?php $i = 1; $count = count($breadcrumbs);  ?>
	<b></b>
	<?php foreach ($breadcrumbs as $breadcrumb) { ?>
	<a class="<?php if($i==$count){echo 'breadcrumb_last';} else if($i==$count-1){echo 'breadcumb_middle';} else{echo 'breadcumb_first';} ?>" href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
	<?php $i++; } ?>
	</div>	
</div>
<?php echo $column_left; ?>
<?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
    <h1><?php echo $heading_title; ?></h1>
    <?php if ($articles) { ?>
        <div class="article-filter grid-100">  
        <div class="rss-feed">
            <a href="<?php echo $link_rss; ?>" title='RSS'><img src='catalog/view/theme/<?php echo $this->config->get('config_template'); ?>/image/bossblog/rss.png' alt='Subscribe' /></a>
        </div>          
           
			<div class="sort"><b><?php echo $text_sort; ?></b>
				<label class="select">
			  <select onchange="location = this.value;">
				<?php foreach ($sorts as $sorts) { ?>
				<?php if ($sorts['value'] == $sort . '-' . $order) { ?>
				<option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
				<?php } ?>
				<?php } ?>
			  </select>
			  </label>
			</div>
			 <div class="limit"><b><?php echo $text_limit; ?></b>
			 	<label class="select">
			  <select onchange="location = this.value;" >
				<?php foreach ($limits as $limits) { ?>
				<?php if ($limits['value'] == $limit) { ?>
				<option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
				<?php } ?>
				<?php } ?>
			  </select>
			  </label>
			</div>
			<div class="display"><b><?php echo $text_display; ?></b> <?php echo $text_list; ?> <a onclick="display('grid');"><?php echo $text_grid; ?></a></div>
          </div>
           
        <div class="boss_article-items">
            <div class="article-list">
                <?php foreach ($articles as $key => $article) { ?><div class="boss_article-item<?php if(($key+1)%2 == 0){echo ' last';} ?> " >
				<div class="row not-animated" data-animate="fadeInUp" data-delay="<?php echo $key*50+100; ?>" >
                    
                    <div class="article-image"><a href="<?php echo $article['href']; ?>"><img src="<?php echo $article['thumb']; ?>" title="<?php echo $article['name']; ?>" alt="<?php echo $article['name']; ?>" /><b></b></a></div>
                    <div class="std">					
    					<div class="article-name">
                        <h2><a href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a></h2>                    
                    </div>
    					<div class="time-stamp">
                            <?php $date = new DateTime($article['date_modified']);?>
                            <small><?php echo $date->format('l, M j, Y');?></small>
                        </div>
                        <div class="article-title"><p><?php  echo $article['title']; ?></p></div>
    					<div class="article-footer">
                            <span class="post-by"> Post by <span><?php echo $article['author']; ?></span></span>
							<span class="separator">|</span>
        					<span class="comment-count"><span><?php echo $article['comment']; ?> </span><a href="<?php echo $article['href']; ?>">Comment(s)</a></span>                 
                        </div>
                    </div>
                    
                </div></div><?php } ?></div>
        </div>
        <div class="pagination"><?php echo $pagination; ?></div>  
    <?php } else { ?>
      <div class="content"><?php echo $text_empty; ?></div>
    <?php }?>
    
<?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
function display(view) {
	if (view == 'list') {
		$('.article-grid').attr('class', 'article-list');
		
		$('.article-list > div > div').each(function(index, element) {
            html = '';

			html += '  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-24" > ';
            html += '  <div class="article-image">' + $(element).find('.article-image').html() + '</div>';
			html += '</div>';
			
			html += '<div class="std col-lg-18 col-md-18 col-sm-18 col-xs-24">';
            html += '  <div class="article-name">' + $(element).find('.article-name').html() + '</div>';
			html += '  <div class="time-stamp">' + $(element).find('.time-stamp').html() + '</div>';		
			html += '  <div class="article-title">' + $(element).find('.article-title').html() + '</div>';
			html += '  <div class="article-footer">' + $(element).find('.article-footer').html() + '</div>';
				
			html += '</div>';

						
			$(element).html(html);
		});	

		$('.display').html('<b><?php echo $text_display; ?></b><a title="<?php echo $text_grid; ?>" class="no-active-gird" onclick="display(\'grid\');"><?php echo $text_grid; ?></a><span class="active-list"><?php echo $text_list; ?> </span>');
		
		$.totalStorage('display', 'list'); 
	} else {
		$('.article-list').attr('class', 'article-grid');
		
		$('.article-grid > div > div').each(function(index, element) {
			html = '';
			
			html += '<div class="article-image">' + $(element).find('.article-image').html() + '</div>';
			html += '<div class="article-name">' + $(element).find('.article-name').html() + '</div>';
            html += '  <div class="time-stamp">' + $(element).find('.time-stamp').html() + '</div>';
            html += '  <div class="article-title">' + $(element).find('.article-title').html() + '</div>';
            html += '  <div class="article-footer">' + $(element).find('.article-footer').html() + '</div>';
			
			$(element).html(html);
		});
		
		$('.display').html('<b><?php echo $text_display; ?></b><span class="active-gird"><?php echo $text_grid; ?></span><a title="<?php echo $text_list; ?>" class="no-active-list" onclick="display(\'list\');"><?php echo $text_list; ?></a>');
		
		$.totalStorage('display', 'grid');
	}
}

view = $.totalStorage('display');

if (view) {
	display(view);
} else {
	display('list');
}

if(getWidthBrowser() < 767){
  display('grid');
}
$(".boss_select").selectbox();
//--></script> 
<?php echo $footer; ?>