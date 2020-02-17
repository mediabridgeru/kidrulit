<!DOCTYPE html>
<html dir="ltr" lang="ru">
<head>
<?php
$themeConfig = $this->config->get( 'themecontrol' );
$themeName =  $this->config->get('config_template');
require_once( DIR_TEMPLATE.$themeName."/template/bossthemes/boss_library.php" );
$helper = ThemeControlHelper::getInstance( $this->registry, $themeName );
?>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, minimum-scale=1.0">
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>

<link href='https://fonts.googleapis.com/css?family=Lato:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $themeName; ?>/stylesheet/bossthemes/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $themeName; ?>/stylesheet/bossthemes/boss_add_cart.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $themeName; ?>/stylesheet/stylesheet.css?v=5" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $themeName; ?>/stylesheet/bossthemes/cs.animate.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $themeName; ?>/stylesheet/bossthemes/jquery.jgrowl.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $themeName; ?>/stylesheet/bossthemes/responsive.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $themeName; ?>/stylesheet/bossthemes/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $themeName; ?>/stylesheet/bossthemes/font-awesome.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $themeName; ?>/stylesheet/bossthemes/bootstrap-custom.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $themeName; ?>/stylesheet/callbackphone/callbackphone.css" />
<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>

<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-migrate-1.2.1.min.js"></script>

<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
<script type="text/javascript" src="catalog/view/javascript/common.js"></script>

<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/callbackphone/jquery-ui-timepicker-addon.css" />
<script type="text/javascript" src="catalog/view/javascript/callbackphone/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="catalog/view/javascript/callbackphone/jquery-ui-timepicker-ru.js"></script>
<script type="text/javascript" src="catalog/view/javascript/callbackphone/simplemodal.js"></script>
<script type="text/javascript" src="catalog/view/javascript/callbackphone/mask.js"></script>
<script type="text/javascript" src="catalog/view/javascript/bossthemes/jquery.selectbox-0.2.js"></script>
<script type="text/javascript" src="catalog/view/javascript/bossthemes/bootstrap.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/bossthemes/jquery.jgrowl.js"></script>
<script type="text/javascript" src="catalog/view/javascript/tmstickup.js"></script>
<script type="text/javascript" src="catalog/view/javascript/device.min.js"></script>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<script type="text/javascript" src="catalog/view/javascript/bossthemes/bossthemes.js"></script>
<script type="text/javascript" src="catalog/view/javascript/bossthemes/jquery.appear.js"></script>
<script type="text/javascript" src="catalog/view/javascript/bossthemes/jquery.smoothscroll.min.js"></script>
<!--[if lt IE 9]>
  <script type="text/javascript" src="catalog/view/javascript/bossthemes/html5shiv.js"></script>
<script type="text/javascript" src="catalog/view/javascript/bossthemes/respond.min.js"></script>
<![endif]-->
<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie7.css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $themeName; ?>/stylesheet/ie6.css" />
<script type="text/javascript" src="catalog/view/javascript/DD_belatedPNG_0.0.8a-min.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('#logo img');
</script>
<![endif]-->
<!--[if IE 9]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $themeName; ?>/stylesheet/ie9.css" />
<![endif]-->
<!--[if IE 8]> 
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $themeName; ?>/stylesheet/ie8.css" />
<![endif]-->
<link rel="stylesheet" media="print" href="catalog/view/theme/<?php echo $themeName; ?>/stylesheet/print_stylesheet.css" />
<?php /******************THEME FONTS SETTINGS*********************/ ?>
<?php $editor = $this->config->get('b_General_Show'); ?>
<?php if (isset($editor)) {  ?>
<?php include "catalog/view/theme/".$themeName."/template/bossthemes/Boss_font_setting.php"; ?>
<?php include "catalog/view/theme/".$themeName."/template/bossthemes/Boss_color_setting.php"; ?>
<?php } ?>
<script>  
if (/*@cc_on!@*/false) {  
    document.documentElement.className+=' ie10';  
}  
</script>
<?php if ($stores) { ?>
<script type="text/javascript"><!--
$(document).ready(function() {
<?php foreach ($stores as $store) { ?>
$('body').prepend('<iframe src="<?php echo $store; ?>" style="display: none;"></iframe>');
<?php } ?>
});
//--></script>
<?php } ?>
<?php
$customcode = array();
$customcode =  $this->config->get('customcode');
?>
<!-- custom css-->
<?php if(isset($customcode['custom_css']) && $customcode['custom_css']){ ?>
	<style type="text/css">
	<?php echo $customcode['custom_css']; ?>
	</style>
<?php } ?>
<!-- end custom css-->

<!-- custom javascript-->
<?php if($customcode['custom_java']){ ?>
	<script type="text/javascript"><!--
	<?php echo $customcode['custom_java']; ?>
	//--></script>
<?php } ?>
<!-- end custom javascript-->

<?php echo $google_analytics; ?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		if(!device.mobile() && !device.tablet()){
			jQuery('#header-top').tmStickUp({
				active: true				});
		}
	})
</script>
</head>
<body class="<?php echo $helper->getPageClass();?>">
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-WS7P43"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WS7P43');</script>
<!-- End Google Tag Manager -->
<?php 
$b_Mode_CSS = $this->config->get('b_Mode_CSS');
if(!isset($b_Mode_CSS)){
	$b_Mode_CSS ="wide";
}
?>
<section id="page-container"  class="<?php echo $b_Mode_CSS; ?>">
<header id="header-top">
	<div class="container">
		<div class="row">
			<div class="header-top col-xs-24 col-sm-24 col-md-24">
				<div class="header-top-right">
					<div id="welcome">
						<?php if(isset($boss_login)){echo $boss_login; } ?>
					</div>
					<div class="links">
						<a class="m-wishlist" href="<?php echo $wishlist; ?>" id="wishlist-total"><?php echo $text_wishlist; ?></a>
						<a class="m-account" href="/dostavka">Доставка и оплата</a>
			   		</div>
					<?php echo $carthead; ?>
				</div>
				<div class="header-top-left">
					<div id="search" class=" ">
						<div class="button-search cs-tooltip" title="<?php echo $text_search; ?>" data-toggle="tooltip" data-placement="bottom" data-original-title="Найти">Найти</div>
						<input type="text" name="search" placeholder="<?php echo $text_search; ?>..." value="<?php echo $search; ?>" />
					</div>					
				</div>
			</div>
		</div>
	</div>
</header>
<header id="header">
	<section id="page-top">	</section>
	<div class="container">
		<div class="header-phone middle">
		<a href="tel:+79850929291">+7 (985) 092-92-91</a>
		</div>
		<div class="header-time middle">
			<?php echo $config_time; ?><br>
			
			
		</div>
	</div>
	<div class="container">
		<div class="header-bottom">
			<?php if ($logo) { ?>
				<div id="logo" ><a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a></div>
			<?php } ?>
			<!-- megamenu position-->
			<?php	
				$modules =$helper->getModulesByPosition('mainmenu'); 
				if( $modules ){
					foreach ($modules as $module) { 
						 echo $module; 
					} 
				}
			?>
			<?php echo $cart; ?>
			<!-- Slideshow Position-->
			<?php
				$modules =$helper->getModulesByPosition('slideshow'); 
				if( $modules ){
					foreach ($modules as $module) { 
						echo $module; 
					} 
				} 
			?>
		</div>
	</div>
</header>

<section id="boss-announce">
<div class="container">
<?php if ($error) { ?>   
	<div class="warning">
		<?php echo $error ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" />
	</div>
<?php } ?>
<div id="notification"></div>
</div>
</section>
<section id="content-container">
<!-- Block Header -->
<?php echo $helper->getBlockByPosition('b_Block_Header_Top'); ?>
<?php echo $helper->getBlockByPosition('b_Block_Header_Bottom'); ?>
<div class="container">