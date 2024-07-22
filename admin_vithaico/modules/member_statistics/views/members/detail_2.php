<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Total Price</th>
                        <th>Price before</th>
                        <th>Percent</th>
                        <th>Percent Add</th>
                        <th>Price After</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($list_coin as $item) { ?>
                        <tr>
                            <td><?= $item->order_id ?></td>
                            <td><?= $item->total_coin ?></td>
                            <td><?= $item->before_coin ?></td>
                            <td><?= $item->percent ?></td>
                            <td><?= $item->percent_add ?></td>
                            <td><?= $item->after_coin ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>