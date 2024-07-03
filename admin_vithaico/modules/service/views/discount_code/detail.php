<?php
$title = @$data ? FSText:: _('Sửa') : FSText:: _('Thêm mới');
global $toolbar;
$toolbar->setTitle($title);
//$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png');
$toolbar->addButton('apply', FSText::_('Apply'), '', 'apply.png');
$toolbar->addButton('save', FSText::_('Save'), '', 'save.png');
$toolbar->addButton('cancel', FSText::_('Cancel'), '', 'cancel.png');

$array_status = array(
    1 => FSText::_('Đăng tuyển'),
    2 => FSText::_('QUẢNG CÁO THƯƠNG HIỆU'),
    3 => FSText::_('TÌM THÔNG TIN THÍ SINH'),
    4 => FSText::_('E-MARKETING'),
    5 => FSText::_('Đăng tuyển Combo'),
    //4=>FSText::_('Tin tuyển sinh hết hạn'),
);
$data = @$data ? $data : array();
$this->dt_form_begin(1, 4, $title . ' ' . FSText::_('Combo'), '', 1, 'col-md-12', 1);
//$this -> dt_form_begin(1,4,$title.' '.FSText::_('News'),'fa-edit',1,'col-md-8',1);
TemplateHelper::dt_edit_text(FSText:: _('Tên mã giảm giá'), 'title', @$data->title);
TemplateHelper::dt_edit_text(FSText:: _('Mã giảm giá'), 'name', @$data->name);
?>
<div class="form-group">
    <div class="col-md-9 col-xs-12 col-md-offset-3">
        <a style="color: #fff;" class="btn btn-primary"
           onClick="randomString();"><?php echo FSText::_('Tạo mã giảm giá') ?></a>
    </div>
</div>

<?php
TemplateHelper::dt_edit_text(FSText:: _('Alias'), 'alias', @$data->alias, '', 60, 1, 0, FSText::_("Can auto generate"));
//TemplateHelper::dt_edit_text(FSText :: _('Giá'),'price',@$data -> price);

//TemplateHelper::dt_checkbox(FSText::_('Dịch vụ có sử dụng tới tìm kiếm'),'is_search',@$data -> is_search,0,'','',FSText::_('Xuất hiện danh sách lĩnh vực ngành nghề.'));
//TemplateHelper::dt_checkbox(FSText::_('Kiểu thời gian sử dụng dịch vụ'),'is_type',@$data -> is_type,0,array(0 => FSText::_('Để trống'),1 => FSText::_('Ngay'), 2 => FSText::_('Tuần')),'',FSText::_('kiểu hiển thị tương tác'));
//TemplateHelper::dt_edit_text(FSText :: _('Hạn sử dụng dịch vụ khi đặt mua thành công'),'days_end',@$data -> days_end);
// TemplateHelper::dt_edit_text(FSText :: _('Mã'),'code',@$data -> code);
//TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',URL_ROOT.@$data->image);

// TemplateHelper::dt_edit_selectbox(FSText::_('Sử dụng cho các bảng'),'tablenames',@$data -> tablenames,0,$tables,'table_name','table_name',$size = 10,1,0,'Giữ phím Ctrl để chọn nhiều item');
TemplateHelper::dt_checkbox(FSText::_('Kiểu giảm giá'), 'type', @$data->type, 0, array(0 => FSText::_('Giá trị'), 1 => FSText::_('%')));
TemplateHelper::dt_edit_text(FSText:: _('Giá trị giảm giá'), 'val', @$data->val);

TemplateHelper::dt_edit_text(FSText:: _('Giá trị tối thiểu đc áp dụng'), 'price', @$data->price);
//TemplateHelper::dt_edit_text(FSText:: _('Giá trị tối đa đc áp dụng'), 'price_max', @$data->price_max);
//TemplateHelper::dt_edit_selectbox(FSText::_('Các điều kiện áp dụng theo dịch vụ'),'type_service',@$data->type_service,0,$array_status,$field_value = '', $field_label='',$size = 1,0);

TemplateHelper::dt_edit_text(FSText :: _('Tổng số lượng mã giảm giá'),'count_total',@$data -> count_total);
?>
<input type="hidden" name="count_total_exits" value="<?=@$data -> count_total?>">
<?php
//TemplateHelper::dt_edit_text(FSText:: _('Số lượng sử dụng còn lại'), 'count', @$data->count);
TemplateHelper::datetimepicke(FSText:: _('Thời gian áp dụng'), 'date_start', @$data->date_start ? @$data->date_start : date('Y-m-d H:i:s'), FSText:: _('Bạn vui lòng chọn thời gian hiển thị'), 20, '', 'col-md-3', 'col-md-3');
TemplateHelper::datetimepicke(FSText:: _('Thời gian hết hạn'), 'date_end', @$data->date_end ? @$data->date_end : date('Y-m-d H:i:s'), FSText:: _('Bạn vui lòng chọn thời gian hiển thị'), 20, '', 'col-md-3', 'col-md-3');
TemplateHelper::dt_edit_selectbox(FSText::_('Sản phẩm áp dụng'), 'products', @$data->products, 0, $list_products, $field_value = 'id', $field_label = 'name', $size = 1, 1, 0, '', '', '', 'col-md-3', 'col-md-9');
TemplateHelper::dt_edit_selectbox(FSText::_('Danh mục sản phẩm áp dụng'), 'multi_categories', @$data->multi_categories, 0, $relate_categories, $field_value = 'id', $field_label = 'name', $size = 1, 1, 0, '', '', '', 'col-md-3', 'col-md-9');

TemplateHelper::dt_checkbox(FSText::_('Published'), 'published', @$data->published, 1);
TemplateHelper::dt_edit_text(FSText:: _('Ordering'), 'ordering', @$data->ordering, @$maxOrdering, '20');
$this->dt_form_end_col();

//$this -> dt_form_end(@$data);
$this->dt_form_end(@$data, 1, 0, 2);
?>

<script language="javascript" type="text/javascript">
    function randomString() {
        var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
        var string_length = 10;
        var randomstring = '';
        for (var i = 0; i < string_length; i++) {
            var rnum = Math.floor(Math.random() * chars.length);
            randomstring += chars.substring(rnum, rnum + 1);
        }

        //console.log(randomstring);
        $('#name').val(randomstring);
        $('#alias').val('');
    }
</script>
