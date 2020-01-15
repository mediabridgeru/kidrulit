<?php foreach ($products as $key => $product) { ?><div class="col-xs-24 col-sm-8 col-md-6 col-lg-6">
<?php if ($product['thumb']) { ?>
<div class="image"><a href="<?php echo $product['href']; ?>"><b></b><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a>
<?php if ($product['price'] && $product['special']) { ?>
	<span class="boss-label"><img  alt="label"  src="catalog/view/theme/bt_kidparadise/image/new.png" /></span>	 
<?php } ?>
<div class="cart"><span class="btn btn-color"><input type="button" title="<?php echo $button_cart; ?>" value="<?php echo $button_cart; ?>" onclick="boss_addToCart('<?php echo $product['product_id']; ?>');" class="button"  /></span></div>
</div>
<?php } ?>
<?php if ($product['rating']) { ?>
<div class="rating"><img src="catalog/view/theme/bt_kidparadise/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
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
<?php } ?>
</div><?php } ?>
<?php if($limit < $number_product){ ?>
	<div id="boss_show_more" class="prod-load-more"><a onclick="loadMoreProduct(<?php echo $limit; ?>,<?php echo $module; ?>)" href="javascript:void(0)" class="btn btn-color"><?php echo $text_show_more; ?></a></div>
<?php } ?>
