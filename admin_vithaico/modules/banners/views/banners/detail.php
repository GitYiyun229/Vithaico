<link type="text/css" rel="stylesheet" media="all" href="templates/default/css/jquery-ui.css" />
<script type="text/javascript" src="templates/default/js/jquery-ui.min.js"></script>

<!-- HEAD -->
<?php
	$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
    
    //$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png');
    $toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png',1); 
    $toolbar->addButton('Save',FSText :: _('Save'),'','save.png',1); 

	$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   
    
    echo ' 	<div class="alert alert-danger" style="display:none" >
                    <span id="msg_error"></span>
            </div>';
    
    $this -> dt_form_begin(1,4,$title.' '.FSText::_('banner'));
    include_once 'detail_base.php';
    $this -> dt_form_end(@$data,1,0);
?>
<!-- END BODY-->
<script type="text/javascript">
    $('.form-horizontal').keypress(function (e) {
      if (e.which == 13) {
        formValidator();
        return false;  
      }
    });
    
    
	function formValidator()
	{
	    $('.alert-danger').show();	
        
		if(!notEmpty('name','Nhập tên banner'))
			return false;
            
                
		$('.alert-danger').hide();
		return true;
	}
   

</script>
