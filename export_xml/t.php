<?php
set_time_limit(0);
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
header("Content-type: text/html; charset=utf-8");

$FTP = array();

// Настройки для подключения к FTP серверу (для загрузки xml файла)
$FTP['server'] = 'uploadprices.akusherstvo.ru'; // сервер
$FTP['port'] = '2221'; // порт
$FTP['username'] = 'linden'; // имя пользователя
$FTP['password'] = 'thahPae2wo'; // пароль пользователя для доступа к FTP-серверу
echo'<br />Соединение с '.$FTP['server'];
arr($FTP);
$conn_id = ftp_connect($FTP['server'], $FTP['port']);
echo'<pre>'; var_dump($conn_id); echo'</pre>';
if (!$conn_id) {
	$msg = 'Не удалось соединиться с FTP сервером';
	echo'<br />'.$msg;
} else {
	$msg = 'Соединились с FTP сервером';
	echo'<br />'.$msg;
}




function arr($arr)
{
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}
?>