<?php if ($products) { ?>
<div class="box">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="box-content">
    <div class="box-product" id="recent_view_<?php echo $module; ?>">
	<?php if ($display_type == 'list') { ?> 
		  <ul class="recent_view_list">
		  <?php foreach ($products as $product) { ?>
			<li>
			   <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a> - 
			   <?php if (!$product['special']) { ?>
				  <?php echo $product['price']; ?>
			  <?php } else { ?>
				 <?php echo $product['special']; ?>
			  <?php } ?>
			</li>
		  <?php } ?>
		  </ul>
	<?php } else { ?>
				<?php foreach ($products as $product) { ?>
				  <div>
					<?php if ($product['thumb']) { ?>
					<div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
					<?php } ?>
					<div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
					<?php if ($product['price']) { ?>
					<div class="price">
					  <?php if (!$product['special']) { ?>
					  <?php echo $product['price']; ?>
					  <?php } else { ?>
					  <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
					  <?php } ?>
					</div>
					<?php } ?>
					<div class="cart"><a onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button"><span><?php echo $button_cart; ?></span></a></div>
				  </div>
				<?php } ?>
    <?php } ?>	
    </div>
  </div>
</div>
<?php } ?>


<?php if ($display_type == 'fade'){  ?>
<script type="text/javascript">
  $(document).ready(function(){
    $('#recent_view_<?php echo $module; ?>').bxSlider({
		mode: 'fade',
		infiniteLoop: true,
		controls: false,
		auto: true,
		autoHover: true,
	});
  });
</script>
<?php } ?>

