<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>UserName</th>
                        <th>Telephone</th>
                        <th>Email</th>
                        <th>Time</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($list_f1 as $item) { ?>
                        <tr>
                            <td><?= $item->user_id ?></td>
                            <td><?= $item->user_name ?></td>
                            <td><?= $item->telephone ?></td>
                            <td><?= $item->email ?></td>
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