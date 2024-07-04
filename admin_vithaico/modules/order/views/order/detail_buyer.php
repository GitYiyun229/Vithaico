<?php if ($order->user_id && $buyer) { ?>
    <table cellspacing="0" cellpadding="6" width="100%" class="table table-striped">
        <tbody>
            <tr>
                <td><b>Họ tên</b></td>
                <td><?php echo @$buyer->full_name; ?></td>
            </tr>
            <tr>
                <td><b>Số điện thoại</b></td>
                <td><?php echo @$buyer->telephone; ?></td>
            </tr>
            <tr>
                <td><b>Email</b></td>
                <td><?php echo @$buyer->email; ?></td>
            </tr>
            <tr>
                <td><b>Giới tính</b></td>
                <td><?php echo $this->sex[$buyer->sex] ?></td>
            </tr>
            <tr>
                <td><b>Ngày sinh</b></td>
                <td><?php echo date('d/m/Y', strtotime(@$buyer->birthday)); ?></td>
            </tr>
            
        </tbody>
    </table>
<?php } else { ?>
    Khách chưa đăng ký thành viên
<?php } ?>    