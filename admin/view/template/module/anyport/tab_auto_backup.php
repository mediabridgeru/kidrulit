<div id="autoBackupPage">
    <h1>Automatic Backup Configuration</h1>
    <label for="useAutomaticBackupSelect">Use Automatic Backup</label>
    <select id="useAutomaticBackupSelect" name="AnyPort[AutoBackup][Enable]">
        <option value="No"<?php echo (empty($data['AnyPort']['AutoBackup']['Enable']) || $data['AnyPort']['AutoBackup']['Enable'] == 'No' ? ' selected="selected"' : ''); ?>>No</option>
        <option value="Yes"<?php echo (!empty($data['AnyPort']['AutoBackup']['Enable']) && $data['AnyPort']['AutoBackup']['Enable'] == 'Yes' ? ' selected="selected"' : ''); ?>>Yes</option>
    </select>
    <input type="hidden" name="AnyPort[AutoBackup][AdminFolder]" value="<?php echo ANYPORT_ADMIN_FOLDER_NAME; ?>">
    <div id="autoBackupTable">
        <table class="list">
            <tr>
                <th>Service</th>
                <th>Type of File Backup<span class="help">Keep in mind that the whole database will always be backed up</span></th>
                <th>Status</th>
                <th>Actions</th>
                <th>Command<strong>*</strong></th>
            </tr>
            <tr>
                <td>Dropbox<?php echo empty($autoBackup['Dropbox']['User']) ? '' : ' - '; ?><strong><?php echo $autoBackup['Dropbox']['User']; ?></strong></td>
                <td>
                    <input <?php echo (empty($data['AnyPort']['AutoBackup']['Dropbox']['Folders']) || $data['AnyPort']['AutoBackup']['Dropbox']['Folders'] == 'All' ? ' checked="checked"' : ''); ?> id="selectDropboxAllFilesAndFolders" type="radio" name="AnyPort[AutoBackup][Dropbox][Folders]" value="All" /><label for="selectDropboxAllFilesAndFolders">All OpenCart files and folders</label><br />
                                    
                    <input <?php echo (!empty($data['AnyPort']['AutoBackup']['Dropbox']['Folders']) && $data['AnyPort']['AutoBackup']['Dropbox']['Folders'] == 'AllComplete' ? ' checked="checked"' : ''); ?> id="selectDropboxAllFilesAndFoldersComplete" type="radio" name="AnyPort[AutoBackup][Dropbox][Folders]" value="AllComplete" /><label for="selectDropboxAllFilesAndFoldersComplete">All root files and folders</label><br />
                    
                    <input <?php echo (!empty($data['AnyPort']['AutoBackup']['Dropbox']['Folders']) && $data['AnyPort']['AutoBackup']['Dropbox']['Folders'] == 'Txt' ? ' checked="checked"' : ''); ?> id="selectDropboxTxtFilesAndFolders" type="radio" name="AnyPort[AutoBackup][Dropbox][Folders]" value="Txt" /><label for="selectDropboxTxtFilesAndFolders">Files and folders from /<?php echo ANYPORT_ADMIN_FOLDER_NAME; ?>/anyport.txt</label><br />
                   
                    <input <?php echo (!empty($data['AnyPort']['AutoBackup']['Dropbox']['Folders']) && $data['AnyPort']['AutoBackup']['Dropbox']['Folders'] == 'None' ? ' checked="checked"' : ''); ?> id="selectDropboxNoFilesAndFolders" type="radio" name="AnyPort[AutoBackup][Dropbox][Folders]" value="None" /><label for="selectDropboxNoFilesAndFolders">No files</label>   
                </td>
                <td><span class="<?php echo !empty($autoBackup['Dropbox']['Status']) ? 'successStatus' : 'warningStatus';?>"><?php echo $autoBackup['Dropbox']['Message']; ?></span></td>
                <td><a class="autoBackupDropboxRefreshButton">Refresh</a></td>
                <td><code><?php echo $autoBackup['Dropbox']['Code']; ?></code></td>
            </tr>
        </table>
        <div class="note"><strong>*</strong> In order to set up automatic backups, please add the Command from the table above to your Cron job service with the desired repetition time. You can see a tutorial for CPanel <a href="http://www.siteground.com/tutorials/cpanel/cron_jobs.htm" target="_blank">here</a>. Only UNIX-based servers support Cron jobs. Please keep in mind that the backup will include the files you select, as well as the whole database. This feature is available for OC versions 1.5.1.3 and later.
        </div>
    </div>
</div>
<script type="text/javascript">
	var token = '';
	var vars = window.location.search.split('&');
	for (var i = 0; i < vars.length; i++) {
		var parts = vars[i].split('=');
		if (parts[0] == 'token') token = parts[1];	
	}
	
	$('.autoBackupDropboxRefreshButton').click(function() {
		anyportPopup = window.open('../<?php echo ANYPORT_ADMIN_FOLDER_NAME; ?>/index.php?route=module/anyport/dropbox&page=popup&action=Cron&token=' + token, '_blank', 'location=no,width=1000,height=620,resizable=no');	
	});
</script>