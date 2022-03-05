<table style="width:100%;margin-bottom:5px;">
<tbody><tr><td style="text-align:center;font-family:arial;font-weight:bold;font-size:20px;color:#333;"><?php echo $title;?></td></tr></tbody>
</table>
<table style="width:100%;margin-bottom:20px;">
 <tbody>
 <?php $cols = 4; foreach ($products as $i => $product) { ?>
 <?php if( $i++%$cols == 0 ) { ?>
  <tr>
 <?php } ?>
  <td style="border:0;text-align:center;float:left;width:24%;padding:0.5%;">
   <div style="margin:0;border:1px solid #ebeef2;">
    <?php if ($product['thumb']) { ?>
    <div style="text-align:center;margin-top:5px;margin-bottom:5px;border:0px;">
     <a href="<?php echo $product['href']; ?>"><img style="max-width:100%;height:auto;display:block;margin-left:auto;margin-right:auto;" src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></a>
    </div>
    <?php } ?>
    <div style="text-align:center;font-size:14px;color:#333;height:80px;overflow:hidden;padding-left:10px;padding-right:10px;margin-bottom:5px;font-family:arial;line-height:1.3;"><a style="color:#222222;text-decoration:none;" href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
    <?php if ($product['price_from'] && !$product['price_nof']) { ?>
    <div style="font-weight:bold;font-size:17px;margin-bottom:5px;">
      <span>Цена от </span><?php echo $product['price_from']; ?>
    </div>
    <?php }  else { ?>
      <?php if ($product['price']) { ?>
       <div style="font-weight:bold;font-size:17px;margin-bottom:5px;">
       <?php if (!$product['special']) { ?>
        <?php echo $product['price']; ?>
       <?php } else { ?>
        <span style="font-weight:bold;font-size:15px;text-decoration:line-through;color:#E64B4B;"><?php echo ($product['price'] ? $product['price'] : ' '); ?></span> <span style="font-weight:bold;font-size:17px;"><?php echo ($product['special'] ? : ' '); ?></span>
       <?php } ?>
       </div>
      <?php } ?>
    <?php } ?>
    <?php /* if ($product['rating']) { ?>
     <div style="margin:5px 0;"><img src="<?php echo $product['rating']; ?>" alt="" /></div>
    <?php } */?>



<?php if($product['product_options_data']) { ?>
  <?php foreach($product['product_options_data'] as $options) { ?>
  <?php $i = 0; ?>
  <?php foreach($options as $option) { ?>
<?php if($option) { ?>

<table class="pod" style="margin: 4px 0 8px; width: 100%;  border-collapse: collapse;">

    <thead>
        <tr>
            <th style="border: 1px solid #ddd; padding: 2px 8px;" <?php if($option['qty_column'] && $option['price_format'] == 'both') { ?> rowspan="2"<?php } ?><?php if(!$option['qty_column'] && $option['price_format'] != 'both') { ?> colspan="<?php echo count($option['quantities']) + 1; ?>"<?php } ?> class="center"><?php echo $option['qty_column'] ? $text_col_quantity : ""; ?></th>

            <?php foreach ($option['quantities'] as $quantity => $range) { ?>
            <?php if($option['qty_column']) { ?>
            <th style="border: 1px solid #ddd; padding: 2px 8px;" <?php if($option['price_format'] == 'both') { ?> colspan="2"<?php } ?> class="center"><?php echo $option['qty_format'] == 'single' ? $quantity : $range; ?></th>
            <?php } ?>
            <?php } ?>

            <?php if(!$option['qty_column'] && $option['price_format'] == 'both') { ?>
            <?php foreach ($option['quantities'] as $quantity) { ?>
            <th style="border: 1px solid #ddd; padding: 2px 8px;" class="right"><?php echo $text_unit; ?></th>
            <th style="border: 1px solid #ddd; padding: 2px 8px;" class="right"><?php echo $text_total; ?></th>
            <?php } ?>
            <?php } ?>

            <?php if($option['stock_column']) { ?>
            <th style="border: 1px solid #ddd; padding: 2px 8px;" <?php if($option['qty_column'] && $option['price_format'] == 'both') { ?> rowspan="2"<?php } ?> class="center"><?php echo $text_col_stock; ?></th>
            <?php } ?>

            <?php if($option['qty_cart']) { ?>
            <th style="border: 1px solid #ddd; padding: 2px 8px;" <?php if($option['qty_column'] && $option['price_format'] == 'both') { ?> rowspan="2"<?php } ?> class="center"><?php echo $text_order; ?></th>
            <?php } ?>

        </tr>
        <?php if($option['qty_column'] && $option['price_format'] == 'both') { ?>
        <tr>
            <?php foreach ($option['quantities'] as $quantity) { ?>
            <th style="border: 1px solid #ddd; padding: 2px 8px;"  class="right"><?php echo $text_unit; ?></th>
            <th style="border: 1px solid #ddd; padding: 2px 8px;" class="right"><?php echo $text_total; ?></th>
            <?php } ?>
        </tr>
        <?php } ?>
    </thead>

    <tbody>
        <?php foreach ($option['option_value'] as $option_value) { ?>
        <tr>
            <td style="border: 1px solid #ddd; padding: 2px 8px;" class="option-cell">
                <label>
                <?php /* if ($option['type'] == 'image') { ?>
                    <img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>">
                <?php } ?>
                    <br /><span class="nowrap name-cell"><?php echo $option_value['name']; ?></span>
                <?php if($option_value['price'] || $option_value['extax']) { ?>
                    <br /><span class="nowrap price_value">(<?php echo $option_value['price'] ? $option_value['price_prefix'] . $option_value['price'] : ""; ?><?php echo $option['inc_tax'] == 'both' ? " " . $text_extax . " " : ""; ?><?php echo $option_value['extax'] ? $option_value['price_prefix'] . $option_value['extax'] : ""; ?>)</span>
                <?php } */ ?>
                </label>
            </td>
            <td class="stock-cell">
                <label><?php echo (int)($option_value['stock'] <= 0) ? 'нет в наличии' : 'есть в наличии'; ?></label>
            </td>

            <?php foreach ($option['quantities'] as $quantity => $range) { ?>
            <td style="border: 1px solid #ddd; padding: 2px 8px;" class="right price-cell">
                <?php if ($option_value['option_discount'][$quantity]['special'] === false) : ?>
                    <?php if($option['price_format'] == 'unit' || $option['price_format'] == 'both') { ?>
                        <?php if($option_value['option_discount'][$quantity]['price']) { ?><span class="nowrap price_value"><?php echo $option_value['option_discount'][$quantity]['price']; ?></span><?php } ?>
                        <?php if($option_value['option_discount'][$quantity]['extax']) { ?><span class=""><?php echo $option['inc_tax'] == 'both' ? $text_extax : ""; ?> <?php echo $option_value['option_discount'][$quantity]['extax']; ?></span><?php } ?>
                    <?php } ?>
                    <?php if($option['price_format'] == 'both') { ?>
                </td>
                <td style="border: 1px solid #ddd; padding: 2px 8px;" class="right">
                    <?php } ?>
                    <?php if($option['price_format'] == 'total' || $option['price_format'] == 'both') { ?>
                        <?php if($option_value['option_discount'][$quantity]['price_total']) { ?><span class="nowrap price_value"><?php echo $option_value['option_discount'][$quantity]['price_total']; ?></span><?php } ?>
                        <?php if($option_value['option_discount'][$quantity]['extax_total']) { ?><span class=""><?php echo $option['inc_tax'] == 'both' ? $text_extax : ""; ?> <?php echo $option_value['option_discount'][$quantity]['extax_total']; ?></span><?php } ?>
                    <?php } ?>
                <?php else : ?>
                    <?php if($option['price_format'] == 'unit' || $option['price_format'] == 'both') { ?>
                        <?php if($option_value['option_discount'][$quantity]['price']) { ?><span class="price-old nowrap price_value"><?php echo $option_value['option_discount'][$quantity]['price']; ?></span><?php } ?> <?php if($option_value['option_discount'][$quantity]['special']) { ?><span class="price-new nowrap"><?php echo $option_value['option_discount'][$quantity]['special']; ?></span><?php } ?>
                        <?php if($option_value['option_discount'][$quantity]['extax']) { ?><?php echo $option['inc_tax'] == 'both' ? $text_extax : ""; ?> <span class="price-old"><?php echo $option_value['option_discount'][$quantity]['extax']; ?></span><?php } ?> <?php if($option_value['option_discount'][$quantity]['special_extax']) { ?><span class="price-new nowrap"><?php echo $option_value['option_discount'][$quantity]['special_extax']; ?></span><?php } ?>
                    <?php } ?>
                    <?php if($option['price_format'] == 'both') { ?>
                </td>
                <td class="right">
                    <?php } ?>
                    <?php if($option['price_format'] == 'total' || $option['price_format'] == 'both') { ?>
                        <?php if($option_value['option_discount'][$quantity]['price_total']) { ?><span class="price-old nowrap price_value"><?php echo $option_value['option_discount'][$quantity]['price_total']; ?></span><?php } ?> <?php if($option_value['option_discount'][$quantity]['special_total']) { ?><span class="price-new nowrap"><?php echo $option_value['option_discount'][$quantity]['special_total']; ?></span><?php } ?>
                        <?php if($option_value['option_discount'][$quantity]['extax_total']) { ?><?php echo $option['inc_tax'] == 'both' ? $text_extax : ""; ?> <span class="price-old nowrap"><?php echo $option_value['option_discount'][$quantity]['extax_total']; ?></span><?php } ?> <?php if($option_value['option_discount'][$quantity]['special_extax_total']) { ?><span class="price-new nowrap"><?php echo $option_value['option_discount'][$quantity]['special_extax_total']; ?></span><?php } ?>
                    <?php } ?>
                <?php endif; ?>
            </td>
            <?php } ?>

            <?php if($option['stock_column']) { ?>
                <td style="border: 1px solid #ddd; padding: 2px 8px;" class="right<?php if(!$option_value['stock']) { ?> nostock<?php } ?>"><?php echo $option_value['stock']; ?></td>
            <?php } ?>

        </tr>
        <?php $i++; ?>
        <?php if($i == 2) { ?>
        <tr>
          <td colspan="3">Доступны дополнительные опции</td>
        </tr>
        <?php break; ?>
        <?php } ?>
        <?php } ?>
    </tbody>

</table>
<?php } ?>
    <?php } ?>
  <?php } ?>
<?php } ?>


   </div>
  </td>
 <?php if (($i%$cols == 0) || ($i==count($products))) { ?>
  </tr>
 <?php } ?>				
 <?php } ?>
 </tbody>
</table>