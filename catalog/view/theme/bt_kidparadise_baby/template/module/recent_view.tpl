<?php if (!empty($products)) { ?> 

<div class="box box-recent" id="recent-<?php echo $module; ?>">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="box-content">
    <div class="box-product">
      <?php foreach ($products as $key => $product) { ?><div class="col-xs-24 col-sm-8 col-md-6 col-lg-6 not-animated" data-prodid="<?php echo $product['product_id']; ?>" >       
      <?php if ($product['thumb']) { ?>
        <div class="image"><a href="<?php echo $product['href']; ?>"><b></b><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a>
		<div class="cart">
			<span class="btn btn-color">
				<input type="button" title="<?php echo $button_cart; ?>" value="<?php echo $button_cart; ?>" onclick="boss_addToCart('<?php echo $product['product_id']; ?>');" class="button"  />
			</span>
		</div>
		<?php echo $product['stickers']; ?>
		</div>
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
        <?php } ?>
      </div><?php } ?>
   	  
	<?php if($limit < $number_product){ ?>
		<div id="recent_view_more" class="prod-load-more">
			<a onclick="loadMoreProduct2(<?php echo $limit; ?>,<?php echo $module; ?>)" href="javascript:void(0)" class="btn btn-color">
				<?php echo $text_show_more; ?>
			</a>
		</div>
	<?php } ?>
	</div>
	</div>
	<div class="loading_recent" style="position:absolute;bottom:12px;left:50%"></div>
</div>
<script type="text/javascript"><!--
function loadMoreProduct2(count, module){

	$.ajax({
		url: 'index.php?route=module/recent_view/viewMoreProducts&count='+count+'&module='+module,
		dataType: 'json',
		beforeSend: function() {
			$('.loading_recent').html('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},		
		complete: function() {
			$('.loading_recent .wait').remove();
		},
		success: function(json) {
			$('#recent_view_more').remove();
			$('#recent-'+module+' .box-product').append(json['html']).show('slow');
			if ( typeof boss_quick_shop == 'function' ) { 
				boss_quick_shop();
			}
		}
	});
}
//--></script>
<?php } ?>
