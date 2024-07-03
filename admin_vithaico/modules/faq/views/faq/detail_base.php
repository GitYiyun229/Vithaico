
<?php 
	TemplateHelper::dt_edit_text(FSText :: _('Title'),'title',@$data -> title);
	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
	//TemplateHelper::dt_edit_text(FSText :: _('Nguồn tin'),'source_news',@$data -> source_news);
	TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 10,0);
	TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/small/',URL_ROOT.@$data->image));
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	//TemplateHelper::dt_checkbox(FSText::_('Hiển thị trang chủ'),'show_in_homepage',@$data -> show_in_homepage,0);
    TemplateHelper::dt_checkbox(FSText::_('Tin nổi bật'),'is_hot',@$data -> is_hot,0);
    //TemplateHelper::dt_checkbox(FSText::_('Tin video'),'check_video',@$data -> check_video,0);
    //TemplateHelper::dt_checkbox(FSText::_('Tin mới nhất'),'is_new',@$data -> is_new,0);
    //TemplateHelper::dt_checkbox(FSText::_('Tin đọc nhiều nhất'),'is_view',@$data -> is_view,0);
    TemplateHelper::dt_date_pick ( FSText :: _('Published time' ), 'created_time', @$data->created_time?@$data->created_time:date('Y-m-d H:i:s'), FSText :: _('Bạn vui lòng chọn thời gian hiển thị'), 20);
//	TemplateHelper::dt_checkbox(FSText::_('Tin nhanh'),'news_fast',@$data -> news_fast,1);
//	TemplateHelper::dt_checkbox(FSText::_('Tin tiêu điểm'),'news_focus',@$data -> news_focus,1);
//	TemplateHelper::dt_checkbox(FSText::_('Tin slideshow'),'news_slide',@$data -> news_slide,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,9);
	TemplateHelper::dt_edit_text(FSText :: _('Content'),'content',@$data -> content,'',650,450,1,'','','col-sm-2','col-sm-10');
//	TemplateHelper::dt_edit_text(FSText :: _('Tags'),'tags',@$data -> tags,'',100,4);
?>
