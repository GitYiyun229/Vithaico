<?php

class FCKeditor
{
	/**
	 * Name of the FCKeditor instance.
	 *
	 * @access protected
	 * @var string
	 */
	public $InstanceName ;
	/**
	 * Path to FCKeditor relative to the document root.
	 *
	 * @var string
	 */
	public $BasePath ;
	/**
	 * Width of the FCKeditor.
	 * Examples: 100%, 600
	 *
	 * @var mixed
	 */
	public $Width ;
	/**
	 * Height of the FCKeditor.
	 * Examples: 400, 50%
	 *
	 * @var mixed
	 */
	public $Height ;
	/**
	 * Name of the toolbar to load.
	 *
	 * @var string
	 */
	public $ToolbarSet ;
	/**
	 * Initial value.
	 *
	 * @var string
	 */
	public $Value ;
	/**
	 * This is where additional configuration can be passed.
	 * Example:
	 * $oFCKeditor->Config['EnterMode'] = 'br';
	 *
	 * @var array
	 */
	public $Config ;

	/**
	 * Main Constructor.
	 * Refer to the _samples/php directory for examples.
	 *
	 * @param string $instanceName
	 */
    public $Type ;

	public function __construct( $instanceName )
 	{
		$this->InstanceName	= $instanceName ;
		$this->BasePath		= '/fckeditor/' ;
		$this->Width		= '100%' ;
		$this->Height		= '200' ;
		$this->ToolbarSet	= 'Default' ;
		$this->Value		= '' ;
        $this->Type         = '0';
		$this->Config		= array() ;
	}

	/**
	 * Display FCKeditor.
	 *
	 */
	public function Create()
	{
		$year = date('Y');
		$month = date('m');
		$day = date('d');
		$currentFolder = '/'.$year.'/'.$month.'/'.$day.'/';
		$baseUrl = '/upload_images/';
		$this -> create_folder($baseUrl . '_thumbs/Images/'.$currentFolder);
		$this -> create_folder($baseUrl . 'images/'.$year.'/'.$month.'/'.$day.'/');

		echo '<textarea rows="10" cols="10" name="'.$this->InstanceName.'" id="'.$this->InstanceName.'" >'.$this->Value.'</textarea>';
		if($this->Type == 0)
		echo "<script>CKEDITOR.replace( '".$this->InstanceName."',{
			filebrowserBrowseUrl : '".URL_ROOT."libraries/ckeditor/plugins/ckfinder/ckfinder.html',
			filebrowserImageBrowseUrl : '".URL_ROOT."libraries/ckeditor/plugins/ckfinder/ckfinder.html?type=Images&currentFolder=".$currentFolder."',
			filebrowserFlashBrowseUrl : '".URL_ROOT."libraries/ckeditor/plugins/ckfinder/ckfinder.html?type=Flash',
			filebrowserUploadUrl : '".URL_ROOT."libraries/ckeditor/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&currentFolder=".$currentFolder."',
			filebrowserImageUploadUrl : '".URL_ROOT."libraries/ckeditor/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&currentFolder=".$currentFolder."',
			filebrowserFlashUploadUrl : '".URL_ROOT."libraries/ckeditor/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
				});</script>" ;
		else if($this->Type == 1)
            echo "<script>
                config  = {};
                config.entities_latin = false;
                config.language = 'vi';
                config.height = '200';
                config.htmlEncodeOutput = false;
                config.entities = false;
                // config.filebrowserBrowseUrl 		= '';
                config.filebrowserImageBrowseUrl 	= '';
                // config.filebrowserUploadUrl         = '';
                // config.filebrowserImageUploadUrl    = '';
                config.filebrowserFlashUploadUrl    = '';
              
                config.toolbarGroups = [
                    { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
                    { name: 'links', groups: [ 'links' ] },
                ];                        

              
                config.removeButtons = 'Save,NewPage,ExportPdf,Preview,Print,Templates,Replace,Find,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,RemoveFormat,CopyFormatting,Language,Anchor,Smiley,SpecialChar,Flash,About,Iframe,HorizontalRule,PageBreak,BidiLtr,BidiRtl,Outdent,Indent,Maps';

                CKEDITOR.replace( '".$this->InstanceName."',config,{
                filebrowserBrowseUrl : '".URL_ROOT."libraries/ckeditor/plugins/ckfinder/ckfinder.html',
                filebrowserImageBrowseUrl : '".URL_ROOT."libraries/ckeditor/plugins/ckfinder/ckfinder.html?type=Images&currentFolder=".$currentFolder."',
                filebrowserFlashBrowseUrl : '".URL_ROOT."libraries/ckeditor/plugins/ckfinder/ckfinder.html?type=Flash',
                filebrowserUploadUrl : '".URL_ROOT."libraries/ckeditor/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&currentFolder=".$currentFolder."',
                filebrowserImageUploadUrl : '".URL_ROOT."libraries/ckeditor/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&currentFolder=".$currentFolder."',
                filebrowserFlashUploadUrl : '".URL_ROOT."libraries/ckeditor/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
				});
                </script>" ;
		
	}
	public function Create1()
	{
		echo $this->CreateHtml() ;
	}

	/**
	 * Return the HTML code required to run FCKeditor.
	 *
	 * @return string
	 */
	public function CreateHtml()
	{
		$HtmlValue = htmlspecialchars( $this->Value ) ;

		$Html = '' ;

		if ( $this->IsCompatible() )
		{
			if ( isset( $_GET['fcksource'] ) && $_GET['fcksource'] == "true" )
				$File = 'fckeditor.original.html' ;
			else
				$File = 'fckeditor.html' ;

			$Link = "{$this->BasePath}editor/{$File}?InstanceName={$this->InstanceName}" ;

			if ( $this->ToolbarSet != '' )
				$Link .= "&amp;Toolbar={$this->ToolbarSet}" ;

			// Render the linked hidden field.
			$Html .= "<input type=\"hidden\" id=\"{$this->InstanceName}\" name=\"{$this->InstanceName}\" value=\"{$HtmlValue}\" style=\"display:none\" />" ;

			// Render the configurations hidden field.
			$Html .= "<input type=\"hidden\" id=\"{$this->InstanceName}___Config\" value=\"" . $this->GetConfigFieldString() . "\" style=\"display:none\" />" ;

			// Render the editor IFRAME.
			$Html .= "<iframe id=\"{$this->InstanceName}___Frame\" src=\"{$Link}\" width=\"{$this->Width}\" height=\"{$this->Height}\" frameborder=\"0\" scrolling=\"no\"></iframe>" ;
		}
		else
		{
			if ( strpos( $this->Width, '%' ) === false )
				$WidthCSS = $this->Width . 'px' ;
			else
				$WidthCSS = $this->Width ;

			if ( strpos( $this->Height, '%' ) === false )
				$HeightCSS = $this->Height . 'px' ;
			else
				$HeightCSS = $this->Height ;

			$Html .= "<textarea name=\"{$this->InstanceName}\" rows=\"4\" cols=\"40\" style=\"width: {$WidthCSS}; height: {$HeightCSS}\">{$HtmlValue}</textarea>" ;
		}

		return $Html ;
	}

	/**
	 * Returns true if browser is compatible with FCKeditor.
	 *
	 * @return boolean
	 */
	public function IsCompatible()
	{
		return FCKeditor_IsCompatibleBrowser() ;
	}

	/**
	 * Get settings from Config array as a single string.
	 *
	 * @access protected
	 * @return string
	 */
	public function GetConfigFieldString()
	{
		$sParams = '' ;
		$bFirst = true ;

		foreach ( $this->Config as $sKey => $sValue )
		{
			if ( $bFirst == false )
				$sParams .= '&amp;' ;
			else
				$bFirst = false ;

			if ( $sValue === true )
				$sParams .= $this->EncodeConfig( $sKey ) . '=true' ;
			else if ( $sValue === false )
				$sParams .= $this->EncodeConfig( $sKey ) . '=false' ;
			else
				$sParams .= $this->EncodeConfig( $sKey ) . '=' . $this->EncodeConfig( $sValue ) ;
		}

		return $sParams ;
	}

	/**
	 * Encode characters that may break the configuration string
	 * generated by GetConfigFieldString().
	 *
	 * @access protected
	 * @param string $valueToEncode
	 * @return string
	 */
	public function EncodeConfig( $valueToEncode )
	{
		$chars = array(
			'&' => '%26',
			'=' => '%3D',
			'"' => '%22' ) ;

		return strtr( $valueToEncode,  $chars ) ;
	}
	
	
	function create_folder($path,$chmod = '0777'){
//		$path = str_replace('/', DS,$path);
//		$folder_reduce = str_replace(PATH_BASE,'',$path);
		$arr_folder = explode('/',$path); 
		if(!count($arr_folder))
			return;
		$path = $_SERVER['DOCUMENT_ROOT'];
		$folder_current = $path.'/';

		foreach($arr_folder as $item){
			if(!$item)
				continue;
			$folder_current .=  $item;
			if(!is_dir($folder_current))
	    	{
	    		if(!@mkdir($folder_current))
	    		{
//	    			Errors:: setError("Not create folder: ".$folder_current );
	    			@chmod($folder_current, $chmod); 	
	    			return false;
	    		}else{
//	    			Errors:: setError("Not create folder: ".$folder_current );
	    		}
	    	}
			$folder_current .=  '/';
		}
    	return true;
}
	
}
