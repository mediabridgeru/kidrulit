<?php echo $header; ?>
<div class="col-xs-24 col-sm-24 col-md-24">
	<div id="breadcrumb">
	<?php $i = 1; $count = count($breadcrumbs);  ?>
	<b></b>
	<?php foreach ($breadcrumbs as $breadcrumb) { ?>
	<a class="<?php if($i==$count){echo 'breadcrumb_last';} else if($i==$count-1){echo 'breadcumb_middle';} else{echo 'breadcumb_first';} ?>" href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
	<?php $i++; } ?>
	</div>	
</div>
<div id="content"><?php echo $content_top; ?>
 <div class="wishlist-fr">
  <h1 class="h1margin"><?php echo $heading_title; ?></h1>
     <?php if ($products && count($products) > 1) : ?>
     <div class="clear_wishlist"><button class="btn btn-color" onclick="clearWishList();">Удалить все закладки</button></div>
     <?php endif; ?>
  <?php if ($success) { ?>
<div class="success"><?php echo $success; ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
<?php } ?>
  <?php if ($products) { ?>
 
 <div class="table-responsive wishlist-info table table-bordered">
    <table class="">
      <thead>
        <tr>
          <td class="image" colspan="2"><?php echo $column_name; ?></td>
          <td class="model"><?php echo $column_model; ?></td>		  
		  <td class="unitprice"><?php echo $column_price; ?></td>
          <td class="stock"><?php echo $column_stock; ?></td>
          <td class="action"></td>
        </tr>
      </thead>
      <?php foreach ($products as $count => $product) { ?>
      <tbody <?php if($count==0){echo 'class="first"';} ?>id="wishlist-row<?php echo $product['product_id']; ?>">
        <tr>
          <td class="image<?php echo ($product==end($products) ? ' last' : ''); ?>">
		  <div><?php if ($product['thumb']) { ?>
            <a href="<?php echo $product['href']; ?>"><span><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /><b></b></span></a>
            <?php } ?>
			<div class="remove<?php echo ($product==end($products) ? ' last' : ''); ?>"><a href="<?php echo $product['remove']; ?>"><img src="catalog/view/theme/<?php echo $this->config->get('config_template'); ?>/image/removex.png" alt="<?php echo $button_remove; ?>" title="<?php echo $button_remove; ?>" /><?php echo $button_remove; ?></a></div>
			</div>
			</td>
          <td class="name<?php echo ($product==end($products) ? ' last' : ''); ?>"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></td>
		  
          <td class="model<?php echo ($product==end($products) ? ' last' : ''); ?>"><?php echo $product['model']; ?></td>
		  <td class="unitprice<?php echo ($product==end($products) ? ' last' : ''); ?>"><?php if ($product['price']) { ?>
            <div class="price<?php echo ($product==end($products) ? ' last' : ''); ?>">
              <?php if (!$product['special']) { ?>
              <?php echo $product['price']; ?>
              <?php } else { ?>
             <b><?php echo $product['special']; ?></b>  <s><?php echo $product['price']; ?></s> 
              <?php } ?>
            </div>
            <?php } ?></td>
		  <td class="stock<?php echo ($product==end($products) ? ' last' : ''); ?>"><?php echo $product['stock']; ?></td>
          <td class="action<?php echo ($product==end($products) ? ' last' : ''); ?>"><input type="button" class="btn btn-color" onclick="boss_addToCart('<?php echo $product['product_id']; ?>');" value="<?php echo $button_cart; ?>"></td>
        </tr>
      </tbody>
      <?php } ?>
    </table>
  </div>
  <div class="buttons">
    <div class="left"><a href="<?php echo $continue; ?>" class="btn btn-primary"><span class="button_fr"><?php echo $button_continue; ?></span></a></div>
  </div>
  <?php } else { ?>
  <div class="content"><?php echo $text_empty; ?></div>
  <div class="buttons">
    <div class="left"><a href="<?php echo $continue; ?>" class="btn btn-primary"><span class="button_fr"><?php echo $button_continue; ?></span></a></div>
  </div>
  <?php } ?>
  <?php echo $content_bottom; ?>
 </div>
</div>
<script>
    function clearWishList(){
        event.preventDefault();
        var isConfirm = confirm('Вы уверены что хотите очистить данный список товаров?');
        if (isConfirm) {
            $.ajax({
                url: 'index.php?route=account/wishlist/clear',
                type: 'post',
                data: 'remove=all',
                dataType: 'json',
                beforeSend: function() {

                },
                success: function(json) {
                    $('.success, .warning, .attention, .information, .error').remove();

                    if (json["success"]) {
                        $('.wishlist-info').replaceWith('<div class="content" style="overflow: visible;">'+json["success"]+'</div>');
                        $('.clear_wishlist').remove();
                        $('#wishlist-total').html('Закладки (0)');
                    }
                }
            });
        }
    }
</script>
<?php echo $footer; ?>