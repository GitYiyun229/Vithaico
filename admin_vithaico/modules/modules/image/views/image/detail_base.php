<table cellspacing="1" class="admintable">
<?php 
    TemplateHelper::dt_edit_text(FSText :: _('Tiêu đề'),'name',@$data -> name);
	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
	TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image));
	
//	TemplateHelper::dt_edit_file('Video','link_video_upload','','','.flv,.mp4');
//	TemplateHelper::dt_edit_text(FSText :: _('Hoặc link video'),'link_video_normal',@$data -> link_video,'',60,1,0);
	TemplateHelper::dt_checkbox(FSText::_('Show trang chủ'),'show_in_homepage',@$data -> show_in_homepage,1);
//	TemplateHelper::dt_edit_text(FSText :: _('Tiêu đề'),'title',@$data -> title,'',60,1,0);
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');

?>
</table>