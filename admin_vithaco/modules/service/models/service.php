<?php
	class ServiceModelsService extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'service';
			$this -> table_name = 'fs_members_service';
            
            $this -> arr_img_paths = array(
                                            array('large',400,300,'cut_image')
                                        );
            $cyear = date('Y');
			$cmonth = date('m');
			//$cday = date('d');
			$this -> img_folder = 'images/service/'.$cyear.'/'.$cmonth;
			$this -> check_alias = 1;
			$this -> field_img = 'image';
            
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
            
            if (isset ( $_SESSION [$this->prefix . 'filter0'] )) {
    			$filter = $_SESSION [$this->prefix . 'filter0'];
    			if ($filter) {
    			    //$filter = $filter == 5? 0:$filter; 
    				$where .= ' AND a.group_id = ' . $filter ;
    			}
    		}

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
            $id = isset($id)? $id:0;
            
            // dich vu ap dung dong thoi
            $list_service  = FSInput::get ( 'list_service', array (), 'array' );
            $str_list_service = implode ( ',', $list_service );
    		if ($str_list_service) {
    			$str_list_service = ',' . $str_list_service . ',';
    		}
    		$row ['list_service'] = $str_list_service;
            
            // dich vu tang kem
            $bundled_services  = FSInput::get ( 'bundled_services', array (), 'array' );
            $str_bundled_services = implode ( ',', $bundled_services );
    		if ($str_bundled_services) {
    			$str_bundled_services = ',' . $str_bundled_services . ',';
    		}
    		$row ['bundled_services'] = $str_bundled_services;
            
            $group_id = FSInput::get('group_id',0,'int');
            $str = ',1,2,3,4,';

            // save alias
            $name = FSInput::get('name');
            $fsstring = FSFactory::getClass ( 'FSString', '', '../' );
			$row ['alias'] = $fsstring->stringStandart3 ( $name );
            
            if($id)
                $data = $this->get_record_by_id($id,$this -> table_name,'alias');
            
            $rs = parent::save($row);
            if($rs){
                // add field table
                global $db;
                if($group_id && strpos($str,','.$group_id.',') !== false ){
                    if($id && @$data){
                        global $db_info;
                        $query = ' SHOW COLUMNS FROM `fs_products` LIKE "'.$row['alias'].'" ';      
                        $result = $db->getTotal($query);
                        if($result){
                            $sql = ' ALTER TABLE `fs_products` CHANGE `'.$data->alias.'` `'.$row['alias'].'` tinyint(4) default 0 ';
                        }else{
                            $sql = ' ALTER TABLE `fs_products` ADD '.$row['alias'].' tinyint(4) default 0 ';
                        } 
                    }else{
                        $sql = ' ALTER TABLE `fs_products` ADD '.$row['alias'].' tinyint(4) default 0 ';
                    }
                    $db->query($sql);
                }
                
                // save service_id
                $uploadConfig = base64_encode('add|'.session_id());

                $row2 = array();
                $row2['session_id'] = '';
                $row2['service_id'] = $rs;
                $rs2 = $this->_update($row2,$this -> table_name.'_item',' session_id = "'.$uploadConfig.'" ' ,1);
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
                $row['ordering'] = $this->get_max_ordering($this -> table_name.'_item');
            }
            
            $row['published'] = 1;
            $time = date('Y-m-d H:i:s');
            $stt_add = FSInput::get('stt_add');
            
            if($id){
                $row['edited_time'] = $time;
                $rs = $this->_update($row,$this -> table_name.'_item',' id = '.$id ,1);
                return $rs;
            }else{
                $row['created_time'] = $time;
                $row['edited_time'] = $time;
                $rs = $this->_add($row,$this -> table_name.'_item',1);
                return $rs;
            }
        }
	}
?>
