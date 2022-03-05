<?php 
class Pop_CS {
	protected $hostname;
	protected $username;
	protected $password;
	public $port = 110;
	public $timeout = 5;
	public $qty = 100;
	public $crlf = "\r\n";

	public function setHost($host) {
		$this->hostname = $host;
	}

	public function setUser($name) {
		$this->username = $name;
	}

	public function setPass($pass) {
		$this->password = $pass;
	}

	public function get_mails() {
		@set_time_limit(20);
		$mails = array();
		
		if (!$this->hostname) {
			$mails['error'] = 'Ошибка: Адрес почтового сервера не указан! Error: POP3 server required!';
			return $mails;
		}

		if (!$this->username) {
			$mails['error'] = 'Ошибка: Логин на почтовый сервер не указан! Error: Login for pop-server required!';
			return $mails;
		}

		if (!$this->password) {
			$mails['error'] = 'Ошибка: Пароль на почтовый сервер не указан! Error: Password for pop-server required!';
			return $mails;
		}
		
		// Connect
		$pop_conn = fsockopen($this->hostname, $this->port, $errno, $errstr, $this->timeout);
		
		if (!$pop_conn) {
			$mails['error'] = 'Ошибка: Не удалось открыть порт! - Error: ' . $errstr . ' (' . $errno . ')';
			return $mails;
		}
		
		if (substr(PHP_OS, 0, 3) != 'WIN') {
			socket_set_timeout($pop_conn, $this->timeout, 0);
		}
		
		$reply = fgets($pop_conn, 1024);
		
		if (substr($reply, 0, 3) != '+OK') {
			fputs($pop_conn, 'QUIT' . $this->crlf);
			fclose($pop_conn);
			
			$mails['error'] = $reply;
			return $mails;
		}

		// USER
		fputs($pop_conn, 'USER ' . $this->username . $this->crlf);
		$reply = fgets($pop_conn, 1024);
		
		if (substr($reply, 0, 3) != '+OK') {
			fputs($pop_conn, 'QUIT' . $this->crlf);
			fclose($pop_conn);
			
			$mails['error'] = $reply;
			return $mails;
		}
		
		// PASS
		fputs($pop_conn, 'PASS ' . $this->password . $this->crlf);
		$reply = fgets($pop_conn, 1024);
		
		if (substr($reply, 0, 3) != '+OK') {
			fputs($pop_conn, 'QUIT' . $this->crlf);
			fclose($pop_conn);
			
			$mails['error'] = $reply;
			return $mails;
		}

		// STAT
		fputs($pop_conn, 'STAT' . $this->crlf);
		$reply = fgets($pop_conn, 1024);
		
		if (substr($reply, 0, 3) != '+OK') {
			fputs($pop_conn, 'QUIT' . $this->crlf);
			fclose($pop_conn);
			
			$mails['error'] = $reply;
			return $mails;
		}
		
		$statcodes = explode(' ', $reply);
		if (!isset($statcodes[1]) || !$statcodes[1]) {
			fputs($pop_conn, 'QUIT' . $this->crlf);
			fclose($pop_conn);
			
			$mails['error'] = 'Письма отсутствуют на сервере! ' . $reply;
			return $mails;
		}

		// LIST
		fputs($pop_conn, 'LIST' . $this->crlf);
		$mail_list = $this->get_data($pop_conn);
		
		if (substr($mail_list, 0, 3) != '+OK') {
			fputs($pop_conn, 'QUIT' . $this->crlf);
			fclose($pop_conn);
			
			$mails['error'] = 'Ошибка получения списка писем! ' . $mail_list;
			return $mails;
		} else {
			$mails_list = array();
			
			$mail_parts = explode("\r\n", $mail_list);
			
			foreach ($mail_parts as $result) {
				if (preg_match('/^\d+ \d/', $result)) {
					$result_arr = explode(' ', $result);

					$mails_list[] = array(
						'number' => $result_arr[0],
						'size'   => $result_arr[1]
					);
				}
			}
			
			$mails = array();
			
			if ($mails_list) {
				$mails_list = array_slice($mails_list, -1 * $this->qty);
				
				foreach ($mails_list as $mail) {
					fputs($pop_conn, 'TOP ' . $mail['number'] . ' 3' . $this->crlf);
					$mail_result = $this->get_data($pop_conn);
					
					$mass_header = array();
					
					if (substr($mail_result, 0, 3) == '+OK') {
						$structure = $this->fetch_structure($mail_result);
						
						if (!empty($structure)) {
							if (!empty($structure['header'])) {
								$mass_header = $this->decode_headers($structure['header']);
							}
						}
						
						if (!empty($mass_header)) {
							$headers = array();
							
							if (isset($mass_header['subject'])) {
								$headers['subject'] = @iconv_mime_decode($mass_header['subject'], 2, 'UTF-8');
							} else {
								$headers['subject'] = '';
							}
							
							if (isset($mass_header['from'])) {
								$headers['from'] = @iconv_mime_decode($mass_header['from'], 2, 'UTF-8');
								$headers['from'] = preg_replace('/[<>]/', ' ', $headers['from']);
							} else {
								$headers['from'] = '';
							}
							
							if (isset($mass_header['to'])) {
								$headers['to'] = @iconv_mime_decode($mass_header['to'], 2, 'UTF-8');
								$headers['to'] = preg_replace('/[<>]/', ' ', $headers['to']);
							} else {
								$headers['to'] = '';
							}
							
							if (isset($mass_header['date'])) {
								$headers['date'] = $mass_header['date'];
							} else {
								$headers['date'] = '';
							}
							
							if (isset($mass_header['x-failed-recipients'])) {
								$headers['x-failed-recipients'] = $mass_header['x-failed-recipients'];
							}
							
							if (utf8_strlen($headers['subject']) > 40) {
								$subject = utf8_substr($headers['subject'], 0, 37) . '...';
							} else {
								$subject = $headers['subject'];
							}
							
							if (utf8_strlen($headers['from']) > 40) {
								$from = utf8_substr($headers['from'], 0, 37) . '...';
							} else {
								$from = $headers['from'];
							}
							
							$mails['mails'][$mail['number']] = array(
								'size'    => $mail['size'],
								'subject' => $subject,
								'from'    => $from,
								'headers' => $headers
							);
						}
					} else {
						$mails['mails'][$mail['number']] = array(
							'size'    => $mail['size'],
							'subject' => 'Ошибка данных',
							'from'    => '',
							'headers' => array()
						);
					}
				}
				
				if (!empty($mails['mails'])) {
					krsort($mails['mails']);
				}
				
			} else {
				$mails['error'] = 'Ошибка разбора списка писем! (215)';
			}
		}
		fputs($pop_conn, 'QUIT' . $this->crlf);
		fclose($pop_conn);
		
		return $mails;
	}
	
	public function get_mail($num = 1, $mraw = false) {
		@set_time_limit(20);
		$out_data = array();
		
		if (!$this->hostname) {
			$out_data['error'] = 'Ошибка: Адрес почтового сервера не указан! Error: POP3 server required!';
			return $out_data;
		}

		if (!$this->username) {
			$out_data['error'] = 'Ошибка: Логин на почтовый сервер не указан! Error: Login for pop-server required!';
			return $out_data;
		}

		if (!$this->password) {
			$out_data['error'] = 'Ошибка: Пароль на почтовый сервер не указан! Error: Password for pop-server required!';
			return $out_data;
		}
		
		// Connect
		$pop_conn = fsockopen($this->hostname, $this->port, $errno, $errstr, $this->timeout);
		
		if (!$pop_conn) {
			$out_data['error'] = 'Ошибка: Не удалось открыть порт! - Error: ' . $errstr . ' (' . $errno . ')';
			return $out_data;
		}
		
		if (substr(PHP_OS, 0, 3) != 'WIN') {
			socket_set_timeout($pop_conn, $this->timeout, 0);
		}
		
		$reply = fgets($pop_conn, 1024);
		
		if (substr($reply, 0, 3) != '+OK') {
			fputs($pop_conn, 'QUIT' . $this->crlf);
			fclose($pop_conn);
			
			$out_data['error'] = $reply;
			return $out_data;
		}

		// USER
		fputs($pop_conn, 'USER ' . $this->username . $this->crlf);
		$reply = fgets($pop_conn, 1024);
		
		if (substr($reply, 0, 3) != '+OK') {
			fputs($pop_conn, 'QUIT' . $this->crlf);
			fclose($pop_conn);
			
			$out_data['error'] = $reply;
			return $out_data;
		}
		
		// PASS
		fputs($pop_conn, 'PASS ' . $this->password . $this->crlf);
		$reply = fgets($pop_conn, 1024);
		
		if (substr($reply, 0, 3) != '+OK') {
			fputs($pop_conn, 'QUIT' . $this->crlf);
			fclose($pop_conn);
			
			$out_data['error'] = $reply;
			return $out_data;
		}

		// STAT
		fputs($pop_conn, 'STAT' . $this->crlf);
		$reply = fgets($pop_conn, 1024);
		
		if (substr($reply, 0, 3) != '+OK') {
			fputs($pop_conn, 'QUIT' . $this->crlf);
			fclose($pop_conn);
			
			$out_data['error'] = $reply;
			return $out_data;
		}
		
		$statcodes = explode(' ', $reply);
		if (!isset($statcodes[1]) || !$statcodes[1]) {
			fputs($pop_conn, 'QUIT' . $this->crlf);
			fclose($pop_conn);
			
			$out_data['error'] = 'Письма отсутствуют на сервере! ' . $reply;
			return $out_data;
		}

		// LIST
		$mails_list = array();
		
		fputs($pop_conn, 'LIST' . $this->crlf);
		$mail_list = $this->get_data($pop_conn);
		
		if (substr($mail_list, 0, 3) != '+OK') {
			fputs($pop_conn, 'QUIT' . $this->crlf);
			fclose($pop_conn);
			
			$out_data['error'] = 'Ошибка получения списка писем! ' . $mail_list;
			return $out_data;
		} else {
			$mail_parts = explode("\r\n", $mail_list);
			
			foreach ($mail_parts as $result) {
				if(preg_match('/^\d+ \d/', $result)) {
					$result_arr = explode(' ', $result);

					$mails_list[$result_arr[0]] = array(
						'number' => $result_arr[0],
						'size'   => $result_arr[1]
					);
				}
			}
		}
		
		$mass_header = array();
		$maintype = false;
		
		if ($mails_list && isset($mails_list[$num])) {
			// RETR
			fputs($pop_conn, 'RETR ' . $num . $this->crlf);
			$text = $this->get_data($pop_conn);
			
			if (substr($text, 0, 3) != '+OK') {
				fputs($pop_conn, 'QUIT' . $this->crlf);
				fclose($pop_conn);
				
				$out_data['error'] = $text;
				return $out_data;
			}
			
			if ($mraw) {
				fputs($pop_conn, 'QUIT' . $this->crlf);
				fclose($pop_conn);
				
				//$out_data['mraw'] = nl2br($text);
				$out_data['mraw'] = $text;
				return $out_data;
			}

			$structure = $this->fetch_structure($text);
			
			if (!empty($structure)) {
				if (!empty($structure['header'])) {
					$mass_header = $this->decode_headers($structure['header']);
				}
			}
		} else {
			fputs($pop_conn, 'QUIT' . $this->crlf);
			fclose($pop_conn);
			
			$out_data['error'] = 'Письмо не найдено не сервере!';
			return $out_data;
		}

		if (!empty($mass_header)) {
			if (!empty($mass_header['content-type'])) {
				$mass_header['content-type'] = $mass_header['content-type'];
			} else {
				$mass_header['content-type'] = 'text/plain;';
			}

			$ctype = $mass_header['content-type'];
			$ctype = explode(';', $ctype);
			$types = explode('/', $ctype[0]);

			$maintype = trim(strtolower($types[0]));
			$subtype = trim(strtolower($types[1]));

			if (!isset($mass_header['content-transfer-encoding'])) {
				$mass_header['content-transfer-encoding'] = '';
			}

		} else {
			fputs($pop_conn, 'QUIT' . $this->crlf);
			fclose($pop_conn);
			
			$out_data['error'] = 'Данные заголовков не получены!';
			return $out_data;
		}

		$out_data['headers'] = $mass_header;
		$out_data['body'] = array();
		
		$multipart_subtypes = array('signed','mixed','related','alternative','report');

		if($maintype == 'text') {
			$body = $this->compile_body($structure['body'], $mass_header['content-transfer-encoding'], $mass_header['content-type']);
			
			if ($subtype == 'html') {
				$out_data['body']['html'][] = html_entity_decode($body, ENT_QUOTES, 'UTF-8');
			} else {
				$out_data['body']['text'][] = str_replace(array('<', '>'), array('&lt;', '&gt;'), $body);
			}
		} elseif(($maintype == 'multipart') && in_array($subtype, $multipart_subtypes)) {
			$results = $this->get_multipart($mass_header, $structure['body']);
			
			$out_data = array_merge_recursive($out_data, $results);
		} else {
			$out_data['error'] = 'Тип содержимого письма не распознан!';
		}
		
		fputs($pop_conn, 'QUIT' . $this->crlf);
		fclose($pop_conn);
		
		return $out_data;
	}
	
	public function del_mails($mails) {
		@set_time_limit(20);
		$result = false;
		
		if (!$this->hostname) {
			$result['error'] = 'Ошибка: Адрес почтового сервера не указан! Error: POP3 server required!';
			return $result;
		}

		if (!$this->username) {
			$result['error'] = 'Ошибка: Логин на почтовый сервер не указан! Error: Login for pop-server required!';
			return $result;
		}

		if (!$this->password) {
			$result['error'] = 'Ошибка: Пароль на почтовый сервер не указан! Error: Password for pop-server required!';
			return $result;
		}
		
		// Connect
		$pop_conn = fsockopen($this->hostname, $this->port, $errno, $errstr, $this->timeout);
		
		if (!$pop_conn) {
			$result['error'] = 'Ошибка: Не удалось открыть порт! - Error: ' . $errstr . ' (' . $errno . ')';
			return $result;
		}
		
		if (substr(PHP_OS, 0, 3) != 'WIN') {
			socket_set_timeout($pop_conn, $this->timeout, 0);
		}
		
		$reply = fgets($pop_conn, 1024);
		
		if (substr($reply, 0, 3) != '+OK') {
			fputs($pop_conn, 'QUIT' . $this->crlf);
			fclose($pop_conn);
			
			$result['error'] = $reply;
			return $result;
		}

		// USER
		fputs($pop_conn, 'USER ' . $this->username . $this->crlf);
		$reply = fgets($pop_conn, 1024);
		
		if (substr($reply, 0, 3) != '+OK') {
			fputs($pop_conn, 'QUIT' . $this->crlf);
			fclose($pop_conn);
			
			$result['error'] = $reply;
			return $result;
		}
		
		// PASS
		fputs($pop_conn, 'PASS ' . $this->password . $this->crlf);
		$reply = fgets($pop_conn, 1024);
		
		if (substr($reply, 0, 3) != '+OK') {
			fputs($pop_conn, 'QUIT' . $this->crlf);
			fclose($pop_conn);
			
			$result['error'] = $reply;
			return $result;
		}

		// STAT
		fputs($pop_conn, 'STAT' . $this->crlf);
		$reply = fgets($pop_conn, 1024);
		
		if (substr($reply, 0, 3) != '+OK') {
			fputs($pop_conn, 'QUIT' . $this->crlf);
			fclose($pop_conn);
			
			$result['error'] = $reply;
			return $result;
		}
		
		$statcodes = explode(' ', $reply);
		if (!isset($statcodes[1]) || !$statcodes[1]) {
			fputs($pop_conn, 'QUIT' . $this->crlf);
			fclose($pop_conn);
			
			$result['error'] = 'Письма отсутствуют на сервере! ' . $reply;
			return $result;
		}

		// LIST
		fputs($pop_conn, 'LIST' . $this->crlf);
		$mail_list = $this->get_data($pop_conn);
		
		if (substr($mail_list, 0, 3) != '+OK') {
			fputs($pop_conn, 'QUIT' . $this->crlf);
			fclose($pop_conn);
			
			$result['error'] = 'Ошибка получения списка писем! ' . $mail_list;
			return $result;
		} else {
			$mails_list = array();
			
			$mail_parts = explode("\r\n", $mail_list);
			
			foreach ($mail_parts as $result) {
				if(preg_match('/^\d+ \d/', $result)) {
					$result_arr = explode(' ', $result);

					$mails_list[$result_arr[0]] = array(
						'number' => $result_arr[0],
						'size'   => $result_arr[1]
					);
				}
			}
			
			if ($mails_list) {
				$ok = 0;
				foreach ($mails as $mail) {
					if (isset($mails_list[$mail])) {
						fputs($pop_conn, 'DELE ' . $mail . $this->crlf);
						$reply = fgets($pop_conn, 1024);
						
						if (substr($reply, 0, 3) != '+OK') {
							$result['attention'][] = 'Ошибка удаления письма ' . $mail . ': ' . $reply;
						} else {
							$ok++;
						}
					} else {
						$result['attention'][] = 'Ошибка удаления письма ' . $mail . ': Отсутствует на сервере!';
					}
				}
				
				$result['success'] = $ok;
			} else {
				$result['error'] = 'Ошибка разбора списка писем! (215)';
			}
		}
		fputs($pop_conn, 'QUIT' . $this->crlf);
		fclose($pop_conn);
		
		return $result;
	}
	
	private function get_multipart($mass_header, $body) {
		$out_data = array();

		$boundary = $this->get_boundary($mass_header['content-type']);
		
		$parts = $this->split_parts($boundary, $body);

		if ($parts) {
			for($i = 0; $i < count($parts); $i++) {
				$email = $this->fetch_structure($parts[$i]);
				$header = $email['header'];
				$body = $email['body'];

				$headers = $this->decode_headers($header);
				
				if (!empty($headers)) {
					if (!empty($headers['content-type'])) {
						$headers['content-type'] = $headers['content-type'];
					} else {
						$headers['content-type'] = 'text/plain;';
					}
					
					$actype = explode(';', $headers['content-type']);
					$rctype = trim(strtolower($actype[0]));
					
					if (!isset($headers['content-transfer-encoding'])) {
						$headers['content-transfer-encoding'] = '';
					}

					if (isset($headers['content-disposition']) && isset($headers['content-id'])) {
						$is_download = (preg_match('/name=/', $headers['content-disposition'] . $headers['content-type']) || ($headers['content-id'] != '') || ($rctype == 'message/rfc822'));
					} else {
						$is_download = false;
					}

					if((($rctype == 'text/plain') || ($rctype == 'message/delivery-status')) && !$is_download) {
						$body = $this->compile_body($body, $headers['content-transfer-encoding'], $headers['content-type']);
						$out_data['body']['text'][] = str_replace(array('<', '>'), array('&lt;', '&gt;'), $body);
						
					} elseif(($rctype == 'text/html') && !$is_download) {
						$body = $this->compile_body($body, $headers['content-transfer-encoding'], $headers['content-type']);
						$out_data['body']['html'][] = html_entity_decode($body, ENT_QUOTES, 'UTF-8');
					}
					
					elseif((preg_match('/multipart/', $rctype)) && !$is_download) {
						$results = $this->get_multipart($headers, $body);
						
						$out_data = array_merge_recursive($out_data, $results);
					} else {
						continue;
					}
				} else {
					$out_data['body']['text'][] = 'Ошибка! Неудалось обработать часть письма!';
				}
			}
		} else {
			$out_data['body']['text'][] = 'Ошибка! Неудалось обработать часть письма!';
		}
		return $out_data;
	}
	
	private function get_data($pop_conn) {
		@set_time_limit(20);
		$reply = '';
		
		while (!feof($pop_conn)) {
			$buffer = rtrim(fgets($pop_conn, 1024));
			
			if ($buffer !== false) {
				if (preg_match('/^\t/', $buffer) || preg_match('/^ /', $buffer)) {
					$reply = substr_replace($reply, ' ', -2, 2);
					$reply .= $buffer . "\r\n";
				} else {
					$reply .= $buffer . "\r\n";
				}
				
				if(trim($buffer) == ".") break;
			} else {
				break;
			}
		}
		
		return $reply;
	}
	
	private function fetch_structure($mail) {
		$structures = array();
		
		$separator = "\r\n\r\n";
		$hpos = utf8_strpos($mail, $separator);
		$header = trim(utf8_substr($mail, 0, $hpos));
		
		$bpos = $hpos + utf8_strlen($separator);
		$bend = utf8_strlen($mail) - $bpos;
		$body = utf8_substr($mail, $bpos, $bend);
		
		$structures['header'] = $header;
		$structures['body'] = $body;
		
		return $structures;
	}

	private function decode_headers($data) {
		$decoded_headers = array();
		
		$data = preg_replace('/\r\n\t/', ' ', $data);
		
		$headers = explode("\r\n", $data);
		
		foreach ($headers as $header) {
			$header = trim($header);
			
			if ($header != '') {
				if (preg_match('/^[a-z0-9_-]+:/i', $header)) {
					$npoint = utf8_strpos($header, ':');
					$vpoint = $npoint + 1;
					$hname = trim(utf8_substr($header, 0, $npoint));
					$hvalue = trim(utf8_substr($header, $vpoint));
					
					if ($hname != '') {
						$hname = utf8_strtolower($hname);
						$decoded_headers[$hname] = $hvalue;
					}
				}
			}
		}
		return $decoded_headers;
	}

	private function compile_body($body, $enctype, $ctype) {
		if ($enctype) {
			$enctype = trim($enctype);
			$enctypes = explode(' ', $enctype);
			$encode = $enctypes[0];
			
			if (utf8_strtolower($encode) == 'base64') {
				$body = base64_decode($body);
			} elseif(utf8_strtolower($encode) == 'quoted-printable') {
				$body = quoted_printable_decode($body);
			}
		}
		
		if (preg_match('/koi8/i', $ctype)) {
			$body = convert_cyr_string($body, 'k', 'w');
			$body = iconv("WINDOWS-1251", "UTF-8//IGNORE", $body);
		}
		
		if (preg_match('/1251/i', $ctype)) {
			$body = iconv("WINDOWS-1251", "UTF-8//IGNORE", $body);
		}

		return $body;
	}

	private function split_parts($boundary, $body) {
		$parts = array();
		
		if ($boundary) {
			$startpos = utf8_strpos($body, $boundary) + utf8_strlen($boundary) + 2;
			$lenbody = utf8_strpos($body, "\r\n" . $boundary . '--') - $startpos;
			
			$body = utf8_substr($body, $startpos, $lenbody);
			
			$parts = explode($boundary . "\r\n", $body);
		}
		return $parts;
	}
	
	private function get_boundary($ctype){
		$boundary = '';
		$reg_detect = '/boundary[ ]?=(([ ]?(["]?.*[;]))|([ ]?(["]?.*)))/i';
		$str_cut_arr = array('"', ';');
		
		if (preg_match($reg_detect, $ctype, $regs)) {
			$boundary = str_replace($str_cut_arr, '', $regs[1]);
			$boundary = trim($boundary);
			$boundary = '--' . $boundary;
		}
		return $boundary;
	}
}
?>