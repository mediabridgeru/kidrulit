<?php if($option) { ?>
<style type="text/css">
    .pod {
        margin: 4px 0 8px;
        width: 100%;
        border-collapse: collapse;
    }
    .pod tr th,.pod tr td {
        border: 1px solid #ddd;
        padding: 2px 8px;
    }
    .pod td img {
        vertical-align: middle;
        border: 1px solid #ddd;
    }
    .pod td input[type='text'] {
        padding: 1px;
    }
    .pod td input.button {
        height: 20px;
        padding: 0px 12px;
        font-size: 0.9em;
    }
    .pod .nowrap {
        white-space: nowrap;
    }
    .pod th.center,
    .pod td.center {
        text-align: center;
    }
    .pod th.right,
    .pod td.right {
        text-align: right;
    }
    .pod th.nostock,
    .pod td.nostock {
        color: #f00;
    }
    <?php if($option['qty_cart']) { ?>
    input[name='quantity'], #button-cart, #add_to_cart {
        display: none;
    }
    <?php } ?>
</style>
<table class="pod">
<?php if($option['table_style'] == 'h') { //horizontal ?>

    <?php if($option['qty_column'] || $option['stock_column'] || $option['qty_cart'] || $option['price_format'] == 'both') : ?>
    <thead>
        <tr>
            <th<?php if($option['qty_column'] && $option['price_format'] == 'both') { ?> rowspan="2"<?php } ?><?php if(!$option['qty_column'] && $option['price_format'] != 'both') { ?> colspan="<?php echo count($option['quantities']) + 1; ?>"<?php } ?> class="center"><?php echo $option['qty_column'] ? $text_col_quantity : ""; ?></th>

            <?php foreach ($option['quantities'] as $quantity => $range) { ?>
            <?php if($option['qty_column']) { ?>
            <th<?php if($option['price_format'] == 'both') { ?> colspan="2"<?php } ?> class="center"><?php echo $option['qty_format'] == 'single' ? $quantity : $range; ?></th>
            <?php } ?>
            <?php } ?>

            <?php if(!$option['qty_column'] && $option['price_format'] == 'both') { ?>
            <?php foreach ($option['quantities'] as $quantity) { ?>
            <th class="right"><?php echo $text_unit; ?></th>
            <th class="right"><?php echo $text_total; ?></th>
            <?php } ?>
            <?php } ?>

            <?php if($option['stock_column']) { ?>
            <th<?php if($option['qty_column'] && $option['price_format'] == 'both') { ?> rowspan="2"<?php } ?> class="center"><?php echo $text_col_stock; ?></th>
            <?php } ?>

            <?php if($option['qty_cart']) { ?>
            <th<?php if($option['qty_column'] && $option['price_format'] == 'both') { ?> rowspan="2"<?php } ?> class="center"><?php echo $text_order; ?></th>
            <?php } ?>

        </tr>
        <?php if($option['qty_column'] && $option['price_format'] == 'both') { ?>
        <tr>
            <?php foreach ($option['quantities'] as $quantity) { ?>
            <th class="right"><?php echo $text_unit; ?></th>
            <th class="right"><?php echo $text_total; ?></th>
            <?php } ?>
        </tr>
        <?php } ?>
    </thead>
    <?php endif; ?>

    <tbody>
    <?php if ($option['type'] == 'select') : /* if ($option['type'] == 'select') *****************************************/ ?>

        <tr>
            <td>
            <select name="option[<?php echo $option['product_option_id']; ?>]" data-poid="<?php echo $option['product_option_id']; ?>">
                <option value=""><?php echo $text_select; ?></option>
            <?php foreach ($option['option_value'] as $option_value) { ?>
                <?php if(!$option_value['subtract'] || $option_value['stock']) { ?>
                <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                    <?php if($option_value['price'] || $option_value['extax']) { ?>
                    (<?php echo $option_value['price'] ? $option_value['price_prefix'] . $option_value['price'] : ""; ?><?php echo $option['inc_tax'] == 'both' ? " " . $text_extax . " " : ""; ?><?php echo $option_value['extax'] ? $option_value['price_prefix'] . $option_value['extax'] : ""; ?>)
                    <?php } ?>
                </option>
                <?php } ?>
            <?php } ?>
            </select>
        </td>

        <?php if(count($option['quantities']) > 0) { ?>
            <td colspan="<?php echo count($option['quantities']) * ($option['price_format'] == 'both' ? 2 : 1) + ($option['qty_cart'] ? 1 : 0) + ($option['stock_column'] ? 1 : 0); ?>" data-podsel="<?php echo $option['product_option_id']; ?>" class="center">
                <?php echo $text_select; ?>
            </td>
        <?php } ?>

        <?php foreach ($option['option_value'] as $option_value) : ?>

            <?php foreach ($option['quantities'] as $quantity => $range) { ?>
            <td data-podpovid="<?php echo $option_value['product_option_value_id']; ?>" data-podpoid="<?php echo $option['product_option_id']; ?>" style="display:none;" class="right">
                <?php if($option_value['option_discount'][$quantity]['special'] === false && $option_value['option_discount'][$quantity]['special_extax'] === false) { ?>
                <?php if($option['price_format'] == 'unit' || $option['price_format'] == 'both') { ?>
                <?php if($option_value['option_discount'][$quantity]['price']) { ?><span class="nowrap"><?php echo $option_value['option_discount'][$quantity]['price']; ?></span><?php } ?>
                <?php if($option_value['option_discount'][$quantity]['extax']) { ?><span class=""><?php echo $option['inc_tax'] == 'both' ? $text_extax : ""; ?> <?php echo $option_value['option_discount'][$quantity]['extax']; ?></span><?php } ?>
                <?php } ?>
                <?php if($option['price_format'] == 'both') { ?>
            </td>
            <td data-podpovid="<?php echo $option_value['product_option_value_id']; ?>" data-podpoid="<?php echo $option['product_option_id']; ?>" style="display:none;" class="right">
                <?php } ?>
                <?php if($option['price_format'] == 'total' || $option['price_format'] == 'both') { ?>
                <?php if($option_value['option_discount'][$quantity]['price_total']) { ?><span class="nowrap"><?php echo $option_value['option_discount'][$quantity]['price_total']; ?></span><?php } ?>
                <?php if($option_value['option_discount'][$quantity]['extax_total']) { ?><span class=""><?php echo $option['inc_tax'] == 'both' ? $text_extax : ""; ?> <?php echo $option_value['option_discount'][$quantity]['extax_total']; ?></span><?php } ?>
                <?php } ?>
                <?php } else { ?>
                <?php if($option['price_format'] == 'unit' || $option['price_format'] == 'both') { ?>
                <?php if($option_value['option_discount'][$quantity]['price']) { ?><span class="price-old nowrap"><?php echo $option_value['option_discount'][$quantity]['price']; ?></span><?php } ?> <?php if($option_value['option_discount'][$quantity]['special']) { ?><span class="price-new nowrap"><?php echo $option_value['option_discount'][$quantity]['special']; ?></span><?php } ?>
                <?php if($option_value['option_discount'][$quantity]['extax']) { ?><?php echo $option['inc_tax'] == 'both' ? $text_extax : ""; ?> <span class="price-old nowrap"><?php echo $option_value['option_discount'][$quantity]['extax']; ?></span><?php } ?> <?php if($option_value['option_discount'][$quantity]['special_extax']) { ?><span class="price-new nowrap"><?php echo $option_value['option_discount'][$quantity]['special_extax']; ?></span><?php } ?>
                <?php } ?>
                <?php if($option['price_format'] == 'both') { ?>
            </td>
            <td data-podpovid="<?php echo $option_value['product_option_value_id']; ?>" data-podpoid="<?php echo $option['product_option_id']; ?>" style="display:none;" class="right">
                <?php } ?>
                <?php if($option['price_format'] == 'total' || $option['price_format'] == 'both') { ?>
                <?php if($option_value['option_discount'][$quantity]['price_total']) { ?><span class="price-old nowrap"><?php echo $option_value['option_discount'][$quantity]['price_total']; ?></span><?php } ?> <?php if($option_value['option_discount'][$quantity]['special_total']) { ?><span class="price-new nowrap"><?php echo $option_value['option_discount'][$quantity]['special_total']; ?></span><?php } ?>
                <?php if($option_value['option_discount'][$quantity]['extax_total']) { ?><?php echo $option['inc_tax'] == 'both' ? $text_extax : ""; ?> <span class="price-old nowrap"><?php echo $option_value['option_discount'][$quantity]['extax_total']; ?></span><?php } ?> <?php if($option_value['option_discount'][$quantity]['special_extax_total']) { ?><span class="price-new nowrap"><?php echo $option_value['option_discount'][$quantity]['special_extax_total']; ?></span><?php } ?>
                <?php } ?>
                <?php } ?>
            </td>
            <?php } ?>

            <?php if($option['stock_column']) { ?>
            <td data-podpovid="<?php echo $option_value['product_option_value_id']; ?>" data-podpoid="<?php echo $option['product_option_id']; ?>" style="display:none;" class="right<?php if(!$option_value['stock']) { ?> nostock<?php } ?>"><?php echo $option_value['stock']; ?></td>
            <?php } ?>

            <?php if($option['qty_cart']) { ?>
            <td data-podpovid="<?php echo $option_value['product_option_value_id']; ?>" data-podpoid="<?php echo $option['product_option_id']; ?>" class="nowrap" style="display:none;">
                <input type="text" name="quantitypod[<?php echo $option_value['product_option_value_id']; ?>]" value="<?php echo $minimum; ?>" data-cart-poid="<?php echo $option['product_option_id']; ?>" data-cart-povid="<?php echo $option_value['product_option_value_id']; ?>" size="3"<?php if($option_value['subtract'] && !$option_value['stock']) { ?> disabled="disabled"<?php } ?>>
                <input type="button" value="<?php echo $button_cart; ?>" data-cart-poid="<?php echo $option['product_option_id']; ?>" data-cart-povid="<?php echo $option_value['product_option_value_id']; ?>" class="button btn-podcart"<?php if($option_value['subtract'] && !$option_value['stock']) { ?> disabled="disabled"<?php } ?>>
            </td>
            <?php } ?>

        <?php endforeach; ?>
        </tr>

    <?php else : /* if ($option['type'] == 'select') ******** not *************************/ ?>

        <?php foreach ($option['option_value'] as $option_value) { ?>
        <tr>
            <td class="option-cell">
                <label>
                    <input type="<?php echo ($option['qty_cart']) ? 'hidden' : ($option['type'] == 'image' ? 'radio' : $option['type']); ?>" name="option[<?php echo $option['product_option_id']; ?>]<?php if($option['type'] == 'checkbox') { ?>[]<?php } ?>" value="<?php echo $option_value['product_option_value_id']; ?>" <?php if($option['qty_cart']) { ?> disabled="disabled"<?php } ?>>
                <?php if ($option['type'] == 'image') { ?>
                    <img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>">
                <?php } ?>
                    <span class="nowrap name-cell"><?php echo $option_value['name']; ?></span>
                <?php if($option_value['price'] || $option_value['extax']) { ?>
                    <span class="nowrap price_value">(<?php echo $option_value['price'] ? $option_value['price_prefix'] . $option_value['price'] : ""; ?><?php echo $option['inc_tax'] == 'both' ? " " . $text_extax . " " : ""; ?><?php echo $option_value['extax'] ? $option_value['price_prefix'] . $option_value['extax'] : ""; ?>)</span>
                <?php } ?>
                </label>
            </td>
            <td class="stock-cell">
                <label><?php echo (int)($option_value['stock'] <= 0) ? 'нет в наличии' : 'есть в наличии'; ?></label>
            </td>

            <?php foreach ($option['quantities'] as $quantity => $range) { ?>
            <td class="right price-cell">
                <?php if ($option_value['option_discount'][$quantity]['special'] === false) : ?>
                    <?php if($option['price_format'] == 'unit' || $option['price_format'] == 'both') { ?>
                        <?php if($option_value['option_discount'][$quantity]['price']) { ?><span class="nowrap price_value"><?php echo $option_value['option_discount'][$quantity]['price']; ?></span><?php } ?>
                        <?php if($option_value['option_discount'][$quantity]['extax']) { ?><span class=""><?php echo $option['inc_tax'] == 'both' ? $text_extax : ""; ?> <?php echo $option_value['option_discount'][$quantity]['extax']; ?></span><?php } ?>
                    <?php } ?>
                    <?php if($option['price_format'] == 'both') { ?>
                </td>
                <td class="right">
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
                <td class="right<?php if(!$option_value['stock']) { ?> nostock<?php } ?>"><?php echo $option_value['stock']; ?></td>
            <?php } ?>
            <?php if($option['qty_cart']) { ?>
                <td class="nowrap">
                    <input type="text" name="quantitypod[<?php echo $option_value['product_option_value_id']; ?>]" value="<?php echo $minimum; ?>" data-cart-poid="<?php echo $option['product_option_id']; ?>" data-cart-povid="<?php echo $option_value['product_option_value_id']; ?>" size="3"<?php if($option_value['subtract'] && !$option_value['stock']) { ?> disabled="disabled"<?php } ?>>
                    <input type="button" value="<?php echo $button_cart; ?>" data-cart-poid="<?php echo $option['product_option_id']; ?>" data-cart-povid="<?php echo $option_value['product_option_value_id']; ?>" class="button btn-podcart"<?php if($option_value['subtract'] && !$option_value['stock']) { ?> disabled="disabled"<?php } ?>>
                </td>
            <?php } ?>
        </tr>
        <?php } ?>

    <?php endif; /* if ($option['type'] == 'select') *****************************************/ ?>
    </tbody>

<?php } else { //vertical ?>

    <?php $colspan = 1; ?>
    <?php if($option['price_format'] == 'both' || (($option['qty_cart'] || $option['stock_column']) && !$option['qty_column'])) { $colspan++; } ?>
    <?php $rowspan = 1; ?>
    <?php if($option['price_format'] == 'both') { $rowspan++; } ?>

    <thead>
    <tr>
    <?php if($option['type'] == 'select') { ?>

        <?php if($option['qty_column']) { $colspan++; } ?>
        <td colspan="<?php echo $colspan; ?>">
            <select name="option[<?php echo $option['product_option_id']; ?>]" data-poid="<?php echo $option['product_option_id']; ?>">
                <option value=""><?php echo $text_select; ?></option>
            <?php foreach ($option['option_value'] as $option_value) { ?>
                <?php if(!$option_value['subtract'] || $option_value['stock']) { ?>
                <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                    <?php if ($option_value['price'] || $option_value['extax']) { ?>
                    (<?php echo $option_value['price'] ? $option_value['price_prefix'] . $option_value['price'] : ""; ?><?php echo $option['inc_tax'] == 'both' ? " " . $text_extax . " " : ""; ?><?php echo $option_value['extax'] ? $option_value['price_prefix'] . $option_value['extax'] : ""; ?>)
                    <?php } ?>
                </option>
                <?php } ?>
            <?php } ?>
            </select>
        </td>
    </tr>

    <?php if($option['price_format'] == 'both') { ?>
    <tr>
    <?php if($option['qty_column']) { ?>
        <th><?php echo $text_col_quantity; ?></th>
    <?php } ?>
        <th class="right"><?php echo $text_unit; ?></th>
        <th class="right"><?php echo $text_total; ?></th>
    </tr>
    <?php } ?>

    </thead>
    <tbody>
    <?php $i = 0; ?>
    <?php foreach ($option['quantities'] as $quantity => $range) { ?>
    <tr>

        <?php if($option['qty_column']) { ?>
        <td><?php echo $option['qty_format'] == 'single' ? $quantity : $range; ?></td>
        <?php } ?>

        <?php if ($i == 0) { ?>
        <td<?php if($option['qty_column']) { ?> rowspan="<?php echo count($option['quantities']); ?>"<?php } ?><?php if($option['price_format'] == 'both' || (!$option['qty_column'] && ($option['qty_cart'] || $option['stock_column']))) { ?> colspan="2"<?php } ?> data-podsel="<?php echo $option['product_option_id']; ?>" class="center">
        <?php echo $text_select; ?>
        </td>
        <?php } ?>

        <?php foreach ($option['option_value'] as $option_value) { ?>
        <td data-podpovid="<?php echo $option_value['product_option_value_id']; ?>" data-podpoid="<?php echo $option['product_option_id']; ?>"<?php if(!$option['qty_column'] && ($option['qty_cart'] || $option['stock_column']) && $option['price_format'] != 'both') { ?> colspan="2"<?php } ?> style="display:none;" class="right">
        <?php if($option_value['option_discount'][$quantity]['special'] === false && $option_value['option_discount'][$quantity]['special_extax'] === false) { ?>

            <?php if($option['price_format'] == 'unit' || $option['price_format'] == 'both') { ?>
                <?php if($option_value['option_discount'][$quantity]['price']) { ?><span class="nowrap"><?php echo $option_value['option_discount'][$quantity]['price']; ?></span><?php } ?>
                <?php if($option_value['option_discount'][$quantity]['extax']) { ?><span class=""><?php echo $option['inc_tax'] == 'both' ? $text_extax : ""; ?> <?php echo $option_value['option_discount'][$quantity]['extax']; ?></span><?php } ?>
            <?php } ?>

            <?php if($option['price_format'] == 'both') { ?>
                </td>
                <td data-podpovid="<?php echo $option_value['product_option_value_id']; ?>" data-podpoid="<?php echo $option['product_option_id']; ?>" style="display:none;" class="right">
            <?php } ?>

            <?php if($option['price_format'] == 'total' || $option['price_format'] == 'both') { ?>
                <?php if($option_value['option_discount'][$quantity]['price_total']) { ?><span class="nowrap"><?php echo $option_value['option_discount'][$quantity]['price_total']; ?></span><?php } ?>
                <?php if($option_value['option_discount'][$quantity]['extax_total']) { ?><span class=""><?php echo $option['inc_tax'] == 'both' ? $text_extax : ""; ?> <?php echo $option_value['option_discount'][$quantity]['extax_total']; ?></span><?php } ?>
            <?php } ?>

            <?php } else { ?>

            <?php if($option['price_format'] == 'unit' || $option['price_format'] == 'both') { ?>
                <?php if($option_value['option_discount'][$quantity]['price']) { ?><span class="price-old nowrap"><?php echo $option_value['option_discount'][$quantity]['price']; ?></span><?php } ?> <?php if($option_value['option_discount'][$quantity]['special']) { ?><span class="price-new nowrap"><?php echo $option_value['option_discount'][$quantity]['special']; ?></span><?php } ?>
                <?php if($option_value['option_discount'][$quantity]['extax']) { ?><?php echo $option['inc_tax'] == 'both' ? $text_extax : ""; ?> <span class="price-old nowrap"><?php echo $option_value['option_discount'][$quantity]['extax']; ?></span><?php } ?> <?php if($option_value['option_discount'][$quantity]['special_extax']) { ?><span class="price-new nowrap"><?php echo $option_value['option_discount'][$quantity]['special_extax']; ?></span><?php } ?>
            <?php } ?>

            <?php if($option['price_format'] == 'both') { ?>
        </td>
        <td data-podpovid="<?php echo $option_value['product_option_value_id']; ?>" data-podpoid="<?php echo $option['product_option_id']; ?>" style="display:none;" class="right">
            <?php } ?>

            <?php if($option['price_format'] == 'total' || $option['price_format'] == 'both') { ?>
                <?php if($option_value['option_discount'][$quantity]['price_total']) { ?><span class="price-old nowrap"><?php echo $option_value['option_discount'][$quantity]['price_total']; ?></span><?php } ?> <?php if($option_value['option_discount'][$quantity]['special_total']) { ?><span class="price-new nowrap"><?php echo $option_value['option_discount'][$quantity]['special_total']; ?></span><?php } ?>
                <?php if($option_value['option_discount'][$quantity]['extax_total']) { ?><?php echo $option['inc_tax'] == 'both' ? $text_extax : ""; ?> <span class="price-old nowrap"><?php echo $option_value['option_discount'][$quantity]['extax_total']; ?></span><?php } ?> <?php if($option_value['option_discount'][$quantity]['special_extax_total']) { ?><span class="price-new nowrap"><?php echo $option_value['option_discount'][$quantity]['special_extax_total']; ?></span><?php } ?>
            <?php } ?>

            <?php } ?>
        </td>
        <?php } ?>
    </tr>
    <?php $i++; ?>
    <?php } ?>

    <?php if($option['stock_column']) { ?>
    <tr>
        <th><?php echo $text_col_stock; ?></th>
        <th<?php if($option['price_format'] == 'both' && $option['qty_column']) { ?> colspan="2"<?php } ?> data-podsel="<?php echo $option['product_option_id']; ?>" class="center"><?php echo $text_select; ?></th>
    <?php foreach ($option['option_value'] as $option_value) { ?>
        <th<?php if($option['price_format'] == 'both' && $option['qty_column']) { ?> colspan="2"<?php } ?> data-podpovid="<?php echo $option_value['product_option_value_id']; ?>" data-podpoid="<?php echo $option['product_option_id']; ?>" style="display:none;" class="right<?php if(!$option_value['stock']) { ?> nostock<?php } ?>"><?php echo $option_value['stock']; ?></th>
    <?php } ?>
    </tr>
    <?php } ?>

    <?php if($option['qty_cart']) { ?>
    <tr>
        <th><?php echo $text_order; ?></th>
        <th<?php if($option['price_format'] == 'both' && $option['qty_column']) { ?> colspan="2"<?php } ?> data-podsel="<?php echo $option['product_option_id']; ?>" class="center"><?php echo $text_select; ?></th>
    <?php foreach ($option['option_value'] as $option_value) { ?>
        <td data-podpovid="<?php echo $option_value['product_option_value_id']; ?>" data-podpoid="<?php echo $option['product_option_id']; ?>" class="right nowrap" style="display:none;"<?php if($option['price_format'] == 'both' && $option['qty_column']) { ?> colspan="2"<?php } ?>>
            <input type="text" name="quantitypod[<?php echo $option_value['product_option_value_id']; ?>]" value="<?php echo $minimum; ?>" data-cart-poid="<?php echo $option['product_option_id']; ?>" data-cart-povid="<?php echo $option_value['product_option_value_id']; ?>" size="3"<?php if($option_value['subtract'] && !$option_value['stock']) { ?> disabled="disabled"<?php } ?>>
            <input type="button" value="<?php echo $button_cart; ?>" data-cart-poid="<?php echo $option['product_option_id']; ?>" data-cart-povid="<?php echo $option_value['product_option_value_id']; ?>" class="button btn-podcart"<?php if($option_value['subtract'] && !$option_value['stock']) { ?> disabled="disabled"<?php } ?>>
        </td>
    <?php } ?>
    </tr>
    <?php } ?>

    <?php } else { //not select ?>

    <?php if($option['qty_column'] || $option['qty_cart'] || $option['stock_column']) { ?>
    <th rowspan="<?php echo $rowspan; ?>"><?php echo $option['qty_column'] ? $text_col_quantity : ""; ?></th>
    <?php } ?>
    <?php foreach ($option['option_value'] as $option_value) { ?>
    <th<?php if($option['price_format'] == 'both') { ?> colspan="2"<?php } ?>>
    <label>
        <?php if($option['type'] == 'image') { ?>
        <img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>"><br>
        <?php } ?>
        <input type="<?php echo ($option['qty_cart'] || ($option_value['subtract'] && !$option_value['stock'])) ? 'hidden' : ($option['type'] == 'image' ? 'radio' : $option['type']); ?>" name="option[<?php echo $option['product_option_id']; ?>]<?php if($option['type'] == 'checkbox') { ?>[]<?php } ?>" value="<?php echo $option_value['product_option_value_id']; ?>" <?php if($option['qty_cart'] || ($option_value['subtract'] && !$option_value['stock'])) { ?> disabled="disabled"<?php } ?>>
        <span class="nowrap"><?php echo $option_value['name']; ?></span>
        <?php if ($option_value['price'] || $option_value['extax']) { ?>
        <span class="nowrap">(<?php echo $option_value['price'] ? $option_value['price_prefix'] . $option_value['price'] : ""; ?><?php echo $option['inc_tax'] == 'both' ? " " . $text_extax . " " : ""; ?><?php echo $option_value['extax'] ? $option_value['price_prefix'] . $option_value['extax'] : ""; ?>)</span>
        <?php } ?>
    </label>
    </th>
    <?php } ?>
    </tr>
    <?php if($option['price_format'] == 'both') { ?>
    <tr>
        <?php foreach ($option['option_value'] as $option_value) { ?>
        <th class="right"><?php echo $text_unit; ?></th>
        <th class="right"><?php echo $text_total; ?></th>
        <?php } ?>
    </tr>
    <?php } ?>
    </thead>
    <tbody>

    <?php $j=0; ?>
    <?php foreach ($option['quantities'] as $quantity => $range) { ?>
    <tr>
        <?php if($option['qty_column']) { ?>
        <td><?php echo $option['qty_format'] == 'single' ? $quantity : $range; ?></td>
        <?php } elseif($j==0 && (($option['qty_cart'] || $option['stock_column']) && !$option['qty_column'])) { ?>
        <td rowspan="<?php echo count($option['quantities']); ?>"></td>
        <?php } ?>

        <?php foreach ($option['option_value'] as $option_value) { ?>
        <td class="right">
            <?php if($option_value['option_discount'][$quantity]['special'] === false && $option_value['option_discount'][$quantity]['special_extax'] === false) { ?>
            <?php if($option['price_format'] == 'unit' || $option['price_format'] == 'both') { ?>
            <?php if($option_value['option_discount'][$quantity]['price']) { ?><span class="nowrap"><?php echo $option_value['option_discount'][$quantity]['price']; ?></span><?php } ?>
            <?php if($option_value['option_discount'][$quantity]['extax']) { ?><span class=""><?php echo $option['inc_tax'] == 'both' ? $text_extax : ""; ?> <?php echo $option_value['option_discount'][$quantity]['extax']; ?></span><?php } ?>
            <?php } ?>
            <?php if($option['price_format'] == 'both') { ?>
        </td>
        <td class="right">
            <?php } ?>
            <?php if($option['price_format'] == 'total' || $option['price_format'] == 'both') { ?>
            <?php if($option_value['option_discount'][$quantity]['price_total']) { ?><span class="nowrap"><?php echo $option_value['option_discount'][$quantity]['price_total']; ?></span><?php } ?>
            <?php if($option_value['option_discount'][$quantity]['extax_total']) { ?><span class=""><?php echo $option['inc_tax'] == 'both' ? $text_extax : ""; ?> <?php echo $option_value['option_discount'][$quantity]['extax_total']; ?></span><?php } ?>
            <?php } ?>
            <?php } else { ?>
            <?php if($option['price_format'] == 'unit' || $option['price_format'] == 'both') { ?>
            <?php if($option_value['option_discount'][$quantity]['price']) { ?><span class="price-old nowrap"><?php echo $option_value['option_discount'][$quantity]['price']; ?></span><?php } ?> <?php if($option_value['option_discount'][$quantity]['special']) { ?><span class="price-new nowrap"><?php echo $option_value['option_discount'][$quantity]['special']; ?></span><?php } ?>
            <?php if($option_value['option_discount'][$quantity]['extax']) { ?><?php echo $option['inc_tax'] == 'both' ? $text_extax : ""; ?> <span class="price-old nowrap"><?php echo $option_value['option_discount'][$quantity]['extax']; ?></span><?php } ?> <?php if($option_value['option_discount'][$quantity]['special_extax']) { ?><span class="price-new nowrap"><?php echo $option_value['option_discount'][$quantity]['special_extax']; ?></span><?php } ?>
            <?php } ?>
            <?php if($option['price_format'] == 'both') { ?>
        </td>
        <td class="right">
            <?php } ?>
            <?php if($option['price_format'] == 'total' || $option['price_format'] == 'both') { ?>
            <?php if($option_value['option_discount'][$quantity]['price_total']) { ?><span class="price-old nowrap"><?php echo $option_value['option_discount'][$quantity]['price_total']; ?></span><?php } ?> <?php if($option_value['option_discount'][$quantity]['special_total']) { ?><span class="price-new nowrap"><?php echo $option_value['option_discount'][$quantity]['special_total']; ?></span><?php } ?>
            <?php if($option_value['option_discount'][$quantity]['extax_total']) { ?><?php echo $option['inc_tax'] == 'both' ? $text_extax : ""; ?> <span class="price-old nowrap"><?php echo $option_value['option_discount'][$quantity]['extax_total']; ?></span><?php } ?> <?php if($option_value['option_discount'][$quantity]['special_extax_total']) { ?><span class="price-new nowrap"><?php echo $option_value['option_discount'][$quantity]['special_extax_total']; ?></span><?php } ?>
            <?php } ?>
            <?php } ?>
        </td>
        <?php } ?>
    </tr>
    <?php $j++; ?>
    <?php } ?>

    <?php if($option['stock_column']) { ?>
    <tr>
        <th><?php echo $text_col_stock; ?></th>
        <?php foreach ($option['option_value'] as $option_value) { ?>
        <th<?php if($option['price_format'] == 'both') { ?> colspan="2"<?php } ?> class="right<?php if(!$option_value['stock']) { ?> nostock<?php } ?>"><?php echo $option_value['stock']; ?></th>
        <?php } ?>
    </tr>
    <?php } ?>

    <?php if($option['qty_cart']) { ?>
    <tr>
        <th><?php echo $text_order; ?></th>
        <?php foreach ($option['option_value'] as $option_value) { ?>
        <td<?php if($option['price_format'] == 'both') { ?> colspan="2"<?php } ?> class="center">
        <input type="text" name="quantitypod[<?php echo $option_value['product_option_value_id']; ?>]" value="<?php echo $minimum; ?>" data-cart-poid="<?php echo $option['product_option_id']; ?>" data-cart-povid="<?php echo $option_value['product_option_value_id']; ?>" size="3"<?php if($option_value['subtract'] && !$option_value['stock']) { ?> disabled="disabled"<?php } ?>>
        <br>
        <input type="button" value="<?php echo $button_cart; ?>" data-cart-poid="<?php echo $option['product_option_id']; ?>" data-cart-povid="<?php echo $option_value['product_option_value_id']; ?>" class="button btn-podcart"<?php if($option_value['subtract'] && !$option_value['stock']) { ?> disabled="disabled"<?php } ?>>
        </td>
        <?php } ?>
    </tr>
    <?php } ?>

    <?php } //end not select ?>
    </tbody>
    <?php } ?>
</table>
<?php } ?>