<?php 
class Mail_CS {
	protected $to;
	protected $from;
	protected $sender;
	protected $reply_to;
	protected $retpath;
	protected $unsubscribe;
	protected $subject;
	protected $mid;
	protected $text;
	protected $html;
	protected $attachments = array();
	protected $listid = '';
	protected $precedence = '';
	public $protocol = 'mail';
	public $hostname;
	public $username;
	public $password;
	public $port = 25;
	public $timeout = 5;
	public $newline = "\n";
	public $crlf = "\r\n";
	public $verp = false;
	public $parameter = '';
	
	public function setTo($to) {
		$this->to = $to;
	}
	
	public function setFrom($from) {
		$this->from = $from;
	}
	
	public function setSender($sender) {
		$this->sender = $sender;
	}
	
	public function setReplyTo($reply_to) {
		$this->reply_to = $reply_to;
	}
	
	public function setRetpath($retpath) {
		$this->retpath = $retpath;
	}
	
	public function setUnsubscribe($unsubscribe) {
		$this->unsubscribe = $unsubscribe;
	}
	
	public function setMid($sid) {
		$this->mid = $sid;
	}
	
	public function setListid($id) {
		$this->listid = $id;
	}
	
	public function setPrecedence($pr) {
		$this->precedence = $pr;
	}
	
	public function setSubject($subject) {
		$this->subject = $subject;
	}
	
	public function setText($text) {
		$this->text = $text;
	}
	
	public function setHtml($html) {
		$this->html = html_entity_decode($html, ENT_NOQUOTES, 'UTF-8');
	}
	
	public function addAttachment($filename) {
		$this->attachments[] = $filename;
	}
	
	public function send() {
		$contacts_log = new Log('contacts.log');
		$status = false;
	
		if (!$this->to) {
			$contacts_log->write('Ошибка: Адрес получателя отсутствует! Error: E-Mail to required!');
			$status = 'cerr01';
			return $status;
		}
	
		if (!$this->from) {
			$contacts_log->write('Ошибка: Адрес отправителя отсутствует! Error: E-Mail from to required!');
			$status = 'cerr02';
			return $status;
		}
	
		if (!$this->sender) {
			$contacts_log->write('Ошибка: Имя отправителя отсутствует! Error: E-Mail sender required!');
			$status = 'cerr03';
			return $status;
		}
	
		if (!$this->subject) {
			$contacts_log->write('Ошибка: Тема отсутствует! Error: E-Mail subject required!');
			$status = 'cerr04';
			return $status;
		}
	
		if ((!$this->text) && (!$this->html)) {
			$contacts_log->write('Ошибка: Сообщение отсутствует! Error: E-Mail message required!');
			$status = 'cerr05';
			return $status;
		}
	
		if (($this->protocol == 'smtp') && ($this->hostname == '')) {
			$contacts_log->write('Ошибка: Не указан SMTP сервер! Error: SMTP server required!');
			$status = 'cerr14';
			return $status;
		}
	
		if (is_array($this->to)) {
			$to = implode(',', $this->to);
		} else {
			$to = $this->to;
		}
	
		$boundary = '----=_NextPart_' . md5(time());
		$header = 'MIME-Version: 1.0' . $this->newline;
	
		$postdomens = explode('@', $this->from);
		$postdomen = $postdomens[1];
	
		$header .= 'Message-ID: <' .sha1(microtime(true)). '@' . $postdomen . '>' . $this->newline;
	
		if ($this->listid != '') {
			$header .= 'List-id: ' . $this->listid . $this->newline;
		}
		if ($this->precedence != '') {
			$header .= 'Precedence: ' . $this->precedence . $this->newline;
		}
	
		if ($this->protocol != 'mail') {
			$header .= 'To: <' . $to . '>' . $this->newline;
			$header .= 'Subject: =?UTF-8?B?' . base64_encode($this->subject) . '?=' . $this->newline;
		}
	
		$header .= 'Date: ' . date('D, d M Y H:i:s O') . $this->newline;
		$header .= 'From: =?UTF-8?B?' . base64_encode($this->sender) . '?= <' . $this->from . '>' . $this->newline;
	
		if (!$this->reply_to) {
			$header .= 'Reply-To: =?UTF-8?B?' . base64_encode($this->sender) . '?= <' . $this->from . '>' . $this->newline;
		} else {
			$header .= 'Reply-To: =?UTF-8?B?' . base64_encode($this->reply_to) . '?= <' . $this->reply_to . '>' . $this->newline;
		}
	
		if (!$this->retpath) {
			$header .= 'Return-Path: ' . $this->from . $this->newline;
		} else {
			$header .= 'Return-Path: ' . $this->retpath . $this->newline;
		}
	
		if ($this->unsubscribe) {
			$header .= 'List-Unsubscribe: <' . $this->unsubscribe . '>' . $this->newline;
		}
		//$header .= 'X-Mailer: PHP/' . phpversion() . $this->newline;
		//$header .= 'Organization: =?UTF-8?B?' . base64_encode($this->sender) . '?=' . $this->newline;
	
		$header .= 'Content-Type: multipart/mixed; boundary="' . $boundary . '"' . $this->newline . $this->newline;
	
		if (!$this->text) {
			$newtext = $this->createText($this->html);
			$this->text = $newtext;
		}
	
		if (!$this->html) {
			$message  = '--' . $boundary . $this->newline;
			$message .= 'Content-Type: text/plain; charset="utf-8"' . $this->newline;
			$message .= 'Content-Transfer-Encoding: 8bit' . $this->newline . $this->newline;
			$message .= $this->text . $this->newline;
		} else {
			if ($this->text) {
				$message  = '--' . $boundary . $this->newline;
				$message .= 'Content-Type: multipart/alternative; boundary="' . $boundary . '_alt"' . $this->newline . $this->newline;
	
				$message .= '--' . $boundary . '_alt' . $this->newline;
				$message .= 'Content-Type: text/plain; charset="utf-8"' . $this->newline;
				$message .= 'Content-Transfer-Encoding: 8bit' . $this->newline . $this->newline;
				$message .= $this->text . $this->newline;
	
				$message .= '--' . $boundary . '_alt' . $this->newline;
				$message .= 'Content-Type: text/html; charset="utf-8"' . $this->newline;
				$message .= 'Content-Transfer-Encoding: 8bit' . $this->newline . $this->newline;
				$message .= $this->html . $this->newline;
	
				$message .= '--' . $boundary . '_alt--' . $this->newline;
			} else {
				$message  = '--' . $boundary . $this->newline;
				$message .= 'Content-Type: text/html; charset="utf-8"' . $this->newline;
				$message .= 'Content-Transfer-Encoding: 8bit' . $this->newline . $this->newline;
				$message .= $this->html . $this->newline;
			}
		}
	
		foreach ($this->attachments as $attachment) {
			if (file_exists($attachment)) {
				$handle = fopen($attachment, 'r');
				$content = fread($handle, filesize($attachment));
	
				fclose($handle);
	
				$filename = substr(strrchr($attachment, "/"), 1);
	
				if (extension_loaded('mbstring')) {
					$is_utf8 = mb_detect_encoding($filename, 'UTF-8', true);
				} else {
					if (preg_match('//u', $filename)) {
						$is_utf8 = true;
					} else {
						$is_utf8 = false;
					}
				}
	
				if (($is_utf8 == false) && function_exists('iconv')) {
					$filename = @iconv("WINDOWS-1251", "UTF-8//IGNORE", $filename);
				}
	
				$message .= '--' . $boundary . $this->newline;
				$message .= 'Content-Type: application/octet-stream; name="' . $filename . '"' . $this->newline;
				$message .= 'Content-Transfer-Encoding: base64' . $this->newline;
				$message .= 'Content-Disposition: attachment; filename="' . $filename . '"' . $this->newline;
				$message .= 'Content-ID: <' . urlencode($filename) . '>' . $this->newline;
				$message .= 'X-Attachment-Id: ' . urlencode($filename) . $this->newline . $this->newline;
				$message .= chunk_split(base64_encode($content));
			}
		}
	
		$message .= '--' . $boundary . '--' . $this->newline;
	
		if ($this->protocol == 'mail') {
			ini_set('sendmail_from', $this->from);
	
			if ($this->parameter) {
				$sendst = mail($to, '=?UTF-8?B?' . base64_encode($this->subject) . '?=', $message, $header, $this->parameter);
			} else {
				$sendst = mail($to, '=?UTF-8?B?' . base64_encode($this->subject) . '?=', $message, $header);
			}
	
			if ($sendst) {
				$status = 55;
				return $status;
			} else {
				$contacts_log->write('Ошибка: Письмо не принято вашим сервером! Error: The letter is not accepted by your server!');
				$status = 'nerr20';
				return $status;
			}
	
		} elseif ($this->protocol == 'smtp') {
	
			if (substr($this->hostname, 0, 3) == 'tls') {
				$hostname = substr($this->hostname, 6);
			} else {
				$hostname = $this->hostname;
			}
	
			$handle = fsockopen($hostname, $this->port, $errno, $errstr, $this->timeout);
	
			if (!$handle) {
				$contacts_log->write('Ошибка: Не удалось открыть порт! - Error: ' . $errstr . ' (' . $errno . ')');
				$status = 'nerr06';
				return $status;
			} else {
				if (substr(PHP_OS, 0, 3) != 'WIN') {
					socket_set_timeout($handle, $this->timeout, 0);
				}
	
				while ($line = fgets($handle, 515)) {
					if (substr($line, 3, 1) == ' ') {
						break;
					}
				}
	
				fputs($handle, 'EHLO ' . getenv('SERVER_NAME') . $this->crlf);
	
 				$reply = '';
	
				while ($line = fgets($handle, 515)) {
					$reply .= $line;
	
					if ((substr($reply, 0, 3) == 220) && (substr($line, 3, 1) == ' ')) {
						$reply = '';
						continue;
					} else if (substr($line, 3, 1) == ' ') {
						break;
 					}
 				}
	
				if (substr($reply, 0, 3) != 250) {
					$contacts_log->write('Ошибка: Ваш почтовый сервер не отвечает! Error: EHLO not accepted from server! Reply: ' . $reply);
					$status = 'nerr09';
					fclose($handle);
					return $status;
				}
	
				if (substr($this->hostname, 0, 3) == 'tls') {
					fputs($handle, 'STARTTLS' . $this->crlf);
	
					$reply = '';
	
					while ($line = fgets($handle, 515)) {
						$reply .= $line;
	
						if (substr($line, 3, 1) == ' ') {
							break;
						}
					}
	
					if (substr($reply, 0, 3) != 220) {
						$contacts_log->write('Ошибка: Не удалось установить защищенное соединение! Error: STARTTLS not accepted from server! Reply: ' . $reply);
						$status = 'nerr07';
						fclose($handle);
						return $status;
					}
	
					stream_socket_enable_crypto($handle, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
				}
	
				if (!empty($this->username) && !empty($this->password)) {
					fputs($handle, 'EHLO ' . getenv('SERVER_NAME') . $this->crlf);
	
					$reply = '';
	
					while ($line = fgets($handle, 515)) {
						$reply .= $line;
	
						if (substr($line, 3, 1) == ' ') {
							break;
						}
					}
	
					if (substr($reply, 0, 3) != 250) {
						$contacts_log->write('Ошибка: Ваш почтовый сервер не отвечает! Error: EHLO not accepted from server! Reply: ' . $reply);
						$status = 'nerr09';
						fclose($handle);
						return $status;
					}
	
					fputs($handle, 'AUTH LOGIN' . $this->crlf);
	
					$reply = '';
	
					while ($line = fgets($handle, 515)) {
						$reply .= $line;
	
						if (substr($line, 3, 1) == ' ') {
							break;
						}
					}
	
					if (substr($reply, 0, 3) != 334) {
						$contacts_log->write('Ошибка: Метод авторизации не принят вашим почтовым сервером! Error: AUTH LOGIN not accepted from server! Reply: ' . $reply);
						$status = 'nerr08';
						fclose($handle);
						return $status;
					}
	
					fputs($handle, base64_encode($this->username) . $this->crlf);
	
					$reply = '';
	
					while ($line = fgets($handle, 515)) {
						$reply .= $line;
	
						if (substr($line, 3, 1) == ' ') {
							break;
						}
					}
	
					if (substr($reply, 0, 3) != 334) {
						$contacts_log->write('Ошибка: Логин не принят вашим почтовым сервером! Error: Username not accepted from server! Reply: ' . $reply);
						$status = 'nerr10';
						fclose($handle);
						return $status;
					}
	
					fputs($handle, base64_encode($this->password) . $this->crlf);
	
					$reply = '';
	
					while ($line = fgets($handle, 515)) {
						$reply .= $line;
	
						if (substr($line, 3, 1) == ' ') {
							break;
						}
					}
	
					if (substr($reply, 0, 3) != 235) {
						$contacts_log->write('Ошибка: Пароль не принят вашим почтовым сервером! Error: Password not accepted from server! Reply: ' . $reply);
						$status = 'nerr11';
						fclose($handle);
						return $status;
					}
	
				} else {
	
					fputs($handle, 'HELO ' . getenv('SERVER_NAME') . $this->crlf);
	
					$reply = '';
	
					while ($line = fgets($handle, 515)) {
						$reply .= $line;

						if (substr($line, 3, 1) == ' ') {
							break;
						}
					}
	
					if (substr($reply, 0, 3) != 250) {
						$contacts_log->write('Ошибка: Ваш почтовый сервер не отвечает! Error: HELO not accepted from server! Reply: ' . $reply);
						$status = 'nerr12';
						fclose($handle);
						return $status;
					}
				}
	
				if ($this->verp) {
					fputs($handle, 'MAIL FROM: <' . $this->from . '>XVERP' . $this->crlf);
				} else {
					fputs($handle, 'MAIL FROM: <' . $this->from . '>' . $this->crlf);
				}
	
				$reply = '';
	
				while ($line = fgets($handle, 515)) {
					$reply .= $line;
	
					if (substr($line, 3, 1) == ' ') {
						break;
					}
				}
	
				if (substr($reply, 0, 3) != 250) {
					$contacts_log->write('Ошибка: Адрес отправителя не принят вашим сервером! Error: MAIL FROM not accepted from server! Reply: ' . $reply);
					$status = 'nerr13';
					fclose($handle);
					return $status;
				}
	
				if (!is_array($this->to)) {
					fputs($handle, 'RCPT TO: <' . $this->to . '>' . $this->crlf);
	
					$reply = '';
	
					while ($line = fgets($handle, 515)) {
						$reply .= $line;
	
						if (substr($line, 3, 1) == ' ') {
							break;
						}
					}
	
					if ((substr($reply, 0, 3) != 250) && (substr($reply, 0, 3) != 251)) {
						$contacts_log->write('Ошибка: Адрес получателя не принят вашим сервером! Error: RCPT TO not accepted from server! Reply: ' . $reply);
						$status = 'nerr21|' . $reply;
						fclose($handle);
						return $status;
					}
				} else {
					foreach ($this->to as $recipient) {
						fputs($handle, 'RCPT TO: <' . $recipient . '>' . $this->crlf);
	
						$reply = '';
	
						while ($line = fgets($handle, 515)) {
							$reply .= $line;
	
							if (substr($line, 3, 1) == ' ') {
								break;
							}
						}
	
						if ((substr($reply, 0, 3) != 250) && (substr($reply, 0, 3) != 251)) {
							$contacts_log->write('Ошибка: Адрес получателя ' . $recipient . ' не принят вашим сервером! Error: RCPT TO ' . $recipient . ' not accepted from server! Reply: ' . $reply);
							continue;
						}
					}
				}
	
				fputs($handle, 'DATA' . $this->crlf);
	
				$reply = '';
	
				while ($line = fgets($handle, 515)) {
					$reply .= $line;
	
					if (substr($line, 3, 1) == ' ') {
						break;
					}
				}
	
				if (substr($reply, 0, 3) != 354) {
					$contacts_log->write('Ошибка: Сервер отказался принимать данные! Error: DATA not accepted from server! Reply: ' . $reply);
					$status = 'nerr22|' . $reply;
					fclose($handle);
					return $status;
				}
	
				$message = str_replace("\r\n", "\n",  $header . $message);
				$message = str_replace("\r", "\n", $message);
	
				$lines = explode("\n", $message);
	
				foreach ($lines as $line) {
					$results = $this->str_split_unicode($line, 499);
	
					foreach ($results as $result) {
						if (substr(PHP_OS, 0, 3) != 'WIN') {
							fputs($handle, $result . $this->crlf);
						} else {
							fputs($handle, str_replace("\n", "\r\n", $result) . $this->crlf);
						}	
					}
				}
	
				fputs($handle, '.' . $this->crlf);
	
				$reply = '';
	
				while ($line = fgets($handle, 515)) {
					$reply .= $line;
	
					if (substr($line, 3, 1) == ' ') {
						break;
					}
				}
	
				if ($reply && (substr($reply, 0, 3) != 250)) {
					$contacts_log->write('Ошибка: Содержимое письма не приняты вашим сервером! Error: DATA not accepted from server! Reply: ' . $reply);
					$status = 'nerr23|' . $reply;
					fclose($handle);
					return $status;
				}
	
				fputs($handle, 'QUIT' . $this->crlf);
	
				$reply = '';
	
				while ($line = fgets($handle, 515)) {
					$reply .= $line;
	
					if (substr($line, 3, 1) == ' ') {
						break;
					}
				}
	
				if ($reply && (substr($reply, 0, 3) != 221)) {
					$contacts_log->write('Ошибка: Сеанс связи с сервером завершен не корректно! Error: QUIT not accepted from server! Reply: ' . $reply);
					$status = 'nerr24';
					fclose($handle);
					return $status;
				}
	
				fclose($handle);
				$status = 55;
				return $status;
			}
		}
	}
	
	public function str_split_unicode($str, $l = 0) {
		$ret = array();
	
		if ($l > 0) {
			$len_str = utf8_strlen($str);
	
			if ($len_str > 0) {
				if ($len_str > $l) {
					$len_str_part = 0;
	
					for ($i = 0; $i < $len_str; $i += $len_str_part) {
						$start = $i;
	
						$temp_part = utf8_substr($str, $start, $l);
						$len_temp_part = utf8_strlen($temp_part);
	
						if ($len_temp_part < $l) {
							$len_str_part = $len_temp_part;
							$ret[] = $temp_part;
						} else {
							$pos_s = utf8_strrpos($temp_part, ' ', 0);
	
							if ($pos_s) {
								$str_part = utf8_substr($str, $start, $pos_s);
								$len_str_part = utf8_strlen($str_part);
	
								$ret[] = $str_part;
							} else {
								$len_str_part = $len_temp_part;
								$ret[] = $temp_part;
							}
						}
					}
				} else {
					$ret[] = $str;
				}
			} else {
				$ret[] = '';
			}
		} else {
			$ret = preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
		}
		return $ret;
	}
	
   	public function createText($str) {
		$str = preg_replace('/<\s*script[^>]*>.*?<\s*\/\s*script\s*>/is', ' ', $str);
		$str = preg_replace('/<\s*style[^>]*>.*?<\s*\/\s*style\s*>/is', ' ', $str);
		$str = preg_replace('/<\s*select[^>]*>.*?<\s*\/\s*select\s*>/is', ' ', $str);

		$str = strip_tags($str);

		$str = preg_replace('/(<([^>]+)>)/U', ' ', $str);

		$str = str_replace('&amp;', '&', $str);
		$str = str_replace('&nbsp;', ' ', $str);
		$str = preg_replace('/\t/', ' ', $str);
		$str = preg_replace('/ +/', ' ', $str);

		$str = preg_replace('/[\r\n\t ]+[\r\n]/', "\n", $str);

		return $str;
  	}
}
?>