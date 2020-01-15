<?php
set_time_limit(0);
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
header("Content-type: text/html; charset=utf-8");
require_once dirname(dirname(__FILE__)).'/config.php';
define('LOG_ERROR', dirname(__FILE__).'/log_err.txt');

$FTP = array();
// Настройки для подключения к FTP серверу (для загрузки xml файла)
$FTP['server'] = 'uploadprices.akusherstvo.ru'; // сервер
$FTP['port'] = '2221'; // порт
$FTP['username'] = 'linden'; // имя пользователя
$FTP['password'] = 'thahPae2wo'; // пароль пользователя для доступа к FTP-серверу

$xml_file = date('d.m.Y').'_tovar.xml';

clean_log();

$db_link = db_connect();
if (!$db_link) exit('Не удалось соединится с БД');

$cat_name = 'Аксессуары к детским коляскам';
$cat_id = 0;
$sql = "SELECT `category_id` FROM `".DB_PREFIX."category_description` WHERE `name`='{$cat_name}'";
$res = query($sql);
while($r = mysqli_fetch_assoc($res)) $cat_id = $r['category_id'];

$catIDs = array($cat_id);
get_sub_cats($cat_id);

$data = '<?xml version="1.0" encoding="UTF-8"?>
<shop>
	<name>ИП Масенко Елена Владимировна</name>
	<company>ИП Масенко Елена Владимировна</company>
	<url>ud-linden.ru</url>
	<currencies>
		<currency id="RUR" rate="1" plus="0"/>
	</currencies>
	<categories/>
	<offers>';
// берем товары нужных категорий
$sql = "SELECT p.`product_id`, p.`model`, p.`quantity`, p.`price`, pd.`name` FROM `".DB_PREFIX."product` as p LEFT JOIN `".DB_PREFIX."product_description` as pd ON p.`product_id`=pd.`product_id` LEFT JOIN `".DB_PREFIX."product_to_category` as pc ON pc.`product_id`=p.`product_id` WHERE p.`status`=1 AND pc.`category_id` IN (".implode(',', $catIDs).") GROUP BY p.`product_id`";
//echo $sql;
$res = query($sql);
echo'<br />Найдено товаров БД: '.mysqli_num_rows($res);
while($r = mysqli_fetch_assoc($res)) {
	$items = array();
	$prod_id = $r['product_id'];
	$name = $r['name'];
	$quantity = $r['quantity'];
	$price = $r['price'];
	$model = $r['model'];
	$options = array();
	// если у товара есть опции
	$sql = "SELECT pov.`quantity`, pov.`ob_sku`, ovd.`name`, mp.`customer_group_ids`, mp.`price`, mp.`special` FROM `".DB_PREFIX."product_option_value` pov LEFT JOIN `".DB_PREFIX."option_value_description` ovd ON pov.`option_value_id`=ovd.`option_value_id` LEFT JOIN `".DB_PREFIX."myoc_pod` mp ON pov.`product_option_value_id`=mp.`product_option_value_id` WHERE pov.`product_id`={$prod_id}";
	$res0 = query($sql);
	while($r0 = mysqli_fetch_assoc($res0)) {
		$t = unserialize($r0['customer_group_ids']);
		if (in_array(2, $t)) {
			$options[$r0['ob_sku']] = array(
				'name' => $r0['name'],
				'quantity' => $r0['quantity'],
				'price' => $r0['price'],
				'special' => $r0['special'],
			);
		}
	}
	if (count($options)>0) {
		foreach($options as $o_model => $val) {
			$items[] = array(
				'name' => $name.' '.$val['name'],
				'quantity' => $val['quantity'],
				'price' => $val['price'],
				'special_price' => $val['special'],
				'model' => $o_model,
			);
		}
	} else {// товар без опций
		$special_price = 0;
		$sql = "SELECT `price` as special_price FROM `".DB_PREFIX."product_special` WHERE `product_id`={$prod_id} AND `customer_group_id`=2";// цена для оптовиков
		$res0 = query($sql);
		while($r0 = mysqli_fetch_assoc($res0)) $special_price = $r0['special_price'];
		$items[] = array(
			'name' => $name,
			'quantity' => $quantity,
			'price' => $price,
			'special_price' => $special_price,
			'model' => $model,
		);
	}

	foreach($items as $v) {
		$data .= "<offer>\n";
		$data .= "<name>".escapexml(trim($v['name']))."</name>\n";
		$data .= "<quantum>".$v['quantity']."</quantum>\n";
		if ($v['special_price']>1) $data .= "<price>".$v['special_price']."</price>\n"; else $data .= "<price/>\n";
		if ($v['price']>0) $data .= "<mrc>".$v['price']."</mrc>\n"; else $data .= "<mrc/>\n";
	//	$data .= "<price>".$v['price']."</price>\n";
	//	if ($v['special_price']>1) $data .= "<mrc>".$v['special_price']."</mrc>\n"; else $data .= "<mrc/>\n";
		$data .= "<currencyId>RUR</currencyId>\n";
		$data .= "<categoryId/>\n";
		$data .= "<vendor>ИП Масенко Елена Владимировна</vendor>\n";
		$data .= "<vendorCode>".escapexml($v['model'])."</vendorCode>\n";
		$data .= "</offer>\n";
	}
}
$data .= "</offers>\n";
$data .= "</shop>";

file_put_contents(dirname(__FILE__).'/temp.xml', $data);
file_put_contents(dirname(__FILE__).'/temp_'.date('H-i-s_d-m-Y').'.xml', $data);

$conn_id = ftp_connect($FTP['server'], $FTP['port']);
if (!$conn_id) {
	$msg = 'Не удалось соединиться с FTP сервером';
	add_log($msg);
	echo'<br />'.$msg;
	exit;
} else {
	$msg = 'Соединились с FTP сервером';
	add_log($msg);
	echo'<br />'.$msg;
}
// авторизуемся
$login_result = ftp_login($conn_id, $FTP['username'], $FTP['password']);
if (!$login_result) {
	$msg = 'Не удалось авторизоваться на FTP';
	add_log($msg);
	echo'<br />'.$msg;
	exit;
} else {
	$msg = 'Авторизовались';
	add_log($msg);
	echo'<br />'.$msg;
}
ftp_pasv($conn_id, true);
// загружаем файл
$upload = ftp_put($conn_id, $xml_file, dirname(__FILE__).'/temp.xml', FTP_BINARY);
if (!$upload) {
    $msg = 'Ошибка FTP: Не удалось загрузить xml файл';
	add_log($msg);
	echo'<br />'.$msg;
	exit;
} else {
	$msg = 'xml файл загружен на сервер';
	add_log($msg);
	echo'<br />'.$msg;
}

// удаляем старые файлы
$files = ftp_nlist($conn_id, '.');
foreach($files as $file) {
	if (preg_match('/[\d]{2}\.[\d]{2}\.[\d]{4}_tovar\.xml/', $file) && $file!=$xml_file) ftp_delete($conn_id, $file);  
}

ftp_close($conn_id);

//
function db_connect()
{
	$db_link = mysqli_init();
	if (!$db_link) die('mysqli_init завершилась провалом');

	if (!mysqli_options($db_link, MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 0')) die('Установка MYSQLI_INIT_COMMAND завершилась провалом');

	if (!mysqli_options($db_link, MYSQLI_OPT_CONNECT_TIMEOUT, 5)) die('Установка MYSQLI_OPT_CONNECT_TIMEOUT завершилась провалом');

	if (!mysqli_real_connect($db_link, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE)) die('Ошибка подключения (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
	
	if (!mysqli_set_charset($db_link, 'utf8')) die('Не удалось установить кодировку utf8');
	
	return $db_link;
}

function query($sql)
{
	global $db_link;
//Функция для выполнения sql-запроса (если возникнет ошибка - будет записана в ЛОГ файл)
	$res = mysqli_query($db_link, $sql);
	if (!$res) { add_log("Ошибка MySQL: ".mysqli_errno($db_link).": ".mysqli_error($db_link)." ($sql)");
		return false;
	} else { return $res; }
}

function get_sub_cats($category_id) {
	global $catIDs;
	$sql = "SELECT `category_id` FROM `".DB_PREFIX."category` WHERE `parent_id`={$category_id}";
	$res = query($sql);
	while($r = mysqli_fetch_assoc($res)) {
		$catIDs[] = $r['category_id'];
		get_sub_cats($r['category_id']);
	}
}

function add_log($err)
{
	$date = date('Y-m-d H:i:s');
	$error = $date." - ".$err."\n";
	$file = fopen(LOG_ERROR, "a+");
	fwrite($file, $error);
	fclose($file);
}

function arr($arr)
{
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}

function clean_log()
{
	$file = fopen(LOG_ERROR, "w+");
	fwrite($file, '');
	fclose($file);
}

function escapexml($string)
{
	$string = preg_replace('/</',' <',$string);
	$string = preg_replace('/>/','> ',$string);
	$string = strip_tags($string);
	$string = preg_replace('/[\n\r\t]/',' ',$string);
	while (strpos($string,'  ') !== false) {
		$string = str_replace('  ',' ',$string);
	}
	$string = trim ($string);

	$p[] = '"';
	$r[] = '&quot;';

	$p[] = '&nbsp;';
	$r[] = ' ';

	$p[] = '&';
	$r[] = '&amp;';

	$p[] = '&amp;amp;';
	$r[] = '&amp;';

	$p[] = '>';
	$r[] = '&gt;';
	
	$p[] = '<';
	$r[] = '&lt;';
	
	$p[] = "'";
	$r[] = '&apos;';
	
	$string = str_replace($p,$r,$string);
	return $string;
}
?>