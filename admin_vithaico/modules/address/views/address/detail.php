<style>
    #gmap {
        height: 400px;
        margin: 20px 0px;
        width: 100% !important;
    }

    .controls {
        margin-top: 16px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }

    #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 15px;
        text-overflow: ellipsis;
        width: 400px;
    }

    #pac-input:focus {
        border-color: #4d90fe;
    }

    .pac-container {
        font-family: Roboto;
    }

    #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
    }

    #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
    }
</style>
<?php
$latitude = @$data->latitude ? $data->latitude : '21.028224';
$longitude = @$data->longitude ? $data->longitude : '105.835419';
?>
<?php
$title = @$data ? FSText::_('Edit') : FSText::_('Add');
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply', FSText::_('Apply'), '', 'apply.png');
$toolbar->addButton('Save', FSText::_('Save'), '', 'save.png');
$toolbar->addButton('back', FSText::_('Cancel'), '', 'cancel.png');

$this->dt_form_begin(1, 4, $title . ' ' . FSText::_('Địa chỉ'));

TemplateHelper::dt_edit_text(FSText::_('Name'), 'name', @$data->name);
TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',URL_ROOT.str_replace('/original/','/original/',@$data->image));
TemplateHelper::dt_edit_selectbox(FSText::_('Tỉnh/Thành phố'), 'city_id', @$data->city_id, 0, $cities, $field_value = 'id', $field_label = 'name', $size = 10, 0, 1);
?>
<div class="form-group">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Quận/Huyện") ?></label>
    <div class="col-sm-9 col-xs-12">
        <select id="district_id" name="district_id" class="form-control chosen-select-no-field listItem">
            <?php foreach ($district as $item) { ?>
                <option <?php echo ($item->id == @$data->district_id) ? 'selected="selected"' : ''; ?> value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<?php
TemplateHelper::dt_edit_text(FSText::_('Address'), 'address', @$data->address);
TemplateHelper::dt_edit_text(FSText::_('Điện thoại'), 'phone', @$data->phone);
TemplateHelper::dt_edit_text(FSText:: _('Kinh độ'), 'latitude', @$data->latitude);
TemplateHelper::dt_edit_text(FSText:: _('Vĩ độ'), 'longitude', @$data->longitude);
TemplateHelper::dt_edit_text(FSText::_('Link Googlemap'), 'googlemap', @$data->googlemap);
//TemplateHelper::dt_edit_text(FSText :: _('Email'),'email',@$data -> email);


TemplateHelper::dt_checkbox(FSText::_('Published'), 'published', @$data->published, 1);
// TemplateHelper::dt_checkbox(FSText::_('ATM'), 'is_atm', @$data->is_atm, 0, '', '', '', 'col-sm-4', 'col-sm-8');
TemplateHelper::dt_edit_text(FSText::_('Ordering'), 'ordering', @$data->ordering, @$maxOrdering, '20');
//TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,9);
// TemplateHelper::dt_edit_text(FSText :: _('Thông tin thêm'),'more_info',@$data -> more_info,'',650,450,1);
?>
<div class="form-group" id="set-width">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_('Khu vực'); ?></label>
    <div class="col-sm-9 col-xs-12">
        <select class="form-control select2" name="region" id="more_info">
            <?php
            $i = 0;
            $region = array(0 => 'Miền Bắc', 1 => 'Miền Trung', 2 => 'Miền Nam');
            foreach ($region as $key => $name) {
                $checked = "";
                if (in_array(@$data->region, $region)) {
                    $checked = "' selected='selected' ";
                }
            ?>
                <option value="<?php echo $key; ?>" <?php echo @$data->region == $key ? "' selected='selected' " : null; ?>> <?php echo $name ?> </option>
            <?php
                $i++;
            } ?>
        </select>
    </div>
</div>

<?php
//	TemplateHelper::dt_edit_text(FSText :: _('Tags'),'tags',@$data -> tags,'',100,4);
$this->dt_form_end(@$data, 1);

?>


<script type="text/javascript" language="javascript">
    $(function() {
        $("select#city_id").change(function() {
            $.ajax({
                url: "index.php?module=address&task=ajax_district&raw=1",
                data: {
                    cid: $(this).val()
                },
                dataType: "text",
                success: function(text) {
                    if (text == '')
                        return;

                    var options = '';

                    for (var i = 0; i < JSON.parse(text).length; i++) {
                        options += `<option value="${JSON.parse(text)[i].id}"> ${JSON.parse(text)[i].name} </option>`;
                    }
                    $('#district_id').html(options);
                    elemnent_fisrt = $('#district_id option:first').val();
                }
            });
        });

    })
</script>
