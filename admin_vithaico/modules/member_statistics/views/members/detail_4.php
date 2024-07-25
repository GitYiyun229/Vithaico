<div>
    <div class="inner">
        <p><?php echo FSText::_('Số coin nhận'); ?>
            <span>
                <?= @$total_coin_f1 . ' VT-Coin' ?>
            </span>
        </p>
    </div>
    <div class="inner">
        <p><?php echo FSText::_('Số tiền tương đương'); ?>
            <span> <?= format_money(@$total_coin_f1 * 4500, 'đ') ?></span>
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
                <tbody>
                    <?php foreach ($list_order_f1 as $item) {
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