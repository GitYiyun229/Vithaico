<?php
    $title = @$data ? FSText :: _('Edit'): FSText :: _('Add');
    global $toolbar;
    $toolbar->setTitle($title);
    $toolbar->addButton('save_add', FSText :: _('Save and new'), '', 'save_add.png');
    $toolbar->addButton('apply', FSText :: _('Apply'), '', 'apply.png');
    $toolbar->addButton('Save', FSText :: _('Save'), '', 'save.png');
    $toolbar->addButton('back', FSText :: _('Cancel'), '', 'cancel.png');

    $array_positions = array(
                        1=>FSText::_('Góc trên bên phải'),
                        2=>FSText::_('Góc trên bên trái'),
                        3=>FSText::_('Góc dưới bên phải'),
                        4=>FSText::_('Góc dưới bên trái'),
    );

    $this -> dt_form_begin(1, 4, $title.' '.FSText::_('Cấu hình dịch vụ'));

    TemplateHelper::dt_edit_text(FSText :: _('Name'), 'name', @$data -> name);
  TemplateHelper::dt_edit_text(FSText :: _('Link tiêu đề'), 'link_title', @$data -> link_title);
    //TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));

    //TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 1,0);
    //TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',URL_ROOT.str_replace('/original/','/resized/', @$data->image),'','');
    TemplateHelper::dt_edit_text(FSText :: _('Summary'), 'summary', @$data -> summary, '', 100, 5);
    TemplateHelper::dt_edit_text(FSText :: _('Content'), 'content', @$data -> content, '', 650, 450, 1);

    TemplateHelper::dt_edit_text(FSText :: _('Tên link 1'), 'name_link1', @$data -> name_link1);
    TemplateHelper::dt_edit_text(FSText :: _('link1'), 'link1', @$data -> link1);
    TemplateHelper::dt_edit_text(FSText :: _('Tên link 2'), 'name_link2', @$data -> name_link2);
    TemplateHelper::dt_edit_text(FSText :: _('link2'), 'link2', @$data -> link1);
    
    TemplateHelper::dt_edit_text(FSText :: _('Khuyến mại'), 'sale', @$data -> sale, '', 650, 450, 1);
    //TemplateHelper::dt_edit_text(FSText :: _('Khuyến mại'), 'sale', @$data -> sale, '', 60, 1, 0, FSText::_("nhập số %"));
    TemplateHelper::dt_edit_selectbox(FSText::_('Vị trí xuất hiện box giảm giá'), 'positions', @$data->positions, 0, $array_positions, $field_value = '', $field_label='', $size = 1, 0);

    TemplateHelper::dt_checkbox(FSText::_('Published'), 'published', @$data -> published, 1);
    TemplateHelper::dt_edit_text(FSText :: _('Ordering'), 'ordering', @$data -> ordering, @$maxOrdering, '20');

    $this -> dt_form_end(@$data);
