<?php

class UsersModelsGroups extends FSModels
{
    var $limit;
    var $page;

    function __construct()
    {
        parent::__construct();
        $limit = 30;
        $page = FSInput::get('page');
        $this->limit = $limit;
        $this->page = $page;
    }

    function setQuery()
    {
        $ordering = '';
        if (isset($_SESSION['usersgroup_sort_field'])) {
            $sort_field = $_SESSION['usersgroup_sort_field'];
            $sort_direct = $_SESSION['usersgroup_sort_direct'];
            $sort_direct = $sort_direct ? $sort_direct : 'asc';

            if ($sort_field)
                $ordering .= " ORDER BY $sort_field $sort_direct ";
        }

        $query = " 	   SELECT a.* 
						,(SELECT  count(*)  FROM fs_users_groups  as b WHERE a.id = b.groupid ) as num_user
						  FROM fs_groups AS a 
						  GROUP BY a.id
						 $ordering 
						 ";
        return $query;
    }


    function getUserGroups()
    {
        global $db;
        $query = $this->setQuery();
        $sql = $db->query_limit($query, $this->limit, $this->page);
        $result = $db->getObjectList();

        return $result;
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

    function getUserGroupById()
    {
        $cids = FSInput::get('id');
        if (!$cids)
            $cids = FSInput::get('cid');
        $cid = $cids ? $cids : 0;
        $query = " SELECT *
						  FROM fs_groups
						  WHERE id = $cid ";

        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function getModulePermission()
    {
        $cids = FSInput::get('cid', array(0), 'array');
        $cid = $cids[0];
        $query = " SELECT a.*,b.*,a.id as module_typeid ,  b.id as group_permission_id
					 FROM fs_modules_admin AS a
						LEFT JOIN fs_groups_permission AS b ON a.id = b.module_type_id 
						AND b.group_id = $cid 
					WHERE a.published = 1";

        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    /*
     * Save
     */
    function save()
    {
        $cid = $this->save_into_groups();
        // if ($cid) 
        //     if ($this->save_into_group_permission($cid))
        //         return $cid;


        if ($cid) {
            $this->save_into_group_permission($cid);

            /**
             * new
             */
            $user = $this->get_records("groupid = $cid", "fs_users_groups");
            $userId = array_map(function($item) {
                return $item->userid;
            }, $user);
            $groupPermisstion = $this->get_records("group_id = $cid AND permission > 0", "fs_groups_permission");
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

            foreach ($userId as $user) {
                $this->_remove("user_id = $user", "fs_users_permission_fun");
                foreach ($groupPermisstion as $item) {
                    if ($item->permission && $item->moduleName && $item->viewName) {
                        $viewName = explode(',', $item->viewName);
                        foreach ($viewName as $view) {
                            $this->_add([
                                "user_id" => $user,
                                "module" => $item->moduleName,
                                "view" => $view,
                                "list_field" => $item->permission >= 7 ? ",add,edit,remove,published,unpublished,apply,save_add,duplicate,back," : ",add,edit,published,unpublished,apply,save_add,duplicate,back,",
                            ], "fs_users_permission_fun");
                        }               
                    }                       
                }
            }

            return $cid;
        }

        return false;

    }

    /*
     * Save into tble fs_groups
     */
    function save_into_groups()
    {
        global $db;
        $group_name = FSInput::get('group_name');
        if (!$group_name) {
            Errors::_('B&#7841;n ph&#7843;i nh&#7853;p groupname');
            return false;
        }
        $published = FSInput::get('published');
        $ordering = FSInput::get('ordering');
        $time = gmdate('Y-m-d H:i:s');
        $updated_time = FSInput::get('updated_time');
        $edit_other = FSInput::get('edit_other');
        $cid = FSInput::get('cid');

        if (@$cid) {
            $sql = " UPDATE  fs_groups SET 
							group_name = '$group_name',
							published = '$published',
							ordering = '$ordering',
							created_time = '$time',
							updated_time = '$time',
							edit_other = '$edit_other'
							
						WHERE id = 	$cid 
				";
            $db->query($sql);
            $rows = $db->affected_rows();
            if ($rows) {
                return $cid;
            }
            return 1;
        } else {
            $sql = " INSERT INTO fs_groups 
							(group_name,published,ordering,created_time,updated_time,edit_other)
							VALUES ('$group_name','$published','$ordering','$time','$time','$edit_other')
							";
            $db->query($sql);
            $cid = $db->insert();
            return $cid;
        }

    }

    /*
     * save into table : fs_group_permission
     *
     */
    function save_into_group_permission($cid = 0)
    {
        // array module_type list.
        $modulelist = FSInput::get('modulelist');
        $array_modulelist = explode(",", $modulelist);

        global $db;
        foreach ($array_modulelist as $module_type_id) {

            $permission_arr = FSInput::get("per_$module_type_id", array(), 'array');

            $per = 0;
            if (count($permission_arr)) {
                for ($i = 0; $i < count($permission_arr); $i++)
                    $per = max($per, $permission_arr[$i]);
            }
            $sql = " SELECT id FROM fs_groups_permission 
						WHERE group_id = $cid 
						AND module_type_id = $module_type_id ";
            $db->query($sql);
            $id = $db->getResult();

            if (!$id) {
                $sql_insert = "  INSERT INTO fs_groups_permission 
							(group_id,module_type_id,permission)
							VALUES ('$cid','$module_type_id','$per' ) ";
                $db->query($sql_insert);
                $id = $db->insert();
                if (!$id)
                    return 0;
            } else {
                $sql_update = " UPDATE  fs_groups_permission
									 SET permission = '$per'
								 		WHERE id = $id ";
                $rows = $db->affected_rows();
                $db->query($sql_update);
            }

        }

        $sql_mnu1 = "UPDATE fs_menus_admin SET group_id = REPLACE(group_id,',$cid','')";
        $sql_mnu2 = "UPDATE fs_menus_admin SET group_id = CONCAT(group_id, ',$cid')
                        WHERE FIND_IN_SET(module_type_id,(
                          SELECT GROUP_CONCAT(module_type_id) FROM fs_groups_permission
                          WHERE group_id = $cid AND permission > 0
                        ))";
       //echo $sql_mnu2;die;
        $db->query($sql_mnu1);
        $db->query($sql_mnu2);
        return true;
    }

    /*
     * remove record
     */
    function remove()
    {
        $ids = FSInput::get('cid', array(), 'array');
        $str_cids = '';
        $i = 0;
        if (!count($ids))
            return false;
        foreach ($ids as $cid) {

            if ($cid != 1) {
                if ($i > 0)
                    $str_cids .= ',';
                $str_cids .= $cid;
                $i++;
            }

        }
        if (!$str_cids)
            return false;

        global $db;
        // not del in table users_admin because user use multi groups.

        // delete group in table users_group
        $sql_group_user = " DELETE FROM fs_users_groups  WHERE groupid IN ( $str_cids ) ";
        $db->query($sql_group_user);
        $db->affected_rows();

        // delete permission in this group
        $sql_permission = " DELETE FROM fs_groups_permission 
								WHERE group_id IN ( $str_cids ) ";
        $db->query($sql_permission);
        $db->affected_rows();


        // del from fs_groups
        $sql = " DELETE FROM fs_groups 
						WHERE id IN ( $str_cids ) ";
        $db->query($sql);
        $rows = $db->affected_rows();


        return $rows;


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
            $sql = " UPDATE fs_groups
							SET published = $value
						WHERE id IN ( $str_cids ) ";
            $db->query($sql);
            $rows = $db->affected_rows();
            return $rows;
        }
        return 0;

    }

}

?>