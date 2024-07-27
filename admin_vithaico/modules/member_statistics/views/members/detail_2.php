   <div class="row">
       <div class="col-xs-2">
           <input type="text" placeholder="From day" class="form-control" name="time_hoahong_0" id="time_hoahong_0" value="">
       </div>
       <div class="col-xs-2">
           <input type="text" placeholder="To day" class="form-control" name="time_hoahong_1" id="time_hoahong_1" value="">
       </div>
       <div class="col-xs-2" id="css__select2">
           <select name="hoahong_status" class="select2" id="hoahong_status">
               <option value=""><?php echo FSText::_('Trạng thái chi trả'); ?></option>
               <option value="0"><?php echo FSText::_('Chưa chi trả'); ?></option>
               <option value="1"><?php echo FSText::_('Đã chi trả'); ?></option>
           </select>
       </div>
       <div class="fl-left pd-15">
           <button class="btn btn-outline btn-primary submit_filter_hoahong" type="button">Tìm kiếm</button>
           <button type="button" class="btn btn-outline btn-primary" onclick="
        document.getElementById('time_hoahong_0').value='';
        document.getElementById('time_hoahong_1').value='';">
               Reset
           </button>
       </div>
   </div>
   <div class="row margin-15" id="filter-text-date-hoahong" style="margin-top: 20px;display:none;">
       <p>Đang tìm kiếm từ ngày
           <span id="filter_hoahong_time_0" class="fw-bold color-red">[Ngày bắt đầu]</span>
           <span> đến ngày </span>
           <span id="filter_hoahong_time_1" class="fw-bold color-red">[Ngày kết thúc]</span>
       </p>
   </div>
   <div class="row" style="margin-top: 20px;">
       <div class="inner col-xs-2">
           <p><?php echo FSText::_('Số coin nhận'); ?>
               <span id="filter_hoahong_coin">
                   <?= @$total_coin . ' VT-Coin' ?>
               </span>
           </p>
       </div>
       <div class="inner col-xs-2">
           <p><?php echo FSText::_('Số tiền tương đương'); ?>
               <span id="filter_hoahong_vnd"> <?= format_money(@$total_coin * 4500, 'đ') ?></span>
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
                           <th><?php echo FSText::_('Created_time'); ?></th>
                           <th><?php echo FSText::_('Coin từ đơn hàng'); ?></th>
                           <!-- <th><?php echo FSText::_('Coin trong ví trước khi nhận'); ?></th> -->
                           <th><?php echo FSText::_('Percent Rank'); ?></th>
                           <th><?php echo FSText::_('Percent Add(Total order >300Coin)'); ?></th>
                           <th><?php echo FSText::_('Coin nhận từ đơn hàng * giá coin'); ?></th>
                           <th><?php echo FSText::_('Trạng thái Đơn hàng'); ?></th>
                           <th><?php echo FSText::_('Trạng thái chi trả'); ?></th>
                           <th><?php echo FSText::_('Thực nhận'); ?></th>
                       </tr>
                   </thead>
                   <tbody id="tab_filter_2">
                       <?php foreach ($list_coin as $item) { ?>
                           <tr>
                               <td><?= $item->order_id ?></td>
                               <td><?= $item->created_time ?></td>
                               <td><?= $item->total_coin . ' Coin' ?></td>
                               <!-- <td><?= $item->before_coin . ' Coin' ?></td> -->
                               <td><?= $item->percent . '%' ?></td>
                               <td><?= ($item->percent_add - $item->percent ? $item->percent_add - $item->percent : '0') . '%' ?></td>
                               <td><?= $item->after_coin . ' Coin * 4500đ' ?></td>
                               <td style="font-weight:600;color:<?= $item->dieu_kien_nhan == 1 ? '#28a745' : 'red' ?>"><?= $item->dieu_kien_nhan == 1 ? 'True' : 'False' ?></td>
                               <td style="font-weight:600;color:<?= $item->status_chi_tra == 1 ? '#28a745' : 'red' ?>"><?= $item->status_chi_tra == 1 ? 'True' : 'False' ?></td>
                               <td><?= format_money($item->after_coin * 4500, 'đ') ?></td>
                           </tr>
                       <?php } ?>
                   </tbody>
               </table>
           </div>
       </div>
   </div>