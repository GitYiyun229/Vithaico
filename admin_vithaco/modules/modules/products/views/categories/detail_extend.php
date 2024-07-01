<table id="table_extend_fields" class="table table-bordered" style="background-color: #f5f5f5">
    <thead>
        <tr class="table-primary"><th class="text-center" colspan="6">Tạo bộ lọc</th></tr>
        <tr>
            <th>Tên</th>
            <th>Kiểu trường</th>
            <th>
                Bảng mở rộng
                <a class="pull-right" href="javascript:void(0);" onclick="show_field_table();" title="Thêm nhóm dữ liệu mở rộng"><img src="/admin_logico/templates/default/images/toolbar/add.png" /></a>
            </th>
            <th>Thứ tự</th>
            <th style="width: 100px">Mục con</th>
            <th style="width: 80px"></th>
        </tr>
    </thead>
    <tbody>

    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" class="text-center">
                <a class="btn btn-success" href="javascript:void(0)" onclick="add_extend_fields();">Thêm mới</a>
                <input type="hidden" id="extend_category_id" name="extend_category_id" value="<?php echo intval(@$data->id); ?>" />
            </td>
        </tr>
    </tfoot>
</table>
<?php
$extend_number = intval($this->model->get_auto_increment('fs_products_extend_fields'));
?>
<script type="text/javascript">
    var  $extend_number = parseInt(<?php echo $extend_number?>);

    function load_extend_fields(){
        var $extend_category_id = $('#extend_category_id').val();
        $.ajax({
            url: "index.php?module=ajax&view=ajax&task=load_extend_fields&raw=1",
            dataType: 'html',
            data: 'extend_category_id='+$extend_category_id,
            method: "POST",
            success: function ($html) {
                $('#table_extend_fields tbody').html($html);
            }
        });
    }

    function add_extend_fields(){
        $extend_number++;

        $.ajax({
            url: "index.php?module=ajax&view=ajax&task=add_extend_fields&raw=1",
            dataType: 'html',
            data: 'extend_number='+$extend_number,
            method: "POST",
            success: function ($html) {
                $('#table_extend_fields tbody').append($html);
            }
        });
    }

    function save_extend_fields($obj, $extend_number){
        var $field_name = $('#field_name_'+$extend_number).val();
        var $field_type = $('#field_type_'+$extend_number).val();
        var $field_table = $('#field_table_'+$extend_number).val();
        var $ordering = $('#ordering_'+$extend_number).val();
        var $extend_category_id = $('#extend_category_id').val();
        var $extend_id = $('#extend_id_'+$extend_number).val();

        var $childs = 0;
        if($('#childs_'+$extend_number).is(":checked"))
            $childs = 1;

        $($obj).children('img').attr('src', 'templates/default/images/toolbar/process.gif');

        $.ajax({
            url: "index.php?module=ajax&view=ajax&task=save_extend_fields&raw=1",
            dataType: 'json',
            data: 'extend_category_id='+$extend_category_id+'&field_name='+$field_name+'&field_type='+$field_type+'&field_table='+$field_table+'&extend_id='+$extend_id+'&childs='+$childs+'&ordering='+$ordering,
            method: "POST",
            success: function ($json) {
                load_extend_fields();
            }
        });
    }

    function del_extend_fields($extend_number){
        var $confirm = confirm("Bạn có chắc muốn xóa filed này?");
        if($confirm==true) {
            var $extend_id = $('#extend_id_' + $extend_number).val();
            $.ajax({
                url: "index.php?module=ajax&view=ajax&task=del_extend_fields&raw=1",
                dataType: 'json',
                data: 'extend_id=' + $extend_id,
                method: "POST",
                success: function ($json) {
                    load_extend_fields();
                }
            });
        }
    }

    function change_field_type($extend_number){
        var $field_type = $('#field_type_'+$extend_number).val();
        if($field_type=='select' || $field_type=='multi_select'){
            $('#field_table_'+$extend_number).prop("disabled", false);
        }else{
            $('#field_table_'+$extend_number).val('');
            $('#field_table_'+$extend_number).prop("disabled", true);
        }
    }

    function show_field_table(){
        $('#modal_field_table').modal('toggle');
    }

    $(document).ready(function (){
        load_extend_fields();
    });
</script>

<div id="modal_field_table" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Nhóm dữ liệu mở rộng</h4>
            </div>
            <div class="modal-body">
                <table id="table_field_tables" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tên</th>
                            <th>Thứ tự</th>
                            <th>Kích hoạt</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer text-center">
                <a class="btn btn-success" href="javascript:void(0)" onclick="add_field_tables();">Thêm mới</a>
            </div>
        </div>
    </div>
</div>
<?php
$group_number = intval($this->model->get_auto_increment('fs_extends_groups'));
?>
<script type="text/javascript">
    var  $group_number = parseInt(<?php echo $group_number?>);

    function load_field_tables(){
        $.ajax({
            url: "index.php?module=ajax&view=ajax&task=load_field_tables&raw=1",
            dataType: 'html',
            method: "POST",
            success: function ($html) {
                $('#table_field_tables tbody').html($html);
            }
        });
    }

    function save_field_tables($obj, $extend_number){
        var $name = $('#ft_name_'+$extend_number).val();
        var $ordering = $('#ft_ordering_'+$extend_number).val();
        var $group_id = $('#ft_group_id_'+$extend_number).val();

        var $published = 0;
        if($('#ft_published_'+$extend_number).is(":checked"))
            $published = 1;

        $($obj).children('img').attr('src', 'templates/default/images/toolbar/process.gif');

        $.ajax({
            url: "index.php?module=ajax&view=ajax&task=save_field_tables&raw=1",
            dataType: 'json',
            data: 'name='+$name+'&ordering='+$ordering+'&published='+$published+'&group_id='+$group_id,
            method: "POST",
            success: function ($json) {
                load_field_tables();
            }
        });
    }

    function del_field_tables($extend_number){
        var $confirm = confirm("Bạn có chắc muốn xóa filed này?");
        if($confirm==true) {
            var $group_id = $('#ft_group_id_' + $extend_number).val();
            $.ajax({
                url: "index.php?module=ajax&view=ajax&task=del_field_tables&raw=1",
                dataType: 'json',
                data: 'group_id=' + $group_id,
                method: "POST",
                success: function ($json) {
                    load_field_tables();
                }
            });
        }
    }

    function add_field_tables(){
        $group_number++;

        $.ajax({
            url: "index.php?module=ajax&view=ajax&task=add_field_tables&raw=1",
            dataType: 'html',
            data: 'extend_number='+$group_number,
            method: "POST",
            success: function ($html) {
                $('#table_field_tables tbody').append($html);
            }
        });
    }

    $(document).ready(function (){
        load_field_tables();
    });
</script>

<!--<table id="table_filter_price" class="table table-bordered" style="background-color: #f5f5f5">-->
<!--    <thead>-->
<!--        <tr><th class="text-center" colspan="6">Bộ lọc giá</th></tr>-->
<!--        <tr>-->
<!--            <th>Tên</th>-->
<!--            <th>Alias</th>-->
<!--            <th>Min</th>-->
<!--            <th>Max</th>-->
<!--            <th>Thứ tự</th>-->
<!--            <th>Mục con</th>-->
<!--            <th></th>-->
<!--        </tr>-->
<!--    </thead>-->
<!--    <tbody>-->
<!---->
<!--    </tbody>-->
<!--    <tfoot>-->
<!--        <tr>-->
<!--            <td colspan="6" class="text-center">-->
<!--                <a class="btn btn-success" href="javascript:void(0)" onclick="add_filter_price();">Thêm mới</a>-->
<!--                <input type="hidden" id="price_category_id" name="price_category_id" value="--><?php //echo intval(@$data->id); ?><!--" />-->
<!--            </td>-->
<!--        </tr>-->
<!--    </tfoot>-->
<!--</table>-->

<?php
$price_number = intval($this->model->get_auto_increment('fs_products_filter_price'));
?>
<script type="text/javascript">
    var  $price_number = parseInt(<?php echo $price_number?>);

    function add_filter_price(){
        $price_number++;

        $.ajax({
            url: "index.php?module=ajax&view=ajax&task=add_filter_price&raw=1",
            dataType: 'html',
            data: 'extend_number='+$price_number,
            method: "POST",
            success: function ($html) {
                $('#table_filter_price tbody').append($html);
            }
        });
    }

    function save_filter_price($obj, $extend_number){
        var $title = $('#fp_title_'+$extend_number).val();
        var $min = $('#fp_min_'+$extend_number).val();
        var $max = $('#fp_max_'+$extend_number).val();
        var $ordering = $('#fp_ordering_'+$extend_number).val();
        var $price_category_id = $('#price_category_id').val();
        var $price_id = $('#fp_price_id_'+$extend_number).val();

        var $childs = 0;
        if($('#fp_childs_'+$extend_number).is(":checked"))
            $childs = 1;

        $($obj).children('img').attr('src', 'templates/default/images/toolbar/process.gif');

        $.ajax({
            url: "index.php?module=ajax&view=ajax&task=save_filter_price&raw=1",
            dataType: 'json',
            data: 'price_category_id='+$price_category_id+'&title='+$title+'&min='+$min+'&max='+$max+'&ordering='+$ordering+'&price_id='+$price_id+'&childs='+$childs,
            method: "POST",
            success: function ($json) {
                load_filter_price();
            }
        });
    }

    function load_filter_price(){
        var $price_category_id = $('#price_category_id').val();
        $.ajax({
            url: "index.php?module=ajax&view=ajax&task=load_filter_price&raw=1",
            dataType: 'html',
            data: 'price_category_id='+$price_category_id,
            method: "POST",
            success: function ($html) {
                $('#table_filter_price tbody').html($html);
            }
        });
    }

    function del_filter_price($extend_number){
        var $confirm = confirm("Bạn có chắc muốn xóa lọc giá này?");
        if($confirm==true) {
            var $extend_id = $('#fp_price_id_' + $extend_number).val();
            $.ajax({
                url: "index.php?module=ajax&view=ajax&task=del_filter_price&raw=1",
                dataType: 'json',
                data: 'extend_id=' + $extend_id,
                method: "POST",
                success: function ($json) {
                    load_filter_price();
                }
            });
        }
    }

    $(document).ready(function (){
        load_filter_price();
    });
</script>