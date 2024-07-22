<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Total Product</th>
                        <th>Total Order</th>
                        <th>Price Ship</th>
                        <th>Total Price</th>
                        <th>Coin</th>
                        <th>Time</th>
                        <th>Detail</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($list_order_f1 as $item) {
                    ?>
                        <tr>
                            <td><?= $item->id ?></td>
                            <td><?= $item->products_count ?></td>
                            <td><?= $item->total_before ?></td>
                            <td><?= $item->ship_price ?></td>
                            <td><?= $item->total_end ?></td>
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