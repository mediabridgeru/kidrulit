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
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  	<h1 class="article-title-boss"><?php echo $heading_title; ?></h1> 
  	<div class="boss_article-detail">
  	<div class="date-post">
		<small class="time-stamp">
			<?php $date = new DateTime($date_modified);?>
			<?php echo $date->format('l, M j, Y');?>
		</small>
		<span class="separator">|</span>
		<span class="post-by"> Post by <span><?php echo $author; ?></span></span>
		<span class="separator">|</span>
		<span class="comment-count"><span><?php echo $comments; ?></span> comment(s)</span>
	</div>
    	<div class="article-content"><?php echo $content;?></div>
        <div class="boss_article-action">			
            	<?php if ($tags) { ?>
	  	<div class="tags"><span><?php echo $text_tags; ?>: </span>
	  	<ul>
			<?php for ($i = 0; $i < count($tags); $i++) { ?>
			<?php if ($i < (count($tags) - 1)) { ?>
			<li class="item"><a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a></li>
			<?php } else { ?>
			<li class="item"><a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a></li>
			<?php } ?>
			<?php } ?>
	  	</ul>
	  	</div>
		<?php } ?>
            	<div class="article-share">
                        <div class="share"><!-- AddThis Button BEGIN -->
                      	<div class="addthis_default_style"><a class="addthis_button_compact"><?php echo $text_share; ?></a> <a class="addthis_button_email"></a><a class="addthis_button_print"></a> <a class="addthis_button_facebook"></a> <a class="addthis_button_twitter"></a></div>
                       	<script type="text/javascript" src="//s7.addthis.com/js/250/addthis_widget.js"></script> 
                       	<!-- AddThis Button END --> 
                    	</div>
                </div>
	</div>	
    <?php if ($articles) { ?> 
    	<div class="article-related boss_article-items">
            <h3 class="form-title"><?php echo $article_related; ?></h3>
			<div class="carousel-button">
				 <a id="prev_blog_related" class="prev nav_thumb" href="javascript:void(0)" title="prev">Prev</a>
				<a id="next_blog_related" class="next nav_thumb" href="javascript:void(0)" title="next">Next</a>
			</div>
         	<div class="list_carousel responsive" >
		    <ul id="blog_article" class="box-product article-grid">
                   <?php foreach ($articles as $article) { ?> 
                       <li><div class="boss_article-item">
                       	<div class="article-image"><a href="<?php echo $article['href']; ?>"><img src="<?php echo $article['thumb']; ?>" title="<?php echo $article['name']; ?>" alt="<?php echo $article['name']; ?>" /><b></b></a></div>		
			<div class="article-name"><h2><a href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a></h2></div>
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

		  	</div></li>
                   <?php } ?> 
        	</ul>
		   
        	</div>
    	</div>
    <?php } ?>
	<?php if ($products) { ?>
  	<div id="tab-related" >
   		<h2 class="ta-related"><span><?php echo $text_product_related; ?> (<?php echo count($products); ?>)</span></h2>
		<div class="carousel-button">
			<a id="prev_related" class="prev nav_thumb" href="javascript:void(0)" title="prev">Prev</a>
			<a id="next_related" class="next nav_thumb" href="javascript:void(0)" title="next">Next</a>
		</div>
	  	<div class="list_carousel responsive product-grid" >
			<ul id="product_related" class="box-product"><?php foreach ($products as $product) { ?><li><div class="relt_product">
		  		<?php if ($product['thumb']) { ?>
				<div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /><b></b></a></div>
				<?php } ?>
				   
				 <?php if ($product['rating']) { ?>
				<div class="rating"><img src="catalog/view/theme/bt_kidparadise_baby/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
				<?php } ?>
				
				<div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
					
				<?php if ($product['price']) { ?>
				<div class="price">
			  		<?php if (!$product['special']) { ?>
				  		<?php echo $product['price']; ?>
			  		<?php } else { ?>
				 		<span class="price-new"><?php echo $product['special']; ?></span>  <span class="price-old"><?php echo $product['price']; ?></span>
			  		<?php } ?>
				</div>	
				<?php } ?></div></li><?php } ?></ul>
		
		</div>
  	</div>
  	<?php } ?>
    	<?php if ($allow_comment!=0) { ?>
   	    <?php if ($comment_status==1||$allow_comment==1) {?>
        <div class="comments">
        <div id="article-comments"></div> 
                <div class="form-comment-container">
                	<span id="new"><h3><?php echo $text_comment; ?> </h3></span>       
                	<div id="0_comment_box" class="form-comment">
            	  	<?php if(!$login){?>
        		  	<div class="field" id="username">
        			  	<label class="required" for="name"><?php echo $text_username; ?><em>*</em></label>
        			  	<div class="input-box">
        				  	<input type="text" class="input-text required-entry" value="" title="Name" id="name" name="username">
        			  	</div>
					</div>
		  	        <div class="field" class="email_blog">
			  	        <label class="required" for="email"><?php echo $text_email; ?><em>*</em></label>
    			  	    <div class="input-box">
            				  <input type="text" class="input-text required-entry validate-email" value="" title="Email" id="email" name="email_blog">
    			  	    </div>
    		  	    </div>
            	  	<?php } else{ ?>
                                <input type="hidden" class="input-text required-entry" value="<?php echo $username; ?>" title="Name" id="name" name="username">
                                <input type="hidden" class="input-text required-entry validate-email" value="<?php echo $email; ?>" title="Email" id="email" name="email_blog">
                  	<?php } ?>
  		            <div class="input-box">
		  		        <label class="required" for="comment"><?php echo $entry_comment; ?><em>*</em></label>
            		  	<textarea rows="2" cols="10" class="required-entry input-text" style="height:110px" title="Comment" id="comment" name="comment_content"></textarea>
            	  	</div>
                    	  
            	  	<?php if($capcha){?>
                  	<div class="captcha">
                        <img src="index.php?route=product/product/captcha" alt="" id="captcha" /><br />
                        <input type="text" name="captcha" value="" />
                        <label class="required-1 " for="recaptcha"><?php echo $text_required?><em>*</em></label>
            	  	</div>
                  	<?php }?>
                    <div class="left"><a id="button-comment" class="btn btn-primary"><span><?php echo $button_continue; ?></span></a></div>
            	  	</div>
    	   	</div>
     	</div>
     	<?php } } ?>        
	</div>
<?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
$('#article-comments .pagination a').live('click', function() {
	$('#article-comments').fadeOut('slow');
		
	$('#article-comments').load(this.href);
	
	$('#article-comments').fadeIn('slow');
	
	return false;
});	

$('#article-comments').load('index.php?route=bossblog/article/comment&blog_article_id=<?php echo $blog_article_id; ?>');

$('#button-comment').bind('click', function() {
	$.ajax({
		url: 'index.php?route=bossblog/article/write&blog_article_id=<?php echo $blog_article_id; ?>&need_approval=<?php echo $need_approval; ?>&approval_status=<?php echo $approval_status; ?>',
		type: 'post',
		dataType: 'json',
		data: 'username=' + encodeURIComponent($('input[name=\'username\']').val()) + '&comment_content=' + encodeURIComponent($('textarea[name=\'comment_content\']').val()) + '&email=' + encodeURIComponent($('input[name=\'email_blog\']').val()) + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-comment').attr('disabled', true);
			$('#new').after('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-comment').attr('disabled', false);
			$('.attention').remove();
		},
		success: function(data) {
			if (data['error']) {
				$('#new').after('<div class="warning">' + data['error'] + '</div>');
			}
			
			if (data['success']) {
				$('#new').after('<div class="success">' + data['success'] + '</div>');
				$('#article-comments').load('index.php?route=bossblog/article/comment&blog_article_id=<?php echo $blog_article_id; ?>');				
				$('input[name=\'username\']').val('');
				$('textarea[name=\'comment_content\']').val('');
				$('input[name=\'email_blog\']').val('');
                $('input[name=\'captcha\']').val('');
			}
		}
	});
});

$(window).load(function(){	
	$('#product_related').carouFredSel({
        auto: false,
        responsive: true,
        width: '100%',
		height: 'variable',
        prev: '#prev_related',
        next: '#next_related',
        swipe: {
        onTouch : true
        },
        items: {
            width: 300,
            height: 'auto',
            visible: {
            min: 1,
            max: 3
            }
        },
        scroll: {
            direction : 'left',    //  The direction of the transition.
            duration  : 1000   //  The duration of the transition.
        }
    });

	$('#blog_article').carouFredSel({
        auto: false,
        responsive: true,
        width: '100%',
		height:'variable',
        prev: '#prev_blog_related',
        next: '#next_blog_related',
        swipe: {
        onTouch : true
        },
        items: {
            width: 300,
			height:'auto',
            visible: {
            min: 1,
            max: 3
            }
        },
        scroll: {
            direction : 'left',    //  The direction of the transition.
            duration  : 1000   //  The duration of the transition.
        },
    });
});	
//--></script> 
<?php echo $footer; ?>