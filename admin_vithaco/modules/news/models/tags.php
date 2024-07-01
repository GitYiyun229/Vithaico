<?php 
	class NewsModelsTags extends FSModels
	{
		function __construct()
		{
			
			$this -> table_items = FSTable_ad::_('fs_news');
			$this -> table_name = FSTable_ad::_('fs_news_tags');
			$this -> check_alias = 1;
			$this -> call_update_sitemap = 1;
			$this -> table_products = FSTable_ad::_('fs_products');
			// exception: key (field need change) => name ( key change follow this field)
			$this -> field_except_when_duplicate = array(array('list_parents','id'),array('alias_wrapper','alias'));
			// config for save
			$cyear = date('Y');
			$cmonth = date('m');
			//$cday = date('d');
			$this -> img_folder = 'images/news/cat/'.$cyear.'/'.$cmonth;
			$this -> field_img = 'image';
			parent::__construct();
			$this -> limit = 100;
            
           // $this -> array_synchronize = array($this -> table_items=>array('id'=>'category_id','alias'=>'category_alias','name'=>'category_name'
//                                                                            ,'published'=>'published_cate','alias_wrapper'=>'category_alias_wrapper'));
		}
        
        function get_products_related($product_related){
    		if(!$product_related)
    				return;
    		$query   = ' SELECT id, name,image 
    					FROM '.$this -> table_products.'
    					WHERE id IN (0'.$product_related.'0) 
    					 ORDER BY POSITION(","+id+"," IN "0'.$product_related.'0")
    					';
    		global $db;
    		$sql = $db->query($query);
    		$result = $db->getObjectList();
    		return $result;
    	}

        function save($row = array(),$use_mysql_real_escape_string = 1){
            $title = FSInput::get('name');
            $id = FSInput::get('id');

            $fsstring = FSFactory::getClass('FSString', '', '../');
            $alias = $fsstring->stringStandart($title);
            $row['alias'] = FSInput::get('alias') ? FSInput::get('alias') : $alias;
            $row['seo_title'] = FSInput::get('seo_title');
            $check_alias = $this->check_exist_alias_redirect($id,$alias);
            if($check_alias){
                Errors::_('Alias của bạn đã bị trùng tên','alert');
                $row['alias'] = $this -> genarate_alias_news($row['alias'],$id);
            }

            $record_id =  parent::save($row);

            $this->save_redirect($id,$record_id,$row['alias']);

            return $record_id;
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

        function save_redirect($id,$rs,$alias){
            global $db;
            if($id){
                $query = "UPDATE fs_redirect set record_id = $id, alias = '$alias', `module` = 'news', `view` = 'tags' WHERE record_id = $id";
                $db->affected_rows($query);
            }else{
                $query = "INSERT INTO fs_redirect (record_id,alias,`module`,`view`) 
                      VALUE ($rs,'$alias','news','tags')";
                $db->insert($query);
            }
            return true;
        }

        function remove(){
            $id = FSInput::get('id',array(),'array');

            foreach ($id as $item){
                $this -> _remove('record_id  = '.$item .' and `module` = "news" and `view` = "tags" ','fs_redirect');
            }
            
            $rs = parent::remove();
            return $rs;
        }
	}
	
?>