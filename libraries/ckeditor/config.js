/**
 * @license Copyright (c) 2003-2022, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' }
	];

	config.language = 'vi';
	config.filebrowserBrowseUrl      = '../libraries/ckeditor/plugins/ckfinder/ckfinder.html';
	config.filebrowserImageBrowseUrl = '../libraries/ckeditor/plugins/ckfinder/ckfinder.html?type=Images';
	config.filebrowserFlashBrowseUrl = '../libraries/ckeditor/plugins/ckfinder/ckfinder.html?type=Flash';
	config.filebrowserUploadUrl      = '../libraries/ckeditor/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	config.filebrowserImageUploadUrl = '../libraries/ckeditor/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	config.filebrowserFlashUploadUrl = '../libraries/ckeditor/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
	config.extraPlugins = 'youtube,pastefromgdocs,pastefromword,collapsibleItem,wenzgmap,html5video,colorbutton,justify,btgrid';

	config.height = 800;
	//config.removePlugins = 'oembed';
	config.allowedContent = true;
	config.removeButtons = 'Underline,Subscript,Superscript';
	config.format_tags = 'p;h1;h2;h3;pre';
	config.disallowedContent = 'p[clas*];*{text*};p*{color*}*;div[clas*];div[class*];*[dir]';
	config.extraAllowedContent = 'iframe[*]';
	config.removeDialogTabs = 'image:advanced;link:advanced';
};
