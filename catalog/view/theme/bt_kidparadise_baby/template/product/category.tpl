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
<?php echo $column_left; ?>	<?php echo $column_right; ?>
<div id="content">
    <?php echo $content_top; ?>
    <?php if ($thumb || $description) { ?>
    <div class="category-info">
        <?php if ($thumb) { ?>
        <div class="image"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" /></div>
        <?php } ?>
        <div  class="category-info-2">
            <h1><?php echo $heading_title; ?></h1>
            <?php if ($description) { ?>
            <?php echo $description; ?>
            <?php } ?>
            <?php if ($categories) { ?>
            <h2><?php echo $text_refine; ?></h2>
            <div class="category-list">
                <?php if (count($categories) <= 5) { ?>
                <ul class="list-unstyled">
                    <?php foreach ($categories as $category) { ?>
                    <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
                    <?php } ?>
                </ul>
                <?php } else { ?>
                <?php for ($i = 0; $i < count($categories);) { ?>
                <ul class="list-unstyled">
                    <?php $j = $i + ceil(count($categories) / 4); ?>
                    <?php for (; $i < $j; $i++) { ?>
                    <?php if (isset($categories[$i])) { ?>
                    <li><a href="<?php echo $categories[$i]['href']; ?>"><?php echo $categories[$i]['name']; ?></a></li>
                    <?php } ?>
                    <?php } ?>
                </ul>
                <?php } ?>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
        <?php /* if ($description_bottom) { ?>
        <div class="description_bottom">
            <?php echo $description_bottom; ?>
        </div>
        <?php } */ ?>
    </div>
    <?php } ?>
    <?php if ($products) { ?>
    <div class="product-filter">
        <div class="product-compare"><a href="<?php echo $compare; ?>" id="compare-total"><?php echo $text_compare; ?></a></div>
        <div class="sort">
            <b><?php echo $text_sort; ?></b>
            <label class="select">
                <select onchange="location = this.value;">
                    <?php foreach ($sorts as $sorts) { ?>
                    <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
                    <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
                    <?php } ?>
                    <?php } ?>
                </select>
            </label>
        </div>
        <div class="limit">
            <b><?php echo $text_limit; ?></b>
            <label class="select">
                <select  onchange="location = this.value;">
                    <?php foreach ($limits as $limits) { ?>
                    <?php if ($limits['value'] == $limit) { ?>
                    <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
                    <?php } ?>
                    <?php } ?>
                </select>
            </label>
        </div>
        <div class="display"><b><?php echo $text_display; ?></b> <?php echo $text_list; ?> <b>/</b> <a onclick="display('grid');"><?php echo $text_grid; ?></a></div>
    </div>
    <div class="row">
        <div class="product-list" >
            <?php $item = 4; $col = 24/$item; ?>
            <?php foreach ($products as $key => $product) { ?>
            <div class="col-sm-4 col-xs-24 col-md-<?php echo $col; ?> " data-prodid="<?php echo $product['product_id']; ?>">
                <div class="row not-animated" >
                    <div>
                        <?php if ($product['thumb']) { ?>
                        <div class="image">
                            <div class="boss_image">
                                <a href="<?php echo $product['href']; ?>"><img class="image-fly" src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /><b></b></a>
                                <?php if ($product['price'] && $product['special']) { ?>
                                <!--<span class="boss-label"><img alt="label" src="catalog/view/theme/bt_kidparadise_baby/image/sale.png" /><i><?php echo $product['percent']; ?>%</i></span>-->
                                <?php } ?>
                                <?php echo $product['sticker']; ?>
                            </div>
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
                            <span class="price-new"><?php echo $product['special']; ?></span><span class="price-old"><?php echo $product['price']; ?></span>
                            <?php } ?>
                            <?php if ($product['tax']) { ?>
                            <br />
                            <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                            <?php } ?>
                        </div>
                        <?php } ?>
                        <div class="stock_status<?php if($product['not_in_stock']) echo ' product_unavailable'; ?>">
                            <?php echo $product['stock_status']; ?>
                        </div>
                        <div class="description"><?php echo $product['description']; ?></div>
                        <div class="cart"><span class="btn btn-color"  title="<?php echo $button_cart; ?>" ><input  type="button" value="<?php echo $button_cart; ?>" onclick="boss_addToCart('<?php echo $product['product_id']; ?>');" data-parent=".parent-fly" ></span></div>
                        <div class="boss_actions">
                            <div class="compare"><a  onclick="boss_addToCompare('<?php echo $product['product_id']; ?>');"><?php echo $button_compare; ?></a></div>
                            <div class="wishlist"><a  onclick="boss_addToWishList('<?php echo $product['product_id']; ?>');"><?php echo $button_wishlist; ?></a></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php  } ?>
        </div>
    </div>
    <div class="pagination"><?php echo $pagination; ?></div>
</div>
<?php } ?>
<?php if (!$categories && !$products) { ?>
<div class="content"><?php echo $text_empty; ?></div>
<div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
</div>
<?php } ?>
<?php echo $content_bottom; ?>
<?php if ($description_bottom) { ?>
<div class="description_bottom">
    <?php echo $description_bottom; ?>
</div>
<?php } ?>
<script type="text/javascript"><!--
    function display(view) {
        if (view == 'list') {
            $('.product-grid').attr('class', 'product-list');
            $('.product-list > div > div').each(function (index, element) {
                html = '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-24">';
                html += '<div class="image">';
                var btnQuickshop = $(element).find('.btn-quickshop').html();
                if (btnQuickshop != null) {
                    html += '<div class="btn-quickshop">' + btnQuickshop + '</div>';
                }

                var boss_image = $(element).find('.boss_image').html();
                if (boss_image != null) {
                    html += '<div class="boss_image">' + boss_image + '</div>';
                }

                html += '</div>';
                html += '</div>';

                html += '<div class="col-lg-18 col-md-18 col-sm-18 col-xs-24">';
                var rating = $(element).find('.rating').html();
                if (rating != null) {
                    html += '<div class="rating">' + rating + '</div>';
                }

                html += '  <div class="name">' + $(element).find('.name').html() + '</div>';

                var price = $(element).find('.price').html();
                if (price != null) {
                    html += '<div class="price">' + price + '</div>';
                }

                html += '  <div class="stock_status">' + $(element).find('.stock_status').html() + '</div>';

                html += '  <div class="description">' + $(element).find('.description').html() + '</div>';

                var cart = $(element).find('.cart').html();
                if (cart != null) {
                    html += '<div class="cart">' + cart + '</div>';
                }

                var boss_actions = $(element).find('.boss_actions').html();

                html += '<div class="boss_actions">' + boss_actions + '</div>';

                html += '<div>';

                $(element).html(html);

            });

            $('.display').html('<b><?php echo $text_display; ?></b> <a title="<?php echo $text_grid; ?>" class="no-active-gird" onclick="display(\'grid\');"><?php echo $text_grid; ?></a><span class="active-list" title="<?php echo $text_list; ?>"><?php echo $text_list; ?></span>');

            $.totalStorage('display', 'list');

        } else {

            $('.product-list').attr('class', 'product-grid');

            $('.product-grid > div > div').each(function(index, element) {
                html = '';
                html += '<div class="image">';

                var btnQuickshop = $(element).find('.btn-quickshop').html();

                if (btnQuickshop != null) {
                    html += '<div class="btn-quickshop">' + btnQuickshop + '</div>';
                }

                var boss_image = $(element).find('.boss_image').html();
                if (boss_image != null) {
                    html += '<div class="boss_image">' + boss_image + '</div>';
                }

                var cart = $(element).find('.cart').html();
                if (cart != null) {
                    html += '<div class="cart">' + cart + '</div>';
                }

                html += '</div>';

                var rating = $(element).find('.rating').html();
                if (rating != null) {
                    html += '<div class="rating">' + rating + '</div>';
                }

                html += '<div class="name">' + $(element).find('.name').html() + '</div>';

                var price = $(element).find('.price').html();

                if (price != null) {
                    html += '<div class="price">' + price + '</div>';
                }

                html += '  <div class="' + $(element).find('.stock_status').attr('class') + '">' + $(element).find('.stock_status').html() + '</div>';

                html += '<div class="description">' + $(element).find('.description').html() + '</div>';

                var boss_actions = $(element).find('.boss_actions').html();

                html += '<div class="boss_actions">' + boss_actions + '</div>';

                $(element).html(html);

            });

            $('.display').html('<b><?php echo $text_display; ?></b> <span class="active-gird" title="<?php echo $text_grid; ?>" ><?php echo $text_grid; ?></span><a title="<?php echo $text_list; ?>" class="no-active-list" onclick="display(\'list\');"><?php echo $text_list; ?></a>');

            $.totalStorage('display', 'grid');
        }
    }

    view = $.totalStorage('display');

    if (view) {
        display(view);
    } else {
    <?php if ($this->config->get('b_General_P_Display') == 'grid') { ?>
            display('grid');
        <?php } else { ?>
            display('list');
        <?php } ?>
    }

    if (getWidthBrowser() < 768) {
        display('grid');
    }
//-->
</script>
<?php echo $footer; ?>