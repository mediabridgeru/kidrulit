<?php
if (empty($argc) || $argc !== 1) exit;
$_GET['route'] = 'module/anyport/dropboxcron';
$folder = dirname(dirname(dirname($argv[0])));
chdir($folder);
ini_set('session.use_cookies', 0);
session_cache_limiter('');
ini_set('max_execution_time', 900);
session_start();
require_once('index.php');
?>