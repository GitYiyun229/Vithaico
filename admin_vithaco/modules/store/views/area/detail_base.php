<div class="col-md-8 col-xs-12">
	<div class="panel-heading" style="margin-bottom: 15px"><i class="fa fa-edit"></i> Sửa Cửa hàng</div>
	<?php
    TemplateHelper::dt_edit_text(FSText:: _('Tên cửa hàng'), 'name', @$data->name);
    TemplateHelper::dt_edit_text(FSText:: _('Alias'), 'alias', @$data->alias, '', 60, 1, 0, FSText::_("Can auto generate"));
//    TemplateHelper::dt_edit_image(FSText:: _('Hình ảnh'), 'image', str_replace('/original/', '/small/', URL_ROOT . @$data->image));
    TemplateHelper::dt_edit_selectbox(FSText::_('Tỉnh/ thành'), 'city_id', @$data->city_id, 0, $list_city, $field_value = 'id', $field_label = 'name', $size = 10, 0, 1,'','','','col-md-3','col-md-5');
    TemplateHelper::datetimepicke(FSText:: _('Published time'), 'created_time', @$data->created_time ? @$data->created_time : date('Y-m-d H:i:s'), FSText:: _('Bạn vui lòng chọn thời gian hiển thị'), 20, '', 'col-md-3', 'col-md-5');
//    TemplateHelper::datetimepicke(FSText:: _('End time (Đối với Tin tuyển dụng)'), 'end_time', @$data->end_time ? @$data->end_time : date('Y-m-d H:i:s'), FSText:: _('Bạn vui lòng chọn thời gian hiển thị'), 20, '', 'col-md-3', 'col-md-5');
//    TemplateHelper::dt_edit_text(FSText:: _('Địa điểm (Đối với Tin tuyển dụng)'), 'address', @$data->address);
	?>
</div>
<div class="col-md-4 col-xs-12">
	<div class="panel-heading" style="margin-bottom: 15px"><i class="fa fa-user"></i> Quản trị</div>
	<?php
    TemplateHelper::dt_text(FSText:: _('Người tạo'), @$data->author, '', '', '', 'col-md-6', 'col-md-6');
    TemplateHelper::dt_text(FSText:: _('Người sửa cuối'), @$data->author_last, '', '', '', 'col-md-6', 'col-md-6');
    ?>
</div>
<div class="col-md-4 col-xs-12">
	<div class="panel-heading" style="margin-bottom: 15px"><i class="fa fa-unlock"></i> Kích hoạt</div>
	<?php
    TemplateHelper::dt_checkbox(FSText::_('Published'), 'published', @$data->published, 1, '', '', '', 'col-sm-4', 'col-sm-8');
//    TemplateHelper::dt_checkbox(FSText::_('Trang chủ'), 'show_in_homepage', @$data->show_in_homepage, 0, '', '', '', 'col-sm-4', 'col-sm-8');
//    TemplateHelper::dt_checkbox(FSText::_('Hot'), 'is_hot', @$data->is_hot, 0, '', '', '', 'col-sm-4', 'col-sm-8');
//    TemplateHelper::dt_checkbox(FSText::_('Sản phẩm'), 'is_new_video', @$data->is_new_video, 0, '', '', '', 'col-sm-4', 'col-sm-8');
    TemplateHelper::dt_edit_text(FSText:: _('Ordering'), 'ordering', @$data->ordering, @$maxOrdering, '', '', 0, '', '', 'col-sm-4', 'col-sm-8');
    ?>
</div>
<!--<div class="col-md-8 col-xs-12">-->
<!--	<div class="panel-heading"><i class="fa fa-info"></i> Nội dung</div>-->
<!--	--><?php
//    TemplateHelper::dt_edit_text(FSText:: _(''), 'content', @$data->content, '', 650, 450, 1, '', '', 'col-sm-2', 'col-sm-12');
//    ?>
<!--</div>-->

<!--<div class="col-md-4 col-xs-12">-->
<!--	<div class="panel-heading" style="margin-bottom: 15px"><i class="fa fa-info"></i> Mô tả</div>-->
<!--    --><?php
//    TemplateHelper::dt_edit_text(FSText:: _(''), 'summary', @$data->summary, '', 100, 5, 0, '', '', 'col-sm-2', 'col-sm-12');
//    ?>
<!--</div>-->

<!--<div class="col-md-4 col-xs-12">-->
<!--	<div class="panel-heading" style="margin-bottom: 15px"><i class="fa fa-tags"></i> Tag</div>-->
<!--    --><?php
//    TemplateHelper::dt_edit_selectbox('','tags',@$data -> tags,0,$tag,$field_value = 'id', $field_label='name',$size = 30,1,'','','','','','col-sm-12');
//    ?>
<!--</div>-->
