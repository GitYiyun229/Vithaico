<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<script>
    $(document).ready(function() {
        $("#tabs").tabs();
    });
</script>
<style>
    .ui-tabs .ui-tabs-nav {
        margin-bottom: 20px;
    }
</style>
<?php
$title = @$data ? FSText::_('Edit') : FSText::_('Add');
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save_add', FSText::_('Save and new'), '', 'save_add.png', 1);
$toolbar->addButton('apply', FSText::_('Apply'), '', 'apply.png', 1);
$toolbar->addButton('Save', FSText::_('Save'), '', 'save.png', 1);
$toolbar->addButton('back', FSText::_('Cancel'), '', 'cancel.png');

echo ' 	<div class="alert alert-danger" style="display:none" >
                    <span id="msg_error"></span>
            </div>';
$this->dt_form_begin(1, 4, '', 'fa-edit', 1, 'col-md-12', 1);
?>
<div id="tabs" class="row">
    <ul>
        <li><a href="#fragment-1"><span><?php echo FSText::_("Trường cơ bản"); ?></span></a></li>
        <!-- <li><a href="#fragment-2"><span><?php //echo FSText::_("Tin liên quan"); 
                                                ?></span></a></li> -->
        <!-- <li><a href="#fragment-3"><span><?php //echo FSText::_("Cấu hình SEO"); 
                                                ?></span></a></li> -->
    </ul>
    <div id="fragment-1" style="padding: 0">
        <?php
        include_once 'detail_base.php';
        ?>
    </div>
    <!-- <div id="fragment-2" style="padding: 0">
        <?php //include_once 'detail_related.php';
        ?>
    </div>
    <div id="fragment-3" style="padding: 0">
        <?php //include_once 'detail_seo.php';
        ?>
    </div> -->
</div>
<?php
$this->dt_form_end(@$data, 1, 0, 2, 'Cấu hình seo', '', 1, 'col-sm-4');
?>
<script type="text/javascript">
    $('.form-horizontal').keypress(function(e) {
        if (e.which == 13) {
            formValidator();
            return false;
        }
    });

    function formValidator() {
        $('.alert-danger').show();

        // if (!notEmpty('title', 'Bạn phải nhập tiêu đề'))
        //     return false;

        //        if(!notEmpty('image','bạn phải nhập hình ảnh'))
        //			return false;

        // if(!notEmpty('category_id','Bạn phải chọn danh mục'))
        //   return false;

        // if (!notEmpty('summary', 'Bạn phải nhập nội dung mô tả'))
        //     return false;

        // if (CKEDITOR.instances.content.getData() == '') {
        //     invalid("content", 'Bạn phải nhập nội dung chi tiết');
        //     return false;
        // }

        $('.alert-danger').hide();
        return true;
    }
</script>
<?php //include 'detail_seo.php'; 
?>