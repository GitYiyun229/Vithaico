<!-- <div>
    <canvas id="doughnut"></canvas>
</div> -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="card" id="Thong_ke_gioi_thieu">
    <div class="card-header-member">
        <div class="filter-id">
            <h3>Lọc theo danh sách</h3>
            <select name="member-detail-1" id="member-detail-1">
                <option value="">Thành viên đã giới thiệu</option>
                <?php foreach ($list_f1 as $item) { ?>
                    <option value="<?php echo $item->user_id ?>"><?php echo $item->user_name ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
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
                        <tr data-id>
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
<!-- <script>
    const data = {
        labels: ['Red', 'Blue', 'Yellow'],
        datasets: [{
            label: 'My First Dataset',
            data: [300, 50, 100],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)'
            ],
            hoverOffset: 4
        }]
    };

    const config = {
        type: 'doughnut',
        data: data,
    };

    const ctx = document.getElementById('doughnut').getContext('2d');
    const myDoughnutChart = new Chart(ctx, config);
</script> -->