<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
    Site: http://im-cloud.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

class IMDBOCacheFile 
{
	private $expire;

	public function __construct($expire = 3600)
	{
		$this->expire = $expire;
	
		if (!is_dir(DIR_CACHE . 'imdbo')) {
			mkdir(DIR_CACHE . 'imdbo', 0755);
		}
	
		$files = glob(DIR_CACHE . 'imdbo/' . 'cache.*');

		if ($files) {
			foreach ($files as $file) {
				$time = substr(strrchr($file, '.'), 1);

				if ($time < time()) {
					if (file_exists($file)) {
						unlink($file);
					}
				}
			}
		}
	}

	public function get($key)
	{
		$files = glob(DIR_CACHE . 'imdbo/' . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.*');

		if ($files) {
			$handle = fopen($files[0], 'r');

			flock($handle, LOCK_SH);

			$data = fread($handle, filesize($files[0]));

			flock($handle, LOCK_UN);

			fclose($handle);

			return json_decode($data, true);
		}

		return false;
	}

	public function set($key, $value)
	{
		$this->delete($key);

		$file = DIR_CACHE . 'imdbo/' . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.' . (time() + $this->expire);

		$handle = fopen($file, 'w');

		flock($handle, LOCK_EX);

		fwrite($handle, json_encode($value));

		fflush($handle);

		flock($handle, LOCK_UN);

		fclose($handle);
	}

	public function delete($key)
	{
		$files = glob(DIR_CACHE . 'imdbo/' . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.*');

		if ($files) {
			foreach ($files as $file) {
				if (file_exists($file)) {
					unlink($file);
				}
			}
		}
	}
	
	public function clearAll()
	{
		if (!is_dir(DIR_CACHE . 'imdbo')) {
			mkdir(DIR_CACHE . 'imdbo', 0755);
		}
	
		$files = glob(DIR_CACHE . 'imdbo/' . 'cache.*');

		if ($files) {
			foreach ($files as $file) {
				if (file_exists($file)) {
					unlink($file);
				}
			}
		}
	}
}