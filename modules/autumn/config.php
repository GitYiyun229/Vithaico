<?php 
//module_view_task


$config_module['autumn_autumn'] = array(
	// Thông số này giúp cho các trang không nhập được  SEO như trang "trang chủ sp, trang chủ tin tức,...)
	'seo_special' => 1,
//	'params' => array (
//		'limit' => array(
//			'name' => 'Giới hạn',
//			'type' => 'text',
//			'default' => '6'
//		)
//	)
);



/*
 * Hàm liệt kê danh sách cách phương thức resize ảnh
 */
function get_method_resized_image(){
    return array('cropImge' => 'Crop ảnh', // crop ảnh
        'cut_image' => 'Cắt ảnh', // chém ảnh cho vừa khít
        'resize_image' => 'Resize ảnh',// nguyên tỉ lệ, thêm khoảng trắng
        'resized_not_crop' => 'Resize không crop',// bóp méo ảnh
    );
}
?>