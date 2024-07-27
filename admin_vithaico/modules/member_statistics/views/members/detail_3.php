   <div class="row">
       <div class="col-xs-2">
           <input type="text" placeholder="From day" class="form-control" name="time_order_0" id="time_order_0" value="">
       </div>
       <div class="col-xs-2">
           <input type="text" placeholder="To day" class="form-control" name="time_order_1" id="time_order_1" value="">
       </div>
       <div class="fl-left pd-15">
           <button class="btn btn-outline btn-primary submit_filter_order" type="button">Tìm kiếm</button>
           <button type="button" class="btn btn-outline btn-primary" onclick="
        document.getElementById('time_order_0').value='';
        document.getElementById('time_order_0').value='';">
               Reset
           </button>
       </div>
   </div>
   <div class="row margin-15" id="filter-text-date-order" style="margin-top: 20px;display:none;">
       <p>Đang tìm kiếm từ ngày
           <span id="filter_order_time_0" class="fw-bold color-red">[Ngày bắt đầu]</span>
           <span> đến ngày </span>
           <span id="filter_order_time_1" class="fw-bold color-red">[Ngày kết thúc]</span>
       </p>
   </div>
   <div class="row" style="margin-top: 20px;">
       <div class="inner col-xs-2">
           <p><?php echo FSText::_('Số coin từ đơn hàng'); ?>
               <span id="filter_order_coin">
                   <?= @$total_coin_list_order . ' VT-Coin' ?>
               </span>
           </p>
       </div>
       <div class="inner col-xs-3">
           <p><?php echo FSText::_('Số tiền từ tổng đã mua hàng'); ?>
               <span id="filter_order_vnd"> <?= format_money(@$total_list_order, 'đ') ?></span>
           </p>
       </div>
   </div>
   <div class="card">
       <div class="card-body p-0">
           <div class="table-responsive">
               <table class="table m-0">
                   <thead>
                       <tr>
                           <th><?php echo FSText::_('Order ID'); ?></th>
                           <th><?php echo FSText::_('Total Product'); ?></th>
                           <th><?php echo FSText::_('Total Order'); ?></th>
                           <th><?php echo FSText::_('Price Ship'); ?></th>
                           <th><?php echo FSText::_('Total Price'); ?></th>
                           <th><?php echo FSText::_('Coin'); ?></th>
                           <th><?php echo FSText::_('Time'); ?></th>
                           <th><?php echo FSText::_('Detail'); ?></th>

                       </tr>
                   </thead>
                   <tbody id="tab_filter_3">
                       <?php foreach ($list_order as $item) {
                        ?>
                           <tr>
                               <td><?= $item->id ?></td>
                               <td><?= $item->products_count ?></td>
                               <td><?= format_money($item->total_before, 'đ') ?></td>
                               <td><?= format_money($item->ship_price, 'đ') ?></td>
                               <td><?= format_money($item->total_end, 'đ') ?></td>
                               <td><?= $item->member_coin ?></td>
                               <td><?= $item->created_time ?></td>
                               <td>
                                   <a href="#" data-color="#00a65a" data-height="20">Chi tiết</a>
                               </td>
                           </tr>
                       <?php } ?>
                   </tbody>
               </table>
           </div>
       </div>
   </div>