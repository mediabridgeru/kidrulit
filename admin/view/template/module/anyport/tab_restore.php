<div id="accordion_restore">
	<h3><a href="#">Step 1: Choose Restore Type</a></h3>
    <div class="step1 actionTypeDiv mainWrapper">
    	<table class="form">
        	<tr>
            	<td>
			    	<table class="tableWrapper">
			        	<tr>
			            	<td valign="top">
						    	<ul>
						            <li class="sectionHeading"><h2>Restore Types</h2></li>
						            <li class="fullRestore">
						                <input type="radio" name="AnyPort[Restore][Type]" id="FullRestore_Restore" value="FullRestore" />
						                <label for="FullRestore_Restore">Full Restore</label>
						                <p>Do a full system restore, using an AnyPort generated backup file. This restores your root files and folders and your database.</p>
						            </li>
						            <li class="databaseRestore">
						                <input type="radio" name="AnyPort[Restore][Type]" id="DatabaseRestore_Restore" value="DatabaseRestore" />
						                <label for="DatabaseRestore_Restore">Database Restore</label>
						                <p>Do a database restore, using an AnyPort generated backup file.</p>
						            </li>
						            <li class="filesRestore">
						                <input type="radio" name="AnyPort[Restore][Type]" id="FilesRestore_Restore" value="FilesRestore" />
						                <label for="FilesRestore_Restore">Files Restore</label>
						                <p>Do a files and folders restore, using an AnyPort generated backup file.</p>
						            </li>
                                    <li class="helpMessage"><span class="cloudHelp"><strong>Note:</strong> When a Full Restore or a Database Restore is made the restore process will not be stopped if a mismatch occurs.</span></li>
						        </ul>
                           	</td>
                        </tr>
                 	</table>
               	</td>
            </tr>
      	</table>
    <a href="javascript:void(0)" class="continueAction" data-notalone="true" id="stepContinue_toSources">Continue</a>
    <span class="cloudHelp"><strong>Tip:</strong> It is always a good idea to generate a full backup of your current system before restoring. These files might be useful in case of invalid restore data.</span>
    </div>
	<h3><a href="#">Step 2: Choose Restore Source</a></h3>
    <div class="step2 actionSettingsDiv mainWrapper">
    	<table class="form">
        	<tr>
            	<td>
                	<table class=" tableWrapper ChooseRestoreSource">
                    	<tr>
                        	<td valign="top">
                            	<ul>
                                	<li class="sectionHeading"><h2>Cloud Services</h2></li>
                                    <?php if (!empty($data['AnyPort']['Settings']['Dropbox']['Enable']) && $data['AnyPort']['Settings']['Dropbox']['Enable']) : ?>
                            		<li class="dropboxService">
                                    	<input type="radio" name="AnyPort[Restore][Source]" id="Dropbox_Restore" value="Dropbox" />
                                		<label for="Dropbox_Restore"></label>
                                        <p>Get the restore file from your pre-configured Dropbox work folder.</p>
                                	</li>
                                    <?php endif; ?>
                                    <?php if (!empty($data['AnyPort']['Settings']['GoogleDrive']['Enable']) && $data['AnyPort']['Settings']['GoogleDrive']['Enable']) : ?>
                                    <li class="googleDriveService">
                                    	<input type="radio" name="AnyPort[Restore][Source]" id="GoogleDrive_Restore" value="GoogleDrive" />
                                		<label for="GoogleDrive_Restore"></label>
                                        <p>Get the restore file from your pre-configured Google Drive work folder.</span></p>
                                    </li>
                                    <?php endif; ?>
                                    <?php if (!empty($data['AnyPort']['Settings']['OneDrive']['Enable']) && $data['AnyPort']['Settings']['OneDrive']['Enable']) : ?>
                                    <li class="oneDriveService">
                                    	<input type="radio" name="AnyPort[Restore][Source]" id="OneDrive_Restore" value="OneDrive" />
                                		<label for="OneDrive_Restore"></label>
                                        <p>Get the restore file from your pre-configured OneDrive work folder.</p>
                                    </li>
                                    <?php endif; ?>
                                    <?php if (
											empty($data['AnyPort']['Settings']['Dropbox']['Enable']) &&
											empty($data['AnyPort']['Settings']['GoogleDrive']['Enable']) &&
											empty($data['AnyPort']['Settings']['OneDrive']['Enable'])
											) : ?>
                                    <li>
                                    	<p>No Cloud Services are enabled. Please go to the Settings tab where you can configure and enable them. You can refer to AnyPort's User Documentation if you need help with the setup.</p>
                                    </li>
                                    <?php endif; ?>
                                </ul>
                        	</td>
                        	<td valign="top">
	                            <ul>
                                	<li class="sectionHeading"><h2>File Formats</h2></li>
	                            	<?php /*?><li class="commaSeparatedFile">
	                                   	<input type="radio" name="AnyPort[Restore][Source]" id="FileCSV_Restore" value="FileCSV" />
                                		<label for="FileCSV_Restore">CSV File for Download</label>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
	                               	</li>
	                                <li class="excelFile">
	                                   	<input type="radio" name="AnyPort[Restore][Source]" id="FileXLS_Restore" value="FileXLS" />
                                		<label for="FileXLS_Restore">XLS File for Download</label>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
	                                </li><?php */?>
                                    <li class="standardFile">
	                                   	<input type="radio" name="AnyPort[Restore][Source]" id="StandardFile_Restore" value="FileStandard" />
                                		<label for="StandardFile_Restore">Restore From File</label>
                                        <p>Restore from a file on your Computer.</p>
	                                </li>
	                	        </ul>
                        	</td>
                    	</tr>    
                	</table>
          		</td>  
          	</tr>
    	</table>
        <a href="javascript:void(0)" class="continueAction" data-notalone="true" id="stepOneContinue_toList">Continue</a>
    </div>
    <h3><a href="#">Step 3: Set Restore Settings</a></h3>
    <div class="step3 fileSettingsDiv mainWrapper">
    	<table class="form">
        	<tr>
            	<td>
                	<table class=" tableWrapper ChooseRestoreSource">
                    	<tr>
                        	<td valign="top">
                            	<select id="restoreFiles" name="AnyPort[Restore][File]">
        
						        </select>
						        <div id="noFiles">
						        	<p>The folder is empty or it doesn't exist.</p>
						        </div>
						        <a id="refreshFilesButton" class="AnyPortRefreshButton">Refresh</a>
						        
						        <div id="standardFiles">
						        	<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $maxSize; ?>" /> 
						        	<input type="file" name="AnyPort[Restore][StandardFile]" /><span class="fileSizeInfo">Max size: <?php echo $maxSizeReadable; ?><a class='needMoreSize' href="javascript:void(0)">Learn how to increase it</a></span>
						        </div>
						        <div>
						        	<img src="../<?php echo ANYPORT_ADMIN_FOLDER_NAME; ?>/view/image/loading.gif" class="loading restore_loading" />
						        </div>
                            </td>
                      	</tr>
                  	</table>
                </td>
            </tr>
        </table>
        <a href="javascript:void(0)" class="continueAction">Continue</a>
    </div>
    <h3><a href="#">Step 4: Restore Now</a></h3>
    <div class="step4 mainWrapper">
		<a data-action="restore" class="continueAction AnyPortSubmitButton">Restore Now</a>
    </div>
</div>
<style>
.step1 {
	height: 620px;	
}

#accordion_restore h3 > a {
	font-size: 18px;	
}

#accordion_restore h3.ui-state-active {
	border: 1px solid #ddd;	
}

#accordion_restore h3.ui-state-default > a {
	color: #222;
}

#accordion_restore h3.ui-state-active > a {
	color: #1C94C4;
}
</style>
<script>
var currentList = '';
var populateRestoreList = function() {};

$(document).ready(function() {
	populateRestoreList = function(list) {
		if (list == '') {
			$('#accordion_restore').accordion( "option", "active", 0);
			return;
		}
		$('#standardFiles').hide();
		
		$('#restoreFiles').hide();
		$('#noFiles').hide();
		var token = '';
		var vars = window.location.search.split('&');
		for (var i = 0; i < vars.length; i++) {
			var parts = vars[i].split('=');
			if (parts[0] == 'token') token = parts[1];	
		}
		
		$.ajax({
			url : '<?php echo (!empty($_SERVER['HTTPS']) ? HTTPS_SERVER : HTTP_SERVER); ?>index.php?route=module/anyport/'+list+'&page=list&token=' + token,
			success: function(data, textStatus, jqXHR) {
				var temp = data;
				try {
					data = $.parseJSON(temp);
					if ($.type(data) === "object") {
						$('#restoreFiles').show();
						var val = '';
						$('#restoreFiles').html('');
						var i = 0;
						for (var key in data) {
							if (i==0) val = data[key];
							i++;
							$('#restoreFiles').append('<option value="'+key+'">'+data[key]+'</option>');
						}
						$('#restoreFiles').val(val);
					} 
				} catch(exception) {
					data = temp;
					if ($.type(data) === "string") {
						$('#noFiles').html(data).css('display','inline-block');
					} else {
						$('#noFiles').css('display','inline-block');
					}
				}
			},
			beforeSend: function(jqXHR, settings) {
				$('#restoreFiles').hide();
				$('#refreshFilesButton').hide();
				$('.restore_loading').show();
				currentList = list;
			},
			complete: function(jqXHR, textStatus) {
				$('.restore_loading').hide();
				$('#refreshFilesButton').css('display','inline-block');	
			}
		});
	}
	
	refreshDisabled('#accordion_restore');
	$('.loading').hide();
	$('#restoreFiles').hide();
	$('#noFiles').hide();
	$('#standardFiles').hide();
	$('#refreshFilesButton').hide();
	
	$('.AnyPortRefreshButton').click(function(e) {
		populateRestoreList(currentList);
	});
	
	$('#stepOneContinue_toList').click(function () {
		$('.loading').hide();
		$('#restoreFiles').hide();
		$('#noFiles').hide();
		$('#standardFiles').hide();
		$('#refreshFilesButton').hide();
	
		var switchAccordion = true;
		var val = $('.ChooseRestoreSource input[name="AnyPort[Restore][Source]"]:checked').val();
		
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
			refreshDisabled($('#accordion_restore'), getIndexOf('fileSettingsDiv', $('#accordion_restore')));
			$('#accordion_restore').accordion( "option", "active", getIndexOf('fileSettingsDiv', $('#accordion_restore')));
			
			$('#standardFiles').show();
		}
	});
	
	$('#stepContinue_toSources').click(function() {
		var val = $('.actionTypeDiv input[name="AnyPort[Restore][Type]"]:checked').val();
		
		if (val != undefined) {
			refreshDisabled($('#accordion_restore'), getIndexOf('actionSettingsDiv', $('#accordion_restore')));
			$('#accordion_restore').accordion( "option", "active", getIndexOf('actionSettingsDiv', $('#accordion_restore')));
		}
	});
});
</script>