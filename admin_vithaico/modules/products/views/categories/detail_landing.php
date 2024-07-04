<div class="row">
    <div class="col-md-8 col-xs-12">
        <?php
        TemplateHelper::dt_edit_text(FSText::_('Tiêu đề'), 'landing_title', @$data->landing_title, '', '', 1, '', '', '', 'col-md-3', 'col-md-9');
        ?>
        <div class="form-group">
            <label class="col-md-3 col-xs-12 control-label">
                <a href="<?php echo URL_ROOT_ADMIN ?>index.php?module=promotion&view=accompanying" target="_blank" style="font-style: italic; text-decoration:underline">
                    <i class="fa fa-cog"></i>
                    Cấu hình quà tặng
                    <i class="fa fa-info-circle" data-toggle="tooltip" title="Module quà tặng"></i>
                </a>
            </label>
            <div class="col-md-9 col-xs-12">

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 col-xs-12 control-label">Sản phẩm tiêu biểu</label>
            <div class="col-md-9 col-xs-12">
                <?php if ($data->landing_product) { ?>
                    <?php @$news = $this->model->get_record('id=' . @$data->landing_product, 'fs_products', 'id,name'); ?>
                <?php } ?>
                <select name="landing_product" id="landing_product">
                    <option value="<?php echo @$news->id ?>" selected><?php echo @$news->name ?></option>
                </select>
                <script>
                    $(document).ready(function() {
                        $('#landing_product').select2({
                            placeholder: "Chọn sản phẩm",
                            ajax: {
                                url: 'index2.php?module=products&view=categories&task=ajax_get_landing_product&raw=1&id=<?php echo $data->id ?>',
                                delay: 1000,
                                data: function(params) {
                                    var query = {
                                        search: params.term,
                                        page: params.page || 1
                                    }
                                    return query;
                                },
                                processResults: function(data, params) {
                                    data = JSON.parse(data);
                                    return {
                                        results: data.results,
                                        pagination: {
                                            'more': data.pagination.more
                                        }
                                    };
                                }
                            }
                        })
                    })
                </script>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3 col-xs-12">
                <input class="form-control" type="text" name="landing_text1" value="<?php echo $data->landing_text1 ? $data->landing_text1 : 'Đặt gạch' ?>">
            </div>
            <div class="col-md-5 col-xs-12">
                <div class="input-group date datetimepicker" id="datetimepicker_landing_date1">
                    <input class="form-control" type="text" name="landing_date1" id="landing_date1" value="<?php echo date('Y-m-d H:i:s', strtotime($data->landing_date1)) ?>" size="20">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3 col-xs-12">
                <input class="form-control" type="text" name="landing_text2" value="<?php echo $data->landing_text2 ? $data->landing_text2 : 'Mở bán' ?>">
            </div>
            <div class="col-md-5 col-xs-12">
                <div class="input-group date datetimepicker" id="datetimepicker_landing_date2">
                    <input class="form-control" type="text" name="landing_date2" id="landing_date2" value="<?php echo date('Y-m-d H:i:s', strtotime($data->landing_date2)) ?>" size="20">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3 col-xs-12">
                <input class="form-control" type="text" name="landing_text3" value="<?php echo $data->landing_text3 ? $data->landing_text3 : 'Nhận hàng' ?>">
            </div>
            <div class="col-md-5 col-xs-12">
                <div class="input-group date datetimepicker" id="datetimepicker_landing_date3">
                    <input class="form-control" type="text" name="landing_date3" id="landing_date3" value="<?php echo date('Y-m-d H:i:s', strtotime($data->landing_date3)) ?>" size="20">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <script src="<?php echo URL_ROOT_ADMIN ?>templates/default/js/moment.js"></script>
        <script src="<?php echo URL_ROOT_ADMIN ?>templates/default/js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript">
            $(function() {
                $(".datetimepicker").datetimepicker({
                    format: "YYYY-MM-DD HH:mm:ss"
                });
            });
        </script>
        <?php
        TemplateHelper::dt_edit_text(FSText::_('Số lượng đặt, cọc'), 'landing_sl', @$data->landing_sl, '', '', 1, '', '', '', 'col-md-3', 'col-md-9');

        TemplateHelper::dt_edit_text(FSText::_('Video Youtube'), 'landing_video', @$data->landing_video, '', '', 6, '0', '', '', 'col-md-12 left', 'col-md-12 ', '', '1', '1', '');
        echo '<div style="border: 1px solid #d1d1d1; margin-bottom: 15px; background:#f1f1f1; padding:10px 7px 0px 6px;">';
        TemplateHelper::dt_edit_image2(FSText::_('Đặc điểm nổi bật + Video'), 'image', str_replace('/original/', '/resized/', URL_ROOT . @$data->image), '', '', '', 1, @$list_images, 'col-md-12', 'col-md-12', '1', '');
        echo '</div>';
        TemplateHelper::dt_edit_text(FSText::_('Thể lệ'), 'landing_policy', @$data->landing_policy, '', 100, 6, '1', '', '', 'col-md-12 left', 'col-md-12 ', '', '1', '1', 'thể lệ');
        TemplateHelper::dt_edit_text(FSText::_('Tổng khách đặt'), 'landing_buy', @$data->landing_buy, '', 100, 6, '1', '', '', 'col-md-12 left', 'col-md-12 ', '', '1', '1', 'tổng khách đặt');

        ?>
    </div>
    <div class="col-md-4 col-xs-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <i class="fa fa-cog"></i> Cấu hình Landing Page
            </div>
            <div class="panel-body">
                <?php
                TemplateHelper::dt_checkbox(FSText::_('Tin tức'), 'is_land_news', @$data->is_land_news, 1, '', '', '', 'col-md-5', 'col-md-7');
                TemplateHelper::dt_checkbox(FSText::_('Bộ lọc'), 'is_land_filter', @$data->is_land_filter, 1, '', '', '', 'col-md-5', 'col-md-7');
                TemplateHelper::dt_checkbox(FSText::_('Time Line'), 'is_land_time', @$data->is_land_time, 1, '', '', '', 'col-md-5', 'col-md-7');
                TemplateHelper::dt_checkbox(FSText::_('Danh sách mua'), 'is_land_buy', @$data->is_land_buy, 1, '', '', '', 'col-md-5', 'col-md-7');
                TemplateHelper::dt_checkbox(FSText::_('Quà tặng'), 'is_land_gift', @$data->is_land_gift, 1, '', '', '', 'col-md-5', 'col-md-7');
                TemplateHelper::dt_checkbox(FSText::_('Ưu đãi'), 'is_land_offer', @$data->is_land_offer, 1, '', '', '', 'col-md-5', 'col-md-7');
                TemplateHelper::dt_checkbox(FSText::_('Video'), 'is_land_video', @$data->is_land_video, 1, '', '', '', 'col-md-5', 'col-md-7');
                TemplateHelper::dt_checkbox(FSText::_('Thông số kỹ thuật'), 'is_land_tech', @$data->is_land_tech, 1, '', '', '', 'col-md-5', 'col-md-7');
                ?>
            </div>
        </div>
    </div>
</div>