<?php
class UsersModelsUsers extends FSModels
{
	var $limit;
	var $page;
	function __construct()
	{
		parent::__construct();
		$limit = 50;
		$page = FSInput::get('page');
		$this->limit = $limit;
		$this->page = $page;
	}

	function getUserList()
	{
		global $db;
		$query = $this->setQuery();
		$sql = $db->query_limit($query, $this->limit, $this->page);
		$result = $db->getObjectList();

		return $result;
	}
	/*
		 * select group_id list contain this user
		 */
	function getUserGroupsByUser()
	{
		$cids = FSInput::get('cid', array(), 'array');
		$cid = $cids[0] ? $cids[0] : 0;
		global $db;
		$query = " SELECT groupid 
						FROM fs_users_groups 
						WHERE userid = $cid ";
		$sql = $db->query($query);
		$list = $db->getObjectList();

		$arr_result = array();
		if ($list)
			foreach ($list as $item) {
				$arr_result[] = $item->groupid;
			}
		return $arr_result;
	}

	/*
		 * select all group in table fs_group
		 */
	function getUserGroupsAll()
	{
		global $db;
		$query = " SELECT group_name, id 
						FROM fs_groups ";
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}


	function setQuery()
	{
		// ordering
		$ordering = "";
		if (isset($_SESSION['users_users_sort_field'])) {
			$sort_field = $_SESSION['users_users_sort_field'];
			$sort_direct = $_SESSION['users_users_sort_direct'];
			$sort_direct = $sort_direct ? $sort_direct : 'asc';
			$ordering = '';
			if ($sort_field)
				$ordering .= " ORDER BY $sort_field $sort_direct ";
		}

		$where = ' WHERE 1=1 ';
		if (isset($_SESSION['ss_usr_keysearch'])) {
			if ($_SESSION['ss_usr_keysearch']) {
				$keysearch = $_SESSION['ss_usr_keysearch'];
				$where .= " AND username LIKE '%" . $keysearch . "%' ";
			}
		}

		if (isset($_SESSION['ss_usr_group'])) {
			if ($_SESSION['ss_usr_group']) {
				$groupid = $_SESSION['ss_usr_group'];
				global $db;
				$query_group = " SELECT userid 
							FROM fs_users_groups
							WHERE groupid = $groupid ";
				$db->query($query_group);
				$list_userid = $db->getObjectList();
				$str_ids = '';
				for ($i = 0; $i < count($list_userid); $i++) {
					if ($i > 0)
						$str_ids .= ',';
					$str_ids .=  $list_userid[$i]->userid;
				}

				if ($str_ids)
					$where .= ' AND id IN (' . $str_ids . ') ';
			}
		}

		$query = " SELECT *
						  FROM fs_users
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
		$pagination = new Pagination($this->limit, $total, $this->page);
		return $pagination;
	}



	/*
		 * Select User by Id
		 */
	function getUserById()
	{
		$cids = FSInput::get('cid', array(), 'array');
		$cid = isset($cids[0]) ? $cids[0] : 0;
		$query = " SELECT *
						  FROM fs_users
						  WHERE id = $cid ";

		global $db;
		$sql = $db->query($query);
		$result = $db->getObject();
		return $result;
	}

	/*
		 * Save
		 */
	function save()
	{
		$cid = $this->save_into_users();
		if ($cid) {
			$this->save_into_users_groups($cid);

			/**
             * new
             */
            $user = $this->get_records("userid = $cid", "fs_users_groups");
            $groupid = array_map(function($item) {
                return $item->groupid;
            }, $user);
            $groupPermisstion = $this->get_records("group_id IN (".implode(",", $groupid).") AND permission > 0", "fs_groups_permission");
            $moduleId = array_map(function($item) {
                return $item->module_type_id;
            }, $groupPermisstion);
            $moduleAdmin = $this->get_records("id IN(".implode(",", $moduleId).") AND published = 1 AND view_type IS NOT NULL AND view_type != ''", "fs_modules_admin");

            foreach ($groupPermisstion as $item) {
                $item->moduleName = '';
                $item->viewName = '';
                foreach ($moduleAdmin as $module) {
                    if ($item->module_type_id == $module->id) { 
                        $item->moduleName = $module->module_type;
                        $item->viewName = $module->view_type;
                    }
                }
            }
         
			$this->_remove("user_id = $cid", "fs_users_permission_fun");
			foreach ($groupPermisstion as $item) {
				if ($item->permission && $item->moduleName && $item->viewName) {
					$viewName = explode(',', $item->viewName);
					foreach ($viewName as $view) {
						$this->_add([
							"user_id" => $cid,
							"module" => $item->moduleName,
							"view" => $view,
							"list_field" => $item->permission >= 7 ? ",add,edit,remove,published,unpublished,apply,save_add,duplicate,back," : ",add,edit,published,unpublished,apply,save_add,duplicate,back,",
						], "fs_users_permission_fun");
					}               
				}                       
			}
             

			return $cid;
		}

		return false;
	}

	/*
		 * check exits User
		 */
	function checkExistUser()
	{
		global $db;
		$email = FSInput::get('email');
		$username = FSInput::get('username');
	}

	function save_into_users()
	{
		global $db;
		$username = FSInput::get('username');
		$password = FSInput::get('password');
		$fname = FSInput::get('fname');
		$lname = FSInput::get('lname');
		$lname = FSInput::get('lname');
		$email = FSInput::get('email');
		$phone = FSInput::get('phone');
		$address = FSInput::get('address');
		$country = FSInput::get('country');
		$published = FSInput::get('published');
		$ordering = FSInput::get('ordering');
		$time = gmdate('Y-m-d H:i:s');

		$id = FSInput::get('id');

		if (@$id) {
			if ($password != '') {
				$password = md5(FSInput::get('password'));
				$repass = md5(FSInput::get('repass'));
				if ($password != $repass)
					return false;
				$sql_set = "password = '$password',";
			} else {
				$sql_set = "";
			}
			$sql = " UPDATE  fs_users SET 
							username = '$username'," .
				$sql_set .
				"fname  = '$fname',
							lname  = '$lname',
							email  = '$email',
							phone  = '$phone',
							address  = '$address',
							country = '$country',
							published  = '$published',
							ordering  = '$ordering',
							updated_time = '$time'
						WHERE id = 	$id 
				";
			$db->query($sql);
			$rows = $db->affected_rows();

			return $id;
		} else {
			// if (!$password || ($password != $repass))
			// 	return false;

			$sql = " INSERT INTO fs_users
							(`username`,`password`,fname,lname,email,phone,address,country,published,ordering,updated_time,created_time)
							VALUES ('$username','$password','$fname','$lname','$email','$phone','$address','$country','$published','$ordering','$time','$time')
							";
			$db->query($sql);
			$id = $db->insert();
			return $id;
		}
	}

	/*
		 * Save into tble_users_groups
		 * @id: id of user
		 */
	function save_into_users_groups($id)
	{

		if ($id) {
			global $db;
			//	remove before save
			$sql = " DELETE FROM fs_users_groups
						WHERE userid = $id ";

			$db->query($sql);
			$rows = $db->affected_rows();

			$group_ids =  FSInput::get('group_ids', array(), 'array');
			if (@$group_ids) {
				foreach ($group_ids as $groupid) {

					// save
					$sql = " INSERT INTO fs_users_groups
									(`userid`,`groupid`)
									VALUES ('$id','$groupid')
									";

					$db->query($sql);
					//						$id = $db->insert();
				}
			}
			return $id;
		}
	}
	/*
		 * remove record
		 */
	function remove()
	{
		$cids = FSInput::get('cid', array(), 'array');

		if (count($cids)) {
			global $db;
			$str_cids = implode(',', $cids);
			$sql = " DELETE FROM fs_users
						WHERE id IN ( $str_cids ) ";
			$db->query($sql);
			$rows = $db->affected_rows();
			return $rows;
		}
		return 0;
	}
	/*
		 * value: == 1 :published
		 * value  == 0 :unpublished
		 * published record
		 */
	function published($value)
	{
		$cids = FSInput::get('cid', array(), 'array');

		if (count($cids)) {
			global $db;
			$str_cids = implode(',', $cids);
			$sql = " UPDATE fs_users
							SET published = $value
						WHERE id IN ( $str_cids ) ";
			$db->query($sql);
			$rows = $db->affected_rows();
			return $rows;
		}
		return 0;
	}
}
