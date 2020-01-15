/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function(config) {
	// Define changes to default configuration here. For example:
	 config.language = 'ru';
	// config.uiColor = '#AADC6E';

	config.filebrowserBrowseUrl = 'index.php?route=common/filemanager';
	config.filebrowserImageBrowseUrl = 'index.php?route=common/filemanager';
	config.filebrowserFlashBrowseUrl = 'index.php?route=common/filemanager';
	config.filebrowserUploadUrl = 'index.php?route=common/filemanager';
	config.filebrowserImageUploadUrl = 'index.php?route=common/filemanager';
	config.filebrowserFlashUploadUrl = 'index.php?route=common/filemanager';

	config.filebrowserWindowWidth = '850';
	config.filebrowserWindowHeight = '500';

	config.enterMode = CKEDITOR.ENTER_BR;
	config.shiftEnterMode = CKEDITOR.ENTER_P;
    config.extraAllowedContent = 'span(*)';
    // allow i tags to be empty (for font awesome)
    config.protectedSource.push(/<i[^>]*><\/i>/g);
    config.protectedSource.push(/<a[^>]*><\/a>/g);

    config.allowedContent = true;

	config.extraPlugins = 'codemirror';
	config.codemirror_theme = 'rubyblue';
	config.codemirror = {
		lineNumbers: true,
		highlightActiveLine: false,
		enableSearchTools: true,
		showSearchButton: true,
		showFormatButton: true,
		showCommentButton: true,
		showUncommentButton: true,
		showAutoCompleteButton: true,
		showTrailingSpace: true
	};
};

CKEDITOR.dtd.$removeEmpty.span = 0;
CKEDITOR.dtd.$removeEmpty['i'] = false;
CKEDITOR.dtd.$removeEmpty['a'] = false;