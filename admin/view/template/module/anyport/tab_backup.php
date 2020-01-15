<div id="accordion_backup">
	<h3><a href="#">Step 1: Choose Backup Type</a></h3>
    <div class="step1 actionTypeDiv mainWrapper">
    	<table class="form">
        	<tr>
            	<td>
			    	<table class="tableWrapper">
			        	<tr>
			            	<td valign="top">
			                	<ul class="backupTypesList">
						            <li class="sectionHeading">
						            	<h2>Backup Types</h2>
						            </li>
						            <li class="fullBackup">
						                <input type="radio" name="AnyPort[Backup][Type]" id="FullBackup" value="FullBackup" />
						                <label for="FullBackup">Full OpenCart Backup</label>
						                <p>Generate a backup of your OpenCart system. This includes all the OpenCart folders and files and the whole database.</p>
						            </li>
						            <li class="databaseBackup">
						                <input type="radio" name="AnyPort[Backup][Type]" id="DatabaseBackup" value="DatabaseBackup" />
						                <label for="DatabaseBackup">Database Backup</label>
						                <p>Generate a database backup. You can select the tables you need to back up in the next steps.</p>
						            </li>
						            <li class="filesBackup">
						                <input type="radio" name="AnyPort[Backup][Type]" id="FilesBackup" value="FilesBackup" />
						                <label for="FilesBackup">Files Backup</label>
						                <p>Back up your root folders and files. You can select the folders and files you need to back up in the next steps.</p>
						            </li>
						            <li class="customBackup">
						                <input type="radio" name="AnyPort[Backup][Type]" id="CustomBackup" value="CustomBackup" />
						                <label for="CustomBackup">Custom Backup</label>
						                <p>Generate a custom backup, where you can select which folders and files and/or database tables you need to back up.</p>
						            </li>
                                    <li class="clearfix"></li>
						        </ul>
			                </td>
			            </tr>
			        </table>
                </td>
            </tr>
        </table>
    	<a href="javascript:void(0)" class="continueAction" data-notalone="true" id="stepContinue_toDestinations">Continue</a> 
    </div>
	<h3><a href="#">Step 2: Choose Destination</a></h3>
    <div class="step2 actionSettingsDiv mainWrapper">
    	<table class="form">
        	<tr>
            	<td>
                	<table class="tableWrapper ChooseBackupDestination">
                    	<tr>
                        	<td valign="top">
                            	<ul>
                                	<li class="sectionHeading"><h2>Cloud Services</h2></li>
                                    <?php if (!empty($data['AnyPort']['Settings']['Dropbox']['Enable']) && $data['AnyPort']['Settings']['Dropbox']['Enable']) : ?>
                            		<li class="dropboxService">
                                    	<input type="radio" name="AnyPort[Backup][Destination]" id="Dropbox" value="Dropbox" />
                                		<label for="Dropbox"></label>
                                        <p>Send the generated file to a pre-configured Dropbox work folder.</p>
                                	</li>
                                    <?php endif; ?>
                                    <?php if (!empty($data['AnyPort']['Settings']['GoogleDrive']['Enable']) && $data['AnyPort']['Settings']['GoogleDrive']['Enable']) : ?>
                                    <li class="googleDriveService">
                                    	<input type="radio" name="AnyPort[Backup][Destination]" id="GoogleDrive" value="GoogleDrive" />
                                		<label for="GoogleDrive"></label>
                                        <p>Send the generated file to a pre-configured Google Drive work folder.</p>
                                    </li>
                                    <?php endif; ?>
                                    <?php if (!empty($data['AnyPort']['Settings']['OneDrive']['Enable']) && $data['AnyPort']['Settings']['OneDrive']['Enable']) : ?>
                                    <li class="oneDriveService">
                                    	<input type="radio" name="AnyPort[Backup][Destination]" id="OneDrive" value="OneDrive" />
                                		<label for="OneDrive"></label>
                                        <p>Send the generated file to a pre-configured OneDrive work folder.</p>
                                    </li>
                                    <?php endif; ?>
                                    <?php if (
											empty($data['AnyPort']['Settings']['Dropbox']['Enable']) &&
											empty($data['AnyPort']['Settings']['GoogleDrive']['Enable']) &&
											empty($data['AnyPort']['Settings']['OneDrive']['Enable'])
											) { ?>
                                    <li>
                                    	<p>No Cloud Services are enabled. Please go to the Settings tab where you can configure and enable them. You can refer to AnyPort's User Documentation if you need help with the setup.</p>
                                    </li>
                                    <?php } else { ?>
                                    <li class="helpMessage"><span class="cloudHelp"><strong>Note:</strong> If a backup is too large to transfer, a download to your computer will start automatically and you will be asked to upload the file manually to your cloud  service work folder.</span></li>
                                    <?php } ?>
                                </ul>
                        	</td>
                        	<td valign="top">
	                            <ul>
                                	<li class="sectionHeading"><h2>File Formats</h2></li>
                                    <li class="standardFile">
	                                   	<input type="radio" name="AnyPort[Backup][Destination]" id="FileStandard_Backup" value="FileStandard" />
                                		<label for="FileStandard_Backup">Zipped Files for Download</label>
                                        <p>Download the generated file to your Computer.</p>
	                                </li>
	                	        </ul>
                        	</td>
                    	</tr>    
                	</table>
          		</td>  
          	</tr>
    	</table>
        <a href="javascript:void(0)" class="continueAction" data-notalone="true" id="stepContinue_toTables">Continue</a>
    </div>
    <h3 class="fileSettingsH3"><a href="#">Step 3: Choose Database Tables</a></h3>
    <div class="step3 fileSettingsDiv mainWrapper">
    	<div class="tagSelector">
        	<a class="selected">All</a>
        	<?php foreach($anyPortBackupCategories as $category) : ?>
            <a><?php echo ($category); ?></a>
            <?php endforeach; ?>
            <a>Other</a>
        </div>
        <table class="form tableSelector">
        	<tr>
            	<td class="tableList" valign="top">
            		<table class="tableWrapper">
                		<tr>
                    		<td valign="top">
                        		<ul class="databaseTablesList">
					           		<?php foreach($tableList as $i => $tableName): 
										$className = ' allTable';
										$found = false;
										foreach($anyPortBackupCategories as $category) {
											if (stripos($tableName,strtolower($category)) === 0) {
												$className .= ' '.strtolower($category).'Table'; $found = true; break;
											}
										}
										if (!$found) {
											$className .= ' otherTable';
										}	
									?>
							        <li style="display:none;">
                                    	<div class="tableName<?php echo $className; ?>">
                                        	<input type="checkbox" value="<?php echo $tableName; ?>" id="BackupTable<?php echo $i; ?>" name="AnyPort[Backup][Tables][BackupTable<?php echo $i; ?>]" />
                                            <label for="BackupTable<?php echo $i; ?>"><?php echo $tableName; ?></label>
							            </div>
                                   	</li>
					            	<?php endforeach; ?>
                                    <li class="actionButtons">
                                    	<a href="javascript:void(0)" class="selectAllTables">Select All</a>
										<a href="javascript:void(0)" class="deselectAllTables">Deselect All</a>
                                    </li>
            	        		</ul>
                        	</td>
                    	</tr>
                	</table>
            	</td>
          	</tr>
       	</table>
        <a href="javascript:void(0)" class="continueAction" data-notalone="true" id="stepContinue_toFilePicker">Continue</a>
    </div>
    <h3 class="fileFilePickerH3"><a href="#">Step 4: Choose Files &amp; Folders for Backup</a></h3>
    <div class="step4 fileFilePickerDiv mainWrapper">
    	<table class="form">
        	<tr>
            	<td>
			    	<table class="tableWrapper">
                    	<tr>
                        	<td valign="top">
                            	<ul class="filePickerList">
		                            <li class="sectionHeading">
	                                	<h2>Files/Folders List</h2>
	                                </li>
	                                <li>
	                                	<table id="rootFolders">
								        	<?php 
												/*foreach ($rootFolders as $index => $rootFolder) : 
												$tdClass = (substr($rootFolder, strlen($rootFolder) - 1, 1) == '/') ? 'filePickerFolder' : 'filePickerFile';
											?>
								            <tr>
                                            	<td class="checkboxColumn"><input type='checkbox' class='rootFolderOption' id='<?php echo 'rootFolderOption'.$index; ?>' selected="selected" name="AnyPort[Backup][Folders][]" value="<?php echo ($rootFolder); ?>" /></td>
												<td class="<?php echo $tdClass; ?>"></td>
												<td><label for='<?php echo 'rootFolderOption'.$index; ?>'><?php echo ($rootFolder); ?></label></td>
                                            </tr>
								            <?php endforeach;*/ ?>
                                            
                                            <input id="selectAllFilesAndFolders" type="radio" name="AnyPort[Backup][Folders][Custom]" value="All" /><label for="selectAllFilesAndFolders">All OpenCart files and folders</label><br />
                                            
                                            <input id="selectAllFilesAndFoldersComplete" type="radio" name="AnyPort[Backup][Folders][Custom]" value="AllComplete" /><label for="selectAllFilesAndFoldersComplete">All root files and folders</label><br />
                                            
                                            <input id="selectTxtFilesAndFolders" type="radio" name="AnyPort[Backup][Folders][Custom]" value="Txt" /><label for="selectTxtFilesAndFolders">Files and folders from /<?php echo ANYPORT_ADMIN_FOLDER_NAME; ?>/anyport.txt</label><br />
                                           
                                            <input id="selectNoFilesAndFolders" type="radio" name="AnyPort[Backup][Folders][Custom]" value="None" /><label for="selectNoFilesAndFolders">No files</label>
                                        </table>
	                                </li>
                                    <!--<li class="actionButtons">
                                    	<a href="javascript:void(0)" class="selectAllFiles">Select All</a>
                                        <a href="javascript:void(0)" class="deselectAllFiles">Deselect All</a>
                                    </li>-->
	                        	</ul>
        					</td>
                      	</tr>
                    </table>
            	</td>
        	</tr>
        </table>
        <a href="javascript:void(0)" class="continueAction" data-notalone="true" id="stepContinue_toSubmitDiv">Continue</a>
    </div>
    <h3><a href="#">Step 5: Backup Now</a></h3>
    <div class="step5 actionSubmitDiv mainWrapper">
    	<table class="form">
        	<tr>
            	<td class="tablesToBackupContainer" valign="top">
                	<table class="tableWrapper">
                    	<tr>
                        	<td valign="top">
			                    <ul class='databaseTablesList'>
                                	<li class="sectionHeading"><h2>Tables to Backup</h2></li>
                                    <li class="tablesToBackupReviewList">
                                    	<ul class="tablesToBackupList">
                                        
                                        </ul>
                                    </li>
			                    </ul>
                    		</td>
                    	</tr>
                    </table>
                </td>
                <td valign="middle" class="plusSignImage"><div class="plusIcon"></div></td>
                <td class="filesToBackupContainer">
                	<table class="tableWrapper">
                    	<tr>
                        	<td valign="top">
                    			<ul class="filePickerList">
		                            <li class="sectionHeading">
	                                	<h2>Files/Folders List to Backup</h2>
	                                </li>
	                                <li class="filesToBackupReviewList">
	                                	<table class="filesToBackupList">
								            
							        	</table>
	                                </li>
	                        	</ul>
                        	</td>
                    	</tr>
                    </table>
            	</td>
            </tr>
        </table>
        <a data-action="backup" class="AnyPortSubmitButton continueAction">Backup Now</a>
    </div>
</div>
<style>


#accordion_backup h3 > a {
	font-size: 18px;	
}

#accordion_backup h3.ui-state-active {
	border: 1px solid #ddd;	
}

#accordion_backup h3.ui-state-default > a {
	color: #222;
}

#accordion_backup h3.ui-state-active > a {
	color: #1C94C4;
}
</style>
<script>
var permanentDisable = [];
var populateSummaryFields = null;

$(document).ready(function() {
	var putPredefinedTables = function(tableName) {
		$.each($('.tagSelector > a'), function() { $(this).removeClass('selected'); if ($(this).html() == tableName) $(this).addClass('selected'); });
		tableName = tableName.toLowerCase() + 'Table';
		$('.tableSelector .' + tableName).parent().show().find('input[type=checkbox]').attr('checked', true);
	}
	
	var showAndHideSummary = function(param) {
		if (param == 1) {
			$('.tablesToBackupContainer').show();
			$('.filesToBackupContainer').hide();
			$('.plusSignImage').hide();
		} else if (param == 2) {
			$('.tablesToBackupContainer').hide();
			$('.filesToBackupContainer').show();
			$('.plusSignImage').hide();
		} else if (param == 3) {
			$('.tablesToBackupContainer').show();
			$('.filesToBackupContainer').show();
			$('.plusSignImage').show();
		}
	}
	
	populateSummaryFields = function() {
		var newTablesToBackupListHTML = '';
		var newFilesToBackupListHTML = '';
		
		$('.tagSelector > a.selected').each(function(i,e) {
			$('.tableSelector .' + $(this).html().toLowerCase() + 'Table').find('input[type=checkbox]').each(function(){
				if ($(this).attr('checked') == true || $(this).attr('checked') == 'checked') {
					newTablesToBackupListHTML += '<li>'+$(this).parent().children('label').html()+'</li>';
				}
			});
		});
		if (newTablesToBackupListHTML != '') $('.tablesToBackupList').html(newTablesToBackupListHTML);
		else $('.tablesToBackupList').html('<li><p>There are no tables selected.</p></li>');
		
		/*$('.rootFolderOption:checked').each(function() {
			var fileName = $(this).parent().parent().find('label').html();
			var fileClass = (fileName.substr(fileName.length-1, 1) == '/') ? 'filePickerFolder' : 'filePickerFile';
			
			newFilesToBackupListHTML += '<tr><td class="'+fileClass+'"></td><td>'+fileName+'</td></tr>';
		});*/
		if ($('#selectAllFilesAndFolders').is(':checked')) $('.filesToBackupList').html('<tr><td><p>All OpenCart files and folders.</p></td></tr>');
		else if ($('#selectTxtFilesAndFolders').is(':checked')) $('.filesToBackupList').html('<tr><td><p>The files and folders from /<?php echo ANYPORT_ADMIN_FOLDER_NAME; ?>/anyport.txt will be backed up.</p></td></tr>');
		else if ($('#selectAllFilesAndFoldersComplete').is(':checked')) $('.filesToBackupList').html('<tr><td><p>All root files and folders will be backed up.</p></td></tr>');
		else $('.filesToBackupList').html('<tr><td><p>No files and folders will be backed up.</p></td></tr>');
	}
	
	$('.selectAllFiles').click(function() {
		$('.rootFolderOption').attr('checked', true);
		$('#rootFolders').focus();
	});
	
	$('.deselectAllFiles').click(function() {
		$('.rootFolderOption').removeAttr('checked');
		$('#rootFolders').focus();
	});
	
	$('.selectAllTables').click(function() {
		$('.tagSelector > a.selected').each(function(i,e) {
			$('.tableSelector .' + $(this).html().toLowerCase() + 'Table').find('input[type=checkbox]').attr('checked', true);
		});
	});
	
	$('.deselectAllTables').click(function() {
		$('.tagSelector > a.selected').each(function(i,e) {
			$('.tableSelector .' + $(this).html().toLowerCase() + 'Table').find('input[type=checkbox]').attr('checked', false);
		});
	});
	
	$('.tableName input[type=checkbox]').click(function() {
		if($(this).is(':checked')) {
			$(this).parent().css('color','#003A88');
		} else {
			$(this).parent().css('color','#000000');
		}
	});
	
	$('.tagSelector > a').click(function() {
		if ($(this).hasClass('selected')) {
			$(this).removeClass('selected');
			$('.tableSelector .' + $(this).html().toLowerCase() + 'Table').parent().hide().find('input[type=checkbox]').attr('checked', false);
		} else {
			if ($(this).html().toLowerCase() == 'all') {
				$('.tagSelector > a').removeClass('selected');
			} else {
				$('.tagSelector > a.selected').each(function(i,e) {
					if ($(this).html() == 'All') {
						$(this).removeClass('selected');
						$('.tableSelector .allTable').parent().hide().find('input[type=checkbox]').attr('checked', false);
					}
				});
			}
			$(this).addClass('selected');
			$('.tableSelector .' + $(this).html().toLowerCase() + 'Table').parent().show().find('input[type=checkbox]').attr('checked', true);
		}
	});
	
	$('#stepContinue_toTables').click(function () {
		var switchAccordion = true;
		var val = $('.ChooseBackupDestination input[name="AnyPort[Backup][Destination]"]:checked').val();
		
		var token = '';
		var vars = window.location.search.split('&');
		for (var i = 0; i < vars.length; i++) {
			var parts = vars[i].split('=');
			if (parts[0] == 'token') token = parts[1];	
		}
		
		if (anyportPopup != null) { anyportPopup.close(); anyportPopup = null; }
		
		if (val == 'Dropbox') {
			switchAccordion = false;
			anyportPopup = window.open('../<?php echo ANYPORT_ADMIN_FOLDER_NAME; ?>/index.php?route=module/anyport/dropbox&page=popup&token=' + token, '_blank', 'location=no,width=1000,height=620,resizable=no');
		} else if (val == 'GoogleDrive') {
			anyportPopup = window.open('../<?php echo ANYPORT_ADMIN_FOLDER_NAME; ?>/index.php?route=module/anyport/googledrive&page=popup&token=' + token, '_blank', 'location=no,width=750,height=450,resizable=no');
			switchAccordion = false;
		} else if (val == 'OneDrive') {
			switchAccordion = false;
			anyportPopup = window.open('../<?php echo ANYPORT_ADMIN_FOLDER_NAME; ?>/index.php?route=module/anyport/onedrive&page=popup&token=' + token, '_blank', 'location=no,width=750,height=600,resizable=no');
		}
		
		if (switchAccordion && val != undefined) {
			var val2 = $('.actionTypeDiv input[name="AnyPort[Backup][Type]"]:checked').val();
			
			var enableIndexClass = '';
			if (val2 == 'FullBackup') {
				populateSummaryFields();
				enableIndexClass = 'actionSubmitDiv';
			} else if (val2 == 'FilesBackup') {
				enableIndexClass = 'fileFilePickerDiv';
			} else {
				enableIndexClass = 'fileSettingsDiv';
			}
			refreshDisabled($('#accordion_backup'), getIndexOf(enableIndexClass, $('#accordion_backup')));
			$('#accordion_backup').accordion( "option", "active", getIndexOf(enableIndexClass, $('#accordion_backup')));
		}
	});
	
	$('#stepContinue_toDestinations').click(function() {
		var val = $('.actionTypeDiv input[name="AnyPort[Backup][Type]"]:checked').val();
	
		if (val != undefined) {
			var val2 = $('.actionTypeDiv input[name="AnyPort[Backup][Type]"]:checked').val();
			
			if (val2 == 'FullBackup') {
				permanentDisable = [$('.fileSettingsH3', $('#accordion_backup')), $('.fileFilePickerH3', $('#accordion_backup'))];
				putPredefinedTables('All');
				$('#selectAllFilesAndFolders').attr('checked', true);
				//$('.rootFolderOption').attr('selected', 'selected');
				showAndHideSummary(3);
			} else if (val2 == 'DatabaseBackup') {
				permanentDisable = [$('.fileFilePickerH3', $('#accordion_backup'))];
				putPredefinedTables('All');
				$('#selectAllFilesAndFolders').attr('checked', false);
				//$('.rootFolderOption').removeAttr('selected');
				showAndHideSummary(1);
			} else if (val2 == 'FilesBackup') {
				$('#selectAllFilesAndFolders').attr('checked', true);
				permanentDisable = [$('.fileSettingsH3', $('#accordion_backup'))];
				//$('.rootFolderOption').attr('selected', 'selected');
				showAndHideSummary(2);
			} else {
				$('#selectAllFilesAndFolders').attr('checked', true);
				//$('.rootFolderOption').removeAttr('selected');
				permanentDisable = [];
				showAndHideSummary(3);
			}
			$.each($('#accordion_backup').children('h3'), function() {
				$(this).removeClass('permanent-disable');
			});
			$.each(permanentDisable, function() {
				$(this).addClass('permanent-disable');
			});
			
			refreshDisabled($('#accordion_backup'), getIndexOf('actionSettingsDiv', $('#accordion_backup')));
			$('#accordion_backup').accordion( "option", "active", getIndexOf('actionSettingsDiv', $('#accordion_backup')));
		}
	});
	
	$('#stepContinue_toFilePicker').click(function() {
		var val2 = $('.actionTypeDiv input[name="AnyPort[Backup][Type]"]:checked').val();
		var enableIndexClass = '';
		if (val2 == 'DatabaseBackup') {
			enableIndexClass = 'actionSubmitDiv';
		} else {
			enableIndexClass = 'fileFilePickerDiv';
		}
		populateSummaryFields();
		refreshDisabled($('#accordion_backup'), getIndexOf(enableIndexClass, $('#accordion_backup')));
		$('#accordion_backup').accordion( "option", "active", getIndexOf(enableIndexClass, $('#accordion_backup')));
	});
	
	$('#stepContinue_toSubmitDiv').click(function() {
		var val2 = $('.actionTypeDiv input[name="AnyPort[Backup][Type]"]:checked').val();
		var enableIndexClass = '';
		
		if (val2 == 'FilesBackup') {
			enableIndexClass = 'actionSubmitDiv';
		} else {
			enableIndexClass = 'actionSubmitDiv';
		}
		populateSummaryFields();
		refreshDisabled($('#accordion_backup'), getIndexOf(enableIndexClass, $('#accordion_backup')));
		$('#accordion_backup').accordion( "option", "active", getIndexOf(enableIndexClass, $('#accordion_backup')));
	});
	
	refreshDisabled('#accordion_backup');
	putPredefinedTables('All');
	$('.rootFolderOption').attr('checked', true);
});
</script>