<?php echo $header; ?>
<script>
    $(document).ready(function() {
        let el = $("*[data-modal]")[0];
        $(el).find("*[data-modal-close]").on('click', function() { $(el.parentElement).addClass("modal__overlay-hidden"); });
        $(el).find("*[data-modal-submit]").on('click', function() {
        let form = $(el).find("form")[0];
        if(!validate(el)) alert("Необходимо заполнить все поля и принять условия политики конфиденциальности!");
            else grecaptcha.execute();
        });
        $("#lowcost").on('click', function() {
            $($("*[data-modal]")[0].parentElement).removeClass("modal__overlay-hidden");
        });
    });

    function validate(form) {
        let link = $(form).find("input[name='link']")[0].value;
        let email = $(form).find("input[name='email']")[0].value;
        let phone = $(form).find("input[name='phone']")[0].value;
        let policy = $(form).find("input[name='policy']")[0].checked;
        return policy && (link.length>0) && (email.length>0) && (phone.length>0);
    }

    function onCaptchaExecuted() {
        $.ajax({
          type: "POST",
          url: "/index.php?route=information/lowcost",
          data: $("*[data-modal] form").serialize(),
          success: function (data) {
            data = JSON.parse(data);
            if(data["success"]) {
                alert("Ваша заявка принята!");
                $($("*[data-modal]")[0].parentElement).addClass("modal__overlay-hidden");
            } else {
                alert("Ошибка! Попробуйте повторить запрос.");
            }
          }
        });
    }
</script>
	<div class="modal__overlay modal__overlay-hidden">
		<div class="modal__window" data-modal>
			<h3 class="modal__caption">Нашли этот товар дешевле?</h3>
			<div class="modal__text">
				Пришлите нам ссылку на этот товар в другом магазине, и в течение 24-х часов Вы получите E-mail с уникальным промокодом. В случае отказа информация так же поступит на указанный Вами E-mail.
			</div>
			<form class="modal__form" onsubmit="return false;">
				<div class="modal__field">
					<label for="modal__name">Имя</label>
					<input type="text" id="modal__name" name = "name" />
				</div>
				<div class="modal__field modal__field-required">
					<label for="modal__email">Электронная почта</label>
					<input type="text" id="modal__email" name = "email" />
				</div>
				<div class="modal__field modal__field-required">
					<label for="modal__phone">Контактный телефон</label>
					<input type="text" id="modal__phone" name = "phone" />
				</div>
				<div class="modal__field modal__field-required">
					<label for="modal__link">Ссылка на товар в другом магазине</label>
					<input type="text" id="modal__name" name = "link" />
				</div>
				<div class="modal__field">
					<label for="modal__message">Ваше сообщение</label>
					<textarea style="resize:none;height: 150px;" name="message" id="modal__message"></textarea>
				</div>
				<div class="modal__field modal__field-checkbox">
					<input type="checkbox" id="modal__policy" name="policy" value="1"/>
					<label for = "modal__policy">Настоящим подтверждаю, что я ознакомлен и согласен с условиями <a href="./politika">оферты и политики конфиденциальности</a></label>
				</div>
				<input type="hidden" name="product" value="<?php echo $product_id; ?>" />
				<script src='https://www.google.com/recaptcha/api.js'></script>
				<div class="g-recaptcha" data-sitekey="6Lf_34kUAAAAAO4lhpAv1AXAc0dF54jXuh99OL6e" data-callback="onCaptchaExecuted" data-size="invisible"></div>
				<button class="modal__button modal__button-primary" data-modal-submit>Отправить заявку</button>
			</form>
			<div class="modal__closebutton" data-modal-close>×</div>
		</div>
	</div>

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

    <div id="content"><?php echo $content_top; ?>
        <div class="row">
            <div class="product-info">
            <?php if ($thumb || $images) { ?>
                <div class="boss_zoom col-lg-13 col-md-13 col-sm-24 col-xs-24">
                    <?php if ($thumb) { ?>
                        <div class="image">
                            <a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>">
                                <img id="image" src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
                            </a>
                            <?php echo $product_stickers; ?>
                        </div>
                    <?php } ?>
                    <?php if ($images) { ?>
                        <div id="prod_additional_carousel" class="list_carousel responsive">
                            <div class="owl-carousel">
                                <?php foreach ($images as $image) { ?>
                                    <div class="image-additional">
                                        <a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>">
                                            <img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
                <div class=" col-lg-11 col-md-11 col-sm-24 col-xs-24">
                    <h1 ><?php echo $heading_title; ?></h1>
                    <div class="review">
                        <div><img src="catalog/view/theme/<?php echo $this->config->get('config_template'); ?>/image/stars-<?php echo $rating; ?>.png" alt="<?php echo $reviews; ?>" />&nbsp;&nbsp;<a onclick="$('a[href=\'#tab-review\']').trigger('click');goToByScroll('tab-review');"><?php echo $reviews; ?></a><a  class="pull-right" onclick="$('a[href=\'#tab-review\']').trigger('click');goToByScroll('review-title');"><?php echo $text_write; ?></a></div>
                    </div>

                    <div class="description">
						<?php if($isnotopt) { ?>
						<div class="pull-right">
							<a id="lowcost" class="btn btn-color" style="font-size: 10pt;padding: 6px;">Нашли дешевле?<br />Снизим цену!</a>
						</div>
						<?php } ?>

                        <span><?php echo $text_stock; ?></span> <b class="stock"><?php echo $stock; ?></b><br />

						<?php if ($manufacturer) { ?>
                            <span><?php echo $text_manufacturer; ?></span> <a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a><br />
						<?php } ?>

                        <span><?php echo $text_model; ?></span> <?php echo $model; ?><br />

						<?php if ($reward) { ?>
                            <span><?php echo $text_reward; ?></span> <?php echo $reward; ?><br />
						<?php } ?>
                    </div>

					<?php if ($profiles): ?>
                        <div class="profiles options">
                            <h2><?php echo $text_payment_profile ?><span class="required"> *</span></h2>
                            <select class="profiles_sl" name="profile_id">
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
								<?php } ?>

								<?php if ($option['type'] == 'image') { ?>
                                    <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                                        <div class="title_text"><b><?php echo $option['name']; ?>:</b>
											<?php if ($option['required']) { ?>
                                                <span class="required">*</span>
											<?php } ?></div>
                                        <?php if($this->myocpod->showPod($option['product_option_id']) && $option['type'] != 'select') :
                                        echo $this->getChild('myoc/pod', array('product_option_id' => $option['product_option_id']));
                                        $option['option_value'] = array();
                                        endif; ?>
                                        <?php if (!empty($option['option_value'])) : ?>
                                        <table class="option-image">
                                            <?php foreach($option['option_value'] as $option_value) { ?>
                                            <tr>
                                                <td style="width: 1px;"><input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="qs-option-value-<?php echo $option_value['product_option_value_id']; ?>" /></td>
                                                <td>
                                                    <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>">
                                                        <img src="<?php echo $option_value['ob_thumb']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" />
                                                    </label>
                                                </td>
                                                <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                                                        <?php if ($option_value['price']) { ?>
                                                        (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                                                        <?php } ?>
                                                    </label>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </table>
                                        <?php endif; ?>
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
                                        <span class="button"><input type="button" value="<?php echo $button_upload; ?>" id="button-option-<?php echo $option['product_option_id']; ?>" class="btn btn-primary"></span>
                                        <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" />
                                    </div>
								<?php } ?>

								<?php if ($option['type'] == 'date') { ?>
                                    <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                                        <div class="title_text"><b><?php echo $option['name']; ?>:</b>
											<?php if ($option['required']) { ?>
                                                <span class="required">*</span>
											<?php } ?></div>
                                        <input type="text" class="text datetime_box date" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>"  />
                                    </div>
								<?php } ?>

								<?php if ($option['type'] == 'datetime') { ?>
                                    <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                                        <div class="title_text"><b><?php echo $option['name']; ?>:</b>
											<?php if ($option['required']) { ?>
                                                <span class="required">*</span>
											<?php } ?></div>
                                        <input type="text" class="text datetime" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" />
                                    </div>
								<?php } ?>

								<?php if ($option['type'] == 'time') { ?>
                                    <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                                        <div class="title_text"><b><?php echo $option['name']; ?>:</b>
											<?php if ($option['required']) { ?>
                                                <span class="required">*</span>
											<?php } ?></div>
                                        <input type="text" class="text datetime_box time" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" />
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
                                    <button onclick="changeQtyPp(1); return false;" class="increase" title="Прибавить">+</button>
                                    <button onclick="changeQtyPp(-1); return false;" class="decrease" title="Убавить">-</button>
                                </div>
                                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
                            </div>
						<?php } ?>

                        <div class="price_info" data-price="<?php echo $price; ?>">
							<?php if ($price) { ?>
								<?php if (!$special) { ?>
                                    <span class="price"><?php echo $price; ?></span> <span class="currency">руб.</span>
								<?php } else { ?>
                                    <span class="price-new"><?php echo $special; ?></span>  <span class="price-old"><?php echo $price; ?></span> <span class="currency">руб.</span>
								<?php } ?>
							<?php } ?>

							<?php if ($tax) { ?>
                                <span class="price-tax"><?php echo $text_tax; ?> <?php echo $tax; ?> руб.</span>
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

                        <div class=""><span class="btn btn-color"  title="<?php echo $button_cart; ?>" ><input type="button" value="<?php echo $button_cart; ?>" id="button-cart" title="<?php echo $button_cart; ?>" /></span></div>

                        <div class="action">
                            <div class="compare"><a class="action-button" onclick="boss_addToCompare('<?php echo $product_id; ?>');" ><?php echo $button_compare; ?></a></div>
                            <div class="wishlist"><a class="action-button" onclick="boss_addToWishList('<?php echo $product_id; ?>');" ><?php echo $button_wishlist; ?></a></div>
                        </div>

                        <div class="share"><!-- AddThis Button BEGIN -->
                            <div class="addthis_default_style"><a class="addthis_button_compact"><?php echo $text_share; ?></a> <a class="addthis_button_email"></a><a class="addthis_button_print"></a> <a class="addthis_button_facebook"></a> <a class="addthis_button_twitter"></a></div>
                            <script type="text/javascript" src="//s7.addthis.com/js/250/addthis_widget.js"></script><!-- AddThis Button END -->
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div id="tabs" class="htabs"><a href="#tab-description"><?php echo $tab_description; ?></a>
        <?php if ($attribute_groups) { ?>
            <a href="#tab-attribute"><?php echo $tab_attribute; ?></a>
        <?php } ?>

        <?php if ($review_status) { ?>
            <a href="#tab-review"><?php echo $tab_review; ?></a>
        <?php } ?>
        </div>

        <h2 class="ta-header"><span><?php echo $tab_description; ?></span></h2>

        <div id="tab-description" class="tab-content"><?php echo $description; ?></div>

		<?php if ($attribute_groups) { ?>
            <div id="tab-attribute" class="tab-content">
                <table class="attribute">
                <?php foreach ($attribute_groups as $attribute_group) { ?>
                    <thead>
                    <tr>
                        <td colspan="2"><?php echo $attribute_group['name']; ?></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
                        <tr>
                            <td><?php echo $attribute['name']; ?></td>
                            <td><?php echo $attribute['text']; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                <?php } ?>
                </table>
            </div>
		<?php } ?>

		<?php if ($review_status) { ?>
            <h2 class="ta-header"><span><?php echo $tab_review; ?></span></h2>
            <div id="tab-review" class="tab-content">
                <div id="review"></div>
                <h2 id="review-title"><?php echo $text_write; ?></h2>
                <b><?php echo $entry_name; ?></b><br />
                <input type="text" name="name" value="" />
                <br />
                <br />
                <b><?php echo $entry_review; ?></b>
                <textarea name="text" cols="40" rows="8" ></textarea>
                <span style="font-size: 11px;"><?php echo $text_note; ?></span><br />
                <br />
                <b><?php echo $entry_rating; ?></b> <span><?php echo $entry_bad; ?></span>&nbsp;
                <input type="radio" name="rating" value="1" />&nbsp;
                <input type="radio" name="rating" value="2" />&nbsp;
                <input type="radio" name="rating" value="3" />&nbsp;
                <input type="radio" name="rating" value="4" />&nbsp;
                <input type="radio" name="rating" value="5" />&nbsp;
                <span><?php echo $entry_good; ?></span><br />
                <br />

                <b><?php echo $entry_captcha; ?></b><br />
                <input type="text" name="captcha" value="" />
                <br />
                <img src="index.php?route=product/product/captcha" alt="" id="captcha" /><br />
                <br />

                <div class="buttons">
                    <div class="left"><a id="button-review" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
                </div>
            </div>
		<?php } ?>

		<?php if ($tags) { ?>
            <div class="tags"><b><?php echo $text_tags; ?></b>
            <?php for ($i = 0; $i < count($tags); $i++) { ?>
                <?php if ($i < (count($tags) - 1)) { ?>
                    <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
                <?php } else { ?>
                    <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
                <?php } ?>
            <?php } ?>
            </div>
		<?php } ?>

		<?php if ($products) { ?>

            <div id="tab-related">

                <h2 class="ta-related"><span><?php echo $tab_related; ?> (<?php echo count($products); ?>)</span></h2>

                <div class="carousel-button">
                    <a id="prev_related" class="prev nav_thumb" href="javascript:void(0)" title="prev">Prev</a>
                    <a id="next_related" class="next nav_thumb" href="javascript:void(0)" title="next">Next</a>
                </div>

                <div class="list_carousel responsive" >

                    <ul id="product_related" class="content-products box-product product-grid"><?php foreach ($products as $product) { ?><li data-prodid="<?php echo $product['product_id']; ?>"><div>
                    <?php if ($product['thumb']) { ?>
                        <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /><b></b></a>
                            <div class="cart"><a onclick="boss_addToCart('<?php echo $product['product_id']; ?>');" class="btn btn-color" title="<?php echo $button_cart; ?>"><span><?php echo $button_cart; ?></span></a></div>
                        </div>
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

                    <div class="action boss-actions ">
                        <div class="wishlist"><a class="button button-grey" onclick="boss_addToWishList('<?php echo  $product['product_id']; ?>');"><span><?php echo $button_wishlist; ?></span></a></div><div class="compare"><a class="button button-grey" onclick="boss_addToCompare('<?php echo  $product['product_id'];  ?>');"><span><?php echo $button_compare; ?></span></a></div>
                    </div></div>

                </li><?php } ?></ul>
                </div>
            </div>
		<?php } ?>

		<?php echo $content_bottom; ?></div>
<?php // added ?>
<?php if ($products2) { ?>
<div class="box box-recent" id="recent-pdct">
    <div class="box-heading">Рекомендуемые товары</div>
    <div class="box-content">
        <div class="box-product">
            <?php foreach ($products2 as $key => $product) { ?><div class="col-xs-24 col-sm-8 col-md-6 col-lg-6 not-animated" data-prodid="<?php echo $product['product_id']; ?>" >
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

        </div>
    </div>
</div>
<?php } ?>
<?php // end ?>
<script type="text/javascript"><!--
        $(document).ready(function() {
            var $product_info = $('body').find('.product-info');

            var $inputs = $product_info.find('input[name^="option"][type=\'checkbox\'], input[type=\'hidden\'], input[name^="option"][type=\'radio\'], select[name^="option"]');

            if ($inputs.length) {
                $inputs.change(function(){
                    var $selected = $product_info.find('input[name^="option"][type=\'checkbox\']:checked, input[type=\'hidden\'], input[name^="option"][type=\'radio\']:checked, select[name^="option"]');
                    var option_val	= $(this).val();
                    var data = $selected.serialize() + '&option_value_id='+option_val;
                    obUpdate($(this), data);
                });

                // Force a change on load to support mods like default product options and any "onload" adjustments
                var $first_option = $('.option .option-cell').first().find('input[type="radio"]');
                if ($first_option.length) {
                    $first_option.prop("checked", true);
                    $first_option.change();
                }
            }
        });

        function obUpdate($this, datas) {
            var $product_info = $('body').find('.product-info');

            var option_val	= $this.val();

            // Remove existing option info
            $('#option_info').remove();
            $('.ob_ajax_error').remove();

            var $zoom = $('#zoom');
            var $image = $('#image');
            var $parent = $image.parent();

            var origSrc = $image.attr('src');
            var origTitle = $image.attr('title');
            var origAlt = $image.attr('alt');
            var origPopup = $image.parent().attr('href');

            if (option_val) {
                var $price_info = $product_info.find('.price_info');
                var $price = $price_info.find('.price');
                var $price_tax = $price_info.find('.price-tax');
                var $price_cell = $this.closest('tr').find('td.price-cell');

                if ($price_cell.length) {
                    var option_price = $price_cell.text();
                    var price = StrToNum(option_price);

                    if ($price_cell.children().length === 2) {
                        $price.remove();
                        $price_info.find('.price-old').remove();
                        $price_info.find('.price-new').remove();
                        $price_info.prepend($price_cell.html());

                        var $price_display = $price_info.find('.price-old');
                        price = StrToNum($price_display.text());
                        $price_display.text(price);

                        var $special = $price_info.find('.price-new');
                        var special_price = StrToNum($special.text());
                        $special.text(special_price);
                        $price_tax.text('Без НДС: '+special_price+' руб.');
                    } else {
                        $price_info.data("price", price);
                        $price.text(price);
                        $price_tax.text('Без НДС: '+price+' руб.');
                    }
                }

                // ajax lookup
                $.ajax({
                    type: 'post',
                    url: 'index.php?route=product/product/updateImage',
                    dataType: 'json',
                    data: datas,
                    beforeSend: function() {
                        $this.after('<img class="ob_loading" src="catalog/view/javascript/ajax_load_sm.gif" alt=""/>');
                    },
                    success: function (data) {

                        // Update the main image with the new image.
                        var swatch 		= data.ob_swatch;
                        var thumb 		= data.ob_thumb;
                        var popup 		= data.ob_popup;
                        var info 		= data.ob_info;
                        var stock       = data.quantity;
                        var name	    = data.name;

                        // Set to true if you want options without images to revert back to the stock image
                        var revert = false;

                        // Swap Image if exists...
                        if (thumb) {
                            $image.attr('src', thumb);
                            $image.attr('title', name);
                            $image.attr('alt', name);
                            $parent.attr('title', name);
                            $parent.attr('alt', name);
                            $parent.attr('href', popup);

                            // CloudZoom support
                            $zoom.attr('href', popup);
                            $image.attr('data-zoom-image', popup);
                            $('.zoomWindow').css("background-image",'url("'+popup+'")');
                            $zoom.CloudZoom();
                        } else if (revert) { //revert back to main if image not exists
                            $image.attr('src', origSrc);
                            $image.attr('title', origTitle);
                            $image.attr('title', origAlt);
                            $parent.attr('title', origTitle);
                            $parent.attr('alt', origAlt);
                            $parent.attr('href', origPopup);

                            // CloudZoom support
                            $('.image a').attr('href', origPopup);
                            $image.attr('data-zoom-image', origPopup);
                            $('.zoomWindow').css("background-image",'url("'+origPopup+'")');
                        }

                        // Add under main image or popup
                        if (info) {
                            var xinfo = info.replace("~~", "");
                            if (info.indexOf("~~") != -1) { alert(xinfo); }
                            $image.parent().after('<p id="option_info">'+xinfo+'</p>');
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        console.log('Options Boost: Ajax Lookup Error. Please try again.');
                    },
                    complete: function() {
                        $('.ob_loading').remove();
                    }
                });

            } else {
                $image.attr('src', origSrc);
                $image.attr('title', origTitle);
                $image.attr('title', origAlt);
                $parent.attr('title', origTitle);
                $parent.attr('alt', origAlt);
                $parent.attr('href', origPopup);
            }
        }
    //--></script>
    <script type="text/javascript"><!--
        $(window).load(function(){
            var $images_carousel = $('#prod_additional_carousel .owl-carousel');
            if ($images_carousel.length) {
                if (typeof(owlCarousel)) {
                    $images_carousel.owlCarousel({
                        // Most important owl features
                        items : 5,
                        itemsDesktop : [1199,5],
                        itemsDesktopSmall : [980,4],
                        itemsTablet: [768,3],
                        itemsTabletSmall: false,
                        itemsMobile : [479,2],
                        singleItem : false,

                        //Basic Speeds
                        slideSpeed : 200,
                        paginationSpeed : 800,
                        rewindSpeed : 1000,

                        //Autoplay
                        autoPlay : false,
                        stopOnHover : true,

                        // Navigation
                        navigation : true,
                        navigationText : ["<",">"],
                        rewindNav : true,
                        scrollPerPage : false,

                        //Pagination
                        pagination : false,
                        paginationNumbers: false,

                        // Responsive
                        responsive: true,
                        responsiveRefreshRate : 200,
                        responsiveBaseWidth: window,

                        //Lazy load
                        lazyLoad : false,
                        lazyFollow : true,

                        //Auto height
                        autoHeight : false,

                        //Mouse Events
                        mouseDrag : true,
                        touchDrag : true,

                        //Transitions
                        transitionStyle : false
                    });

                    $('.cloud-zoom, .cloud-zoom-gallery').CloudZoom();
                }
            }

            var $product_related_carousel = $('#product_related .owl-carousel');
            if ($product_related_carousel.length) {
                if (typeof(owlCarousel)) {
                    $product_related_carousel.owlCarousel({
                        // Most important owl features
                        items : 5,
                        itemsDesktop : [1199,5],
                        itemsDesktopSmall : [980,4],
                        itemsTablet: [768,3],
                        itemsTabletSmall: false,
                        itemsMobile : [479,2],
                        singleItem : false,

                        //Basic Speeds
                        slideSpeed : 200,
                        paginationSpeed : 800,
                        rewindSpeed : 1000,

                        //Autoplay
                        autoPlay : false,
                        stopOnHover : true,

                        // Navigation
                        navigation : true,
                        navigationText : ["<",">"],
                        rewindNav : true,
                        scrollPerPage : false,

                        //Pagination
                        pagination : false,
                        paginationNumbers: false,

                        // Responsive
                        responsive: true,
                        responsiveRefreshRate : 200,
                        responsiveBaseWidth: window,

                        //Lazy load
                        lazyLoad : false,
                        lazyFollow : true,

                        //Auto height
                        autoHeight : false,

                        //Mouse Events
                        mouseDrag : true,
                        touchDrag : true,

                        //Transitions
                        transitionStyle : false
                    });
                }
            }
        });

        function goToByScroll(id){
            $('html,body').animate({scrollTop: $("#"+id).offset().top},'slow');
            $('h2.ta-header').removeClass('selected');
            $('#tab-review').prev().addClass('selected');
        }

        $(document).ready(function() {
            product_resize();
        });

        $(window).resize(function() {
            product_resize();
        });

        function product_resize()   {
            if(getWidthBrowser() < 768){
                $('#tabs').hide();
                $('h2.ta-header').show();
            } else {
                $('h2.ta-header').hide();
                $('#tabs').show();

                var list = $('#tabs a');
                list.each(function( index ) {
                    if($(this).hasClass('selected')){
                        $(this).click();
                    }
                });
            }
        }

        $('h2.ta-header').first().addClass('selected');

        $('h2.ta-header').click(function() {
            if ($(this).next().css('display') == 'none') {
                $(this).next().show();
                $(this).addClass('selected');
            } else {
                $(this).next().hide();
                $(this).removeClass('selected');
            }
            return false;
        }).next().hide();
    //--></script>
    <script type="text/javascript"><!--
        $('select[name="profile_id"], input[name="quantity"]').change(function(){
            $.ajax({
                url: 'index.php?route=product/product/getRecurringDescription',
                type: 'post',
                data: $('input[name="product_id"], input[name="quantity"], select[name="profile_id"]'),
                dataType: 'json',
                beforeSend: function() {
                    $('#profile-description').html('');
                },
                success: function(json) {
                    $('.success, .warning, .attention, .information, .error').remove();

                    if (json['success']) {
                        $('#profile-description').html(json['success']);
                    }
                }
            });
        });

        $('#button-cart').bind('click', function() {
            $.ajax({
                url: 'index.php?route=bossthemes/cart/add',
                type: 'post',
                data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
                dataType: 'json',
                success: function(json) {
                    $('.warning, .attention, .information, .error').remove();
                    if (json['error']) {
                        if (json['error']['option']) {
                            for (i in json['error']['option']) {
                                $('#option-' + i).append('<span class="error">' + json['error']['option'][i] + '</span>');
                            }
                        }

                        if (json['error']['profile']) {
                            $('select[name="profile_id"]').after('<span class="error">' + json['error']['profile'] + '</span>');
                        }
                    }

                    if (json['success']) {
                        addProductNotice(json['title'], json['thumb'], json['success'], 'success');
                        $('#cart-total').html(json['total']);
                        $('#boss_cart').load('index.php?route=module/cart #boss_cart > *');
                        $('#top_cart').load('index.php?route=module/carthead #top_cart > *');
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
                new AjaxUpload('#button-option-<?php echo $option['product_option_id']; ?>', {
                    action: 'index.php?route=product/product/upload',
                    name: 'file',
                    autoSubmit: true,
                    responseType: 'json',
                    onSubmit: function(file, extension) {
                        $('#button-option-<?php echo $option['product_option_id']; ?>').after('<img src="catalog/view/theme/default/image/loading.gif" class="loading" style="padding-left: 5px;" />');
                        $('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', true);
                    },
                    onComplete: function(file, json) {
                        $('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', false);

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

    <script type="text/javascript"><!--
        $('#review .pagination a').live('click', function() {
            $('#review').fadeOut('slow');
            $('#review').load(this.href);
            $('#review').fadeIn('slow');

            return false;
        });

        $('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

        $('#button-review').bind('click', function() {
            $.ajax({
                url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
                type: 'post',
                data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
                beforeSend: function() {
                    $('.success, .warning').remove();
                    $('#button-review').attr('disabled', true);
                    $('#review-title').after('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
                },
                complete: function() {
                    $('#button-review').attr('disabled', false);
                    $('.attention').remove();
                },
                success: function(data) {
                    if (data['error']) {
                        $('#review-title').after('<div class="warning">' + data['error'] + '</div>');
                    }

                    if (data['success']) {
                        $('#review-title').after('<div class="success">' + data['success'] + '</div>');

                        $('input[name=\'name\']').val('');
                        $('textarea[name=\'text\']').val('');
                        $('input[name=\'rating\']:checked').attr('checked', '');
                        $('input[name=\'captcha\']').val('');
                    }
                }
            });
        });
    //--></script>
    <script type="text/javascript"><!--
        $('#tabs a').tabs();
    //--></script>
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
    //--></script>

<?php echo $footer; ?>