<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<script>
    $(document).ready(function () {
        $("#tabs").tabs();
        //$("#products_related_category_id").select2();
    });
</script>
<?php
$title = @$data ? FSText :: _('Edit') : FSText :: _('Add');
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save_add', FSText :: _('Save and new'), '', 'save_add.png');
$toolbar->addButton('apply', FSText :: _('Apply'), '', 'apply.png');
$toolbar->addButton('Save', FSText :: _('Save'), '', 'save.png');
$toolbar->addButton('back', FSText :: _('Cancel'), '', 'cancel.png');
$this -> dt_form_begin(0);
?>
<div id="tabs">
    <ul>
        <li><a href="#fragment-1"><span><?php echo FSText::_("Tr&#432;&#7901;ng c&#417; b&#7843;n"); ?></span></a></li>
        <li><a href="#fragment-4"><span><?php echo FSText::_("Mã"); ?></span></a></li>
        <!--<li><a href="#fragment-12"><span><?php echo FSText::_("SEO"); ?></span></a></li>-->
    </ul>

    <!--	BASE FIELDS    -->
    <div id="fragment-1">
        <?php include_once 'detail_base.php'; ?>
    </div>

    <div id="fragment-4">
    <?php include_once 'detail_code.php'; ?>
    </div>

<!--    <div id="fragment-12">
        <?php // include_once 'detail_seo.php'; ?>
    </div>-->

</div>
        <?php
        $this->dt_form_end(@$data, 0);
        ?>