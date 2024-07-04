<?php
$title = @$data ? FSText::_('Edit'): FSText::_('Add');
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png');
$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png');
$toolbar->addButton('save',FSText::_('Save'),'','save.png');
$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');
$this -> dt_form_begin(1,4,$title.' '.FSText::_('Categories'),'',1,'col-md-12',1);

TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
TemplateHelper::dt_edit_selectbox(FSText::_('Parent'),'parent_id',@$data -> parent_id,'',$categories,$field_value = 'id', $field_label='treename',$size = 1,0,1);
TemplateHelper::dt_edit_selectbox(FSText::_('Danh Mục Cha Phụ'),'multi_parent',@$data -> multi_parent,'',$categories,$field_value = 'id', $field_label='treename',$size = 1,1,1);
TemplateHelper::dt_edit_selectbox(FSText::_('Bảng thông số kỹ thuật'),'tablename',@$data -> tablename,'fs_products',$tables,$field_value = 'table_name', $field_label='table_name',$size = 1,0,1);
TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
TemplateHelper::dt_checkbox(FSText::_('Danh mục phụ kiện?'),'is_accessories',@$data -> is_accessories,0);
TemplateHelper::dt_checkbox(FSText::_('Hiển thị trang chủ'),'show_in_homepage',@$data -> show_in_homepage,0);
TemplateHelper::dt_edit_selectbox(FSText::_('Gói bảo hành'), 'warranty', @$data->warranty, 0, $warranty, $field_value = 'id', $field_label = 'name', $size = 1, 1, 0, '', '', '', 'col-md-3 right', 'col-md-9');

TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');

// TemplateHelper::dt_edit_image(FSText :: _('Icon hover'),'avatar',str_replace('/original/','/small/',URL_ROOT.@$data->avatar));
TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',URL_ROOT.@$data->image,'','','Ảnh đại diện khi vào Danh mục. Lưu ý ảnh vuông');
TemplateHelper::dt_edit_image(FSText :: _('Icon'),'icon',str_replace('/original/','/original/',URL_ROOT.@$data->icon));
TemplateHelper::dt_edit_image(FSText :: _('Logo Sản phẩm'),'logo',str_replace('/original/','/original/',URL_ROOT.@$data->logo));

//TemplateHelper::dt_edit_image(FSText :: _('Icon'),'icon',str_replace('/original/','/small/',URL_ROOT.@$data->icon));

//TemplateHelper::dt_edit_text(FSText :: _('Svg'),'svg',@$data -> svg,'','','4');
?>
<?php
echo '<div style="margin-bottom: 15px">';
TemplateHelper::dt_edit_selectbox(FSText::_('Khoảng giá'), 'price', @$data->price, 0, $range_price, $field_value = 'id', $field_label = 'treename', $size = 1, 1,0,'','','','col-md-12 left','col-md-12');
echo '</div>';
require_once ('detail_extend.php');
// TemplateHelper::dt_edit_text(FSText :: _(''),'content',@$data -> content,'',650,450,1,'','','col-sm-2','col-sm-12');
// TemplateHelper::dt_edit_text(FSText :: _('Mô tả dưới'),'summary_small',@$data -> summary_small,'',100,6);
//TemplateHelper::dt_checkbox(FSText::_('Dữ liệu mở rộng'),'have_extend',@$data -> have_extend,1);
TemplateHelper::dt_edit_text(FSText::_('Bộ sản phẩm chuẩn'),'product_set',@$data -> product_set,'',100,6,'1','','','col-md-12 left','col-md-12 ','','1');
TemplateHelper::dt_edit_text(FSText::_('Khuyến mại'),'accessories',@$data -> accessories,'',100,6,'1','','','col-md-12 left','col-md-12 ','','1');
TemplateHelper::dt_edit_text(FSText::_('Bảo hành cơ bản'),'basic_warranty',@$data -> basic_warranty,'',100,6,'1','','','col-md-12 left','col-md-12 ','','1');
TemplateHelper::dt_edit_text(FSText::_('Mô tả'),'description',@$data -> description,'',100,6,'1','','','col-md-12 left','col-md-12 ');


$this->dt_form_end_col(); // END: col-1
$this -> dt_form_end(@$data,1,1,2,FSText::_('Cấu hình Seo'),'',1,'col-md-12');

//$this -> dt_form_begin(1,4,$title.' '.FSText::_('Mô tả'),'',1,'col-md-12',1);
//$this->dt_form_end_col(); // END: col-1
?>

<style>
    .image-area-single{
        background: #f5f5f5;
    }
</style>
