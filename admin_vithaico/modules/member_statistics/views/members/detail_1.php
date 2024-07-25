<!-- <div>
    <canvas id="doughnut"></canvas>
</div> -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="card-header-member">
    <div class="filter-id">
        <h3><?php echo FSText::_('Lọc theo danh sách'); ?></h3>
        <select name="member-detail-1" class="select2" id="member-detail-1" onclick="member_detail_1()">
            <option value=""><?php echo FSText::_('Thành viên đã giới thiệu'); ?></option>
            <?php foreach ($list_f1 as $item) { ?>
                <option data-id="<?= $item->id  ?>" value="<?php echo $item->id ?>"><?php echo $item->full_name ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="card" id="Thong_ke_gioi_thieu">

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th><?php echo FSText::_('ID'); ?></th>
                        <th><?php echo FSText::_('UserName'); ?></th>
                        <th><?php echo FSText::_('Telephone'); ?></th>
                        <th><?php echo FSText::_('Email'); ?></th>
                        <th><?php echo FSText::_('Time'); ?></th>
                        <th><?php echo FSText::_('Rank'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($list_f1 as $item) { ?>
                        <tr class="turn_on<?= $item->id ?>" data-id>
                            <td><?= $item->id ?></td>
                            <td><?= $item->full_name ?></td>
                            <td><?= $item->telephone ?></td>
                            <td><?= $item->email ?></td>
                            <td><?= $item->created_time ?></td>
                            <td class="color_rank_<?=$item->level?>">
                                <?= $item->name_rank ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Listen for changes on the dropdown with id 'member-detail-1'
        $("#member-detail-1").change(function() {
            var selectedValue = $("#member-detail-1 option:selected").data('id');
            console.log(selectedValue); // Corrected line
            // Hide all rows in the table
            $("tr[class^='turn_on']").hide();
            // Check the selected value
            if (selectedValue == "") {
                // If the default option is selected, show all rows
                $("tr[class^='turn_on']").show();
            } else {
                // Show only the rows that match the selected user ID
                $(".turn_on" + selectedValue).show();
            }
        });
    });

    // const data = {
    //     labels: ['Red', 'Blue', 'Yellow'],
    //     datasets: [{
    //         label: 'My First Dataset',
    //         data: [300, 50, 100],
    //         backgroundColor: [
    //             'rgb(255, 99, 132)',
    //             'rgb(54, 162, 235)',
    //             'rgb(255, 205, 86)'
    //         ],
    //         hoverOffset: 4
    //     }]
    // };

    // const config = {
    //     type: 'doughnut',
    //     data: data,
    // };

    // const ctx = document.getElementById('doughnut').getContext('2d');
    // const myDoughnutChart = new Chart(ctx, config);
</script>