<link type="text/css" rel="stylesheet" media="all" href="templates/default/css/jquery-ui.css" />
<script type="text/javascript" src="templates/default/js/jquery-ui.min.js"></script>

<!-- HEAD -->
<?php
$title = @$data ? FSText::_('Edit') : FSText::_('Add');
global $toolbar;
$toolbar->setTitle($title);

//$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png');
$toolbar->addButton('apply', FSText::_('Apply'), '', 'apply.png', 1);
$toolbar->addButton('Save', FSText::_('Save'), '', 'save.png', 1);

$toolbar->addButton('back', FSText::_('Cancel'), '', 'back.png');

echo ' 	<div class="alert alert-danger" style="display:none" >
                    <span id="msg_error"></span>
            </div>';

$this->dt_form_begin(1, 4, $title . ' ' . FSText::_('banner'), '', 1, 'col-md-8', 1);
include_once 'detail_base.php';
$this->dt_form_end_col();

$this->dt_form_begin(1, 4, FSText::_('Create Links'), 'fa fa-link', 1, 'col-md-4 fl-right');
?>
<div class="form-group panel-body panel-primary">

  <ul>
    <?php
    if ($create_link) {
      foreach ($create_link as $item) {
        if (!$item->link_menu) {
          echo '<li><strong>' . $item->treename . '</strong><li>';
        } else {
          if ($item->add_parameter) {
            echo '<li><a href="javascript: created_indirect(\'' . $item->link_menu . '\',\'' . $item->id . '\');">' . $item->treename . '</a><li>';
          } else {
            echo '<li><a href="javascript: created_direct(\'' . $item->link_menu . '\');">' . $item->treename . '</a><li>';
          }
        }
      }
    }
    ?>
  </ul>

</div>
<?php $this->dt_form_end(@$data, 1, 0); ?>


<!-- END BODY-->
<script type="text/javascript">
  $('.form-horizontal').keypress(function(e) {
    if (e.which == 13) {
      formValidator();
      return false;
    }
  });


  function formValidator() {
    $('.alert-danger').show();

    if (!notEmpty('name', 'Nhập tên banner'))
      return false;


    $('.alert-danger').hide();
    return true;
  }

  function created_direct(link) {
    $('#link').val(link);
  }

  function created_indirect(link, created_link_id) {
    $('#link').val(link);
    window.open("index2.php?module=menus&view=items&task=add_param&id=" + created_link_id, "", "height=600,width=700,menubar=0,resizable=1,scrollbars=1,statusbar=0,titlebar=0,toolbar=0");
  }
</script>