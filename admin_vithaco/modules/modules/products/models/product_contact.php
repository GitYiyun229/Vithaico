<?php 
	class ProductsModelsProduct_contact extends FSModels
	{
		var $limit;
		var $page;
		function __construct()
		{
			$limit = FSInput::get('limit',20,'int');
			$page = FSInput::get('page');
			$this->limit = $limit;
			//$this -> table_name = 'fs_manufactories';
            $this -> table_name = 'fs_product_contact';
			//synchronize
			$this -> check_alias = 1;
			//$this -> table_product = 'fs_products';
            $this ->table_product = FSTable_ad::_('fs_products');
			$this -> arr_img_paths = array(array('resized',170,170,'resize_image'));
			$this -> img_folder = 'images/products/product_contact/';
			$this->field_img = 'image';
			parent::__construct();
		}
		
		function setQuery()
		{
			// ordering
			$ordering = '';
			$where = "  ";
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
				if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND name LIKE '%".$keysearch."%' ";
				}
			}
			$query = " 	   SELECT * 
						
						  FROM ".$this -> table_name." 
						  	WHERE 1=1 ".
						 $where.
						 $ordering. " ";
			return $query;
		}
		
		
		/*
		 * get Tablename product
		 */
		function get_tablenames()
		{
			global $db;
			$query = " 	   SELECT DISTINCT(a.table_name) as table_name
						  FROM fs_products_tables AS a 
						 ";
			$db->query($query);
			$result = $db->getObjectList();
			
			return $result;
		}
	
	
			
		
		/*
		 * Save into tble fs_manufactories
		 */
		function save($row = array(),$use_mysql_real_escape_string = 0){
			
			// $name = htmlspecialchars(FSInput::get('name'), ENT_QUOTES);
			// $row['name'] = $name;
			$tablename = FSInput::get('tablenames',array(),'array');
			$str_tables = '';
			for($i = 0 ; $i < count($tablename); $i ++ ){
				if($i)
					$str_tables .= ',';
				$item    = $tablename[$i];
				$str_tables .=  $item;
			}
			if($str_tables)
				$str_tables = ','.$str_tables.',';
			$row['tablenames'] = $str_tables;
		
			$record_id =  parent::save($row,1);
			if($record_id){
				$record = $this -> get_record('id = '.$record_id.'',$this -> table_name);
				// update bảng sp
				$this -> update_table_products($record_id,$record);
				// update bảng mở rộng
				// $this -> update_table_products_extend($record_id,$record);
			}
			return $record_id;
		}
		
		/*
		 * Update table  table fs_products
		 * Chú ý: toàn bộ các bảng con của sp phải đồng bộ lại hết
		 */
		function update_table_products($cid,$manufactory){
				$row['manufactory_alias'] = $manufactory->alias;
				$row['manufactory_name'] = $manufactory->name;
				$row['manufactory_image'] = $manufactory->image;
//				$row['manufactory_published'] = $manufactory->published;
				return $this -> _update($row,'fs_products','  manufactory = '.$cid.' ');
		}
		/*
		 * Update manufactory tại các bảng mở rộng
		 */
		function update_table_products_extend($mid,$manufactory){
			$tables = $this -> get_records('','fs_products_tables',' DISTINCT(table_name)  AS table_name');
						
			if(!count($tables))
				return true;
				
			foreach($tables as $table){
				$table_name = $table -> table_name;
				
				if(!$table_name)
					continue;
				$row['manufactory_alias'] = $manufactory->alias;
				$row['manufactory_name'] = $manufactory->name;
				$row['manufactory_image'] = $manufactory->image;
//				$row['manufactory_published'] = $manufactory->published;
							
				$this -> _update($row,$table_name,' manufactory = '.$mid.' ');				
			}
			
		}

// 		function published($value)
// 		{
// 			$ids = FSInput::get('id',array(),'array');
// 			if(count($ids))
// 			{
// 				global $db;
// 				$str_ids = implode(',',$ids);
// 				$sql = " UPDATE ".$this -> table_product."
// 							SET manufactory_published = $value
// 						WHERE manufactory IN ( $str_ids ) " ;
// 				$db->query($sql);
// 				$result = $db->getResult();
// 				$tables = $this -> get_records('','fs_products_tables',' DISTINCT(table_name)  AS table_name');
// 				if(count($tables)){
// 					foreach($tables as $table){
// 						$table_name = $table -> table_name;
						
// 						if(!$table_name)
// 							continue;
// //						$row['manufactory_published'] = $value;
									
// 						$this -> _update($row,$table_name,' manufactory IN ('.$str_ids.' )' );				
// 					}
// 				}
// 			}
// 			return parent::published($value);
// 		}
	/*
		 * value: == 1 :old
		 * value  == 0 :unold
		 * published record
		 */
		function is_retail($value)
		{
			$ids = FSInput::get('id',array(),'array');
			if(count($ids))
			{
				global $db;
				echo $str_ids = implode(',',$ids);
				$sql = " UPDATE ".$this -> table_name."
							SET is_retail = $value
						WHERE id IN ( $str_ids ) " ;
				$db->query($sql);
				$rows = $db->affected_rows();

				
				if($rows){
					$row['is_retail'] = $value;
					$this -> _update($row,'fs_products',' manufactory = '.$str_ids);		
				}
					
				return $rows;
			}
			// 	update sitemap
			if($this -> call_update_sitemap){
				$this -> call_update_sitemap();
			}
			return 0;
		}
	}
	
?>