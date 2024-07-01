<?php
// if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
//     $ip_address = $_SERVER["HTTP_CF_CONNECTING_IP"];
// } else {
//     $ip_address = $_SERVER['REMOTE_ADDR'];
// }

// function log_ip()
// {
//     if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
//         $ip_address = $_SERVER["HTTP_CF_CONNECTING_IP"];
//     } else {
//         $ip_address = $_SERVER['REMOTE_ADDR'];
//     }
//     $date = date("Y-m-d H:i:s");
//     if (($ip_address != '118.70.171.104') || ($ip_address != '118.70.17.130')) {
//         $log_line = "$ip_address\t$date\n";
//     }
//     // Đọc nội dung của file ip.txt vào một chuỗi
//     $content = file_get_contents("ip.txt");

//     // Thêm dòng mới vào đầu chuỗi
//     $content = $log_line . $content;

//     // Cắt bớt các dòng dư thừa nếu nó vượt quá số lượng dòng tối đa
//     $lines = explode("\n", $content);
//     if (count($lines) > 2000) {
//         $new_lines = array_slice($lines, 0, 1000);
//         $content = implode("\n", $new_lines);
//     }

//     // Ghi lại toàn bộ chuỗi nội dung vào file ip.txt
//     file_put_contents("ip.txt", $content);
// }

// // Hàm kiểm tra số lần truy cập của mỗi địa chỉ IP trong 1 phút và khóa nếu vượt quá giới hạn
// function block_ip($ip_address)
// {    
//     $ip_count = 0;
//     $now = time();
//     $lines = file("ip.txt");

//     // Tính số lần truy cập của địa chỉ IP trong 1 phút
//     foreach ($lines as $line) {
//         $parts = explode("\t", $line);
//         if (count($parts) < 2) {
//             continue;
//         }
//         $log_ip = $parts[0];
//         $log_time = strtotime($parts[1]);
//         if ($ip_address == $log_ip && $now - $log_time <= 60) {
//             $ip_count++;
//         }
//     }
//     // echo $ip_address.'-'.$ip_count;

//     // Kiểm tra và khóa địa chỉ IP nếu vượt quá giới hạn
//     if ($ip_count > 120) {
//         $ip_file = "blocked_ips.txt";
//         $log_line = "$ip_address\t$now\n";
//         file_put_contents($ip_file, $log_line, FILE_APPEND);
//         return true;
//     }

//     return false;
// }

// // Sử dụng hàm log_ip() để lưu địa chỉ IP của client vào file dailyip.log
// log_ip();

// // Sử dụng hàm block_ip() để kiểm tra và khóa địa chỉ IP nếu vượt quá giới hạn
// if (block_ip($ip_address)) {
//     header("HTTP/1.1 429 Too Many Requests");
//     echo "Too many requests from this IP address. Please try again later.";
//     exit;
// }

$db_info = array(
    'dbName' => 'shopusa',
    'dbUser' => 'root',
    'dbPass' => 'root',
    'dbHost' => 'localhost'
);
