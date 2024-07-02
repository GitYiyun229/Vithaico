<?php 
     ?>
<div class="form-group">
    <div class="table-responsive col-xs-12">
        <table class="table table-bordered table-hover"> 
			<thead>
				<tr>
				<th class="col-sm-3"><?php echo FSText::_('Tên dịch vụ'); ?></th>
				<th class="col-sm-1"><?php echo FSText::_('Số lượng'); ?></th>
                <th class="col-sm-2"><?php echo FSText::_('Đơn hàng'); ?></th>
				<th class="col-sm-2"><?php echo FSText::_('Ngày bắt đầu'); ?></th>
				<th class="col-sm-2"><?php echo FSText::_('Thời gian kết thúc'); ?></th>
				</tr>
			</thead>
			<tbody>
                <?php
                    if (count($banner)) {
                        foreach ($banner as $item) { ?>
				<tr>
					<td class="title-td"><?php echo $item->name ?></td>
					<td><?php echo $item->total_usage ?></td>
                    <td>
                        <?php 
                            $order = $model->get_record_by_id($item->order_id,'fs_order_2','code'); 
                            echo @$order->code;
                        ?>
                    </td>
					<td><?php echo date('H:i:s d-m-Y',strtotime($item->date_start)); ?></td>
                    <td><?php echo date('H:i:s d-m-Y',strtotime($item->date_end)); ?></td>
				</tr>
                <?php
                        }
                    } ?>
			</tbody>
        </table>    
    </div> 
</div>