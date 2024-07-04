<?php 
	class MembersModelsBoss extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$limit = 100;
			$this->limit = $limit;
			$this -> table_name = 'fs_members';
			parent::__construct();
		}
		
		function getBoss()
		{
			global $db;
			$query = $this->setQuery();
			if(!$query)
				return array();
				
			$sql = $db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			
//			if(	isset($_POST['filter'])){
//				$_SESSION[$this -> prefix.'filter']  =  $_POST['filter'] ;
//			}
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($result);
			return $list;
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
			$where = "  WHERE (is_boss = 1 OR want_boss = 1) ";
			
			if(isset($_SESSION[$this -> prefix.'keysearch'])){
				$keysearch = $_SESSION[$this -> prefix.'keysearch'];
				if($keysearch){
					$where .= " AND ( a.full_name LIKE '%".$keysearch."%' )
										";
				}
			}
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter < 2){
					$where .= " AND published = $filter ";
				}
			}
//			
//			if(isset($_SESSION[$this -> prefix.'city'] ))
//			{
//				if($_SESSION[$this -> prefix.'city'] )
//				{
//					$city_id = $_SESSION[$this -> prefix.'city'];
//					$where .= " AND a.city_id  =".$city_id." ";
//				}
//			}
//			if(isset($_SESSION[$this -> prefix.'published'] ))
//			{
//				$status= $_SESSION[$this -> prefix.'published'];
//				switch($status)
//				{
//					case 'activated':
//						$where .= " AND a.published = 1 ";
//						break;	
//					case 'unactivated':
//						$where .= " AND a.published = 0 ";
//						break;
//				}
//			}
			
			$query = " SELECT *
						  FROM 
						   fs_members AS a
						 $where
						 $ordering 
						 ";
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
		 * Select a Boss by Id
		 */
		function getBossById()
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
		
		function getCity()
		{
			global $db ;
			$sql = " SELECT id, name FROM fs_cities ";
			$db->query($sql);
			return $db->getObjectList();
		}
		
		
		
		/******************************** SAVE *****************************************/
		/*
		 * 
		 * Save
		 */
		function save(){
			$username = FSInput::get('username');
			if(!$username)
				return false;

			$image = $_FILES["avatar"]["name"];
			if($image){
				
				// remove old if exists record and img
				$id = FSInput::get('id',0,'int');
				if($id){
					
					$img_paths = array();
					$img_paths[] = PATH_IMG_MEMBER_AVATAR.'original'.DS;
					$img_paths[] = PATH_IMG_MEMBER_AVATAR.'resized'.DS;
					$this -> remove_image($id,$img_paths);
				}
				$fsFile = FSFactory::getClass('FsFiles');
				// upload
				$path = PATH_IMG_MEMBER_AVATAR.'original'.DS;
				$image = $fsFile -> uploadImage("avatar", $path ,2000000, '');
				if(!$image){
					Errors::_(" Not upload successful images");
					return false;
				}
					
					
				
				// rezise to standart : 300x175
				$path_resize = PATH_IMG_MEMBER_AVATAR.'resized'.DS;
				if(!$fsFile ->resize_image($path.$image, $path_resize.$image,IMG_MEMBER_AVATAR_WIDTH, IMG_MEMBER_AVATAR_HEIGHT))
				{
					Errors::_(" Not resize successful images");
					return false;
				}
				$row['image'] = 	$image;
			}
			$edit_pass = FSInput::get('edit_pass');
			if($edit_pass){
				$row['password'] = md5(FSInput::get("password1"));
			}
			return parent::save($row);
		}
		
		
		function remove(){
			$img_paths = array();
			$img_paths[] = PATH_IMG_MEMBER_AVATAR.'original'.DS;
			$img_paths[] = PATH_IMG_MEMBER_AVATAR.'resized'.DS;
			return parent::remove('avatar',$img_paths);
		}

		/*************** ADDRESS *************/
		/*
		 * get list District
		 * default: Ha Noi
		 */
		function getDistricts($cityid = '1473')
		{
			if(!$cityid)
				$cityid = '1473';
			global $db ;
			$sql = " SELECT id, name FROM fs_districts
					WHERE city_id = $cityid ";
			$db->query($sql);
			return $db->getObjectList();
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
		
	/*
		 * value: == 1 :hot
		 * value  == 0 :unhot
		 * published record
		 */
		function boss($value)
		{
			$ids = FSInput::get('id',array(),'array');
			
			if(count($ids))
			{
				global $db;
				$str_ids = implode(',',$ids);
				if($value){
					$sql = " UPDATE ".$this -> table_name."
								SET is_boss = $value
							WHERE id IN ( $str_ids ) " ;
				}else{
					$sql = " UPDATE ".$this -> table_name."
								SET is_boss = $value,
								want_boss = 1
							WHERE id IN ( $str_ids ) " ;
				}
				$db->query($sql);
				$rows = $db->affected_rows();
				return $rows;
			}
			return 0;
		}
		/*
		 * Lấy đơn hàng do CTV giới thiệu
		 */
		function get_orders(){
			$id = FSInput::get('id');
			$where = ' ';
			$status = FSInput::get('display');
			if($status!='')
			{
				$where .=  " AND status LIKE '%$status%' ";
			}
			$payment_method = FSInput::get('buy');
			if($payment_method!='')
			{
				$where .=  " AND payment_method LIKE '%$payment_method%' ";
			}
			
			$date_from = FSInput::get('date_from');
			$date_from1 = date("Y/m/d 00:00:00", strtotime($date_from) );
			$date_to = FSInput::get('date_to');
			$date_to1 = date("Y/m/d 23:59:59", strtotime($date_to) );
			$service = FSInput::get('service');
			if($date_from)
			{
				$where .=  " AND created_time >= '$date_from1' ";
			}
			if($date_to)
			{
				$where .=  " AND created_time <= '$date_to1' ";
			}
			
			$sql = "  SELECT a.* 
					FROM fs_order AS a
					WHERE 
					username = '$username'
					AND is_temporary = 0
					". $where ."
					ORDER BY id DESC
					";
			global $db ;
			$db->query($sql);
			return $db->getObjectList();
		}
		/*
		 * Lấy danh sách đơn hàng giới thiệu của chính CTV này
		 */
		function get_orders_intro($my = 0,$str_member_id = '')
		{
			// my == 1: đơn hàng tôi giới thiệu . my == 0: đơn hàng thành viên cấp dưới giới thiệu 
			$user_id = FSInput::get('id',0,'int');
			$where = ' ';
			if($my){
				$where .=  " AND boss_id = ".$user_id." ";
			}else{
				if(!$str_member_id)
					$where .=  " AND 1 = 0 ";
				else 
					$where .=  " AND boss_id IN (".$str_member_id.")";
			}
			$pay_for_boss = FSInput::get('pay_for_boss',0,'int');
			if($pay_for_boss){
				if($pay_for_boss == 1){ 
					$where .=  " AND payment_for_boss = 0 ";
				}elseif($pay_for_boss == 2){ // đã thanh toán
					$where .=  " AND payment_for_boss = 1 ";
				}
			}
			$status = FSInput::get('display');
			if($status!='')
			{
				$where .=  " AND status LIKE '%$status%' ";
			}
			$payment_method = FSInput::get('buy');
			if($payment_method!='')
			{
				$where .=  " AND payment_method LIKE '%$payment_method%' ";
			}
			
			$date_from = FSInput::get('date_from');
			$date_from1 = date("Y/m/d 00:00:00", strtotime($date_from) );
			$date_to = FSInput::get('date_to');
			$date_to1 = date("Y/m/d 23:59:59", strtotime($date_to) );
			$service = FSInput::get('service');
			if($date_from)
			{
				$where .=  " AND created_time >= '$date_from1' ";
			}
			if($date_to)
			{
				$where .=  " AND created_time <= '$date_to1' ";
			}
			
			
			$query_body = "  
					FROM fs_order AS a
					WHERE is_temporary = 0
					". $where ."
					";
			$query = ' SELECT a.*  '.$query_body.' ORDER BY id DESC ';
			global $db;
				
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		function get_children_members(){
			$user_id = FSInput::get('id',0,'int');
			if(!$user_id)
				return;
			return $this -> get_records('introduce_id = '.$user_id.' ','fs_members','*',null,null,'id');
		}
	}
	
	
?>