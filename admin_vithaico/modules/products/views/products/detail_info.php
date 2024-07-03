<table cellspacing="1" class="admintable">
<?php
    TemplateHelper::dt_edit_text(FSText :: _('Khuyến mại'),'promotion',@$data -> promotion,'',650,450,1);
	TemplateHelper::dt_edit_text(FSText :: _('Mô tả chi tiết về sản phẩm'),'description',@$data -> description,'',650,450,1);
    TemplateHelper::dt_edit_text(FSText :: _('Thông số kỹ thuật'),'specs',@$data -> specs,'',650,450,1);
 ?>
 </table>