<?php
    $title = @$data ? FSText :: _('Xem'): FSText :: _('Add'); 
    global $toolbar;
    $toolbar->setTitle($title);
    //$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
    //$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
    $toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');   

	$this -> dt_form_begin(1,4,$title.' '.FSText::_('Liên hệ'));

//    TemplateHelper::dt_edit_text(FSText :: _('Title'),'title',@$data -> title);
//    TemplateHelper::dt_edit_text(FSText :: _('Người gửi'),'fullname',@$data -> fullname);
?>
    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Tiêu đề')?></label>
        <div class="col-md-10 col-xs-12">
            <input disabled="disabled" type="text" class="form-control" name="title" id="title" value="<?php echo $data->title ?>" size="60">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Người gửi')?></label>
        <div class="col-md-10 col-xs-12">
            <input disabled="disabled" type="text" class="form-control" name="fullname" id="fullname" value="<?php echo $data->fullname ?>" size="60">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Nhóm đối tượng khách hàng')?></label>
        <div class="col-md-10 col-xs-12">
            <input disabled="disabled" type="text" class="form-control" name="type_id" id="type_id" value="<?php echo $data->type_id ?>" size="60">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Email')?></label>
        <div class="col-md-10 col-xs-12">
            <input disabled="disabled" type="text" class="form-control" name="email" id="email" value="<?php echo $data->email ?>" size="60">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Địa chỉ')?></label>
        <div class="col-md-10 col-xs-12">
            <input disabled="disabled" type="text" class="form-control" name="address" id="address" value="<?php echo $data->address ?>" size="60">
        </div>
    </div>
<?php
//    TemplateHelper::dt_edit_text(FSText :: _('Email'),'email',@$data -> email);
//    TemplateHelper::dt_edit_text(FSText :: _('Telephone'),'telephone',@$data -> telephone);
//    TemplateHelper::dt_edit_text(FSText :: _('Address'),'address',@$data -> address);
?>
    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Bộ phận liên hệ')?></label>
        <div class="col-md-10 col-xs-12">
            <?php foreach($parts as $item){?>
                <?php if($item->email==$data->parts_email) {?>
                    <input disabled="disabled" type="text" class="form-control" name="title" id="title" value="<?php echo $item->name ?>" size="60">
                <?php }else{}?>
            <?php }?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Nội dung')?></label>
        <div class="col-md-10 col-xs-12">
            <textarea disabled="disabled" class="form-control" name="content" id="content"><?php echo $data->content ?></textarea>
        </div>
    </div>
<?php
//    TemplateHelper::dt_edit_text(FSText :: _('Nội dung'),'content',@$data -> content,'',650,450,1,'','','col-sm-2','col-sm-10');
    
    $this -> dt_form_end(@$data,1);  
?>