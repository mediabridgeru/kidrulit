<?php
class ControllerModuleAnyport extends Controller {
	private $error = array(); 
	
	public function index() {
		$this->load->language('module/anyport');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		$this->load->model('tool/anyport');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			if (!$this->user->hasPermission('modify', 'module/anyport')) {
				$this->validate();
				$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
			}
		
			if (!empty($_GET['activate'])) {
				$this->session->data['success'] = $this->language->get('text_success_activation');
				$this->request->post['AnyPort']['Activated'] = 'yes';
			}
			
			$requestPost = $this->request->post;
			$this->model_tool_anyport->editSetting('AnyPort', $requestPost);	
			
			$this->model_tool_anyport->cleanTemp();
			
			$submitAction = (empty($_GET['submitAction'])) ? '' : $_GET['submitAction'];
			
			if ($submitAction == 'restore' && !empty($this->request->post['AnyPort']['Restore']['Source']) && $this->request->post['AnyPort']['Restore']['Source'] == 'FileStandard' && !empty($this->request->files['AnyPort']['name']['Restore']['StandardFile'])) {
				try {
					$this->request->post['AnyPort']['Restore']['File'] = $this->model_tool_anyport->getStandardFile($this->request->files['AnyPort'], 'Restore');
				} catch(Exception $e) {
					$this->session->data['failure'] = $e->getMessage();
				}
			}
			
			$this->session->data['request_post'] = $this->request->post;
			$this->session->data['request_get'] = $this->request->get;
			
			if (!empty($submitAction)) {
				$this->session->data['startajax'] = true;
				$this->session->data['success'] = $this->language->get('text_success');
			}
			
			$selectedTab = (empty($this->request->post['selectedTab'])) ? 0 : $this->request->post['selectedTab'];
			$this->redirect($this->url->link('module/anyport', 'token=' . $this->session->data['token'] . '&tab='.$selectedTab, 'SSL'));
			
		}
		//print_r(ANYPORT_ROOT);
		
		$this->data['maxSize'] = $this->model_tool_anyport->returnMaxUploadSize();
		$this->data['maxSizeReadable'] = $this->model_tool_anyport->returnMaxUploadSize(true);
		$this->data['anyPortBackupCategories'] = array('Product', 'Attribute', 'Option', 'Tax', 'Length', 'Weight', 'Customer', 'User', 'Order', 'Return', 'Category', 'Manufacturer', 'Affiliate', 'Banner', 'Coupon', 'Voucher', 'Download', 'Information');
		
		
		$this->data['autoBackup']['Dropbox'] = $this->model_tool_anyport->getDropboxAutoBackup();
		
		
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		
		$this->data['entry_code'] = $this->language->get('entry_code');
	
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['entry_layouts_active'] = $this->language->get('entry_layouts_active');
		$this->data['entry_highlightcolor'] = $this->language->get('entry_highlightcolor');
				
 		if (isset($this->error['code'])) {
			$this->data['error_code'] = $this->error['code'];
		} else {
			$this->data['error_code'] = '';
		}
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/anyport', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/anyport', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		
		if (isset($this->request->post['AnyPort'])) {
			foreach ($this->request->post['AnyPort'] as $key => $value) {
				$this->data['data']['AnyPort'][$key] = $this->request->post['AnyPort'][$key];
			}
		} else {
			$configValue = $this->config->get('AnyPort');
			set_error_handler(create_function( '$severity, $message, $file, $line', 'return;' )); if (@unserialize(@base64_decode($configValue)) === false) { $this->data['data']['AnyPort'] = @unserialize($configValue) === false ? $configValue : unserialize($configValue); } else { $this->data['data']['AnyPort'] = @unserialize(@base64_decode($configValue)) === false ? $configValue : unserialize(base64_decode($configValue)); } restore_error_handler();
			
		}
			
		$this->data['currenttemplate'] =  $this->config->get('config_template');
		$this->data['tableList'] =  $this->model_tool_anyport->getListOfTables(false);
		
		$this->data['modules'] = array();
		
		if (isset($this->request->post['anyport_module'])) {
			$this->data['modules'] = $this->request->post['anyport_module'];
		} elseif ($this->config->get('anyport_module')) { 
			$this->data['modules'] = $this->config->get('anyport_module');
		}
			
				
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/anyport.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
			
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/anyport')) {
			$this->error = true;
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	
	public function ajaxrequest() {
		if (!$this->user->hasPermission('modify', 'module/anyport')) {
			$this->validate();
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		set_error_handler(
			create_function(
				'$severity, $message, $file, $line',
				'throw new Exception($message . " in file " . $file . " on line " . $line);'
			)
		);
		
		$this->load->language('module/anyport');
		$this->load->model('setting/setting');
		$this->load->model('tool/anyport');
		
		$progress = $this->model_tool_anyport->getProgress();
		
		try {
			if (empty($this->session->data['request_post'])) throw new Exception("The request is invalid.");
			
			$this->request->post = $this->session->data['request_post'];
			unset($this->session->data['request_post']);
			
			$setting = $this->model_tool_anyport->getSetting('AnyPort');
			
			$data = NULL;
			$submitAction = (empty($_GET['submitAction'])) ? '' : $_GET['submitAction'];
			
			switch ($submitAction) {
				case 'backup' : {
					$progress['message'] = 'Backing up... Please wait...';
					$this->model_tool_anyport->setProgress($progress);
					$this->session->data['success'] = '';
					ini_set('memory_limit', '1024M');
					ini_set('max_execution_time', 900);
					$destination = (empty($this->request->post['AnyPort']['Backup']['Destination'])) ? NULL : $this->request->post['AnyPort']['Backup']['Destination'];
					$tables = (empty($this->request->post['AnyPort']['Backup']['Tables'])) ? NULL : $this->request->post['AnyPort']['Backup']['Tables'];
					if (!empty($tables)) {
						foreach ($tables as $index => $table) {
							continue;
							$tables[$index] = str_replace(' ', '_', strtolower($table));	
						}
					}
					$backup = true;
					
					$rootFolders = (empty($this->request->post['AnyPort']['Backup']['Folders'])) ? NULL : $this->request->post['AnyPort']['Backup']['Folders'];
					
					if (!empty($rootFolders['Custom']) && $rootFolders['Custom'] == 'All') {
						$predefinedFolders = array(
							'admin/',
							'catalog/',
							'download/',
							'extension/',
							'extensions/',
							'image/',
							'install/',
							'system/',
							'temp/',
							'vendor/',
							'vendors/',
							'vqmod/',
							'.htaccess.txt',
							'.htaccess',
							'php.ini',
							'config.php',
							'error_log',
							'index.php'
						);
						$predefinedFolders[] = ANYPORT_ADMIN_FOLDER_NAME . '/';
						$rootFolders = array();
						foreach ($predefinedFolders as $predefinedFolder) {
							if (file_exists(ANYPORT_ROOT.'/'.$predefinedFolder) && !in_array($predefinedFolder, $rootFolders)) array_push($rootFolders, $predefinedFolder);	
						}
					} else if (!empty($rootFolders['Custom']) && $rootFolders['Custom'] == 'AllComplete') {
						$filesandfolders = scandir(ANYPORT_ROOT);
						$rootfolders = array();
						$rootfiles = array();
						foreach ($filesandfolders as $rootelement) {
							if (in_array($rootelement, array('.', '..', 'temp'))) continue;
							if (is_dir(ANYPORT_ROOT.'/'.$rootelement)) $rootfolders[$rootelement] = $rootelement.'/';
							else $rootfiles[$rootelement] = $rootelement;
						}
						$rootFolders = array_merge($rootfolders, $rootfiles);
					} else if (!empty($rootFolders['Custom']) && $rootFolders['Custom'] == 'Txt') {
						$txtBackupConfig = './anyport.txt';
						if (!file_exists($txtBackupConfig)) {
							$predefinedFolders = array(
								'admin/',
								'catalog/',
								'download/',
								'extension/',
								'extensions/',
								'image/',
								'install/',
								'system/',
								'temp/',
								'vendor/',
								'vendors/',
								'vqmod/',
								'.htaccess.txt',
								'.htaccess',
								'php.ini',
								'config.php',
								'error_log',
								'index.php'
							);
							$predefinedFolders[] = ANYPORT_ADMIN_FOLDER_NAME . '/';
							$rootFolders = array();
							foreach ($predefinedFolders as $predefinedFolder) {
								if (file_exists('../'.$predefinedFolder) && !in_array($predefinedFolder, $rootFolders)) array_push($rootFolders, $predefinedFolder);	
							}
						} else {
							$fh = fopen($txtBackupConfig, 'r');
							$rootFolders = array();
							while ($line = fgets($fh)) {
								$line = implode('/', $this->model_tool_anyport->clearInvalidEntries(explode('/', trim($line))));
								if (file_exists(ANYPORT_ROOT.'/'.$line) && !in_array($line, $rootFolders)) array_push($rootFolders, $line);
							}
						}
					} else if (!empty($rootFolders['Custom']) && $rootFolders['Custom'] == 'None') {
						$rootFolders = array();
					}
					
					$exportType = (empty($this->request->post['AnyPort']['Backup']['Type'])) ? NULL : $this->request->post['AnyPort']['Backup']['Type'];
					if ($exportType == 'DatabaseBackup') $rootFolders = array();
					if ($exportType == 'FilesBackup') $tables = array();
					
					if (!empty($destination)&&(!empty($tables) || !empty($rootFolders))) {
						$folder = (empty($this->request->post['AnyPort']['Settings'][$destination]['WorkingFolder'])) ? '' : $this->request->post['AnyPort']['Settings'][$destination]['WorkingFolder'];	
						
						try {
							if ($backup) $data = $tables;
							else $this->model_tool_anyport->getTables($data, $tables);
							
							switch($destination) {
								case 'Dropbox' : {
									$dBoxResult = $this->model_tool_anyport->exportToDropbox($data, $rootFolders, $folder, $backup, $exportType);
									if ($dBoxResult === true) {
										//$this->session->data['success'] = $this->language->get('dropbox_success');
										$progress['done'] = true;
										$progress['message'] = $this->language->get('dropbox_success');
										$dBoxResult = NULL;
									} else if ($dBoxResult === false) {
										//$this->session->data['failure'] = $this->language->get('dropbox_failure');
										$progress['error'] = true;
										$progress['message'] = $this->language->get('dropbox_failure');
									} else {
										//$this->session->data['warning'] = $dBoxResult;
										$progress['error'] = true;
										$progress['message'] = $dBoxResult;
									}
								} break;
								case 'GoogleDrive' : {
									$gdriveResult = $this->model_tool_anyport->exportToGoogleDrive($data, $rootFolders, $folder, $backup, $exportType);
									if ($gdriveResult === true) {
										//$this->session->data['success'] = $this->language->get('google_drive_success');
										$progress['done'] = true;
										$progress['message'] = $this->language->get('google_drive_success');
										$gdriveResult = NULL;
									} else if ($gdriveResult === false) {
										//$this->session->data['failure'] = $this->language->get('google_drive_failure');
										$progress['error'] = true;
										$progress['message'] = $this->language->get('google_drive_failure');
									} else {
										//$this->session->data['warning'] = $gdriveResult;
										$progress['error'] = true;
										$progress['message'] = $gdriveResult;
									}
								} break;
								case 'OneDrive' : {
									$skyResult = $this->model_tool_anyport->exportToOneDrive($data, $rootFolders, $folder, $backup, $exportType);
									if ($skyResult === true) {
										//$this->session->data['success'] = $this->language->get('sky_drive_success');
										$progress['done'] = true;
										$progress['message'] = $this->language->get('sky_drive_success');
										$skyResult = NULL;
									} else if ($skyResult === false) {
										//$this->session->data['failure'] = $this->language->get('sky_drive_failure');
										$progress['error'] = true;
										$progress['message'] = $this->language->get('sky_drive_failure');
									} else {
										//$this->session->data['warning'] = $skyResult;
										$progress['error'] = true;
										$progress['message'] = $skyResult;
									}
								} break;
								case 'FileStandard' : {
									$file = $this->model_tool_anyport->exportSQL($tables);
									$file2 = $this->model_tool_anyport->exportRootFolders($rootFolders);
									$file = $this->model_tool_anyport->createFinalArchive(array($file, $file2), $exportType);
									if ($file===false) {
										//$this->session->data['failure'] = $this->language->get('anyport_unable_file');
										$progress['message'] = $this->language->get('anyport_unable_file');
										$progress['error'] = true;
									} else {
										$progress['file'] = $this->model_tool_anyport->createDownload($file);
										$progress['done'] = true;
									}
								}
								$progress['done'] = true;
							}
						} catch(Exception $e) {
							//$this->session->data['failure'] = $e->getMessage();
							$progress['message'] = $e->getMessage();
							$progress['error'] = true;
							$progress['done'] = false;
						}
					} else {
						//$this->session->data['failure'] = $this->language->get('text_pick_destination_and_tables');
						$progress['message'] = $this->language->get('text_pick_destination_and_tables');
						$progress['error'] = true;
					}
				} break;
				case 'restore' : {
					$this->session->data['success'] = '';
					ini_set('memory_limit', '1024M');
					ini_set('max_execution_time', 600);
					$source = (empty($this->request->post['AnyPort']['Restore']['Source'])) ? NULL : $this->request->post['AnyPort']['Restore']['Source'];
					$file = (empty($this->request->post['AnyPort']['Restore']['File'])) ? NULL : $this->request->post['AnyPort']['Restore']['File'];
					
					$restoreType = (empty($this->request->post['AnyPort']['Restore']['Type'])) ? NULL : $this->request->post['AnyPort']['Restore']['Type'];
					
					if (!empty($source)&&(!empty($file))) {
						$folder = (empty($this->request->post['AnyPort']['Settings'][$source]['WorkingFolder'])) ? '' : $this->request->post['AnyPort']['Settings'][$source]['WorkingFolder'];	
						
						try {
							$progress['message'] = 'Downloading from ' . $source . '...';
							$this->model_tool_anyport->setProgress($progress);
							switch($source) {
								case 'Dropbox' : {
									$file = $this->model_tool_anyport->downloadFromDropbox($folder, $file);
								} break;
								case 'GoogleDrive' : {
									$file = $this->model_tool_anyport->downloadFromGoogleDrive($file);
								} break;
								case 'OneDrive' : {
									$file = $this->model_tool_anyport->downloadFromOneDrive($file);
								} break;
							}
							$progress['message'] = 'Restoring files...';
							$this->model_tool_anyport->setProgress($progress);
							$result = $this->model_tool_anyport->restoreSystemFromFile($file, $restoreType);
							if (is_array($result)) {
								foreach ($result as $resItem) {
									if ($resItem !== true) {
										foreach ($resItem as $iIndex => $iItem) {
											//print_r(preg_replace("/^(.*?)\<br \/\>/mi", "<strong>$1</strong><br>", $iItem));
											$resItem[$iIndex] = preg_replace("/^(.*?)\<br \/\>/mi", "<strong>$1</strong><br>", $iItem);
										}
										//$this->session->data['warning'] = str_replace('{COUNT}', count($resItem), $this->language->get('restore_success_warnings')).'<div class="warningContainer" style="display:none; max-height:250px; overflow-y:auto; font-size: 12px;"><br>'.implode('<br><br>', $resItem).'<br></div>';
										$progress['error'] = true;
										$progress['message'] = str_replace('{COUNT}', count($resItem), $this->language->get('restore_success_warnings')).'<div class="warningContainer" style="display:none; max-height:250px; overflow-y:auto; font-size: 12px;"><br>'.implode('<br><br>', $resItem).'<br></div>';
									}
									else {
										$progress['done'] = true;
										//$this->session->data['success'] = $this->language->get('restore_success');
										$progress['message'] = $this->language->get('restore_success');
									}
								}
							}
							else if ($result !== true) {
								//$this->session->data['warning'] = $result;
								$progress['error'] = true;
								$progress['message'] = $result;
							}
							else {
								$progress['done'] = true;
								$progress['message'] = $this->language->get('restore_success');
								//$this->session->data['success'] = $this->language->get('restore_success');
							}
							
						} catch(Exception $e) {
							//$this->session->data['failure'] = $e->getMessage();
							$progress['error'] = true;
							$progress['message'] = $e->getMessage();
						}
					} else {
						//$this->session->data['failure'] = $this->language->get('text_pick_source_and_file');
						$progress['error'] = true;
						$progress['message'] = $this->language->get('text_pick_source_and_file');
					}
					
				} break;
				case 'export' : {
					$this->session->data['success'] = '';
					ini_set('memory_limit', '1024M');
					ini_set('max_execution_time', 600);
					$destination = (empty($this->request->post['AnyPort']['Export']['Destination'])) ? NULL : $this->request->post['AnyPort']['Export']['Destination'];
					$backup = false;
					
					if (!empty($destination)) {
						$folder = (empty($this->request->post['AnyPort']['Settings'][$destination]['WorkingFolder'])) ? '' : $this->request->post['AnyPort']['Settings'][$destination]['WorkingFolder'];	
						
						try {
							switch($destination) {
								case 'FileXLS' : {
									if (!$backup) {
										$this->model_tool_anyport->getProducts($data);
										$file = $this->model_tool_anyport->exportXLS($data, ANYPORT_ROOT.'/temp');
										$progress['file'] = $this->model_tool_anyport->createDownload($file);
										$this->session->data['success'] = '';
									}
								} break;
								case 'FileCSV' : {
									if (!$backup) {
										$this->model_tool_anyport->getProducts($data);
										$file = $this->model_tool_anyport->exportCSV($data, (empty($setting['AnyPort']['Settings']['CSV']['ColumnSeparator'])) ? ',' : $setting['AnyPort']['Settings']['CSV']['ColumnSeparator'], ANYPORT_ROOT.'/temp');
										$progress['file'] = $this->model_tool_anyport->createDownload($file);
										$this->session->data['success'] = '';
									}
								} break;
							}
							$progress['done'] = true;
						} catch(Exception $e) {
							//$this->session->data['failure'] = $e->getMessage();
							$progress['error'] = true;
							$progress['message'] = $e->getMessage();
						}
					} else {
						//$this->session->data['failure'] = $this->language->get('text_pick_destination_and_tables');
						$progress['error'] = true;
						$progress['message'] = $this->language->get('text_pick_destination_and_tables');
					}
				}
			}
		
		} catch (Exception $e) {
			$progress['error'] = true;
			$progress['message'] = $e->getMessage();
		}
		
		restore_error_handler();
		
		$this->model_tool_anyport->setProgress($progress);
		echo json_encode($progress);
		//if OneDrive or Google Drive wants the user to download the temp file, don't clean the folder
		//if (empty($skyResult)&&empty($gdriveResult)&&empty($dBoxResult)) $this->model_tool_anyport->cleanTemp();	
	}
	
	public function clearprogress() {
		if (!$this->user->hasPermission('modify', 'module/anyport')) {
			$this->validate();
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->load->model('tool/anyport');
		
		$this->model_tool_anyport->deleteProgress();
	}
	
	public function googledrive() {
		$page = (empty($_GET['page'])) ? 'popup' : (!in_array($_GET['page'], array('popup', 'callback', 'list')) ? 'popup' : $_GET['page']);
		
		$this->load->model('setting/setting');
		$this->load->model('tool/anyport');
		$setting = $this->model_tool_anyport->getSetting('AnyPort');
		
		$client = &$this->model_tool_anyport->initGoogleDrive('client', false);
		
		if ($page == 'popup') {
			try {
				$authUrl = $client->createAuthUrl();
				header("Location: ".$authUrl);
			} catch (Exception $e) {
				$this->closePopup('googledrive', $e->getMessage());
			}
			
		} else if ($page == 'callback') {
			$authCode = trim($_GET['code']);
			
			if (!empty($authCode)) {
				$this->model_setting_setting->editSetting('AnyPortAuth', array('googleDriveAuthCode' => serialize($authCode)));
				$this->closePopup("googledrive");
			} else {
				$this->closePopup("googledrive", $this->language->get('anyport_no_auth_code'));	
			}
		} else if ($page == 'list') {
			$folder = (empty($setting['AnyPort']['Settings']['GoogleDrive']['WorkingFolder'])) ? '' : $setting['AnyPort']['Settings']['GoogleDrive']['WorkingFolder'];
			
			try {
				$list = $this->model_tool_anyport->listFromGoogleDrive($folder);
			} catch (Exception $e) {
				$list = $e->getMessage();
			}
			$this->generateOutput($list);
		}
	}
	
	public function onedrive() {
		$page = (empty($_GET['page'])) ? 'popup' : (!in_array($_GET['page'], array('popup', 'callback', 'list')) ? 'popup' : $_GET['page']);
		
		$this->load->model('setting/setting');
		$this->load->model('tool/anyport');
		$setting = $this->model_tool_anyport->getSetting('AnyPort');
		
		if ($page == 'popup') {
			$clientId = (empty($setting['AnyPort']['Settings']['OneDrive']['ClientId'])) ? NULL : $setting['AnyPort']['Settings']['OneDrive']['ClientId'];
			$redirectURI = str_replace('/admin', '', (!empty($_SERVER['HTTPS']) ? HTTPS_SERVER : HTTP_SERVER) . 'vendors/anyport/onedrivecallback.php');
			$state = $this->session->data['token'] . '%20' . ANYPORT_ADMIN_FOLDER_NAME;
			
			$authUrl = 'https://login.live.com/oauth20_authorize.srf?client_id='.$clientId.'&scope=wl.skydrive_update%20wl.photos%20wl.offline_access&response_type=code&state='.$state.'&redirect_uri='.$redirectURI;
			header("Location: ".$authUrl);
			
		} else if ($page == 'callback') {
			$authCode = trim($_GET['code']);
			
			if (!empty($authCode)) {
				$this->model_setting_setting->editSetting('AnyPortAuth', array('oneDriveAuthCode' => serialize($authCode)));
				
				$this->closePopup("onedrive");
			} else {
				$this->closePopup("onedrive", $this->language->get('anyport_no_auth_code'));	
			}
		} else if ($page == 'list') {
			$folder = (empty($setting['AnyPort']['Settings']['OneDrive']['WorkingFolder'])) ? '' : $setting['AnyPort']['Settings']['OneDrive']['WorkingFolder'];
			try {
				$list = $this->model_tool_anyport->listFromOneDrive($folder);
			} catch (Exception $e) {
				$list = $e->getMessage();
			}
			$this->generateOutput($list);
		}
	}
	
	public function dropbox() {
		$page = (empty($_GET['page'])) ? 'popup' : (!in_array($_GET['page'], array('popup', 'callback', 'list')) ? 'popup' : $_GET['page']);
		$action = (empty($_GET['action'])) ? 'Auth' : (!in_array($_GET['action'], array('Auth', 'Cron')) ? 'Auth' : $_GET['action']);
		
		$this->load->model('setting/setting');
		$this->load->model('tool/anyport');
		$setting = $this->model_tool_anyport->getSetting('AnyPort');
		
		$dropbox = &$this->model_tool_anyport->initDropbox();
		
		if ($page == 'popup') {
			$return_url = (!empty($_SERVER['HTTPS']) ? HTTPS_SERVER : HTTP_SERVER)."index.php?route=module/anyport/dropbox&page=callback&token=".$this->session->data['token']."&action=".$action."&auth_callback=1";
			
			try {
				$auth_url = $dropbox->BuildAuthorizeUrl($return_url);
				$request_token = $dropbox->GetRequestToken();
				$this->model_setting_setting->editSetting('AnyPort'.$action, array('dropBoxRequestToken' => serialize($request_token)));
				
				header("Location: ".$auth_url);
			} catch (Exception $e) {
				$this->closePopup('dropbox', $e->getMessage());
			}
		} else if ($page == 'callback') {
			$auth_setting = $this->model_tool_anyport->getSetting('AnyPort'.$action);
			
			$reqToken = $auth_setting['dropBoxRequestToken'];
			
			try {
				$authCode = $dropbox->GetAccessToken($reqToken);
				$this->model_setting_setting->editSetting('AnyPort'.$action, array('dropBoxAccessToken' => serialize($authCode)));
				
				$this->closePopup("dropbox");
			} catch (Exception $e) {
				$this->closePopup('dropbox', $e->getMessage());
			}
		} else if ($page == 'list') {
			$folder = (empty($setting['AnyPort']['Settings']['Dropbox']['WorkingFolder'])) ? '' : $setting['AnyPort']['Settings']['Dropbox']['WorkingFolder'];
			
			try {
				$list = $this->model_tool_anyport->listFromDropbox($folder);
			} catch (Exception $e) {
				$list = $e->getMessage();
			}
			
			$this->generateOutput($list);
		}
	}
	
	private function closePopup($show, $message = '') {
		if ($message == '') {
			print_r ('<script>
			if(window.opener && !window.opener.closed) {
				var index = window.opener.$(\'.selectedTab\').val();
				
				if (index == 0) {
					var val2 = window.opener.$(\'.actionTypeDiv input:checked\', window.opener.$(\'.iModuleAdminSuperWrappers\').children(\'li:eq(\'+index+\')\')).val();
					var enableIndexClass = \'\';
					if (val2 == \'FullBackup\') {
						enableIndexClass = \'actionSubmitDiv\';
					} else if (val2 == \'FilesBackup\') {
						enableIndexClass = \'fileFilePickerDiv\';
					} else {
						enableIndexClass = \'fileSettingsDiv\';
					}
					window.opener.populateSummaryFields();
					window.opener.refreshDisabled(window.opener.$(\'.iModuleAdminSuperWrappers\').children(\'li:eq(\'+index+\')\').children(\'div:first\'), window.opener.getIndexOf(enableIndexClass, window.opener.$(\'.iModuleAdminSuperWrappers\').children(\'li:eq(\'+index+\')\').children(\'div:first\')));
					window.opener.$(\'.iModuleAdminSuperWrappers\').children(\'li:eq(\'+index+\')\').children(\'div:first\').accordion( "option", "active", window.opener.getIndexOf(enableIndexClass, window.opener.$(\'.iModuleAdminSuperWrappers\').children(\'li:eq(\'+index+\')\').children(\'div:first\')));
				}
				
				if (index == 1) {
					window.opener.refreshDisabled(window.opener.$(\'.iModuleAdminSuperWrappers\').children(\'li:eq(\'+index+\')\').children(\'div:first\'), window.opener.getIndexOf(\'fileSettingsDiv\', window.opener.$(\'.iModuleAdminSuperWrappers\').children(\'li:eq(\'+index+\')\').children(\'div:first\')));
					window.opener.$(\'.iModuleAdminSuperWrappers\').children(\'li:eq(\'+index+\')\').children(\'div:first\').accordion( "option", "active", window.opener.getIndexOf(\'fileSettingsDiv\', window.opener.$(\'.iModuleAdminSuperWrappers\').children(\'li:eq(\'+index+\')\').children(\'div:first\')));
					
					window.opener.populateRestoreList("'.$show.'");
				}
				
				if (index == 2) {
					window.opener.location = window.opener.location + "&tab=2";
				}
				
				window.opener.anyportPopup.close();
			}
			</script>');
		} else {
			print_r ('<script>
			if(window.opener && !window.opener.closed) {
				window.opener.alert("'.str_replace('"', '\\"', $message).' Please check your settings.");
				window.opener.anyportPopup.close();
			}
			</script>');	
		}
	}
	
	private function generateOutput($list) {
		if (!empty($list)) {
			if (is_array($list)) {
				$output = array();
				foreach($list as $id => $content) {
					if (stripos($content, 'AnyPort') !== FALSE && (stripos($content, '.zip') === strlen($content) - 4 || stripos($content, '.gz') === strlen($content) - 3)) {
						$output[$id] = $content;
					}
				}
				arsort($output);
				echo (json_encode($output));
			} else if (is_string($list)) {
				echo ($list);
			}
		}
	}
}




















































?>