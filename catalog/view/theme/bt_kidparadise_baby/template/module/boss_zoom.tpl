<?php if($status){ ?>
<div id="boss_zoom">
    <div class="bosszoomtoolbox">
        <?php echo $product_stickers; ?>
        <?php if ($thumb) { ?>
        <div itemprop="image" class="image">
            <a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="cloud-zoom" id="zoom" rel="">
                <img id="image" src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
            </a>
        </div>
        <?php } ?>
        <?php if ($images) { ?>
        <div id="prod_additional_carousel" class="list_carousel responsive">
            <div class="owl-carousel">
                <?php foreach ($images as $image) { ?>
                <div class="image-additional">
                    <a class="cloud-zoom-gallery" rel="useZoom: 'zoom', smallImage: '<?php echo $image['thumb']; ?>'" href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>">
                        <img src="<?php echo $image['addition']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<script type="text/javascript"><!--
jQuery(document).ready(function($) {
	if(getWidthBrowser() > 767){
		$(".bosszoomtoolbox").css('display', 'block');
		if ($("#boss_zoom").html()){
			$(".product-info > .boss_zoom").html($("#boss_zoom").html());
			$("#boss_zoom").remove();
		}

        $.fn.CloudZoom.defaults = {
            adjustX: <?php echo $adjustX; ?>,
            adjustY: <?php echo $adjustY; ?>,
            tint: '<?php echo $tint; ?>',
            tintOpacity: <?php echo $tintOpacity; ?>,
            softFocus: <?php echo $softfocus; ?>,
            lensOpacity: <?php echo $lensOpacity; ?>,
            zoomWidth: '<?php if($zoom_area_width){ echo $zoom_area_width; }else{ echo 'auto';} ?>',
            zoomHeight: '<?php if($zoom_area_heigth){ echo $zoom_area_heigth; }else{ echo 'auto';} ?>',
            position: '<?php echo $position_zoom_area; ?>',
            showTitle: <?php echo $title_image; ?>,
            titleOpacity: <?php echo $title_opacity; ?>,
            smoothMove: '<?php echo $smoothMove; ?>'
        };
    } else {
		$(".bosszoomtoolbox").css('display', 'none');
	}
});
//--></script>
<?php } ?>
<script type="text/javascript"><!--
jQuery(document).ready(function($) {
	if(getWidthBrowser() > 767){
		//pass the images to Fancybox			
		
		$("#wrap").bind('click',function(){   
			var gallerylist = [];
			var imageHref = $("a#zoom").attr("href");
			var imageTitle = $("a#zoom").attr("title");
			gallerylist.push({
				href: imageHref,
				title: imageTitle
			}); 
			$.fancybox.open(gallerylist);
			return false;
		});
	}
});
//--></script>