<?php 
	$params = array (
		'suffix' => array(
					'name' => 'Hậu tố',
					'type' => 'text',
					'default' => '_faq'
					),
        'limit' => array(
					'name' => 'Giới hạn',
					'type' => 'text',
					'default' => '6'
		),            
		'style' => array(
					'name'=>'Style',
					'type' => 'select',
					'value' => array('default' => 'Default','default_search' => 'Tìm kiếm')
			),
	);
	
?>