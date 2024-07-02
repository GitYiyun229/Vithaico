
<table cellspacing="1" class="admintable">
<?php 
	TemplateHelper::dt_edit_text(FSText :: _('Thuê xe Sân bay'),'price_fly',@$data -> price_fly,'',60,1,0,FSText::_("Tính theo chuyến"));
	TemplateHelper::dt_edit_text(FSText :: _('Chú ý'),'note_price_fly',@$data -> note_price_fly,'',50,3,1);
	TemplateHelper::dt_sepa();
?>
</table>
<table cellspacing="1" class="admintable">
<?php
	TemplateHelper::dt_edit_text(FSText :: _('Thuê xe Ngoại thành'),'price_suburban',@$data -> price_suburban,'',60,1,0,FSText::_("Tính theo km"));
	TemplateHelper::dt_edit_text(FSText :: _('Chú ý'),'note_price_suburban',@$data -> note_price_suburban,'',50,3,1);
	TemplateHelper::dt_sepa();
	
	TemplateHelper::dt_edit_text(FSText :: _('Thuê xe nội thành'),'price_inner',@$data -> price_inner,'',60,1,0,FSText::_("Tính theo ngày"));
	TemplateHelper::dt_edit_text(FSText :: _('Chú ý'),'note_price_inner',@$data -> note_price_inner,'',50,3,1);
	TemplateHelper::dt_sepa();
	
	TemplateHelper::dt_edit_text(FSText :: _('Thuê xe cưới nội thành 4h/ca'),'price_wedding_inner_4h',@$data -> price_wedding_inner_4h,'',60,1,0,FSText::_("Tính theo ca"));
	TemplateHelper::dt_edit_text(FSText :: _('Thuê xe cưới nội thành 6h/ca'),'price_wedding_inner_6h',@$data -> price_wedding_inner_6h,'',60,1,0,FSText::_("Tính theo ca"));
	TemplateHelper::dt_edit_text(FSText :: _('Thuê xe cưới ngoại thành dưới 100km'),'price_wedding_suburban_smaller_100',@$data -> price_wedding_suburban_smaller_100,'',60,1,0,FSText::_("Tính theo km"));
	TemplateHelper::dt_edit_text(FSText :: _('Thuê xe cưới ngoại thành 101km - 150km'),'price_wedding_suburban_101_150',@$data -> price_wedding_suburban_101_150,'',60,1,0,FSText::_("Tính theo km"));
	TemplateHelper::dt_edit_text(FSText :: _('Thuê xe cưới ngoại thành 151km - 200km'),'price_wedding_suburban_151_200',@$data -> price_wedding_suburban_151_200,'',60,1,0,FSText::_("Tính theo km"));
	TemplateHelper::dt_edit_text(FSText :: _('Thuê xe cưới ngoại thành trên 200km'),'price_wedding_suburban_larger_200',@$data -> price_wedding_suburban_larger_200,'',60,1,0,FSText::_("Tính theo km"));
	TemplateHelper::dt_edit_text(FSText :: _('Chú ý'),'note_price_wedding',@$data -> note_price_wedding,'',50,3,1);
	TemplateHelper::dt_sepa();
	
	TemplateHelper::dt_edit_text(FSText :: _('Thuê xe theo tháng 22 ngày/ tháng/ 2.200km'),'price_month_22day_2200km',@$data -> price_month_22day_2200km,'',60,1,0,FSText::_("Tính theo gói"));
	TemplateHelper::dt_edit_text(FSText :: _('Thuê xe theo tháng 24 ngày/ tháng/ 2.400km'),'price_month_24day_2400km',@$data -> price_month_24day_2400km,'',60,1,0,FSText::_("Tính theo gói"));
	TemplateHelper::dt_edit_text(FSText :: _('Thuê xe theo tháng 26 ngày/ tháng/ 2.600km'),'price_month_26day_2600km',@$data -> price_month_26day_2600km,'',60,1,0,FSText::_("Tính theo gói"));
	TemplateHelper::dt_edit_text(FSText :: _('Thuê xe theo tháng 28 ngày/ tháng/ 2.800km'),'price_month_28day_2800km',@$data -> price_month_28day_2800km,'',60,1,0,FSText::_("Tính theo gói"));
	TemplateHelper::dt_edit_text(FSText :: _('Chú ý'),'note_price_month',@$data -> note_price_month,'',50,3,1);
	TemplateHelper::dt_sepa();
?>
</table>
