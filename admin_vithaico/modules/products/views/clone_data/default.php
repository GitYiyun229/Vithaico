<!-- HEAD -->
<?php

global $toolbar;

$title = 'Get dữ liệu tự động';
$toolbar->setTitle($title);

$dataProducts = isset($data['products']) ? $data['products'] : [];
$pagination = 30;

?>
<style>
    .btnGetData {
        color: #fff !important;
        text-decoration: none !important;
    }
</style>
<div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-cog"></i> Chi tiết</div>
    <div class="panel-body">
        <form role="form" action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>"
              method="POST" name="adminForm">
            <input type="hidden" name="task" value="check_data">
            <div class="col-md-12" style="margin-bottom: 15px">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="url" value="<?php echo isset($data['url']) ? $data['url'] : '' ?>" placeholder="Nhập URL bạn muốn lấy dữ liệu" class="form-control txt_url">
                        <small>VD: https://www.mykingdom.com.vn/danh-muc/phuong-tien-giao-thong/xe-cong-trinh.html</small>
                    </div>
                    <a class="btn btn-success col-md-1 col-sm-2 btnGetData" href="index.php?module=<?php echo $this->module;?>&view=<?php echo $this -> view;?>&url=<?php echo isset($data['url']) ? $data['url'] : '' ?>"">
                        <i class="fa fa-download"></i> Get dữ liệu
                    </a>
                </div>
            </div>
            <div class="col-md-12">
                <?php include('detail_specs.php') ?>
            </div>
            <div class="col-md-12">
                <?php echo $pagination; ?>
            </div>
            <div class="col-sm-12 col-xs-12">
                <table class="table table-bordered table-striped table-responsive table-hover">
                    <thead>
                    <tr>
                        <th width="3%" class="text-center">STT</th>
                        <th width="3%" class="text-center" rowspan="1" colspan="1">
                            <input class="checkbox-custom" id="checkAll_box" type="checkbox" onclick="checkAll(864)"
                                   value="" name="toggle">
                            <label for="checkAll_box" class="checkbox-custom-label"></label>
                        </th>
                        <th width="20%" class="text-center">Tên sản phẩm</th>
                        <th width="10%" class="text-center">Ảnh</th>
                        <th width="7%" class="text-center">Mã</th>
                        <th width="7%" class="text-center">Giá</th>
                        <th width="10%" class="text-center">Chuyên mục</th>
                        <th width="5%" class="text-center">Đã import?</th>
                        <th width="10%" class="text-center">Lưu ý</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($dataProducts as $k => $row) { ?>
                        <tr>
                            <td class="text-center"><?php echo($k + 1) ?></td>
                            <td class="text-center">
                                <input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);"
                                       value="<?php echo $row['link'] ?>" name="product_links[<?php echo $k ?>]"
                                       id="cb<?php echo($k + 1) ?>">
                                <label for="cb<?php echo($k + 1) ?>" class="checkbox-custom-label"></label>
                            </td>
                            <td>
                                <a href="<?php echo $row['link'] ?>" style="color: green" target="_blank">
                                    <h5 style="margin: 2px;"><strong><?php echo $row['title'] ?></strong></h5>
                                </a>
                                <a href="<?php echo $row['link'] ?>" style="color: dodgerblue" target="_blank"><?php echo $row['link'] ?></a>
                            </td>
                            <td class="text-center" style="background: #fff"><img src="<?php echo $row['image'] ?>" width="140px"
                                                         alt="<?php echo $row['title'] ?>"></td>
                            <td><span style="color: navy"><?php echo $row['sku_origin'] ?></span></td>
                            <td class="text-center">
                                <?php if ($row['price_sale']) { ?>
                                    <span><small><?php echo $row['price_sale'] ?></small></span>
                                    <br>
                                    <span style="color: red"><strong><?php echo $row['sale'] ?></strong></span>
                                    <br>
                                <?php } ?>
                                <strong style="color: #40aa48"><?php echo $row['price'] ?></strong>
                            </td>
                            <td>
                                <select name="categories[]" id="" class="form-control chosen-select chosen-select-deselect">
                                    <option value="">-- Chọn chuyên mục --</option>
                                    <?php foreach($data['categories'] as $item){ ?>
                                        <option value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
                                    <?php } ?>
                                </select>
<!--                                <div style="margin-top: 5px">-->
<!--                                    <input type="text"  class="form-control" name="categories_not_exists[]" placeholder="Chuyên mục chưa tồn tại?">-->
<!--                                </div>-->
                            </td>
                            <td class="text-center">
                                <?php if ($row['exists']) { ?>
                                    <img border="0" alt="Enabled status" src="templates/default/images/published.png">
                                    <br>
                                    <?php $link = FSRoute::_('index.php?module=products&view=product&ccode=' . $row['p_category_alias'] . '&code=' . $row['p_alias'] . '&id=' . $row['p_id']); ?>
                                    <?php $linkBE = FSRoute::_('admin_lovevn/index.php?module=products&view=products&task=edit&id='.$row['p_id']) ?>
                                    <a href="<?php echo $link; ?>" title="<?php echo $row['title']?>" target="_blank" style="color: #0e7ccd">Xem <i class="fa fa-external-link"></i></a>
                                    <br>
                                    <a href="<?php echo $linkBE; ?>" title="<?php echo $row['title']?>" target="_blank" style="color: #0e7ccd">Edit <i class="fa fa-external-link"></i></a>
                                <?php } ?>
                            </td>
                            <td class="text-center"><span style="color: red"><?php echo $row['available'] ?></span></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 text-center">
                <button class="btn btn-success" type="submit"><i class="fa fa-database"></i> Import vào Cơ sở dữ liệu</button>
            </div>
            <div class="col-md-12">
                <?php echo $pagination ?>
            </div>
        </form>
    </div>
</div>

<script>
    $(function (){
         $('.txt_url').change(function (){
             var valUrl = $(this).val();
            $('.btnGetData').attr('href', 'index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>&url=' + valUrl);
         });
    });
</script>

