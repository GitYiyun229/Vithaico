<?php 
    $array_status_item = array(
                            1=>FSText::_('Chưa sử dụng'),
                            2=>FSText::_('Đang sử dụng'),
                            3=>FSText::_('Đã sử dụng hết'),
                            4=>FSText::_('Đã hết hạn'),
                        );
?>
<style>
    .title-gia {
        font-weight: bold;
    }
    .total-gia {
        margin-left: 20px;
        font-weight: bold;
        color: #e83e28;
        font-size: 18px;
    }
    .total-gia strong {
        display: inline-block;
    }
</style>
    <div class="col-md-8 col-xs-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <i class="fa fa-edit"></i>
                <?php echo FSText::_('Chi tiết đơn hàng').' '.$order->code ?> 
            </div><!-- END: panel-heading -->   
            <div class="panel-body">
                <div class="form-group">
                    <div class="table-responsive col-xs-12">
                        <table class="table table-bordered table-hover"> 
                            <thead> 
                                <tr> 
                                    <th><?php echo FSText::_('STT'); ?></th> 
                                    <th><?php echo FSText::_('Tên dịch vụ'); ?></th> 
                                    <th><?php echo FSText::_('Số lượng'); ?></th> 
                                    <th><?php echo FSText::_('Tiết kiểm'); ?></th> 
                                    <th><?php echo FSText::_('Giá'); ?></th> 
                                    <th><?php echo FSText::_('VAT(%)'); ?></th> 
                                    <th><?php echo FSText::_('Tổng cộng'); ?></th>
                                    <th><?php echo FSText::_('Trạng thái'); ?></th>  
                                    <th><?php echo FSText::_('SL còn lại'); ?></th> 
                                </tr> 
                            </thead> 
                            <tbody> 
                                <?php //if(count($order_item)){ ?>
                                <?php $i = 1; //foreach($order_item as $item){ ?>
                                <tr> 
                                    <th scope="row"><?php echo $i; ?></th> 
                                    <td><?php echo FSText::_('Tìm kiếm thông tin thí sinh') ?></td> 
                                    <td><?php echo $order->quantity ?></td> 
                                    <td><?php echo $order->discount ?></td> 
                                    <td><?php echo format_money($order->total_,'','0') ?></td> 
                                    <td><?php echo format_money($order->total_vat,'','0') ?></td> 
                                    <td><?php echo format_money($order->total_rs,'','0') ?></td> 
                                    <td><?php echo $array_status_item[$order->status_use] ?></td>
                                    <td><?php echo $order->quantity_used ?></td> 
                                </tr>
                                <?php //$i++; } ?>
                                <?php //} ?>
                            </tbody>
                        </table>    
                    </div>
                    <p class="item-name title-center" style="text-align: center;">
                        <span class="title-gia">
                            <?php echo FSText::_('Tổng giá trị (+VAT) của Đơn hàng dịch vụ'); ?>:
                        </span>
                        <span class="total-gia">
                            <strong id="total_order"><?php echo format_money($order->total,' VNĐ','0') ?></strong>
                        </span>
                    </p> 
                </div>
            </div><!-- END: panel-body -->
        </div><!-- END: panel -->
    </div><!-- END: col-xs-12 -->