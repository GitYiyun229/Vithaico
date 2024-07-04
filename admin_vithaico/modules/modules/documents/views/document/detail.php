<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<!-- FOR TAB -->	
 <script>
  $(document).ready(function() {
    $("#tabs").tabs();
  });
  </script>
<?php
    $title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
    global $toolbar;
    $toolbar->setTitle($title);
    $toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png',1);
    $toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png',1); 
    $toolbar->addButton('Save',FSText :: _('Save'),'','save.png',1); 
    $toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   
    echo '  <div class="alert alert-danger" style="display:none" >
                    <span id="msg_error"></span>
            </div>';   

	$this -> dt_form_begin();
?>

  <div id="tabs">
      <ul>
          <li><a href="#fragment-1"><span><?php echo FSText::_("Tr&#432;&#7901;ng c&#417; b&#7843;n"); ?></span></a></li>
          <li><a href="#fragment-2"><span><?php echo FSText::_("File word"); ?></span></a></li>
          <li><a href="#fragment-3"><span><?php echo FSText::_("File excel"); ?></span></a></li>
          <li><a href="#fragment-4"><span><?php echo FSText::_("File pdf"); ?></span></a></li>
      </ul>

      <!--	BASE FIELDS    -->
      <div id="fragment-1">
          <?php include_once 'detail_base.php'; ?>
      </div>
      <div id="fragment-2">
          <?php include_once 'detail_word.php'; ?>
      </div>
      <div id="fragment-3">
          <?php include_once 'detail_excel.php'; ?>
      </div>
      <div id="fragment-4">
          <?php include_once 'detail_pdf.php'; ?>
      </div>
  </div>
  <?php
  $this->dt_form_end(@$data);
  ?>
<input type="hidden" name="val_file" id="val_file" value="<?php echo @$data->urlfile ?>">
<script type="text/javascript">
    $('.form-horizontal').keypress(function (e) {
          if (e.which == 13) {
            formValidator();
            return false;  
          }
    });
    function formValidator()
    {
         if(!notEmpty('name','Bạn chưa nhập tên tài liệu'))
            return false;
        
        return true;
    }
    
</script>
