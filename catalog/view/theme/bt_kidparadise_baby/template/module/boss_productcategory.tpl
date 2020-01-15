<?php if(!empty($tab)){ ?>
<div id="boss_productcategory_tabs<?php echo $module; ?>" class="boss_productcategory_tabs " >
  <div class="box-content">
    <h3><?php echo $tab['title']; ?></h3>	
		<div class="carousel-button">
		<?php if ($use_scrolling_panel) { ?>
			<a id="prev_tab<?php echo $module; ?>" class="prev" title="<?php echo isset($title_left) ? $title_left : ""; ?>">&lt;</a>
			<a id="next_tab<?php echo $module; ?>" class="next" title="<?php echo isset($title_right) ? $title_right : ""; ?>">&gt;</a>
		<?php } ?>
	</div>
    <div class="content_tabs list_carousel responsive" id="content_tab<?php echo $module; ?>">
		<?php if(!empty($tab['products'])){ ?>
			<ul  class="box-product product-grid not-animated" data-animate="fadeInLeft" data-delay="<?php echo 200; ?>" id="carousel_tab<?php echo $module; ?>" >
			<?php foreach ($tab['products'] as $key => $product) { ?><li data-prodid="<?php echo $product['product_id']; ?>">
				<?php if ($product['thumb']) { ?>
				<div class="image">
				<a href="<?php echo $product['href']; ?>"><b></b><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"/></a>
				<?php if ($product['price'] && $product['special']) { ?>
					<span class="boss-label"><img src="catalog/view/theme/bt_kidparadise_baby/image/new.png" alt="label"/></span>	 
				<?php } ?>
				<div class="cart">
				<a title="<?php echo $button_cart; ?>" onclick="boss_addToCart('<?php echo $product['product_id']; ?>');" class="btn btn-color"><span><?php echo $button_cart; ?></span></a></div>	
				
				</div>
				<?php } ?>
				<?php if ($product['rating']) { ?>
				<div class="rating"><img src="catalog/view/theme/<?php echo $template; ?>/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
				<?php } ?>
				<div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
				<div class="model"><?php echo $product['model']; ?></div>
				<?php if ($product['price']) { ?>
				<div class="price">
				  <?php if (!$product['special']) { ?>
				  <?php echo $product['price']; ?>
				  <?php } else { ?>
				 <span class="price-new"><?php echo $product['special']; ?></span>  <span class="price-old"><?php echo $product['price']; ?></span> 
				  <?php } ?>
				</div>
				<?php } ?></li><?php } ?></ul>
		<?php } ?>
    </div>
  </div>
</div>
<?php if ($use_scrolling_panel) { ?>
<script type="text/javascript"><!--
function image_width_resize<?php echo $module; ?>()	{
	<?php if(isset($tab['image']) && $tab['image'] != false) { ?>
		var width = $('#boss_productcategory_tabs<?php echo $module; ?> .box-content').outerWidth();
		var width_content = width - <?php echo $image_width; ?> - 65;
		$('#content_tab<?php echo $module; ?>').css("width", width_content);
		$('#content_tab<?php echo $module; ?>').css("float", "left");
		$('#content_tab<?php echo $module; ?>').css("clear", "none");
	<?php } ?>
}

$(window).resize(function() {
	image_width_resize<?php echo $module; ?>();
});

$(window).load(function() {
	image_width_resize<?php echo $module; ?>();
	//resize_width();
	$('#carousel_tab<?php echo $module; ?>').carouFredSel({
		responsive: true,
		width: '100%',
		height: 'variable', 
		prev: '#prev_tab<?php echo $module; ?>',
		next: '#next_tab<?php echo $module; ?>',
		auto: false,
		swipe: {
				onTouch : true
			},
		items: {
				width: 290 ,
				height: 'auto', 
				visible: {
					min: 1,
					max: 4
				}
			},
		scroll: {
				direction : 'left',    //  The direction of the transition.
				duration  : 900   //  The duration of the transition.
			}
	});	
});

//--></script>
<?php } ?>
<?php } ?>