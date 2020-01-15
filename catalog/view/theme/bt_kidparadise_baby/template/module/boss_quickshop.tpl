<script type="text/javascript"><!--
    $(window).load(function() {
        boss_quick_shop();
        $('.display').bind('click', function() {
            $('.sft_quickshop_icon').remove();
            boss_quick_shop();
        });
    });

    function boss_quick_shop() {
    <?php foreach($selecters as $selecter){ ?>
            $('<?php echo $selecter; ?>').each(function(index, value) {
                product_id = $(this).attr('data-prodid');
                var _qsHref = '<div class=\"btn-quickshop\" ><button  title =\"<?php echo $text; ?>\" onclick=\"getModalContent(' + product_id + ');\" class=\"btn fadeOutLeft sft_quickshop_icon \" data-toggle=\"modal\" data-target=\"#myModal\"><span><?php echo $text; ?></span></button></div>';
                $('.image', this).find(".btn-quickshop").remove();
                $('.image', this).prepend(_qsHref);
            });
        <?php } ?>
        var content_modal = '<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;"></div><div class="loading" style="position:fixed;top:50%;left:50%"></div>';
        myModal = $('#myModal').length;
        if (myModal == 0) {
            $('#content-container').append(content_modal);
        }
    }

    function getModalContent(product_id) {
        $.ajax({
            url: 'index.php?route=module/boss_quick_shop_product/&product_id=' + product_id,
            dataType: 'json',
            async: true,
            beforeSend: function() {
                $('.loading').html('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
                $('#myModal').html('');
            },
            complete: function() {
                $('.wait').remove();
            },
            success: function(json) {
                $('#myModal').html(json['html']);
                $('#myModal > .modal-dialog').css({
                    'width': '95%',
                    'max-width': '<?php echo $width; ?>px'
                });

                var $images_carousel = $('#qs_additional_carousel .owl-carousel');
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
                    }
                }

                if (getWidthBrowser() > 767) {
                    $('.cloud-zoom, .cloud-zoom-gallery').CloudZoom();

                    //pass the images to Fancybox
                    $("#content_quick_shop #wrap").bind('click', function() {
                        var gallerylist = [];
                        var imageHref = $("a#qs_zoom").attr("href");
                        var imageTitle = $("a#qs_zoom").attr("title");
                        gallerylist.push({
                            href: imageHref,
                            title: imageTitle
                        });
                        $.fancybox.open(gallerylist);
                        return false;
                    });
                }

                var $product_info = $('body').find('.product-info-qs');

                var $qs_inputs = $product_info.find('input[name^="option"][type=\'checkbox\'], input[type=\'hidden\'], input[name^="option"][type=\'radio\'], select[name^="option"]');

                if ($qs_inputs.length) {
                    $qs_inputs.change(function(){
                        var $selected = $product_info.find('input[name^="option"][type=\'checkbox\']:checked, input[type=\'hidden\'], input[name^="option"][type=\'radio\']:checked, select[name^="option"]');
                        var option_val	= $(this).val();
                        var data = $selected.serialize() + '&option_value_id='+option_val;
                        QsObUpdate($(this), data);
                    });

                    // Force a change on load to support mods like default product options and any "onload" adjustments
                    var $first_option = $('.option .option-cell').first().find('input[type="radio"]');
                    if ($first_option.length) {
                        $first_option.prop("checked", true);
                        $first_option.change();
                    }
                }

            }

        })
    }

    function QsObUpdate($this, datas) {
        var $product_info = $('body').find('.product-info-qs');

        var option_val	= $this.val();

        // Remove existing option info
        jQuery('#option_info').remove();
        jQuery('.ob_ajax_error').remove();

        var $zoom = $('#qs_zoom');

        var $image = $('#qs-image');
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
            jQuery.ajax({
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
                        $('.cloud-zoom, .cloud-zoom-gallery').CloudZoom();
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
                    jQuery('.ob_loading').remove();
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