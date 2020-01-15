<?php 
$url = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'&page=callback';

$get = explode('=', $_GET['state']);
$get = array_pop($get);
$url = str_replace(array('%26', '%3D'), array('&', '='), $url);

$url = str_replace('vendors/anyport/gdrivecallback.php', $get . '/index.php?route=module/anyport/googledrive', $url);
$url = str_replace('?state=', '&token=', $url);
$url = str_replace('state=', 'token=', $url);

if (!empty($_GET['error'])) {
	print_r ('<script>
	if(window.opener && !window.opener.closed) {
		window.opener.alert("'.str_replace('"', '\\"', $_GET['error']).'");
		window.opener.anyportPopup.close();
	}
	</script>');		
} else header('Location: '.(!empty($_SERVER['HTTPS']) ? 'https://' : 'http://').$url);
?>