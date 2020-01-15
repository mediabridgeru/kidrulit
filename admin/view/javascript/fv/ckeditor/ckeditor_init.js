function ckeditorInit(node, token) {
    CKEDITOR.replace(node, {
    	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token='+token,
    	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token='+token,
    	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token='+token,
    	filebrowserUploadUrl: 'index.php?route=common/filemanager&token='+token,
    	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token='+token,
    	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token='+token
    });
}