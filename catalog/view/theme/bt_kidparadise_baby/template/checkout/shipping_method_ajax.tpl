<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php //print_r($code); ?>
<?php if ($shipping_methods) { ?>
<p><?php echo $text_shipping_method; ?></p>
<table class="radio">
  <?php foreach ($shipping_methods as $shipping_method) { ?>
  <tr>
    <td colspan="3"><b><?php echo $shipping_method['title']; ?></b></td>
  </tr>
  <?php if (!$shipping_method['error']) { ?>
  <?php foreach ($shipping_method['quote'] as $quote) { ?>
    <?php $i = false; ?>
    <?php if(stristr($quote['code'], '.', true) == 'cdek') { ?>
      <?php $i = true; ?>
    <?php } ?>
  <tr class="highlight">
    <td><?php if ($quote['code'] == $code || !$code) { ?>
      <?php $code = $quote['code']; ?>
      <input type="radio" class="shipping-method-ajax-input" data-shcode="<?php echo $quote['code']; ?>" data-shmeth="<?php echo $quote['title']; ?>" data-subt="<?php echo ($quote['title_sub'] ? $quote['title_sub'] : $quote['title_sub']); ?>" data-cdeckcost="<?php echo ($i ? $quote['text'] : 0.00); ?>" name="shipping_code" value="<?php echo $quote['code']; ?>" id="<?php echo $quote['code']; ?>" checked="checked" />
      <?php } else { ?>
      <input type="radio" class="shipping-method-ajax-input" data-shcode="<?php echo $quote['code']; ?>" data-shmeth="<?php echo $quote['title']; ?>" data-subt="<?php echo ($quote['title_sub'] ? $quote['title_sub'] : $quote['title_sub']); ?>" data-cdeckcost="<?php echo ($i ? $quote['text'] : 0.00); ?>" name="shipping_code" value="<?php echo $quote['code']; ?>" id="<?php echo $quote['code']; ?>" />
      <?php } ?></td>
    <td><label for="<?php echo $quote['code']; ?>">
      <?php /* start russianpost2 */ ?>
        <?php if( !empty($quote['html_image']) ) { ?>
        <?php echo $quote['html_image']; ?>
        <?php } else if( !empty($quote['title_sub']) ) { ?>
        <?php echo $quote['title_sub']; ?>
        <?php } else { ?>
        <?php echo $quote['title']; ?>
        <?php } ?>
        <?php /* end russianpost2 */ ?></label></td>
    <td style="text-align: right;"><label for="<?php echo $quote['code']; ?>"><?php echo $quote['text']; ?><?php if (isset($quote['description'])) { ?>
  <tr>
    <td></td>
    <td><?php echo $quote['description']; ?></td>
    <td style="text-align: right;"></td>
  </tr>
  <?php } ?></label></td>
  </tr>
  <?php } ?>
  <?php } else { ?>
  <tr>
    <td colspan="3"><div class="error"><?php echo $shipping_method['error']; ?></div></td>
  </tr>
  <?php } ?>
  <?php } ?>
</table>
<br />
<?php } ?>

