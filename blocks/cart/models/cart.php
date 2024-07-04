<?php
class CartBModelsCart
{
  function set_query_body()
  {
    global $db, $user;
    $where_total = '';
    if ($user->userID) {
      $where_type = ' AND ';
      $where_type .= 'application = 0 AND (member like "%,' . $user->userID . ',%" OR `group` like "%,' . $user->userInfo->group_id . ',%")';

      $where_total .= $where_type;
    } else {
      $where_type = ' AND ';
      $where_type .= 'application = 1';
      $where_total .= $where_type;
    }

    $query = '';
    $query .= " FROM " . FSTable::_('fs_discount') . "
        WHERE published = 1 AND `limit` > `apply_limit` " . $where_total . " 
          ";
    // echo $query;die;
    return $query;
  }
  function get_list_discount($query_body)
  {
      $user = new FSUser();
      if (!$query_body)
          return;
      global $db;
      $query = "SELECT * ";
      $query .= $query_body;
      // echo $query;
      $db->query($query);
      $result = $db->getObjectList();
      return $result;
  }

  function get_records($where = '', $table_name = '', $select = '*', $ordering = '', $limit = '', $field_key = '')
  {
    $sql_where = " ";
    if ($where) {
      $sql_where .= ' WHERE ' . $where;
    }
    if (!$table_name)
      $table_name = $this->table_name;
    $query = " SELECT " . $select . "
					  FROM " . $table_name . $sql_where;

    if ($ordering)
      $query .= ' ORDER BY ' . $ordering;
    if ($limit)
      $query .= ' LIMIT ' . $limit;

    // echo $query;die;
    global $db;
    $sql = $db->query($query);
    if (!$field_key)
      $result = $db->getObjectList();
    else
      $result = $db->getObjectListByKey($field_key);
    return $result;
  }
  function get_record($where = '', $table_name = '', $select = '*')
	{
		if (!$where)
			return;
		if (!$table_name)
			$table_name = $this->table_name;
		$query = " SELECT " . $select . "
					  FROM " . $table_name . "
					  WHERE " . $where;

		global $db;
		$db->query($query);
		// echo $query;
		$result = $db->getObject();
		return $result;
	}
}
