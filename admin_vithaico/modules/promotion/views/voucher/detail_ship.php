<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
 
<?php
$title = 'Voucher Freeship (Áp dụng lên giá ship)';
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save_add', FSText:: _('Save and new'), '', 'save_add.png', 1);
$toolbar->addButton('apply', FSText:: _('Apply'), '', 'apply.png', 1);
$toolbar->addButton('Save', FSText:: _('Save'), '', 'save.png', 1);
$toolbar->addButton('back', FSText:: _('Cancel'), '', 'back.png');

echo '<div class="alert alert-danger" style="display:none" ><span id="msg_error"></span></div>';

$this->dt_form_begin(1, 4,'', 'fa-edit', 1, 'col-md-12', 1);

    $this->dt_form_begin(1, 2, FSText::_('Thông tin cơ bản'), '', 1, 'col-md-12 fl-left');
        TemplateHelper::dt_edit_text(FSText::_('Tên voucher'), 'title', @$data->title, '', '', '', '', '', '', 'col-md-2', 'col-md-10');
        TemplateHelper::datetimepicke(FSText::_('Thời gian nhận'), 'date_receive', @$data->date_receive ? @$data->date_receive : '', FSText::_('Bạn vui lòng chọn thời gian bắt đầu'), 20, '', 'col-md-2', 'col-md-3');
        TemplateHelper::datetimepicke(FSText::_('Áp dụng từ ngày'), 'date_start', @$data->date_start ? @$data->date_start : '', FSText::_('Bạn vui lòng chọn thời gian bắt đầu'), 20, '', 'col-md-2', 'col-md-3');
        TemplateHelper::datetimepicke(FSText::_('Đến ngày'), 'date_end', @$data->date_end ? @$data->date_end : '', FSText::_('Bạn vui lòng chọn thời gian kết thúc'), 20, '', 'col-md-2', 'col-md-3');
        TemplateHelper::dt_checkbox(FSText::_('Published'), 'published', @$data->published, 1, '', '', '', 'col-md-2', 'col-md-10');
        ?>
        <div class="form-group">
            <label for="" class="col-md-2 col-xs-12 control-label">
                Tiền giảm hoặc % giảm giá
            </label>
            <div class="col-md-10 col-xs-12">
                <div class="d-flex gap-2 align-items-center">
                    <div class="input-price d-flex">
                        <input class="form-control" name="price" type="text" placeholder="" value="<?php echo @$data->price ? format_money_0(@$data->price, '', '') : '' ?>" />
                    </div>
                    hoặc
                    <div class="input-percent d-flex">
                        <input class="form-control" name="percent" type="text" placeholder="" value="<?php echo !@$data->price ? @$data->percent : '' ?>" />
                    </div>
                </div>
            </div>
        </div>
        <?php
        TemplateHelper::dt_edit_text(FSText::_('Số tiền chi tối thiểu'), 'min_amount', format_money(@$data->min_amount, '₫', '0₫'), 0, '', '', '', '', '', 'col-md-2', 'col-md-3');
        TemplateHelper::dt_edit_text(FSText::_('Số lượng có thể nhận'), 'quantity', @$data->quantity, 1, '', '', '', '', '', 'col-md-2', 'col-md-3');
        TemplateHelper::dt_edit_text(FSText::_('Giới hạn nhận mỗi khách'), 'user_limit', @$data->user_limit, 1, '', '', '', '', '', 'col-md-2', 'col-md-3');
    $this->dt_form_end_col();

    $this->dt_form_begin(1, 2, FSText::_('Áp dụng cho sản phẩm'), 'fa-bolt', 1, 'col-md-12 fl-left');
    ?>
        <a href="" class="add-products" data-toggle="modal" data-target="#productsModal">Thêm các sản phẩm</a>
         
        <div class="table-contain">
            <table class="table table-hover table-record">
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Giá gốc</th> 
                        <th>Kho</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($detail)) { ?>
                        <?php foreach ($detail as $item) { ?>
                            <tr>
                                <td>
                                    <input name="product[]" type="hidden" value="<?php echo $item->product_id ?>" />
                                    <div class="d-flex gap-2">
                                        <img src="<?php echo URL_ROOT . str_replace(['/original/', '.png', '.jpg'], ['/resized/', '.webp', '.webp'], $item->image) ?>" alt="" class="img-fluid" />
                                        <div>
                                            <div><?php echo $item->name ?></div>
                                            <div><?php echo $item->code ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php echo format_money($item->origin_price) ?>
                                </td>
                                <td>
                                    <?php echo $item->quantity ?: 0 ?>
                                </td>
                                <td>
                                    <?php 
                                    switch ($item->status_prd) {
                                        case 1:
                                            echo 'Sắp ra mắt';
                                            break;
                                        case 2:
                                            echo 'Nhận đặt trước';
                                            break;
                                        case 3:
                                            echo 'Đang kinh doanh';
                                            break;
                                        case 4:
                                            echo 'Ngừng kinh doanh';
                                            break;
                                        default:
                                            echo 'Đang kinh doanh';
                                            break;
                                    }
                                    ?>
                                </td>                  
                                <td>
                                    <a href="" class="delete-product" data-id="<?php echo $item->product_id ?>">Xóa</a>
                                </td>
                            </tr>
                        <?php } ?>    
                    <?php } ?>    
                </tbody>
            </table>
        </div>
    <?php 
    $this->dt_form_end_col();

    $this->dt_form_begin(1, 2, FSText::_('Áp dụng cho Khách hàng'), 'fa-user', 1, 'col-md-12 fl-left');
    ?>
        <a href="" class="add-user" data-toggle="modal" data-target="#userModal">Thêm Khách hàng</a>

        <div class="table-user">
            <table class="table table-hover table-record">
                <thead>
                    <tr>
                        <th>Tên KH</th>
                        <th>Email</th> 
                        <th>Số điện thoại</th>
                        <th>Điểm tích lũy</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($detail)) { ?>
                        <?php foreach ($detail as $item) { ?>
                            <tr>
                                <td>
                                    <input name="product[]" type="hidden" value="<?php echo $item->product_id ?>" />
                                    <div class="d-flex gap-2">
                                        <img src="<?php echo URL_ROOT . str_replace(['/original/', '.png', '.jpg'], ['/resized/', '.webp', '.webp'], $item->image) ?>" alt="" class="img-fluid" />
                                        <div>
                                            <div><?php echo $item->name ?></div>
                                            <div><?php echo $item->code ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php echo format_money($item->origin_price) ?>
                                </td>
                                <td>
                                    <?php echo $item->quantity ?: 0 ?>
                                </td>
                                <td>
                                    <?php 
                                    switch ($item->status_prd) {
                                        case 1:
                                            echo 'Sắp ra mắt';
                                            break;
                                        case 2:
                                            echo 'Nhận đặt trước';
                                            break;
                                        case 3:
                                            echo 'Đang kinh doanh';
                                            break;
                                        case 4:
                                            echo 'Ngừng kinh doanh';
                                            break;
                                        default:
                                            echo 'Đang kinh doanh';
                                            break;
                                    }
                                    ?>
                                </td>                  
                                <td>
                                    <a href="" class="delete-product" data-id="<?php echo $item->product_id ?>">Xóa</a>
                                </td>
                            </tr>
                        <?php } ?>    
                    <?php } ?>    
                </tbody>
            </table>
        </div>
    <?php 
    $this->dt_form_end_col();

$this->dt_form_end(@$data,1);
?>

<div class="modal fade modal-search" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content"> 
            <div class="modal-body"> 
                <div class="d-flex flex-wrap gap-2" style="margin-bottom: 16px;"> 
                    <input type="text" class="form-control keyword" name="keyword" placeholder="Tìm kiếm" required="" autocomplete="off">
                    <button class="btn btn-default fw-semibold search-btn" type="submit">Tìm kiếm</button>
                </div>
                
                <div class="table-container">
                    <table class="table table-hover table-result">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" class="search-check-all">
                                </th>
                                <th>Tên Khách hàng</th>
                                <th>Số điện thoại</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td colspan="4" class="text-center">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between gap-2 flex-wrap">
                    <div class="search-total">
                        Đã chọn 0
                    </div>
                    <div>
                        <button class="search-cancel">Hủy</button>
                        <button class="disabled search-add">Thêm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-search" id="productsModal" tabindex="-1" role="dialog" aria-labelledby="productsModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content"> 
            <div class="modal-body"> 
                <div class="d-flex flex-wrap gap-2" style="margin-bottom: 16px;">
                    <select name="cat" id="cat" class="select2-cat">
                        <option value="0">Danh mục sản phẩm</option>
                        <?php foreach ($categories as $item) {?>
                            <option value="<?php echo $item->id ?>"><?php echo $item->treename ?></option>
                        <?php } ?>    
                    </select>
                    <input type="text" class="form-control keyword" name="keyword" placeholder="Tìm kiếm" required="" autocomplete="off">
                    <button class="btn btn-default fw-semibold search-btn" type="submit">Tìm kiếm</button>
                </div>
                
                <div class="table-container">
                    <table class="table table-hover table-result">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" class="search-check-all">
                                </th>
                                <th>Tên sản phẩm</th>
                                <th>Giá gốc</th>
                                <th>Kho</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td colspan="4" class="text-center">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between gap-2 flex-wrap">
                    <div class="search-total">
                        Đã chọn 0
                    </div>
                    <div>
                        <button class="search-cancel">Hủy</button>
                        <button class="disabled search-add">Thêm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .add-products, .add-user{
        display: inline-block;
        border-radius: 4px;
        padding: 8px 20px;
        background: #aeaeae;
        font-weight: bold;
        text-decoration: none !important;
        color: #000 !important;
    }
    button{
        outline: none !important;
    }
    .d-flex{
        display: flex;
    }
    .mb-2{
        margin-bottom: 0.5rem;
    }
    .gap-2{
        gap: 0.5rem;
    }
    .align-items-center{
        align-items: center;
    }
    .justify-content-between{
        justify-content: space-between;
    }
    .img-fluid{
        max-width: 100%;
        height: auto;
    } 
    #productsModal .modal-dialog, #userModal .modal-dialog{
        margin: 60px auto;
        width: 900px;
    }
    .table-record img{
        width: 40px;
        height: 40px;
        object-fit: contain;
    }
    .table-record th{
        text-wrap: nowrap;
    }
    .table-record td{
        vertical-align: middle !important;
    }
    .table-record td:nth-child(1){
        width: 30%;
    }
    .table-record input.form-control{
        width: 120px;
    }
    a:hover{
        text-decoration: none !important;
        color: #000 !important;
    } 
    .input-price, .input-percent{
        position: relative;
        align-items: center;
    }
    .input-price::before{
        content: 'đ';
        right: 10px;
        position: absolute;
    }
    .input-percent::before{
        content: '% giảm';
        right: 10px;
        position: absolute;
    } 
    .table-container{
        max-height: calc(100vh - 300px);
        overflow: auto;
        margin-bottom: 16px;
    }
    .table-container thead{
        position: sticky;
        top: 0;
        z-index: 1;
        background: #fff;
    }
    .table-container td, .table-container th {
        vertical-align: middle !important;
    }
    input[type=checkbox]{
        margin: 0;
        cursor: pointer;
        width: 16px;
        height: 16px;
    }
    .disabled{
        opacity: 0.5;
        pointer-events: none;
    }
    tr.checked{
        opacity: 0.6;
        background: #ccc;
    }
    input[type=number]{
        width: 100px;
    } 
    #productsModal .select2, #userModal .select2{
        width: 200px !important;
    }
    .select2 .select2-selection{
        height: 34px;
    }
    .select2 .select2-selection .select2-selection__rendered{
        line-height: 34px;
    }
    .select2 .select2-selection .select2-selection__arrow{
        height: 32px;
    }
</style>

<script type="text/javascript">
    // modal search-add products
    let productId = [<?php echo !empty($exist) ? implode(', ', $exist) : ''?>];
    
    $('.select2-cat').select2({
        dropdownParent: $("#productsModal")
    })
    
    $('.search-check-all').change(function(){
        if ($(this).is(':checked')) {
            $(this).closest(".modal-search").find("table tbody input[type=checkbox]").prop('checked', true)
        } else {
            $(this).closest(".modal-search").find("table tbody input[type=checkbox]").prop('checked', false)
        }

        searchCheck($(this).closest(".modal-search").attr('id'))
    })

    $(document).on('change', ".modal-search input[type=checkbox]", function(){
        searchCheck($(this).closest(".modal-search").attr('id'))
    })

    function searchCheck(element){
        if ($("#"+element+" table tbody input[type=checkbox]:checked").length) {
            $("#"+element+" .search-add").removeClass('disabled')
        } else {
            $(""+element+" .search-add").addClass('disabled')
        }

        $("#"+element+" .search-total").html('Đã chọn ' + $("#"+element+" table tbody input[type=checkbox]:checked").length)
    }

    $('.search-cancel').click(function(){
        $('.search-add').addClass('disabled')
        $(".modal-search table tbody input[type=checkbox]").prop('checked', false)
        $(".search-check-all").prop('checked', false)
        $('.modal-search table tbody').empty()
        $(".modal-search").modal('hide');
    })

    $('.search-add').click(function(){
        let html;
        let modal = $('.modal-search.in')
        let modalId = modal.attr('id')

        if (modalId == 'productsModal') {
            let totalCurrent = $('.table-record tbody tr').length 

            $(this).closest('.modal-search').find("table tbody input[type=checkbox]:checked").each(function(i, item){
                let data = JSON.parse($(this).attr('data'))
                if (!productId.includes(parseInt(data.id)) && totalCurrent < 100) { 
                    let quantitOption = ``;
                    if (data.quantity) {
                        for (let i = 1; i <= data.quantity; i++) {
                            quantitOption += `<option value="${i}">${i}</option>`
                        }
                    }

                    html += `
                        <tr>
                            <td>
                                <input name="product[]" type="hidden" value="${data.id}" />
                                <div class="d-flex gap-2">
                                    <img src="${data.image}" alt="" class="img-fluid" />
                                    <div>
                                        <div>${data.name}</div>
                                        <div>${data.code}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                ${data.price}
                            </td>
                            <td>
                                ${data.quantity ? data.quantity : 0}
                            </td>
                            <td>
                                ${statusText(data.status_prd)}
                            </td>                  
                            <td>
                                <a href="" class="delete-product" data-id="${data.id}">Xóa</a>
                            </td>
                        </tr>
                    `
                    productId.push(parseInt(data.id));
                    totalCurrent ++;
                }
            })
        }

        if (modalId == 'userModal') {
            
        }

        $('.table-record tbody').append(html)
        $('.modal-search table tbody').empty()
        $('.modal-search').modal('hide') 
        $('.select2-temp').select2()
    })

    $('.search-btn').click(function(){
        searchModal()
    })

    $('.modal-search').on('shown.bs.modal', function (e) {
        searchModal()
    })

    function searchModal(limit = 0){
        let modal = $('.modal-search.in')
        let modalId = modal.attr('id')

        let cat = $('#cat').val()
        let keyword = modal.find('.keyword').val()

        $('.modal-search table tbody').empty().append('<tr><td colspan="4" class="text-center">Loading...</td></tr>')

        if (modalId == 'productsModal') {
            $.ajax({
                url: "index2.php?module=<?php echo $this->module ?>&view=<?php echo $this->view ?>&raw=1&task=getAjaxSearchProduct",
                type: 'POST',
                data: { cat, keyword, limit },
                dataType: 'JSON',
                success: function (result) {
                    let html;
                    
                    result.forEach(function(item){
                        let checked = '';
                        if (productId.includes(parseInt(item.id))) {
                            checked = 'checked';
                        }
                        html += `
                            <tr class="${checked}">
                                <td>
                                    <input type="checkbox" class="search-check" ${checked} value="${item.id}" data='${JSON.stringify(item)}'/>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <img width="40" height="40" src="${item.image}" class="img-fluid" />
                                        <div>
                                            <div style="margin-bottom: 4px;">${item.name}</div>
                                            <div>${item.code}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    ${item.price}
                                </td>
                                <td>
                                    ${item.quantity}
                                </td>
                            </tr>
                        `
                    })

                    $('.modal-search table tbody').empty().append(html)
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    let message = 'Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.'
                    $('.modal-search table tbody').empty().append('<tr><td colspan="4" class="text-center">' + message + '</td></tr>')
                    return false;
                }
            });  
        }

        if (modalId == 'userModal') {
            $.ajax({
                url: "index2.php?module=<?php echo $this->module ?>&view=<?php echo $this->view ?>&raw=1&task=getAjaxSearchMembers",
                type: 'POST',
                data: { keyword, limit },
                dataType: 'JSON',
                success: function (result) {
                    let html;
                    
                    result.forEach(function(item){
                        let checked = '';
                        if (productId.includes(parseInt(item.id))) {
                            checked = 'checked';
                        }
                        html += `
                            <tr class="${checked}">
                                <td>
                                    <input type="checkbox" class="search-check" ${checked} value="${item.id}" data='${JSON.stringify(item)}'/>
                                </td>
                                <td>
                                    ${item.full_name}
                                </td>
                                <td>
                                    ${item.telephone}
                                </td>
                                <td>
                                    ${item.email}
                                </td>
                            </tr>
                        `
                    })

                    $('.modal-search table tbody').empty().append(html)
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    let message = 'Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.'
                    $('.modal-search table tbody').empty().append('<tr><td colspan="4" class="text-center">' + message + '</td></tr>')
                    return false;
                }
            });
        }
    } 

    function statusText(status) {
        let text = '';
        switch (status) {
            case 1:
                text = 'Sắp ra mắt';
                break;
            case 2:
                text = 'Nhận đặt trước';
                break;
            case 3:
                text = 'Đang kinh doanh';
                break;
            case 4:
                text = 'Ngừng kinh doanh';
                break;
            default:
                text = 'Đang kinh doanh';
                break;
        }

        return text
    }

    $('.add-products').click(function() {
        if($('.table-record tbody tr').length >= 100) {
            alert('Tối đa 100 sản phẩm');
            return false;
        }
    })

    $(document).on('click', '.delete-product', function(e){
        e.preventDefault()
        let id = parseInt($(this).attr('data-id'))
        $(this).closest('tr').remove()

        let index = productId.indexOf(id);
    
        if (index !== -1) {
            productId.splice(index, 1);
        }
    })



    $('.form-horizontal').keypress(function (e) {
        if (e.which == 13) {
            formValidator();
            return false;
        }
    });

    function formValidator() {
        $('.alert-danger').show();

        if (!notEmpty('title', 'Vui lòng nhập tiêu đề')) {
            return false;
        }

        if (!$('.table-record tbody tr').length) {
            alert ('Bạn chưa chọn sản phẩm');
            $('#msg_error').text('Bạn chưa chọn sản phẩm')
            return false
        }
    
        $('.alert-danger').hide();
        return true;
    }
</script>