<ul class="iModuleUL" id="iAnalyticsSearchWrapper">

    <li>
        <ul class="iModuleAdminMenu">
            <li class="selected">Dropbox</li>
            <li>Google Drive</li>
            <li>OneDrive</li>
            <li>CSV</li>
        </ul>
        <div class="content">
            <ul class="iModuleAdminWrappers">
                <li>
                	<div>
                        <h1>Dropbox Configuration</h1>
                    </div>
                    <div class="help">After creating your Dropbox App (with Full access type) in <a href="https://www.dropbox.com/developers/apps" target="_blank">Dropbox Apps</a>, copy your App key and App secret here. You can watch a video tutorial <a href="http://screencast.com/t/zDKbRmHe7" target="_blank">here</a> or you can refer to the User Documentation for instructions on the setup.</div>
                    <div class="iModuleFields">
                    	<table>
                        	<tr>
                            	<td>
                    				<label for="AnyPortDropboxEnable">Enable Dropbox</label>
                        		</td>
                                <td>
                                	<select id="AnyPortDropboxEnable" name="AnyPort[Settings][Dropbox][Enable]">
                                	<option value="1"<?php echo (empty($data['AnyPort']['Settings']['Dropbox']['Enable'])) ? '' : (($data['AnyPort']['Settings']['Dropbox']['Enable'] == true) ? ' selected="selected"' : ''); ?>>Yes</option>
                                    <option value="0"<?php echo (empty($data['AnyPort']['Settings']['Dropbox']['Enable'])) ? ' selected="selected"' : (($data['AnyPort']['Settings']['Dropbox']['Enable'] == false) ? ' selected="selected"' : ''); ?>>No</option>
                                    </select>
                                </td>
                        	</tr>
                        	<tr>
                            	<td>
                    				<label for="AnyPortDropboxAppKey">App key:</label>
                                </td>
                                <td>
                    				<input type="text" id="AnyPortDropboxAppKey" name="AnyPort[Settings][Dropbox][AppKey]" value="<?php echo (empty($data['AnyPort']['Settings']['Dropbox']['AppKey'])) ? '' : $data['AnyPort']['Settings']['Dropbox']['AppKey']; ?>" />
                        		</td>
                        	</tr>
                            <tr>
                            	<td>
                        			<label for="AnyPortDropboxAppSecret">App secret:</label>
                                </td>
                                <td>
                    				<input type="text" id="AnyPortDropboxAppSecret" name="AnyPort[Settings][Dropbox][AppSecret]" value="<?php echo (empty($data['AnyPort']['Settings']['Dropbox']['AppSecret'])) ? '' : $data['AnyPort']['Settings']['Dropbox']['AppSecret']; ?>" />
                        		</td>
                        	</tr>
                            <tr>
                            	<td>
                        			<label for="AnyPortDropboxWorkingFolder">Working folder:</label>
                        		</td>
                                <td>
                    				<input type="text" id="AnyPortDropboxWorkingFolder" name="AnyPort[Settings][Dropbox][WorkingFolder]" value="<?php echo (empty($data['AnyPort']['Settings']['Dropbox']['WorkingFolder'])) ? '' : $data['AnyPort']['Settings']['Dropbox']['WorkingFolder']; ?>" />
                        		</td>
                        	</tr>
                        </table>
                    </div>
                </li>
                <li>
               		<div>
                        <h1>Google Drive Configuration</h1>
                    </div>
                    <div class="help">After creating your Google API Project in <a href="https://code.google.com/apis/console/" target="_blank">Google APIs Console</a>, copy your Client ID and Client secret here. Make sure to add "Drive API" and "Drive SDK" in "Services" and set <strong><?php echo (str_replace('/admin', '', (!empty($_SERVER['HTTPS']) ? HTTPS_SERVER : HTTP_SERVER) . 'vendors/anyport/gdrivecallback.php')); ?></strong> as your redirect URI. You can watch a video tutorial <a href="http://screencast.com/t/U55KHLJn8sY" target="_blank">here</a> or you can refer to the User Documentation for instructions on the setup.</div>
                    <div class="iModuleFields">
                    	<table>
                        	<tr>
                            	<td>
                    				<label for="AnyPortGoogleDriveEnable">Enable Google Drive</label>
                        		</td>
                                <td>
                                	<select id="AnyPortGoogleDriveEnable" name="AnyPort[Settings][GoogleDrive][Enable]">
                                	<option value="1"<?php echo (empty($data['AnyPort']['Settings']['GoogleDrive']['Enable'])) ? '' : (($data['AnyPort']['Settings']['GoogleDrive']['Enable'] == true) ? ' selected="selected"' : ''); ?>>Yes</option>
                                    <option value="0"<?php echo (empty($data['AnyPort']['Settings']['GoogleDrive']['Enable'])) ? ' selected="selected"' : (($data['AnyPort']['Settings']['GoogleDrive']['Enable'] == false) ? ' selected="selected"' : ''); ?>>No</option>
                                    </select>
                                </td>
                        	</tr>
                            <tr>
                            	<td>
                        			<label for="AnyPortGoogleDriveClientId">Client ID:</label>
                                </td>
                                <td>
                    				<input type="text" id="AnyPortGoogleDriveClientId" name="AnyPort[Settings][GoogleDrive][ClientId]" value="<?php echo (empty($data['AnyPort']['Settings']['GoogleDrive']['ClientId'])) ? '' : $data['AnyPort']['Settings']['GoogleDrive']['ClientId']; ?>" />
                                </td>
                        	</tr>
                            <tr>
                            	<td>
                        			<label for="AnyPortGoogleDriveClientSecret">Client secret:</label>
                        		</td>
                                <td>
                    				<input type="text" id="AnyPortGoogleDriveClientSecret" name="AnyPort[Settings][GoogleDrive][ClientSecret]" value="<?php echo (empty($data['AnyPort']['Settings']['GoogleDrive']['ClientSecret'])) ? '' : $data['AnyPort']['Settings']['GoogleDrive']['ClientSecret']; ?>" />
                        		</td>
                        	</tr>
                            <tr>
                            	<td>
                        			<label for="AnyPortGoogleDriveWorkingFolder">Working folder:</label>
                        		</td>
                                <td>
                    				<input type="text" id="AnyPortGoogleDriveWorkingFolder" name="AnyPort[Settings][GoogleDrive][WorkingFolder]" value="<?php echo (empty($data['AnyPort']['Settings']['GoogleDrive']['WorkingFolder'])) ? '' : $data['AnyPort']['Settings']['GoogleDrive']['WorkingFolder']; ?>" />
                        		</td>
                        	</tr>
                        </table>
                    </div>
                </li>
                <li>
               		<div>
                        <h1>OneDrive Configuration</h1>
                    </div>
                    <div class="help">After creating your Windows Live Application in <a href="http://go.microsoft.com/fwlink/p/?LinkId=193157" target="_blank">Live Connect Developer Center</a>, copy your Client ID and Client secret here. Make sure to set <strong><?php echo ((!empty($_SERVER['HTTPS']) ? 'https://' : 'http://').(dirname(preg_replace('~^https?\:\/\/~', '', HTTP_SERVER))).'/vendors/anyport/onedrivecallback.php'); ?></strong> as your Redirect URL in the "API Settings" page. For more detailed instructions, you can watch a video tutorial <a href="https://www.youtube.com/watch?v=PStKRuXzpSQ" target="_blank">here</a> or you can refer to the User Documentation.</div>
                    <div class="iModuleFields">
                        <table>
                        	<tr>
                            	<td>
                    				<label for="AnyPortOneDriveEnable">Enable OneDrive</label>
                        		</td>
                                <td>
                                	<select id="AnyPortOneDriveEnable" name="AnyPort[Settings][OneDrive][Enable]">
                                	<option value="1"<?php echo (empty($data['AnyPort']['Settings']['OneDrive']['Enable'])) ? '' : (($data['AnyPort']['Settings']['OneDrive']['Enable'] == true) ? ' selected="selected"' : ''); ?>>Yes</option>
                                    <option value="0"<?php echo (empty($data['AnyPort']['Settings']['OneDrive']['Enable'])) ? ' selected="selected"' : (($data['AnyPort']['Settings']['OneDrive']['Enable'] == false) ? ' selected="selected"' : ''); ?>>No</option>
                                    </select>
                                </td>
                        	</tr>
                            <tr>
                            	<td>
                        			<label for="AnyPortOneDriveClientId">Client ID:</label>
                                </td>
                                <td>
                    				<input type="text" id="AnyPortOneDriveClientId" name="AnyPort[Settings][OneDrive][ClientId]" value="<?php echo (empty($data['AnyPort']['Settings']['OneDrive']['ClientId'])) ? '' : $data['AnyPort']['Settings']['OneDrive']['ClientId']; ?>" />
                                </td>
                        	</tr>
                            <tr>
                            	<td>
                        			<label for="AnyPortOneDriveClientSecret">Client secret:</label>
                        		</td>
                                <td>
                    				<input type="text" id="AnyPortOneDriveClientSecret" name="AnyPort[Settings][OneDrive][ClientSecret]" value="<?php echo (empty($data['AnyPort']['Settings']['OneDrive']['ClientSecret'])) ? '' : $data['AnyPort']['Settings']['OneDrive']['ClientSecret']; ?>" />
                        		</td>
                        	</tr>
                            <tr>
                            	<td>
                        			<label for="AnyPortOneDriveWorkingFolder">Working folder:</label>
                        		</td>
                                <td>
                    				<input type="text" id="AnyPortOneDriveWorkingFolder" name="AnyPort[Settings][OneDrive][WorkingFolder]" value="<?php echo (empty($data['AnyPort']['Settings']['OneDrive']['WorkingFolder'])) ? '' : $data['AnyPort']['Settings']['OneDrive']['WorkingFolder']; ?>" />
                        		</td>
                        	</tr>
                        </table>
                    </div>
                </li>
                <li>
                	<div>
                        <h1>CSV Configuration</h1>
                    </div>
                    <div class="help"></div>
                    <div class="iModuleFields">
                    	<table>
                        	<tr>
                            	<td>
                    				<label for="AnyPortCSVColumnSeparator">Column Separator</label><br />
                                    <span class="help">The default value is comma (,) but you can set it anything you like. The most common ones are comma (,) and semicolon (&#59;)</span>
                        		</td>
                                <td>
                                	<input id="AnyPortCSVColumnSeparator" type="text" name="AnyPort[Settings][CSV][ColumnSeparator]" value="<?php echo (empty($data['AnyPort']['Settings']['CSV']['ColumnSeparator'])) ? '' : $data['AnyPort']['Settings']['CSV']['ColumnSeparator']; ?>" placeholder="," />
                                </td>
                        	</tr>
                        </table>
                    </div>
                </li>
            </ul>
        </div>
    </li>
</ul>