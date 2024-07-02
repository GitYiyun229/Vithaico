<?php 
	class MembersModelsMembers extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$limit = 100;
			$this -> view = 'members';
			$this->limit = $limit;
			$this -> table_name = 'fs_members';
			parent::__construct();
            //$this -> array_synchronize = array('fs_schedules'=>array('id'=>'user_id','username'=>'user_name','full_name'=>'full_name','sex'=>'sex'
                                                                       // ,'address'=>'address','level'=>'level','email'=>'email','mobilephone'=>'mobilephone'));                                  
		}
		
		function getMembers()
		{
			global $db;
			$query = $this->setQuery();
			if(!$query)
				return array();
				
			$sql = $db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			
			if(	isset($_POST['filter'])){
				$_SESSION[$this -> prefix.'filter']  =  $_POST['filter'] ;
			}
		
			return $result;
		}
		function get_member_info($start = 0,$end = 0){
			global $db;
			$query = $this->setQuery();
			if(!$query)
				return array();
			$sql = $db->query_limit_export($query,$start,$end);
			$result = $db->getObjectList();
			if(	isset($_POST['filter'])){
				$_SESSION[$this -> prefix.'filter']  =  $_POST['filter'] ;
			}
		
			return $result;
		}
		
		
		function setQuery()
		{
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
			$where = "  WHERE 1=1 ";
			
            // from
			if(isset($_SESSION[$this -> prefix.'text0']))
			{
				$date_from = $_SESSION[$this -> prefix.'text0'];
				if($date_from){
					$date_from = strtotime($date_from);
					$date_new = date('Y-m-d H:i:s',$date_from);
					$where .= ' AND a.created_time >=  "'.$date_new.'" ';
				}
			}
			
			// to
			if(isset($_SESSION[$this -> prefix.'text1']))
			{
				$date_to = $_SESSION[$this -> prefix.'text1'];
				if($date_to){
					$date_to = $date_to . ' 23:59:59';
					$date_to = strtotime($date_to);
					$date_new = date('Y-m-d H:i:s',$date_to);
					$where .= ' AND a.created_time <=  "'.$date_new.'" ';
				}
			}
            
			if(isset($_SESSION[$this -> prefix.'keysearch'])){
				$keysearch = $_SESSION[$this -> prefix.'keysearch'];
				if($keysearch){
					$where .= " AND ( a.username LIKE '%".$keysearch."%' OR a.full_name LIKE '%".$keysearch."%' OR a.id LIKE '%".$keysearch."%' )
										";
				}
           
			}
			
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_name." AS a "
						 .$where.
						 $ordering. " ";
			return $query;
		}
		
		function getTotal()
		{
			global $db;
			$query = $this->setQuery();
			$sql = $db->query($query);
			$total = $db->getTotal();
			return $total;
		}
		
		
		function getPagination()
		{
			$total = $this->getTotal();			
			$pagination = new Pagination($this->limit,$total,$this->page);
			return $pagination;
		}
		
		/**************************** end EXPORT *********************/
		/*
		 * Select a Members by Id
		 */
		function getMemberById()
		{
			$ids = FSInput::get('id',array(0),'array');
			$id = $ids[0];
			if(!$id)
				$id = 0;
			$query = " SELECT a.*
						  FROM fs_members AS a
						  WHERE a.id = $id ";
			
			global $db;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}
	
		
		/******************************** SAVE *****************************************/
		/*
		 * 
		 * Save
		 */
		function save(){
			$edit_pass = FSInput::get('edit_pass');
			if($edit_pass){
				$row['password'] = md5(FSInput::get("password1"));
			}
			return parent::save($row,0);
		}
		
		
		function remove(){
			$img_paths = array();
			$img_paths[] = PATH_IMG_MEMBER_AVATAR.'original'.DS;
			$img_paths[] = PATH_IMG_MEMBER_AVATAR.'resized'.DS;
			return parent::remove('avatar',$img_paths);
		}


		/*
		 * Createa folder when create user
		 */
		function create_folder_upload($id){
			$fsFile = FSFactory::getClass('FsFiles','');
			$path = PATH_BASE.'uploaded'.DS.'estores'.DS.$id;
			return $fsFile->create_folder($path);
		}
		
		function get_level(){
			$sql = " SELECT * FROM fs_members_level ";
			global $db ;
			$db->query($sql);
			return $db->getObjectListByKey('level');
		}
 	
	}
	
	
?>