<?php 
	class DocumentsModelsCategories extends ModelsCategories
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			parent::__construct();
			$this -> table_items = FSTable_ad::_('fs_documents');
			$this -> table_name = FSTable_ad::_('fs_documents_categories');
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
	}
	
?>