<?php 
$quantity_products = 0;
foreach ($products as $product) { 
  $quantity_products += $product['quantity'];
}
$last_digit = $quantity_products % 10 ;

if (($quantity_products > 4) && ($quantity_products < 21)) {
  $text_products = 'товаров';
} elseif ($last_digit == 0) {
  $text_products = 'товаров';
} elseif ($last_digit == 1) {
  $text_products = 'товар';
} elseif (($last_digit == 2) || ($last_digit == 3) || ($last_digit == 4)) {
  $text_products = 'товара';
} elseif ($last_digit > 4) {
  $text_products = 'товаров';
}

?>
<div id="top_cart">
  
  <div class="heading" >
    <a class="btn-checkout" href="<?php echo $checkout; ?>">Корзина</a>
  	<span id="nbr-products"><?php echo $quantity_products.' '.$text_products; ?></span>	
  </div>
  <div class="content">
    <?php if ($products || $vouchers) { ?>
    <div class="mini-cart-info">
      <table>
        <?php foreach ($products as $product) { ?>
        <tr>
          <td class="image">
			<div>
		  <?php if ($product['thumb']) { ?>
            <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /><b></b></a>
            <?php } ?>
			<div class="remove"><a class="check_remove" title="<?php echo $button_remove; ?>" onclick="(getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') ? location = 'index.php?route=checkout/carthead&amp;remove=<?php echo $product['key']; ?>' : $('#top_cart').load('index.php?route=module/carthead&amp;remove=<?php echo $product['key'];  ?>' + ' #top_cart > *'); $('#boss_cart').load('index.php?route=module/cart&amp;remove=<?php echo $product['key']; ?>' + ' #boss_cart > *');"><?php echo $button_remove; ?></a></div>
			</div></td>
          <td class="name"><div class="name"><a <?php if(!$product['in_stock']) echo 'class="product_unavailable"'; ?> href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
            <div>
              <?php foreach ($product['option'] as $option) { ?>
              - <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small><br />
              <?php } ?>
              <?php if ($product['recurring']): ?>
              - <small><?php echo $text_payment_profile ?> <?php echo $product['profile']; ?></small><br />
              <?php endif; ?>
            </div>
		  <div class="total"><?php echo $product['total']; ?></div>
          <div class="quantity">x&nbsp;<?php echo $product['quantity']; ?></div>
          
	      </td>
		</tr>
        <?php } ?>
        <?php foreach ($vouchers as $voucher) { ?>
        <tr>
          <td class="image"><div><div class="remove"><a class="check_remove" title="<?php echo $button_remove; ?>" onclick="(getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') ? location = 'index.php?route=checkout/carthead&amp;remove=<?php echo $voucher['key']; ?>' : $('#top_cart').load('index.php?route=module/carthead&amp;remove=<?php echo $voucher['key']; ?>' + ' #top_cart > *');"><?php echo $button_remove; ?></a></div></div></td>
          <td class="name"><?php echo $voucher['description']; ?>
		   <div class="total"><?php echo $voucher['amount']; ?></div>
          <div class="quantity">x&nbsp;1</div>
         
        </td>
		</tr>
        <?php } ?>
      </table>
    </div>
     <div class="mini-cart-total">
      <table>
        <?php foreach ($totals as $total) { ?>
        <tr>
          <td class="left<?php echo ($total==end($totals) ? ' last' : ''); ?>"><?php echo $total['title']; ?>:</td>
          <td class="right<?php echo ($total==end($totals) ? ' last' : ''); ?>"><?php echo $total['text']; ?></td>
        </tr>
        <?php } ?>
      </table>
    </div>
    <div class="checkout">
		<a class="btn btn-checkout" href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a>
		<a class="btn btn-primary" href="<?php echo $carthead; ?>"><?php echo $text_cart; ?></a> </div>
    <?php } else { ?>
    <div class="empty"><?php echo $text_empty; ?></div>
    <?php } ?>
  </div>

</div>	
