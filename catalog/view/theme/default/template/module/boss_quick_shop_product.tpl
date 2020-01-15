<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
</div>
<div class="modal-body">
<div id="notification"></div>
<div id="content">
  <div class="row">
  <div class="product-info-qs product-info">
    <?php if ($thumb || $images) { ?>
    <div class="col-lg-13 col-md-13 col-sm-24 col-xs-24">
	<?php if ($thumb) { ?>
	<div class="image"><a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="cloud-zoom" id='zoom1' rel=""><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" /></a>			
	</div>
	<?php } ?>	
	<?php if ($images) { ?>
		<ul id="boss-qs-image-additional">
        <?php foreach ($images as $image) { ?>
        <li><a  href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="cloud-zoom-gallery" rel="useZoom: 'zoom1', smallImage: '<?php echo $image['thumb']; ?>' "><img src="<?php echo $image['addition']; ?>"  title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></li>
        <?php } ?>
		</ul>
	<?php } ?>
    </div>
    <?php } ?>
    <div class="col-lg-11 col-md-11 col-sm-24 col-xs-24">
	  <h1><?php echo $heading_title; ?></h1>
	   <div class="review">
        <div><img src="catalog/view/theme/<?php echo $this->config->get('config_template'); ?>/image/stars-<?php echo $rating; ?>.png" alt="<?php echo $reviews; ?>" /></div>
      </div>
      <div class="description">
		<span><?php echo $text_stock; ?></span> <b class="stock"><?php echo $stock; ?></b><br />
        <?php if ($manufacturer) { ?>
        <span><?php echo $text_manufacturer; ?></span> <?php echo $manufacturer; ?><br />
        <?php } ?>
        <span><?php echo $text_model; ?></span> <?php echo $model; ?><br />
        <?php if ($reward) { ?>
        <span><?php echo $text_reward; ?></span> <?php echo $reward; ?><br />
        <?php } ?>
        
	  </div>
     
      <?php if ($profiles): ?>
      <div class="profiles options">
          <h2><?php echo $text_payment_profile ?><span class="required"> *</span></h2>          
		  <select class="profiles_sl"name="profile_id">
              <option value=""><?php echo $text_select; ?></option>
              <?php foreach ($profiles as $profile): ?>
              <option value="<?php echo $profile['profile_id'] ?>"><?php echo $profile['name'] ?></option>
              <?php endforeach; ?>
          </select>
          <span id="profile-description"></span>
      </div>
      <?php endif; ?>
      <?php if ($options) { ?>
      <div class="options">
        <h2><?php echo $text_option; ?></h2>
        <?php foreach ($options as $option) { ?>
        <?php if ($option['type'] == 'select') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <div class="title_text"><b><?php echo $option['name']; ?>:</b>
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?></div>
          <select name="option[<?php echo $option['product_option_id']; ?>]">
            <option value=""><?php echo $text_select; ?></option>
            <?php foreach ($option['option_value'] as $option_value) { ?>
            <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
            <?php if ($option_value['price']) { ?>
            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
            <?php } ?>
            </option>
            <?php } ?>
          </select>
        </div>
        <?php } ?>
        <?php if ($option['type'] == 'radio') { ?>
		<div class="boss_check">
		<div class="box-check">
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <p><b><?php echo $option['name']; ?>:</b>
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?></p>
          <?php foreach ($option['option_value'] as $option_value) { ?>
          <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
          <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
            <?php if ($option_value['price']) { ?>
            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
            <?php } ?>
          </label>
          <br />
          <?php } ?>
        </div>
		</div>
        <?php } ?>
        <?php if ($option['type'] == 'checkbox') { ?>
		<div class="box-check">
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <p><b><?php echo $option['name']; ?>:</b>
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?></p>
          <?php foreach ($option['option_value'] as $option_value) { ?>
          <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
          <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
            <?php if ($option_value['price']) { ?>
            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
            <?php } ?>
          </label>
          <br />
          <?php } ?>
        </div>
        </div>
		</div>
       
        <?php } ?>
        <?php if ($option['type'] == 'image') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <div class="title_text"><b><?php echo $option['name']; ?>:</b>
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?></div>
          <table class="option-image">
            <?php foreach ($option['option_value'] as $option_value) { ?>
            <tr>
              <td style="width: 1px;"><input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" /></td>
              <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" /></label></td>
              <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                  <?php if ($option_value['price']) { ?>
                  (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                  <?php } ?>
                </label></td>
            </tr>
            <?php } ?>
          </table>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'text') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <div class="title_text"><b><?php echo $option['name']; ?>:</b>
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?></div>
          <input type="text" class="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" />
        </div>
        <?php } ?>
        <?php if ($option['type'] == 'textarea') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <div class="title_text"><b><?php echo $option['name']; ?>:</b>
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?></div>
          <textarea name="option[<?php echo $option['product_option_id']; ?>]" cols="40" rows="5"><?php echo $option['option_value']; ?></textarea>
        </div>
        <?php } ?>
        <?php if ($option['type'] == 'file') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option button_opt">
          <div class="title_text upload_bt"><b><?php echo $option['name']; ?>:</b>
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?></div>
          <span class="button"><input type="button" value="<?php echo $button_upload; ?>" id="button-option-qs-<?php echo $option['product_option_id']; ?>" class="btn btn-primary"></span>
          <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" />
        </div>
        <?php } ?>
        <?php if ($option['type'] == 'date') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <div class="title_text"><b><?php echo $option['name']; ?>:</b>
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?></div>
          <input type="text" class="text datetime_box" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="date" />
        </div>
        <?php } ?>
        <?php if ($option['type'] == 'datetime') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <div class="title_text"><b><?php echo $option['name']; ?>:</b>
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?></div>
          <input type="text" class="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="datetime" />
        </div>
        <?php } ?>
        <?php if ($option['type'] == 'time') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <div class="title_text"><b><?php echo $option['name']; ?>:</b>
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?></div>
          <input type="text" class="text datetime_box" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="time" />
        </div>
        <?php } ?>
        <?php } ?>
      </div>
      <?php } ?>
	  
    <div class="cart">  
      <?php if ($review_status) { ?>     
	   <div class="quantily_info">
			<div class="title_text"><b><?php echo $text_qty; ?></b></div>
            <div class="select_number">                
				<input type="text" class="text" name="quantity" size="2" value="<?php echo $minimum; ?>" />
                <button onclick="changeQty(1); return false;" class="increase" title="Increase">+</button>
                <button onclick="changeQty(0); return false;" class="decrease" title="Decrease">-</button>	
            </div>
            <input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />
        </div>
      <?php } ?>   
		<div class="price_info">
		 <?php if ($price) { ?>
		<?php if (!$special) { ?>
        <span class="price"><?php echo $price; ?></span>
        <?php } else { ?>
       <span class="price-new"><?php echo $special; ?></span>  <span class="price-old"><?php echo $price; ?></span>
        <?php } ?>
		<?php } ?>     
        <?php if ($tax) { ?>
        <span class="price-tax"><?php echo $text_tax; ?> <?php echo $tax; ?></span>
        <?php } ?>
        <?php if ($points) { ?>
        <span class="reward"><small><?php echo $text_points; ?> <?php echo $points; ?></small></span>
        <?php } ?>
        <?php if ($discounts) { ?>
        <div class="discount">
          <?php foreach ($discounts as $discount) { ?>
          <?php echo sprintf($text_discount, $discount['quantity'], $discount['price']); ?><br />
          <?php } ?>
        </div>
        <?php } ?>
      </div>
		<?php if ($minimum >1) { ?>
			<div class="minimum"><?php echo $text_minimum; ?></div>
			
		<?php } ?>
		<div class=""><span class="btn btn-color cs-tooltip" data-original-title="<?php echo $button_cart; ?>" data-placement="top" data-toggle="tooltip" title="<?php echo $button_cart; ?>" ><input type="button" value="<?php echo $button_cart; ?>" id="button-cart-qs" title="<?php echo $button_cart; ?>" /></span></div>		
		<div class="action">			
			<div class="compare"><a class="action-button" onclick="boss_addToCompare('<?php echo $product_id; ?>');" ><?php echo $button_compare; ?></a></div>
			<div class="wishlist"><a class="action-button" onclick="boss_addToWishList('<?php echo $product_id; ?>');" ><?php echo $button_wishlist; ?></a></div>
		</div>
      </div>
    </div>
  </div>
  </div>
  
</div>

<script type="text/javascript" src="catalog/view/javascript/bossthemes/jquery.easing.js"></script>
<script type="text/javascript" src="catalog/view/javascript/bossthemes/jquery.touchSwipe.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/bossthemes/jquery.carouFredSel-6.2.0-packed.js"></script>

<script type="text/javascript"><!--
function changeQty(increase) {
    var qty = parseInt($('.product-info-qs .select_number').find("input").val());
    if ( !isNaN(qty) ) {
        qty = increase ? qty+1 : (qty > <?php echo $minimum; ?> ? qty-1 : <?php echo $minimum; ?>);
        $('.product-info-qs .select_number').find("input").val(qty);
    }
}	

$.fn.CloudZoom.defaults = {
	position: 'inside',
	tint: '#ffffff',
	tintOpacity: 0.5,
	lensOpacity: 0.5,
	softFocus: false,
	smoothMove: 6,
	showTitle: false,
	titleOpacity: 0.5,
	adjustX: 0,
	adjustY: 0
}; 
$('.cloud-zoom, .cloud-zoom-gallery').CloudZoom();
	
$('.product-info-qs select[name="profile_id"], .product-info-qs input[name="quantity"]').change(function(){
    $.ajax({
		url: 'index.php?route=product/product/getRecurringDescription',
		type: 'post',
		data: $('.product-info-qs input[name="product_id"], .product-info-qs input[name="quantity"], .product-info-qs select[name="profile_id"]'),
		dataType: 'json',
        beforeSend: function() {
            $('.product-info-qs #profile-description').html('');
        },
		success: function(json) {
			$('.success, .warning, .attention, information, .error').remove();
            
			if (json['success']) {
                $('.product-info-qs #profile-description').html(json['success']);
			}	
		}
	});
});
    
$('#button-cart-qs').bind('click', function() {
	$.ajax({
		url: 'index.php?route=bossthemes/cart/add',
		type: 'post',
		data: $('.product-info-qs input[type=\'text\'], .product-info-qs input[type=\'hidden\'], .product-info-qs input[type=\'radio\']:checked, .product-info-qs input[type=\'checkbox\']:checked, .product-info-qs select, .product-info-qs textarea'),
		dataType: 'json',
		success: function(json) {
		$('.warning, .attention, information, .error').remove();
			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						$('#option-' + i).append('<span class="error">' + json['error']['option'][i] + '</span>');
					}
				}   
                if (json['error']['profile']) {
                    $('.product-info-qs select[name="profile_id"]').after('<span class="error">' + json['error']['profile'] + '</span>');
                }
		    }  
            if (json['success']) {
                addProductNotice(json['title'], json['thumb'], json['success'], 'success');
				$('#cart-total').html(json['total']);
				$('#boss_cart').load('index.php?route=module/cart #boss_cart > *');
				$('#myModal').modal('hide');
				$('#myModal').on('hidden.bs.modal', function () {
					$('#myModal > .modal-dialog').remove();
				});
            }
      }
	});
}); 
//--></script>	
<?php if ($options) { ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/ajaxupload.js"></script>
<?php foreach ($options as $option) { ?>
<?php if ($option['type'] == 'file') { ?>
<script type="text/javascript"><!--
new AjaxUpload('#button-option-qs-<?php echo $option['product_option_id']; ?>', {
	action: 'index.php?route=product/product/upload',
	name: 'file',
	autoSubmit: true,
	responseType: 'json',
	onSubmit: function(file, extension) {
		$('#button-option-qs-<?php echo $option['product_option_id']; ?>').after('<img src="catalog/view/theme/default/image/loading.gif" class="loading" style="padding-left: 5px;" />');
		$('#button-option-qs-<?php echo $option['product_option_id']; ?>').attr('disabled', true);
	},
	onComplete: function(file, json) {
		$('#button-option-qs-<?php echo $option['product_option_id']; ?>').attr('disabled', false);
		
		$('.error').remove();
		
		if (json['success']) {
			alert(json['success']);
			
			$('input[name=\'option[<?php echo $option['product_option_id']; ?>]\']').attr('value', json['file']);
		}
		
		if (json['error']) {
			$('#option-<?php echo $option['product_option_id']; ?>').after('<span class="error">' + json['error'] + '</span>');
		}
		
		$('.loading').remove();	
	}
});
//--></script>
<?php } ?>
<?php } ?>
<?php } ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	if ($.browser.msie && $.browser.version == 6) {
		$('.date, .datetime, .time').bgIframe();
	}

	$('.date').datepicker({dateFormat: 'yy-mm-dd'});
	$('.datetime').datetimepicker({
		dateFormat: 'yy-mm-dd',
		timeFormat: 'h:m'
	});
	$('.time').timepicker({timeFormat: 'h:m'});
});
//-->
$(window).load(function(){
	$('#boss-image-additional').carouFredSel({
		auto: false,
		responsive: true,
		width: '100%',
		prev: '#prev_image_additional',
		next: '#next_image_additional',
		swipe: {
		onTouch : true
		},
		items: {
			width: 120,
			height: 'auto',
			visible: {
			min: 1,
			max: 4
			}
		},
		scroll: {
			direction : 'left',    //  The direction of the transition.
			duration  : 1000   //  The duration of the transition.
		}
	});
	$('#product_related').carouFredSel({
		auto: false,
		responsive: true,
		width: '100%',
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
});

</script> 

</div>
</div>
</div>