<?php
ini_set('error_reporting', E_ALL); 
ini_set('display_errors', 1);
header("Content-type: text/html; charset=utf-8");
require_once dirname(dirname(__FILE__)).'/config.php';
define('LOG_ERROR', dirname(__FILE__).'/log_err.txt');
$t_start = microtime(1);

$db_link = db_connect();
if (!$db_link) exit('Не удалось соединится с БД');

clean_log();

$shop_url = 'https://kidrulit.ru/';
$language_id = 4;

// берем все категории (с учетом уровня вложености)
$categories = get_sub_cats(0);
$first_cat_id = array_key_first_2($categories);

// категории товаров
$product_cats = array();
$sql = "SELECT * FROM `".DB_PREFIX."product_to_category`";
$res = query($sql);
while($r = mysqli_fetch_assoc($res)) $product_cats[$r['product_id']][] = $r['category_id'];


$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$xml .= "<!DOCTYPE yml_catalog SYSTEM \"shops.dtd\">\n";
$xml .= "<yml_catalog date=\"".date('Y-m-d H:i')."\">\n";
$xml .= "<shop>\n";

$shop_name = $company_name = $shop_phone = '';
// настройки
$sql = "SELECT * FROM `".DB_PREFIX."setting` WHERE `key` IN ('yandex_market_shopname', 'yandex_market_company', 'config_telephone')";
$res = query($sql);
while($r=mysqli_fetch_assoc($res)) {
	if ($r['key']=='yandex_market_shopname') $shop_name = $r['value'];
	elseif ($r['key']=='yandex_market_company') $company_name = $r['value'];
	elseif ($r['key']=='config_telephone') $shop_phone = $r['value'];
}
$xml .= "<name>".escapexml($shop_name)."</name>\n";
$xml .= "<company>".escapexml($company_name)."</company>\n";
$xml .= "<url>".$shop_url."</url>\n";
$xml .= "<phone>".escapexml($shop_phone)."</phone>\n";
$xml .= "<platform>Yandex.YML for OpenCart (ocStore)</platform>\n";
$xml .= "<version>1.6.6.3</version>\n";
$xml .= "<currencies>\n";
$xml .= "<currency id=\"RUB\" rate=\"1\" />\n";
$xml .= "</currencies>\n";

$xml .= "<categories>\n";
foreach($categories as $cat_id => $v) {
	$xml .= "<category id=\"".$cat_id."\"";
	if ($v['parent_id']) $xml .= " parentId=\"".$v['parent_id']."\"";
	$xml .= ">".escapexml($v['name'])."</category>\n";
}
$xml .= "</categories>\n";
$xml .= "<offers>\n";

// товары
$sql = "SELECT p.`product_id`, p.`sku`, p.`price`, p.`quantity`,  p.`image`, p.`manufacturer_id`, p.`weight`, p.`weight_class_id`, pd.`name`, pd.`description`, m.`name` as vendor_name FROM `".DB_PREFIX."product` as p LEFT JOIN `".DB_PREFIX."product_description` as pd ON p.`product_id`=pd.`product_id` LEFT JOIN `".DB_PREFIX."manufacturer` as m ON m.`manufacturer_id`=p.`manufacturer_id` WHERE pd.`language_id`='{$language_id}' ORDER BY p.`product_id`";
$res = query($sql);
while($r = mysqli_fetch_assoc($res)) {
	$product_id = $r['product_id'];
	try {
		// категория ID
		$category_id = 0;
		if (isset($product_cats[$product_id])) {
			$cats = $product_cats[$product_id];
			$max_cat_id = 0;
			$max_level = 0;
			// Узнаем самую последнюю категорию в цепочке
			foreach($cats as $cat_id) {
				if (isset($categories[$cat_id])) {
					if ($categories[$cat_id]['level']>$max_level) {
						$max_cat_id = $cat_id;
						$max_level = $categories[$cat_id]['level'];
					}
				}
			}
			$category_id = $max_cat_id;
		}
		if (!$category_id) {
			add_log('productID: '.$product_id.' - Не удалось определить категорию');
			$category_id = $first_cat_id;// ставим самую первую категорию
		}
		
		// чпу
		$sql = "SELECT `keyword` FROM `".DB_PREFIX."url_alias` WHERE `query`='product_id={$product_id}'";
		$res2 = query($sql);
		if (mysqli_num_rows($res2)==0) throw new Exception('product_id: '.$product_id.' - Не найдено ЧПУ');
		$r2 = mysqli_fetch_assoc($res2);
		$slug = $r2['keyword'];

		if ($r['quantity'] > 0) $available = 'true'; else $available = 'false';
		
		$url = $shop_url.$slug.'/';

		$xml .= "<offer id=\"".$product_id."\" available=\"".$available."\" >\n";
		$xml .= "<url>".escapexml_in_url($url)."</url>\n";
		$xml .= "<price>".$r['price']."</price>\n";
		$xml .= "<currencyId>RUB</currencyId>\n";
		$xml .= "<categoryId>".$category_id."</categoryId>\n";
		if (!empty($r['image'])) {
			$image = $shop_url.'image/'.preg_replace('/\s/', '%20', $r['image']);
			$xml .= "<picture>".escapexml_in_url($image)."</picture>\n";
		}
		$xml .= "<delivery>true</delivery>\n";
		$xml .= "<name>".escapexml($r['name'])."</name>\n";
		if (!empty($r['vendor_name'])) {
			$xml .= "<vendor>".escapexml($r['vendor_name'])."</vendor>\n";
			$xml .= "<vendorCode>".escapexml($r['name'])."</vendorCode>\n";
		}
		// убираем с описания все теги
		$descr = htmlspecialchars_decode($r['description']);
		$descr = strip_tags($descr);
		$descr = del_bed_sumbol($descr);

		$xml .= "<description>".escapexml($descr)."</description>\n";
		$xml .= "<param name=\"Артикул\">".$r['sku']."</param>\n";
		$xml .= "</offer>\n";

	} catch (Exception $e) {
		add_log($e->getMessage());
	}
}
$xml .= "</offers>\n";
$xml .= "</shop>\n";
$xml .= "</yml_catalog>\n";

$file_name = 'yandex.xml';
$result = file_put_contents(dirname(__FILE__).'/'.$file_name, $xml);	
if (!$result) exit('Error write to file');
echo 'File <a href="'.$file_name.'">'.$file_name.'</a> is ready!';

echo'<br /><br />'.round(microtime(1)-$t_start, 3).' sec, '.round(memory_get_usage()/1024/1024, 2).' MB';

/////////////////////////
function db_connect() {
	$db_link = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
	if (!$db_link) {
		add_log('Не удалось подключиться к БД: '.mysqli_connect_errno().' - '.mysqli_connect_error());
		return false;
	}
	if (!mysqli_set_charset($db_link, 'utf8')) die('Не удалось установить кодировку utf8');
/*	$db_link = mysqli_init();
	if (!$db_link) die('mysqli_init завершилась провалом');

	if (!mysqli_options($db_link, MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 0')) die('Установка MYSQLI_INIT_COMMAND завершилась провалом');

	if (!mysqli_options($db_link, MYSQLI_OPT_CONNECT_TIMEOUT, 5)) die('Установка MYSQLI_OPT_CONNECT_TIMEOUT завершилась провалом');

	if (!mysqli_real_connect($db_link, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE)) die('Ошибка подключения (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
	
	if (!mysqli_set_charset($db_link, 'utf8')) die('Не удалось установить кодировку utf8');
*/	
	return $db_link;
}

function query($sql) {
	global $db_link;
//Функция для выполнения sql-запроса (если возникнет ошибка - будет записана в ЛОГ файл)
	$res = mysqli_query($db_link, $sql);
	if (!$res) { add_log("Ошибка MySQL: ".mysqli_errno($db_link).": ".mysqli_error($db_link)." ($sql)");
		return false;
	} else { return $res; }
}
function add_log($err) {
	$date = date('Y-m-d H:i:s');
	$error = $date." - ".$err."\n";
	$file = fopen(LOG_ERROR, "a+");
	fwrite($file, $error);
	fclose($file);
}

function arr($arr) {
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}

function clean_log() {
	$file = fopen(LOG_ERROR, "w+");
	fwrite($file, '');
	fclose($file);
}

function escapexml_in_url ($string) {
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

function escapexml ($string) {
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

function array_key_first_2($arr) {
	foreach($arr as $key => $v) {
		return $key;
	}
	return 0;
}

function get_sub_cats($cat_id, $level = 1) {
	global $language_id;
	static $cats = array();
	$sql = "SELECT c.`category_id`, c.`parent_id`, c.`image`, cd.`name` FROM `".DB_PREFIX."category` as c LEFT JOIN `".DB_PREFIX."category_description` as cd ON c.`category_id`=cd.`category_id` WHERE c.`parent_id`='{$cat_id}' AND c.`status`='1' AND cd.`language_id`='{$language_id}' ORDER BY c.`category_id`";
	$res = query($sql);
	while($r = mysqli_fetch_assoc($res)) {
		$cat_id = $r['category_id'];
		$cats[$cat_id] = array('parent_id' => $r['parent_id'], 'name' => $r['name'], 'level' => $level);
		$next_level = $level + 1;
		get_sub_cats($cat_id, $next_level);
	}
	return $cats;
}

function del_bed_sumbol($text) {
	//$patterns = array();
	$text = preg_replace('//', ' ', $text);
	return $text;
}
?>