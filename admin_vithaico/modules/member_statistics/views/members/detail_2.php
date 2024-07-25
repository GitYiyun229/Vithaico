<div>
    <div class="inner">
        <p><?php echo FSText::_('Số coin nhận'); ?>
            <span>
                <?= @$total_coin . ' VT-Coin' ?>
            </span>
        </p>
    </div>
    <div class="inner">
        <p><?php echo FSText::_('Số tiền tương đương'); ?>
            <span> <?= format_money(@$total_coin * 4500, 'đ') ?></span>
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
                <tbody>
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