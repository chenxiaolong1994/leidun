
CKEDITOR.editorConfig = function( config ) {
	config.language = 'zh-cn';
	config.toolbar = 'Basic';
	config.height = 100; 
    config.toolbar_Basic =[
    ['Bold', 'Italic', 'Underline','TextColor','FontSize','-','RemoveFormat','PasteText','Table','-','JustifyLeft','JustifyCenter','JustifyRight','-','NumberedList', 'BulletedList', '-', 'Image', 'Maximize']
    ];
	config.removePlugins = 'elementspath';
	config.resize_enabled = false;
	config.enterMode = CKEDITOR.ENTER_BR;
	config.shiftEnterMode = CKEDITOR.ENTER_P;
	config.entities = false; 
};
