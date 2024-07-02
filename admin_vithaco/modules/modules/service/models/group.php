<?php
	class ServiceModelsGroup extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 50;
			$this -> view = 'group';
			$this -> table_name = 'fs_members_service_group';
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
					$ordering .= " ORDER BY $sort_field $sort_direct, id DESC ";
			}
			if(!$ordering)
				$ordering .= " ORDER BY ordering DESC , id DESC ";


			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND ( a.name LIKE '%".$keysearch."%' )";
				}
			}
			$query = " SELECT a.*
						  FROM
						  ".$this -> table_name." AS a
						  	WHERE 1=1".
						 $where.
						 $ordering. " ";

			return $query;
		}
        
        function save($row = array(), $use_mysql_real_escape_string = 1){
            $id = FSInput::get('id',0,'int');
            $name = FSInput::get('name');
            $fsstring = FSFactory::getClass ( 'FSString', '', '../' );
			$row ['alias'] = $fsstring->stringStandart3 ( $name );
            
            $rs = parent::save($row);
            if($rs){
                // save service_id
                $uploadConfig = base64_encode('add|'.session_id());
                $row2 = array();
                $row2['session_id'] = '';
                $row2['service_id'] = $rs;
                $rs2 = $this->_update($row2,$this -> table_name.'_config',' session_id = "'.$uploadConfig.'" ' ,1);
            }
            return $rs;
        }
        
        function save_item(){
            $service_id = FSInput::get('service_id');
            if(!$service_id)
                return false;
            
            $id = FSInput::get('ids',0,'int');
            $row = array();
            
            $row['quanrity'] = FSInput::get2('quanrity',1,'int');
            $row['sale'] = FSInput::get2('sale',0,'int');
            
            $row['is_type'] = FSInput::get2('type',0,'int');
            $row['quanrity_text'] = FSInput::get('quanrity_text'); 
            $row['calculators_int'] = FSInput::get2('calculators',0,'int');
            
            $status = FSInput::get2('stt',0,'int');
            if($status){
                $row['service_id'] = $service_id;
                $row['session_id'] = '';
            }else{
                $row['session_id'] = $service_id;
                $row['ordering'] = $this->get_max_ordering($this -> table_name.'_config');
            }
            
            $row['published'] = 1;
            $time = date('Y-m-d H:i:s');
            $stt_add = FSInput::get('stt_add');
            
            if($id){
                $row['edited_time'] = $time;
                $rs = $this->_update($row,$this -> table_name.'_config',' id = '.$id ,1);
                return $rs;
            }else{
                $row['created_time'] = $time;
                $row['edited_time'] = $time;
                $rs = $this->_add($row,$this -> table_name.'_config',1);
                return $rs;
            }
        }


	}
?>
