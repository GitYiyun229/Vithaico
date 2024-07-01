<?php 
	$params = array (
		'suffix' => array(
					'name' => 'Hậu tố',
					'type' => 'text',
					'default' => '_menu'
					),
		'id' => array(
					'name' => 'Id (dùng cho qcáo bên ngoài trang)',
					'type' => 'text',
					'default' => 'divAdLeft',
					'comment' => 'divAdLeft dùng cho bên trái, divAdRight cho bên phải'
					),
		'style' => array(
					'name'=>'Style',
					'type' => 'select',
					'value' => array('default' => 'Mặc định',
									'bottommenu'=>'Phía dưới',
									'service'=>'Dịch vụ',
									'static'=>'Trang tĩnh',
									)
			),
		'category_id' => array(
					'name'=>'Nhóm menu',
					'type' => 'select',
					'value' => get_category(),
					'attr' => array('multiple' => 'multiple'),
			),
	);
	function get_category(){
		global $db;
			$query = " SELECT group_name, id 
						FROM fs_menus_groups 
						";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			if(!$result)
			     return;
			$arr_group = array();
            foreach($result as $item){
            	$arr_group[$item -> id] = $item -> group_name;
            }
			return $arr_group;
	}
	
?>