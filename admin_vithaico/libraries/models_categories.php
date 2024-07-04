<?php 
	class ModelsCategories extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			parent::__construct();
			$this -> limit = 100;
			$this -> view = 'categories';
			
			$this -> table_items = '';
//			$this -> table_name = 'fs_items_categories';
			$this -> check_alias = 1;
			$this -> call_update_sitemap = 0;
			
			// exception: key (field need change) => name ( key change follow this field)
//			$this -> field_except_when_duplicate = array(array('list_parents','id'),array('alias_wrapper','alias'));
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
			if(isset($_SESSION[$this -> prefix.'filter'])){
				$filter = $_SESSION[$this -> prefix.'filter'];
				if($filter){
					$where .= ' AND b.id =  "'.$filter.'" ';
				}
			}
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND ( a.name LIKE '%".$keysearch."%'  )";
				}
			}
			
			$query = ' SELECT a.*
						  FROM 
						  	'.$this -> table_name.' AS a
						  	WHERE 1=1'.
						 $where.
						 $ordering. " ";
					//echo $query;
			return $query;
		}
		
		
		
		/*
		 * Save
		 */
		function save($row = array(),$use_mysql_real_escape_string = 1){
			$alias= FSInput::get('alias');
			$id= FSInput::get('id',0,'int');
			$fsstring = FSFactory::getClass('FSString','','../');
			$name = FSInput::get('name');
			if(!$alias){
				$row['alias'] = $fsstring -> stringStandart($name);
			} else {
				$row['alias'] = $fsstring -> stringStandart($alias);
			}
			
            $image_name_icon = @$_FILES["icon"]["name"];
    		if($image_name_icon){
    			$image_icon = $this->upload_image('icon','_'.time(),2000000,$this -> arr_img_paths_icon);
    			if($image_icon){
    				$row['icon'] = $image_icon;
    			}
    		}
			// parent
			$parent_id = FSInput::get('parent_id');
			if($id && ($id == $parent_id)){
				Errors::_('Parent can not itseft');
				return false;
			}
			if(@$parent_id)
			{
				$parent =  $this->get_record_by_id($parent_id,$this -> table_name);
				$parent_level = $parent -> level ?$parent -> level : 0; 
				$level = $parent_level + 1;
			} else {
				$level = 0;
			}
			$row['level'] = $level;
			$record_id =  parent::save($row);
			//var_dump($record_id);die;
			if($record_id){
				$this -> update_parent($record_id,$row['alias']);
				// update sitemap
//				$this -> update_sitemap($record_id,$this -> table_name,$this -> module);
			}
			return $record_id;
		}
		
			/*
		 * Update table table category And table table items
		 */
		function update_parent($cid,$alias){
			$record =  $this->get_record_by_id($cid,$this -> table_name);
			if($record -> parent_id){
				$parent =  $this->get_record_by_id($record -> parent_id,$this -> table_name);
				$list_parents = ','.$cid.$parent -> list_parents ;
				$alias_wrapper = ','.$alias.$parent -> alias_wrapper ;
			} else {
				$list_parents = ','.$cid.',';
				$alias_wrapper = ','.$alias.',' ;
			}
			$row['list_parents'] = $list_parents;
			$row['alias_wrapper'] = $alias_wrapper;
			
            $products_related  = FSInput::get ( 'products_record_related', array (), 'array' );
            $str_products_related = implode ( ',', $products_related );
    		if ($str_products_related) {
    			$str_products_related = ',' . $str_products_related . ',';
                $row ['products_related'] = $str_products_related;
    		}
    		
			// update table items
			$id = FSInput::get('id',0,'int');
			if($id && $this -> table_items){
				$row2['category_id_wrapper'] = $list_parents;
				$row2['category_alias'] = $record -> alias;
				$row2['category_alias_wrapper'] =  $alias_wrapper;
				$row2['category_name'] =  $record -> name;
				$row2['category_published'] =  $record -> published;
				$this -> _update($row2,$this -> table_items,' category_id = '.$cid.' ');

				// update table categories : records have parent = this
				$this -> update_categories_children($cid,0,$list_parents,'',$alias_wrapper,$record -> level);
			}
			// change this record
			$rs =  $this -> record_update($row,$cid);
			// update sitemap
//			$this -> update_sitemap($cid,$this -> table_name,$this -> module);
			return $rs;
		}
			
		function update_categories_children($parent_id,$root_id,$list_parents,$root_alias,$alias_wrapper,$level){
			if(!$parent_id)
				return;
			$query = ' SELECT * FROM '.$this -> table_name.' 
						WHERE parent_id = '	.$parent_id;
			global $db;
			$db->query($query);
			$result = $db->getObjectList();	
			if(!count($result))
				return;
			foreach($result as $item){
				
				$row3['list_parents'] = ",".$item -> id.$list_parents;
				$row3['alias_wrapper'] = ",".$item -> alias.$alias_wrapper;
				$row3['level'] =  ($level + 1) ;
				if($this -> _update($row3,$this -> table_name,' id = '.$item -> id.' ')){
					// update sitemap
//					$this -> update_sitemap($item -> id,$this -> table_name,$this -> module);
					
					// update table items owner this category
					$row2['category_id_wrapper'] = $row3['list_parents'];
					$row2['category_alias_wrapper'] =  $row3['alias_wrapper'];
//					$row2['category_name'] =  $row3['name'];
                    if($this -> table_items)
					   $this -> _update($row2,$this -> table_items,' category_id = '.$item -> id.' ');
					
					// đệ quy
//					$this -> update_categories_children($item -> id,$root_id,$row3['list_parents'],$root_alias,$row3['alias_wrapper'],$level);
				}
				$this -> update_categories_children($item -> id,$root_id,$row3['list_parents'],$root_alias,$row3['alias_wrapper'],$row3['level']);
			}
		}
		
		function check_remove(){
			$cids = FSInput::get('id',array(),'array');
			
			foreach ($cids as $cid)
			{
				if( $cid != 1)
				{
					$cids[] = $cid ;
				}
			}
			
			$num_record = 0;
			if(count($cids))
			{
				$str_cids = implode(',',$cids);
				global $db;
				
				$sql = " SELECT count(*) FROM  ".$this -> table_name." 
						WHERE id not IN ( $str_cids ) 
						AND parent_id IN ( $str_cids ) " ;
				$db->query($sql);
				$result = $db->getResult();
				if($result)
					return false;
				
                if($this -> table_items){
                    $sql = " SELECT count(*) FROM  ".$this -> table_items." 
						WHERE category_id IN ( $str_cids ) 
						 " ;
    				$db->query($sql);
    				$result = $db->getResult();
    				if($result)
    					return false;
                }	
				
			}
			return true;
		}
		function published($value)
		{
			$ids = FSInput::get('id',array(),'array');
			if(count($ids) && $this -> table_items)
			{
				global $db;
				$str_ids = implode(',',$ids);
				$sql = " UPDATE ".$this -> table_items."
							SET category_published = $value
						WHERE category_id IN ( $str_ids ) " ;
				$db->query($sql);
				$result = $db->getResult();
				
			}
			return parent::published($value);
		}
			/*
		 * create table Products follow category ( level = 1)
		 */
		function createProductTbl($tbl_name)
		{
			global $db;
			$sql = " CREATE TABLE  IF NOT EXISTS `$tbl_name`
				(
					id int(11) NOT NULL auto_increment,
					name varchar(255),
					alias varchar(255),
					categoryid int(11) NOT NULL,
					summary text,
					description text ,
					image varchar(255) ,
					hit int(11) ,
					created_time datetime,
					updated_time datetime ,
					published tinyint(4) default NULL,
					ordering int(11) default NULL,
					
					PRIMARY KEY  (`id`)
				) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";
			$db->query($sql);
			
		}
	}
	
?>