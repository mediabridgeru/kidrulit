<?php 
class Mail_CC {
	protected $to;
	protected $from;
	protected $cron_id;
	protected $history_id;
	protected $mode;
	protected $testmode;
	public $port = 25;
	public $timeout = 10;
	public $newline = "\n";
	public $crlf = "\r\n";
	public $debag = 0;

	public function setDebag($debag) {
		$this->debag = $debag;
	}
	
	public function setTo($to) {
		$this->to = $to;
	}

	public function setFrom($from) {
		$this->from = $from;
	}
	
	public function setCronid($cron_id) {
		$this->cron_id = $cron_id;
	}

	public function setHistoryid($history_id) {
		$this->history_id = $history_id;
	}
	
	public function setMode($mode) {
		$this->mode = $mode;
	}
	
	public function setTestmode($mode) {
		$this->testmode = $mode;
	}
	
    public function getMXrecords($hostname) {
        $mxhosts = array();
        $mxweights = array();
        if (getmxrr($hostname, $mxhosts, $mxweights)) {
            array_multisort($mxweights, $mxhosts);
        }
		/*if (!$mxhosts) {
			$mxhosts[] = $hostname;
		}*/
        return $mxhosts;
    }
	
	public function check_email() {
		@set_time_limit(360);
		
		if ($this->debag) {
			if ($this->cron_id && $this->history_id) {
				$cron_log = new Log('ccron.' . $this->cron_id . '.' . $this->history_id . '.log');
			} elseif ($this->testmode) {
				$cron_log = new Log('checkmode.log');
			} else {
				$cron_log = new Log('contacts.log');
			}
		}
		
		$status = 'error00';
		$domen = false;
		$mxhosts = array();
		
		if (!$this->to) {
			$status = 'error01';
			return $status;
		}

		if (!$this->from) {
			$status = 'error02';
			return $status;
		}
		
		$to = $this->to;
		
		if ($this->debag) {
			$cron_log->write('Search MX-hosts ' . $to);
		}
		
		$parts = explode('@', $to);

		if(isset($parts[1])) {
			$domen = $parts[1];
		}
		
		if($domen) {
			$mxhosts = $this->getMXrecords($domen);
		}
		
		if($mxhosts) {
			if ($this->debag) {
				$cron_log->write('MX-hosts found:');
				$cron_log->write(print_r($mxhosts, TRUE));
			}
			if ($this->mode) {
				foreach ($mxhosts as $host) {
					$status = $this->check_send($host);

					if (!$this->testmode) {
						if ((stripos($status, 'mcbad02') !== false) || (stripos($status, 'mcbad03') !== false)) {
							$status = $this->check_send($host);
						} else {
							break;
						}
					} else {
						if ($status) {
							break;
						}
					}
				}
			} else {
				$status = 'mcokk55|MX-hosts found!';
			}
		} else {
			if ($this->debag) {
				$cron_log->write('MX-hosts Not found!');
			}
			$status = 'mcbad01';
		}
		return $status;
	}

	public function check_send($hostname) {
		@set_time_limit(360);
		
		if ($this->debag) {
			if ($this->cron_id && $this->history_id) {
				$cron_log = new Log('ccron.' . $this->cron_id . '.' . $this->history_id . '.log');
			} elseif ($this->testmode) {
				$cron_log = new Log('checkmode.log');
			} else {
				$cron_log = new Log('contacts.log');
			}
		}
		
		if ($this->debag) {
			$cron_log->write('Connecting to ' . $hostname);
		}

		$handle = @stream_socket_client("tcp://" . $hostname . ":25", $errno, $errstr, $this->timeout);

		if (!$handle) {
			$status = 'mcbad02';
			return $status;
		} else {
			$reply = '';
			
			while ($line = fgets($handle, 515)) {
				$reply .= $line;

				if (substr($line, 3, 1) == ' ') {
					break;
				}
			}
			
			if ($this->debag) {
				$cron_log->write(print_r($reply, TRUE));
			}
			
			if ((substr($reply, 0, 3) != 220)) {
				$status = 'mcbad03|' . $reply;
				fclose($handle);
				return $status;
			}
			
			//EHLO
			if ($this->debag) {
				$cron_log->write('Send EHLO ' . getenv('SERVER_NAME'));
			}
			fputs($handle, 'EHLO ' . getenv('SERVER_NAME') . $this->crlf);

			$reply = '';

			while ($line = fgets($handle, 515)) {
				$reply .= $line;

				if (substr($reply, 0, 3) == 220 && substr($line, 3, 1) == ' ') {
					$reply = '';
					continue;
				} else if (substr($line, 3, 1) == ' ') {
					break;
				}
			}
			if ($this->debag) {
				$cron_log->write(print_r($reply, TRUE));
			}
			if (substr($reply, 0, 3) != 250) {
				$status = 'mcbad04|' . $reply;
				fclose($handle);
				return $status;
			}
			
			// HELO
			/*if ($this->debag) {
				$cron_log->write('Send HELO ' . getenv('SERVER_NAME'));
			}
			fputs($handle, 'HELO ' . getenv('SERVER_NAME') . $this->crlf);

			$reply = '';

			while ($line = fgets($handle, 515)) {
				$reply .= $line;

				if (substr($line, 3, 1) == ' ') {
					break;
				}
			}
			
			if (substr($reply, 0, 3) != 250) {
				$status = 'mcbad05|' . $reply;
				fclose($handle);
				return $status;
			}*/
			
			//MAIL FROM
			if ($this->debag) {
				$cron_log->write('Send MAIL FROM: <' . $this->from . '>');
			}
			fputs($handle, 'MAIL FROM: <' . $this->from . '>' . $this->crlf);

			$reply = '';

			while ($line = fgets($handle, 515)) {
				$reply .= $line;

				if (substr($line, 3, 1) == ' ') {
					break;
				}
			}
			if ($this->debag) {
				$cron_log->write(print_r($reply, TRUE));
			}
			if (substr($reply, 0, 3) != 250) {
				$status = 'mcsus11|' . $reply;
				fclose($handle);
				return $status;
			}

			//RCPT TO
			if ($this->debag) {
				$cron_log->write('Send RCPT TO: <' . $this->to . '>');
			}
			fputs($handle, 'RCPT TO: <' . $this->to . '>' . $this->crlf);

			$reply = '';

			while ($line = fgets($handle, 515)) {
				$reply .= $line;

				if (substr($line, 3, 1) == ' ') {
					break;
				}
			}
			if ($this->debag) {
				$cron_log->write(print_r($reply, TRUE));
			}
			if ((substr($reply, 0, 3) == 250) || (substr($reply, 0, 3) == 251)) {
				$status = 'mcokk55|' . $reply;
			} elseif ((substr($reply, 0, 3) == 450) || (substr($reply, 0, 3) == 451) || (substr($reply, 0, 3) == 452)) {
				$status = 'mcsus12|' . $reply;
			} else {
				$status = 'mcsus13|' . $reply;
			}
			
			//QUIT
			if ($this->debag) {
				$cron_log->write('Send QUIT');
			}
			fputs($handle, 'QUIT' . $this->crlf);
			fclose($handle);

			return $status;
		}
	}
}
?>