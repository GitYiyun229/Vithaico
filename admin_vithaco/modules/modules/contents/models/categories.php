<?php 
	class ContentsModelsCategories extends ModelsCategories
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			parent::__construct();
			$this -> table_items = FSTable_ad::_('fs_contents');
			$this -> table_name = FSTable_ad::_('fs_contents_categories');
			$this -> check_alias = 1;
			$this -> call_update_sitemap = 0;
			
			// exception: key (field need change) => name ( key change follow this field)
			$this -> field_except_when_duplicate = array(array('list_parents','id'),array('alias_wrapper','alias'));
			$limit = FSInput::get('limit',20,'int');
			$this -> limit = $limit;
			
		}
		function setQuery(){
			// ordering
			$ordering = "";
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
			
			$where = "  ";
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND name LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT a.*, a.parent_id as parent_id 
						  FROM 
						  	".$this -> table_name." AS a
						  	WHERE 1=1".
						 $where.
						 $ordering. " ";
			return $query;
		}
        function save($row = array(), $use_mysql_real_escape_string = 0)
        {
            $id = FSInput::get('id', 0, 'int');
            $title = FSInput::get('name');


//        $row ['sizes'] = $str_sizes;
            $fsstring = FSFactory::getClass('FSString', '', '../');
            $alias = $fsstring->stringStandart($title);
            $row['alias'] = FSInput::get('alias') ? FSInput::get('alias') : $alias;

            $check_alias = $this->check_exist_alias_redirect($id,$alias);
            if($check_alias){
                Errors::_('Alias của bạn đã bị trùng tên','alert');
                $row['alias'] = $this -> genarate_alias_news($row['alias'],$id);
            }
            $rid = parent::save($row);
            $this->save_redirect($rid,$row['alias']);


            return $rid;
        }
        function check_exist_alias_redirect($id,$alias){
            global $db;
            $where = '';
            if($id)
                $where .= " and record_id <> $id ";
            $sql = "SELECT * FROM fs_redirect WHERE alias = '$alias' $where ";
            $db->query($sql);
            return $db->getObject();
        }

        function save_redirect($id,$alias){
            global $db;
            $id_redirect = $this->get_record('record_id = ' .$id.' AND module = "contents" AND view = "cat"','fs_redirect');

            if($id_redirect){
                $query = "UPDATE fs_redirect set record_id = $id, alias = '$alias', `module` = 'contents', `view` = 'cat' WHERE record_id = $id  AND `module` = 'contents' AND `view` = 'cat'";
                $db->affected_rows($query);
            }else{
                $query = "INSERT INTO fs_redirect (record_id,alias,`module`,`view`) 
                      VALUE ($id,'$alias','contents','cat')";

                $db->insert($query);
            }
            return true;
        }

        function remove(){
            $id = FSInput::get('id',array(),'array');

            foreach ($id as $item){
                $this -> _remove('record_id  = '.$item .' and `module` = "contents" and `view` = "cat" ','fs_redirect');
            }
            $rs = parent::remove();
            return $rs;
        }

    }
	
?>