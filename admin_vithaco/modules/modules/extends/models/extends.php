<?php 
	class ExtendsModelsExtends  extends FSModels
	{
		function __construct()
		{
			$this -> limit = 30;
			$this -> table_name = 'fs_extends';
			$this -> extends_tables = 'fs_extends_tables';
			$fields_default = array(
				0 => array('show'=>'Id','name'=>'id','type'=>'int'),
				1 => array('show'=>'Tên','name'=>'name','type'=>'varchar'),
				2 => array('show'=>'Tên hiệu','name'=>'alias','type'=>'varchar'),
				3 => array('show'=>'Thứ tự','name'=>'ordering','type'=>'int'),
				4 => array('show'=>'Hiển thị','name'=>'published','type'=>'int'),
				5 => array('show'=>'Seo title','name'=>'seo_title','type'=>'varchar'),
				6 => array('show'=>'Seo keyword','name'=>'seo_keyword','type'=>'varchar'),
				7 => array('show'=>'Seo description','name'=>'seo_description','type'=>'varchar'),
				8 => array('show'=>'Ngày tạo','name'=>'created_time','type'=>'datetime'),
				9 => array('show'=>'Ngày sửa','name'=>'edited_time','type'=>'datetime')
			);
			$this -> fields_default = $fields_default;
			parent::__construct();
		}
		function setQuery(){
			
			// ordering
			$ordering = "";
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
					$where .= " AND a.name LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_name." AS a
						  	WHERE 1=1 ".
						 $where.
						 $ordering. " ";
			return $query;
		}
		/*
		 * Get extend tables
		 */
		function get_tablenames(){
			$query = " 	   SELECT DISTINCT(a.table_name)
						  FROM fs_extends_tables AS a 
						 ";
			global $db;
			$db->query($query);
			$list = $db->getObjectList();
			return $list;
		}
		
		/*************** CREATE TABLE ****************/
		function table_new()
		{
			global $db;
			$table_name = FSInput::get('table_name');
			$table_name = strtolower($table_name);
			// CHECK 
			// table name not valid
			if(!@$table_name)
			{
				Errors::setError("T&#234;n b&#7843;ng kh&#244;ng &#273;&#432;&#7907;c &#273;&#7875; r&#7895;ng");
				return false;
			}
				
			// tablename invalid
			if( !$this -> check_valid_name($table_name))
			{
				Errors::setError("T&#234;n b&#7843;ng ch&#432;a &#273;&#250;ng");
				return false;
			}
			$table_name = "fs_extends_".$table_name;
			// tablename is exist
			if($db -> checkExistTable($table_name))
			{
				Errors::setError("T&#234;n b&#7843;ng &#273;&#227; &#273;&#432;&#7907;c d&#249;ng");
				return false;
			}
			// end CHECK 
			
			// check duplication
			if( !$this -> checkAlterTable())
			{
				return false;
			}
			// create table
			if(!$this -> createTable($table_name))
				return;
			// INSERT tablename witdh field id INTO fs_extends_table
			$fields_default = $this -> fields_default;
			foreach($fields_default as $field){
				$row = array();
				$row['table_name'] = $table_name ;
				$row['field_name'] = $field['name'] ;
				$row['field_type'] = $field['type'] ;
				$row['field_name_display'] = $field['show'] ;
				$row['is_default'] = 1 ;
				if(!$this -> _add($row,$this -> table_name))
					return;
			}	
			// save field in table
			if(!$this -> save_new_field($table_name))
				return;

			return $table_name;
		}
		
		/*
		 * check Fieledname and tablename
		 */
		function check_valid_name($name) {
 			 if(preg_match("/^[a-zA-Z0-9_]*$/",$name))
 			 	return true;
 			 else
 			 	return false;
		}
		
		/*************** end CREATE TABLE ****************/
		
		
		/*
		 * show field direct from exist table
		 */
		function getTableFields()
		{
			global $db;
			$tablename = FSInput::get('tablename');
			if($tablename == 'fs_extends')
				return;
							
			$query = " SELECT * 
						FROM ".$this -> table_name." 
						WHERE table_name =  '$tablename' 
						ORDER BY is_default DESC, id ASC";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		
		/*
		 * get Field from table fs_produts_table
		 */
		function get_fields_of_table()
		{
			global $db;
			$tablename = FSInput::get('tablename');
			if($tablename == 'fs_extends' || !$tablename)
				return;
				
			$query = " SELECT * 
						FROM ".$this -> table_name."
						WHERE table_name =  $tablename ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		/***************** OK ************/
		
		/*
		 * create table Extends follow category ( level = 1)
		 */
		function createProductTbl($tbl_name)
		{
			global $db;
			$sql = " CREATE TABLE  IF NOT EXISTS `$tbl_name`
				(
					id int(11) NOT NULL auto_increment,
					
					PRIMARY KEY  (`id`)
				) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";
			$db->query($sql);
			
		}
		
		
		
		
		/************ EDIT FIELD ************/
		function getCategoryFields()
		{
			$cid = FSInput::get('cid');
			$cid = $cid ? $cid : 0;
			$query = " SELECT a.*
					 FROM fs_category_fields AS a
					WHERE 
						categoryid	= $cid ";
			
			global $db;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		
		/*************** EDIT TABLE ****************/
		function save_edit()
		{
			global $db;
			$tablename = FSInput::get('table_name');
			$tablename = strtolower($tablename);
			if( !$this -> check_valid_name($tablename) || !$tablename)
			{
				Errors::setError('Can not change table type');
				return false;
			}
			
			// check duplication
			if( !$this -> checkAlterTable())
			{
				return false;
			}
			
			$table_name_begin = FSInput::get('table_name_begin');
			$tablename = "fs_extends_".$tablename;
			$table_name_begin = "fs_extends_".$table_name_begin;
			// change tablename
			if($table_name_begin != $tablename)
			{
				if( $db -> checkExistTable($tablename))
				{
					Errors::setError("Kh&#244;ng th&#7875; thay &#273;&#7893;i t&#234;n Table v&#236; t&#234;n table n&#224;y &#273;&#227; t&#7891;n t&#7841;i");
					return false;
					
				}
//				$this -> createTable($tablename);
				// Rename table
				$sql_rename = " RENAME TABLE $table_name_begin TO $tablename ";
				$db->query($sql_rename);
				$rows = $db->affected_rows();
				
				// change in fs_extends_tables
				$sql_change_table = " UPDATE  ".$this -> table_name."						 SET 
										table_name = '$tablename'
									WHERE table_name = '$table_name_begin' 
									";
				$db->query($sql_change_table);
				$rows = $db->affected_rows();
				if(!$rows)
				{
					Errors::setError("L&#7895;i khi update t&#234;n b&#7843;ng m&#7899;i");
					return false;
				}
			}
				
			// remove field 
			if(!$this->remove_exist_field($tablename))
			{
				return false;
			}
			
			// save exist field
			if(!$this->save_exist_field($tablename))
				return false;
				
			// save new field	
			if(!$this->save_new_field($tablename))
				return false;
			return true;
			
			
		}
		
		/*
		 * created table
		 * 
		 */
		function  createTable($table_name){
			$fields_default = $this -> fields_default;
			$arr_insert_table = array();
			$str_add = '';
			foreach($fields_default as $field){
				$name  = $field['name'];
				$show  = $field['show'];
				$ftype = $field['type'] ;
				if($name == 'id'){
					$str_add .= '`id` int(11) NOT NULL auto_increment,';
					continue;
				}
				if($name == 'published'){
					$str_add .= '`published` tinyint(4),';
					continue;
				}
				switch ($ftype)
				{
					case 'int':
						$type = "INT(11)";
						break;
					case 'varchar':
						$type = "VARCHAR(255)";
						break;
					case 'text':
						$type = "TEXT";
						break;
					case 'image':
						$type = "VARCHAR(255)";
						break;
					case 'datetime':
						$type = "DATETIME";
						break;
					default:
						$type = "VARCHAR(255)";
						break;
				}
				$str_add .= '`'.$name.'` '.$type.',';
			}
			
			global $db;
			$sql = " CREATE TABLE  IF NOT EXISTS `$table_name` 
				(".$str_add."										
					PRIMARY KEY  (`id`)
				) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";
			$rs = $db->query($sql);
			if(!$rs)
				return false;
			return true;
		}
		
		/*
		 * Save new extend field
		 * 
		 */
		function save_new_field($table_name)
		{
			global $db;
			$cid = FSInput::get('cid');
			// NEW FIELD
			$new_field_total = FSInput::get('new_field_total');
			if($new_field_total)
			{
				$sql_add = "";
				$sql_insert_table = "";
				
				$arr_add = array();
				$arr_insert_table = array();
				for($i = 0 ; $i < $new_field_total ; $i ++ )
				{
					$new_fname = FSInput::get('new_fname_'.$i);
					$fsstring = FSFactory::getClass('FSString','','../');
					$new_fname = $fsstring -> stringStandart($new_fname);
					if($new_fname){
						$new_fname = ''.$new_fname; // add prefix
						if($new_fname && $this -> check_valid_name($new_fname) )	
						{
							$new_ftype = FSInput::get('new_ftype_'.$i);
							switch ($new_ftype)
							{
								case 'int':
									$type = "INT(11)";
									break;
								case 'varchar':
									$type = "VARCHAR(255)";
									break;
								case 'text':
									$type = "TEXT";
									break;
								case 'image':
									$type = "VARCHAR(255)";
									break;
								case 'datetime':
									$type = "DATETIME";
									break;
								default:
									$type = "VARCHAR(255)";
									break;
							}
							$new_fshow = FSInput::get('new_fshow_'.$i);
							$arr_insert_table[]  = 		"('$table_name','$new_fname','$new_ftype','$new_fshow')";
							$arr_add[] = "  ADD `$new_fname` $type ";
						}
					}
				}
				
				// alter tablename
				if(count($arr_add))
				{
					$sql_add = " ALTER TABLE  $table_name ";
					$sql_add .= implode(",", $arr_add);
					
					$rs = $db->query($sql_add);
					if(!$rs)
					{
						Errors::setError("Kh&#244;ng alter &#273;&#432;&#7907;c table");
						return false;
					}
				}
				
				// insert into table ".$this -> table_name."
				if(count($arr_insert_table))
				{
					$sql_insert_table .= " INSERT INTO ".$this -> table_name." ";
					$sql_insert_table .= "		(table_name,field_name,field_type,field_name_display) ";
					$sql_insert_table .= "		 VALUES "; 
					$sql_insert_table .= implode(",", $arr_insert_table);
					
					$db->query($sql_insert_table);
					$rs = $db->insert();
					if(!$rs)
					{
						Errors::setError("Kh&#244;ng insert &#273;&#432;&#7907;c v&#224;o ".$this -> table_name."");
						return false;
					}
				}
				
			}
			return true;
		}
		
		/*
		 * Remove field in table
		 */
		function remove_exist_field($tablename)
		{
			global $db;
			$field_remove = trim(FSInput::get('field_remove'));
			if($field_remove)
			{
				$array_field_remove = explode(",",$field_remove);
				if(count($array_field_remove ) > 0)
				{
					$sql_alter = " ALTER TABLE  $tablename ";
					
					$arr_sql_drop = array();
					$arr_fname_remove = array();
					for($i = 0 ; $i < count($array_field_remove) ; $i ++)
					{
						if($array_field_remove[$i])
						{
							$arr_sql_drop[] = " DROP `".$array_field_remove[$i]."`";// add prefix
							$arr_fname_remove[] = "'".$array_field_remove[$i]."'"; // add prefix
						} 
					}
					$sql_drop = implode(",",$arr_sql_drop)	;
					$sql_alter .= 	$sql_drop;
					
					// remove in ".$this -> table_name."
					$sql_remove = " DELETE FROM  ".$this -> table_name."
									 WHERE table_name =  '$tablename' 
									 AND field_name IN (".implode(",",$arr_fname_remove).") ";					
					// remove from database
					$db->query($sql_remove);
					$rows = $db->affected_rows();
					if(!$rows)
					{
						Errors::setError("L&#7895;i x&#7843;y ra khi remove trong table ".$this -> table_name."");
						return false;
					}
					// remove from database
					$db->query($sql_remove);
					$rows = $db->affected_rows();
					if(!$rows)
					{
						Errors::setError("L&#7895;i x&#7843;y ra khi remove bộ lọc trong table fs_extends_filters");
						return false;
					}
					
					// alter
					$rs = $db->query($sql_alter);
					if(!$rs)
					{
						Errors::setError("L&#7895;i x&#7843;y ra khi alter nh&#7857;m remove c&#225;c field");
						return false;
					}
				}
			}
			return true;
		}
		/*
		 * Save exist extend field
		 */
		function save_exist_field($table_name)
		{
			global $db;
			
			// EXIST FIELD
			$field_extend_exist_total = FSInput::get('field_extend_exist_total');
			
			$sql_alter = "";
			$arr_sql_alter = array();
			
			for($i= 0 ; $i < $field_extend_exist_total ; $i++)
			{
				$sql_update = " UPDATE ".$this -> table_name."
							SET ";
				
				$fname_exist = FSInput::get('fname_exist_'.$i);
				$fsstring = FSFactory::getClass('FSString','','../');
				$fname_exist = $fsstring -> stringStandart($fname_exist);
				
				$fname_exist_begin = FSInput::get('fname_exist_'.$i."_begin");
				
				$ftype_exist = FSInput::get('ftype_exist_'.$i);
				$ftype_exist_begin = FSInput::get('ftype_exist_'.$i.'_begin');
				
				$fshow_exist = FSInput::get('fshow_exist_'.$i);
				$fshow_exist_begin = FSInput::get('fshow_exist_'.$i.'_begin');
				
				if($fname_exist){
					if( ($fname_exist != $fname_exist_begin) || ($ftype_exist != $ftype_exist_begin) || ($fshow_exist != $fshow_exist_begin )){
						switch ($ftype_exist)
						{
							case 'int':
								$type = "INT(11)";
								break;
							case 'varchar':
								$type = "VARCHAR(255)";
								break;
							case 'text':
								$type = "TEXT";
								break;
							case 'datetime':
								$type = "DATETIME";
								break;
							case 'image':
								$type = "VARCHAR(255)";
								break;
							default:
								$type = "VARCHAR(255)";
								break;
						}
						$arr_sql_alter[]  = " CHANGE `$fname_exist_begin`  `$fname_exist` $type ";
						
						// update
					$sql_update .= " 	field_name = '$fname_exist',
											field_name_display = '$fshow_exist', 
											field_type = '$ftype_exist'
										WHERE table_name = '$table_name'
										AND field_name = '$fname_exist_begin' ";
						$db->query($sql_update);
						$rows = $db->affected_rows();
					}
					else
					{
						if($fshow_exist != $fshow_exist_begin)
						{
							$sql_update .= " 	
											field_name_display = '$fshow_exist'											
										WHERE table_name = '$table_name'
										AND field_name = '$fname_exist_begin' ";
							$db->query($sql_update);
							$rows = $db->affected_rows();
						}
					}
				}
			}
			if(count($arr_sql_alter))
			{
				$sql_alter = " ALTER TABLE  $table_name ";
				$sql_alter .= implode(",", $arr_sql_alter);
				
				$rs = $db->query($sql_alter);
				if(!$rs)
					return false;
			}
				
			return true;
			
			// END EXIST FIELD
		}
		
		
		/*
		 * check Atler table
		 */
		function checkAlterTable()
		{
			$array_name  = array();
			$array_default = array('id','productid','categoryid','manufactory','manufactory_alias','model','model_alias','price');
			// exist field                           
			$field_extend_exist_total = FSInput::get('field_extend_exist_total');
			for($i= 0 ; $i < $field_extend_exist_total ; $i++)
			{                                       
				$extend_fname_exist = FSInput::get('fname_exist_'.$i);
				if($extend_fname_exist)
				{
					if(in_array(strtolower(trim($extend_fname_exist)),$array_default))
					{
						Errors::setError("Tr&#432;&#7901;ng b&#7883; tr&#249;ng v&#7899;i t&#234;n m&#7863;c &#273;&#7883;nh");
						return false;
					}
					$array_name[] = trim($extend_fname_exist);
				}
			}
			
			// new field
			$new_field_total = FSInput::get('new_field_total');
			if($new_field_total)
			{
				for($i = 0 ; $i < $new_field_total ; $i ++ )
				{
					$new_field_name = FSInput::get('new_fname_'.$i);
					
					if($new_field_name)
					{
						if(in_array(strtolower(trim($new_field_name)),$array_default))
						{
							Errors::setError("Tr&#432;&#7901;ng b&#7883; tr&#249;ng v&#7899;i t&#234;n m&#7863;c &#273;&#7883;nh");
							return false;
						}
						$array_name[] = trim($new_field_name);
					}	
				}
			}
			
			$length = count($array_name);
			$length_unique = count(array_unique($array_name));
			if($length_unique < $length)
			{
				Errors::setError("C&#243; tr&#432;&#7901;ng b&#7883; l&#7863;p");
				return false;
			}
			return true;
		}
		
		function remove()
		{
			$tablenames = FSInput::get('cid',array(),'array');
			
			// remove tabe EXTENTION
			// remove in 2 table:  PRODUCTS AND TABLE IMAGE
			if(count($tablenames))
			{
				global $db;
				$str_tablenames = ''; 
				for($i = 0; $i < count($tablenames) ; $i ++){
					if($i > 0)
						$str_tablenames .= ',';
					$str_tablenames .= "'".$tablenames[$i]."'";
				}
				
				$sql = " DELETE FROM ".$this -> table_name."
						WHERE table_name IN ( $str_tablenames )  " ;
				$db->query($sql);
				$rows = $db->affected_rows();
				
				
//				$sql1 = " DELETE FROM fs_extends_filters
//						WHERE tablename IN ( $str_tablenames )  " ;
//				$db->query($sql1);
//				$rows = $db->affected_rows();
				
				$sql_drop = " DROP TABLE  IF EXISTS  ".implode(",",$tablenames)." ";
				
				$db->query($sql_drop);
				$rows = $db->affected_rows();
				
				return $rows;
			}
			
			return 0;
		}

		/*
		 * Kiểm tra đây có phải là bảng mặc đinh, ko đc sửa tên bảng, remove bảng ko?
		 */
		function check_enable_default_table($table_name){
			if(!$table_name)
				return 0;
			return $this -> _get_result(' table_name = "'.$table_name.'" AND field_name = "id" ','fs_extends_tables','table_default');
		}
	}