<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
    Site: http://im-cloud.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once DIR_SYSTEM . 'IMCommon/math/IM_BigInteger.php';
require_once DIR_SYSTEM . 'IMCommon/crypt/IM_RSA.php';

class IMDBOLicSA100 
{
	public $version = '1.0.0';
	
	protected $controller = null;
	
	protected $module_name = '';
	
	protected $rsa = null;
	
	protected $publickey = '';
	
	protected $enc_message = '';
	
	protected $dec_message = '';
	
	protected $dec_message_parts = array();
	
	protected $domen_name = '';
	
	protected $valid_lic = false;
	
	protected $date_until = '';
	
	protected $demo_privatekey = '';
	
	protected $demo_publickey = '';
	
	function __construct($module_name, $publickey, $enc_message, $demo_enc_message)
	{
		// На время выполнения регулярки отключаем вывод ошибок
		$currLevelReport = error_reporting();
		error_reporting(0);

		$this->demo_privatekey = '-----BEGIN RSA PRIVATE KEY-----
MIIBOgIBAAJBAJz8Owqb7D4ADfYKIFP6rDWewreLIOKuiHjGK0YdjRXWJhWUugdY
RZ+lB4zrI3ohORhD3OPqyeruegkG5INKnJsCAwEAAQJAEcElHEoOKeTvr0ft6BGN
sHLIKuH9UiXTIXWoJ0HoVvO390SR/OQRepoQYvSfTdBJBmTS8kXtGzcjnduaUgrG
gQIhAMPQU/OTcMX5rhbEPyvWDtgp0Cp02l8TrE2mpwefW92rAiEAzTyrP7OpG/Jh
N1h0oKheZ1UJaPeHzdurw32eKg/T7NECIDKJR8FrYgWWRNnXWD5mBnq/f9wVQG6d
UzDPO/h5pmn1AiACqws+5MMKDfidk5TQkd/IUB6zMqSdVIHDJNrtiQ8kQQIhAJui
a+a9pKcq3gIPIqLodJBW0ngfhr0PdC+I8ZLQiy4w
-----END RSA PRIVATE KEY-----';
		
		$this->demo_publickey = '-----BEGIN PUBLIC KEY-----
MFwwDQYJKoZIhvcNAQEBBQADSwAwSAJBAJz8Owqb7D4ADfYKIFP6rDWewreLIOKu
iHjGK0YdjRXWJhWUugdYRZ+lB4zrI3ohORhD3OPqyeruegkG5INKnJsCAwEAAQ==
-----END PUBLIC KEY-----';
		
		$this->rsa = new IM_Crypt_RSA();
		
		$this->publickey = $publickey;
		$this->enc_message = $enc_message;
		$this->module_name = $module_name;
		
		$this->rsa->loadKey($this->publickey);
		
		$this->dec_message = $this->rsa->decrypt(base64_decode($this->enc_message));
		
		$this->dec_message_parts = explode(':::', $this->dec_message);
		
		if (count($this->dec_message_parts) < 2) {
			$this->dec_message_parts = array(-1,-1,-1);
		}
		
		$this->domen_name = self::getDomenName();

		// Обычная лицензия
		if (
			$this->module_name == $this->dec_message_parts[1]
			&&
			(
				strtolower($this->domen_name) == strtolower($this->dec_message_parts[0])
				|| self::strEndWith(
					strtolower($this->domen_name), 
					'.' . strtolower($this->dec_message_parts[0])
				)
			)
		) {
			// Проверяем дату
			if (count($this->dec_message_parts) > 2) {
				$this->date_until = $this->dec_message_parts[2];
				
				$date = self::formDate($this->date_until);
				
				if (empty($date)) {
					error_reporting($currLevelReport);
					return;
				}
				
				$date_now = new DateTime("now");
				
				if ($date_now > $date)  {
					error_reporting($currLevelReport);
					return;
				}
			}
			$this->valid_lic = true;
		} else { 
			// Демо период
			// Кручу верчу для обычных пользователей демку мучу,
			// а необычные - вопрос - стоит ли оно того?
			
			if (!isset($demo_enc_message) || empty($demo_enc_message)) {
				error_reporting($currLevelReport);
				return;
			}
			$currset = array();
			$currset[$this->module_name . 'DataDemo_date'] = $demo_enc_message;
			
			$this->rsa->loadKey($this->demo_publickey);
			
			
			$date_test = $this->rsa->decrypt(base64_decode($currset[$this->module_name . 'DataDemo_date']));
			
			if (!$date_test) {
				error_reporting($currLevelReport);
				return;
			}

			$date_test = base64_decode($date_test);
			$date_test = explode(':::', $date_test);
			
			if ($date_test[0] != base64_decode($date_test[1])) {
				error_reporting($currLevelReport);
				return;
			}
			
			$date_test_dt = self::formDate($date_test[0]);
			$date_test_now = new DateTime("now");
			
			if ($date_test_now > $date_test_dt) {
				error_reporting($currLevelReport);
				return;
			}

			$date_test_now->add(new DateInterval('P10D'));
			
			// Проверяем период
			if ($date_test_now < $date_test_dt) {
				error_reporting($currLevelReport);
				return;
			}
			
			$this->date_until = $date_test_dt->format('Y-m-d');
			$this->valid_lic = true;
		}
		error_reporting($currLevelReport);
	}
	
	protected function strEndWith($str, $search)
	{
		return mb_substr($str, mb_strlen($str) - mb_strlen($search)) == $search;
	}
	
	protected function formDate($str) 
	{
		$date = DateTime::createFromFormat('Y-m-d', $str);
		if (!isset($date) || empty($date)) {
			return null;
		}
		return $date;

	}
	
	protected function getDomenName() 
	{
		$result = '';
		if (defined('HTTP_CATALOG')) {
			$result = str_replace(array('http://', 'https://'), '', HTTP_CATALOG);
		} else {
			$result = str_replace(array('http://', 'https://'), '', HTTP_SERVER);
		}
		$resultArray = explode('/', $result);
		$clearFromPort = explode(':', $resultArray[0]);
		return mb_strtolower($clearFromPort[0], mb_detect_encoding($clearFromPort[0]));
	}

	public function getInfo()
	{
		$resultArray = array();

		$resultArray['date_until'] = empty($this->date_until) ? '' : $this->date_until;
		$resultArray['key'] = $this->publickey;
		$resultArray['enc_mess'] = $this->enc_message;
		
		return $resultArray;
	}
	
	public function isValid() 
	{
		return $this->valid_lic;
	}
}
