<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
 
<?php
$title = 'Quà tặng khi mua hàng';
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save_add', FSText:: _('Save and new'), '', 'save_add.png', 1);
$toolbar->addButton('apply', FSText:: _('Apply'), '', 'apply.png', 1);
$toolbar->addButton('Save', FSText:: _('Save'), '', 'save.png', 1);
$toolbar->addButton('back', FSText:: _('Cancel'), '', 'back.png');

echo '<div class="alert alert-danger" style="display:none" ><span id="msg_error"></span></div>';

$this->dt_form_begin(1, 4,'', 'fa-edit', 1, 'col-md-12', 1);

    $this->dt_form_begin(1, 2, FSText::_('Thông tin cơ bản'), '', 1, 'col-md-12 fl-left');
        TemplateHelper::dt_edit_text(FSText::_('Tên khuyến mãi'), 'title', @$data->title, '', '', '', '', '', '', 'col-md-2', 'col-md-10');
        TemplateHelper::datetimepicke(FSText::_('Ngày bắt đầu'), 'date_start', @$data->date_start ? @$data->date_start : '', FSText::_('Bạn vui lòng chọn thời gian bắt đầu'), 20, '', 'col-md-2', 'col-md-4');
        TemplateHelper::datetimepicke(FSText::_('Ngày kết thúc'), 'date_end', @$data->date_end ? @$data->date_end : '', FSText::_('Bạn vui lòng chọn thời gian kết thúc'), 20, '', 'col-md-2', 'col-md-4');
        TemplateHelper::dt_checkbox(FSText::_('Published'), 'published', @$data->published, 1, '', '', '', 'col-md-2', 'col-md-10');
        TemplateHelper::dt_checkbox(FSText::_('Chương trình KM này được giới hạn với số lượng chỉ một cho mỗi khách hàng'), 'limit', @$data->limit, 0, '', '', '', 'left col-md-5', 'col-md-7');
        // TemplateHelper::dt_checkbox(FSText::_('Loại chương trình'), 'type', @$data->type, 0, ['Chiết khấu', 'Flashsale'], '', '', 'col-md-2', 'col-md-10',);
    $this->dt_form_end_col();  

    $this->dt_form_begin(1, 2, FSText::_('Mặt hàng chính'), 'fa-bolt', 1, 'col-md-12 fl-left');
    ?>
        <div class="row">
            <div class="col-md-12">
                <p>Thêm tối đa 100 mặt hàng chính từ cửa hàng của bạn vào chương trình khuyến mãi này.</p>
                <p>Lưu ý thêm sản phẩm, khi lưu có thể bị loại bỏ do nằm trong chương trình khác trùng thời gian KM.</p>
                <a href="" class="add-products" data-toggle="modal" data-target="#productsModal">Thêm các mặt hàng chính</a>
            </div> 
        </div>

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
                    <?php if (!empty($products)) { ?>
                        <?php foreach ($products as $item) { ?>
                            <tr>
                                <td>
                                    <input name="product_id[]" type="hidden" value="<?php echo $item->id ?>" />
                                    <input name="product_name[]" type="hidden" value="<?php echo $item->name ?>" />
                                    <div class="d-flex gap-2">
                                        <img width="40" height="40" src="<?php echo URL_ROOT . str_replace(['/original/', '.png', '.jpg'], ['/resized/', '.webp', '.webp'], $item->image) ?>" alt="" class="img-fluid" />
                                        <div>
                                            <div><?php echo $item->name ?></div>
                                            <div><?php echo $item->code ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php echo format_money($item->price) ?>
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
                                    <a href="" class="delete-product" data-id="<?php echo $item->id ?>">Xóa</a>
                                </td>
                            </tr>
                        <?php } ?>    
                    <?php } ?>    
                </tbody>
            </table>
        </div>
    <?php
    $this->dt_form_end_col();

    $this->dt_form_begin(1, 2, FSText::_('Cài đặt quà tặng'), 'fa-bolt', 1, 'col-md-12 fl-left');
    ?>
        <div class="row">
            <div class="col-md-12">
                <p>Khách hàng không thể chọn được hàng tặng. Khách hàng sẽ nhận được tất cả hàng được tặng nếu đạt được đến ngưỡng mua của đơn hàng.</p> 
            </div> 
        </div>
        <div class="gift-container mb-4">
            <?php if (!empty($gift)) { ?>
                <?php foreach ($gift as  $i => $item) { ?>
                    <div class="gift-item mb-4 gift-level-<?php echo $i ?>" id="gift-level-<?php echo $i ?>">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <b>Bậc <?php echo $i + 1 ?></b>
                            <?php if ($i) { ?>
                                <a href="" class="delete-gift">Xóa</a>
                            <?php } ?>    
                        </div>
                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                Nhận ngay 1 bộ quà tặng khi đạt số mặt hàng chính trong 1 đơn hàng
                                <input type="number" class="form-control" name="quantity[]" placeholder="Nhập số" min="0" value="<?php echo $item->quantity ?>">
                                <input type="hidden" class="gift_id" name="gift_id[]" value="<?php echo $item->gift ?>">
                            </div>
                            <a href="" class="add-gift" data-toggle="modal" data-target="#productsModal">
                                Thêm quà tặng
                            </a>
                        </div>
                        <div class="table-contain">
                            <table class="table table-hover">
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
                                    <?php if (!empty($item->giftInfo)) { ?>
                                        <?php foreach ($item->giftInfo as $info) { ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <img width="40" height="40" src="<?php echo URL_ROOT . str_replace(['/original/', '.png', '.jpg'], ['/resized/', '.webp', '.webp'], @$info->image) ?>" alt="" class="img-fluid" />
                                                        <div>
                                                            <div><?php echo @$info->name ?></div>
                                                            <div><?php echo @$info->code ?></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php echo format_money(@$info->price) ?>
                                                </td>
                                                <td>
                                                    <?php echo @$info->quantity ?: 0 ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    switch (@$info->status_prd) {
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
                                                    <a href="" class="delete-gift-item" data-id="<?php echo @$info->id ?>">Xóa</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>    
            <?php } else { ?>    
                <div class="gift-item mb-4 gift-level-0" id="gift-level-0">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <b>Bậc 1</b>
                    </div>
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            Nhận ngay 1 bộ quà tặng khi đạt số mặt hàng chính trong 1 đơn hàng
                            <input type="number" class="form-control" name="quantity[]" placeholder="Nhập số" min="0">
                            <input type="hidden" class="gift_id" name="gift_id[]" value="">
                        </div>
                        <a href="" class="add-gift" data-toggle="modal" data-target="#productsModal">
                            Thêm quà tặng
                        </a>
                    </div>
                    <div class="table-contain">
                        <table class="table table-hover">
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

                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <a href="javascript:void(0)" class="btn btn-default add-gift-level">
                <i class="fa fa-plus" aria-hidden="true"></i>
                Thêm bậc
            </a>
            Ngưỡng đơn hàng tối thiểu phải cao hơn bậc 1
        </div>
    <?php 
    $this->dt_form_end_col();

$this->dt_form_end(@$data,1);
?>

<div class="modal fade" id="productsModal" tabindex="-1" role="dialog" aria-labelledby="productsModalLabel">
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
                    <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Tìm kiếm" required="" autocomplete="off">
                    <button class="btn btn-default fw-semibold" type="submit" id="search-btn">Tìm kiếm</button>
                </div>
                
                <div class="table-container">
                    <table class="table table-hover table-result">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="search-check-all">
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
                    <div id="search-total">
                        Đã chọn 0
                    </div>
                    <div>
                        <button id="search-cancel" data-dismiss="modal">Hủy</button>
                        <button class="disabled" id="search-add">Thêm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .add-products, .add-gift{
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
    .mb-3{
        margin-bottom: 1rem;
    }
    .mb-4{
        margin-bottom: 1.5rem;
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
    .autocomplete-suggestions{
        width: 480px !important;
    }
    #productsModal .modal-dialog{
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
    .added{
        opacity: 0.5;
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
    #productsModal .select2{
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
    .gift-item{
        padding: 10px;
        border-radius: 8px;
        background: #fff;
    }
</style>

<script type="text/javascript">
    let productId = [<?php echo !empty($exist) ? implode(',', $exist) : '' ?>]; 
    let searchGift = '';
    let productGift = [];

    $('.select2-cat').select2({
        dropdownParent: $("#productsModal")
    })

    $('#search-check-all').change(function(){
        if ($(this).is(':checked')) {
            $("#productsModal table tbody input[type=checkbox]").prop('checked', true)
        } else {
            $("#productsModal table tbody input[type=checkbox]").prop('checked', false)
        }

        searchCheck()
    })

    $(document).on('change', "#productsModal table tbody input[type=checkbox]", function(){
        searchCheck()
    })

    function searchCheck(){
        if ($("#productsModal table tbody input[type=checkbox]:checked").length) {
            $('#search-add').removeClass('disabled')
        } else {
            $('#search-add').addClass('disabled')
        }

        $('#search-total').html('Đã chọn ' + $("#productsModal table tbody input[type=checkbox]:checked").length)
    }

    $('#search-add').click(function(){
        let html;
        let totalCurrent = $('.table-record tbody tr').length

        $("#productsModal table tbody input[type=checkbox]:checked").each(function(i, item){
            let data = JSON.parse($(this).attr('data'))
             
            if (searchGift) {
                if (!productGift.includes(data.id)) {
                    html += `
                        <tr>
                            <td>
                                <div class="d-flex gap-2">
                                    <img width="40" height="40" src="${data.image}" alt="" class="img-fluid" />
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
                                ${data.quantity}
                            </td>
                            <td>
                                ${statusText(data.status_prd)}
                            </td>
                            <td>
                                <a href="" class="delete-gift-item" data-id="${data.id}">Xóa</a>
                            </td>
                        </tr>
                    ` 
                    productGift.push(data.id)
                }
            } else {
                if (!productId.includes(parseInt(data.id)) && totalCurrent < 100) {
                    html += `
                        <tr>
                            <td>
                                <input name="product_id[]" type="hidden" value="${data.id}" />
                                <input name="product_name[]" type="hidden" value="${data.name}" />
                                <div class="d-flex gap-2">
                                    <img width="40" height="40" src="${data.image}" alt="" class="img-fluid" />
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
                                ${data.quantity}
                            </td>
                            <td>
                                ${statusText(data.status_prd)}
                            </td>
                            <td>
                                <a href="" class="delete-product" data-id="${data.id}">Xóa</a>
                            </td>
                        </tr>
                    `
                    productId.push(parseInt(data.id))
                }
            }
        })

        if (searchGift) {
            $('#'+searchGift+' table tbody').append(html)
            $('#'+searchGift+' .gift_id').val(productGift.join(','))
        } else {            
            $('.table-record tbody').append(html)
        }        

        $('#productsModal table tbody').empty()
        $('#productsModal').modal('hide')
        $('.select2-temp').select2()
    })

    $(document).on('click', '.add-gift', function(){
        searchGift = $(this).closest('.gift-item').attr('id')
        let productItem = $(this).closest('.gift-item').find('.gift_id').val()
        productGift = productItem != '' ? productItem.split(',') : []
    })

    $('#search-btn').click(function(){
        searchModal()
    })

    $('#productsModal').on('shown.bs.modal', function (e) {
        searchModal()
    })

    $('#productsModal').on('hide.bs.modal', function (e) {
        searchGift = ''
        productGift = []
        $('#search-add').addClass('disabled')
        $("#productsModal table tbody input[type=checkbox]").prop('checked', false)
        $("#search-check-all").prop('checked', false)
        $('#productsModal table tbody').empty()
    })

    function searchModal(){
        let cat = $('#cat').val()
        let keyword = $('#keyword').val()
        $('#productsModal table tbody').empty().append('<tr><td colspan="4" class="text-center">Loading...</td></tr>')
        $.ajax({
            url: "index2.php?module=<?php echo $this->module ?>&view=<?php echo $this->view ?>&raw=1&task=getAjaxSearchProduct",
            type: 'POST',
            data: { cat, keyword },
            dataType: 'JSON',
            success: function (result) {
                let html;
               
                result.forEach(function(item){
                    let checked = '';

                    if (searchGift) {
                        if (productGift.includes(item.id)) {
                            checked = 'checked';
                        }
                    } else {
                        if (productId.includes(parseInt(item.id))) {
                            checked = 'checked';
                        }
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

                $('#productsModal table tbody').empty().append(html)
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                let message = 'Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.'
                $('#productsModal table tbody').empty().append('<tr><td colspan="4" class="text-center">' + message + '</td></tr>')
                return false;
            }
        });  
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

        console.log(productId)
    })

    $(document).on('click', '.delete-gift', function(e){
        e.preventDefault()
        $(this).closest('.gift-item').remove();
    })

    $('.add-gift-level').click(function(e){
        e.preventDefault()
        // alert('Tính năng đang trong quá trình hoàn thiện!')
        // return false

        let total = $('.gift-item').length
        $('.gift-container').append(`
            <div class="gift-item mb-4 gift-level-${total}" id="gift-level-${total}">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <b>Bậc ${total + 1}</b>
                    <a href="" class="delete-gift">Xóa</a>
                </div>
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        Nhận ngay 1 bộ quà tặng khi đạt số mặt hàng chính trong 1 đơn hàng
                        <input type="number" class="form-control" name="quantity[]" placeholder="Nhập số" min="0">
                        <input type="hidden" class="gift_id" name="gift_id[]" value="">
                    </div>
                    <a href="" class="add-gift" data-toggle="modal" data-target="#productsModal">
                        Thêm quà tặng
                    </a>
                </div>
                <div class="table-contain">
                    <table class="table table-hover">
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

                        </tbody>
                    </table>
                </div>
            </div>
        `)
    })

    $(document).on('click', '.delete-gift-item', function(e){
        e.preventDefault()
        let id = $(this).attr('data-id')

        let productItem = $(this).closest('.gift-item').find('.gift_id').val()
        let productCurrent = productItem != '' ? productItem.split(',') : []
      
        let index = productCurrent.indexOf(id);

        if (index !== -1) {
            productCurrent.splice(index, 1);
        }

        console.log(productCurrent)

        $(this).closest('.gift-item').find('.gift_id').val(productCurrent.join(','))

        $(this).closest('tr').remove() 
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