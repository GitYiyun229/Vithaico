<?php 
	class ProductsModelsComments_categories extends FSModels{
	
		var $limit;
		var $prefix ;
	function __construct() {
			$this -> limit = 20;
			$this -> view = 'comments_categories';
			$this -> table_name = 'fs_products_categories';
			// $this -> table_category_name = 'fs_products_categories';
			parent::__construct();
		}
		
		function setQuery(){
			
			// ordering
			$ordering = "";
			$where = "  ";
		// id bài viết
		if (isset ( $_SESSION [$this->prefix . 'text0'] )) {
			$search_record_id = $_SESSION [$this->prefix . 'text0'];
			if ($search_record_id) {
				$where .= ' AND a.id =   "' . $search_record_id . '" ';
			}
		}
		
		if (isset ( $_SESSION [$this->prefix . 'sort_field'] )) {
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
			
		// category
		if (isset ( $_SESSION [$this->prefix . 'filter0'] )) {
			$filter = $_SESSION [$this->prefix . 'filter0'];
			if ($filter) {
				$where .= ' AND a.category_id_wrapper like  "%,' . $filter . ',%" ';
			}
		}
		// type comment: 1=>'Comment đã hiển thị',2=>'Comment chưa hiển thị',3=>'Comment chưa đọc'
		if (isset ( $_SESSION [$this->prefix . 'filter1'] )) {
			$filter = $_SESSION [$this->prefix . 'filter1'];
			if ($filter) {
				if($filter == 1){
					$where .= ' AND comments_published > 0';	
				}else if($filter == 2){
					$where .= ' AND (comments_total - comments_published) > 0';
				}else if($filter == 3){
					$where .= ' AND comments_unread > 0';
				}
			}
		}
		
//		if (isset ( $_SESSION [$this->prefix . 'filter1'] )) {
//			$filter = $_SESSION [$this->prefix . 'filter1'];
//			if ($filter) {
//				$where .= ' AND a.type =   "' . $filter . '" ';
//			}
//		}
		
		if (! $ordering)
			$ordering .= " ORDER BY comments_last_time DESC, created_time DESC , id DESC ";
		
		if (isset ( $_SESSION [$this->prefix . 'keysearch'] )) {
			if ($_SESSION [$this->prefix . 'keysearch']) {
				$keysearch = $_SESSION [$this->prefix . 'keysearch'];
				$where .= " AND a.name LIKE '%" . $keysearch . "%' ";
			}
		}
		
		$query = " SELECT a.*
						  FROM 
						  	" . $this->table_name . " AS a
						  	WHERE 1=1 AND comments_total > 0" . $where . $ordering . " ";
		return $query;
	}
	
	
	function save($row = array(),$use_mysql_real_escape_string = 0) {
		return;
	}
	
	function get_comments_by_product($product_id) {
		global $db;
		if (! $product_id)
			return;
		$type = FSInput::get('type',0,'int');
		$where = 	' WHERE product_id = '.$product_id.' ';
		if($type == 1){
			$where .= ' AND published = 1';
		}else if($type == 2){
			$where .= ' AND published = 0';
		}
		
		$query = " SELECT name,created_time,id,email,phone,comment,parent_id, published,product_id,rating
						FROM fs_products_categories_comments
						$where
						ORDER BY  created_time  DESC
						";
		$db->query ( $query );
		$result = $db->getObjectList ();
		$tree = FSFactory::getClass ( 'tree', 'tree/' );
		$list = $tree->indentRows2 ( $result );
		return $list;
	}
	
	function ajax_published($published = 1) {
		$id = FSInput::get ( 'id', 0, 'int' );
		$product_id = FSInput::get ( 'product_id', 0, 'int' );
		if (! $id || ! $product_id) {
			echo 0;
			return;
		}
		
		$row ['published'] = $published;
		$rs = $this->_update ( $row, 'fs_products_categories_comments', 'id = ' . $id . ' AND product_id =  ' . $product_id . ' ' );
		echo $rs ? 1 : 0;
		if ($rs) {
			$this->recal_comments ( $product_id );
		}
		return;
	}
	function ajax_del() {
		$id = FSInput::get ( 'id', 0, 'int' );
		$product_id = FSInput::get ( 'product_id', 0, 'int' );
		if (! $id || ! $product_id) {
			echo 0;
			return;
		}
		
		$rs = $this->_remove ( 'id = ' . $id . ' AND product_id =  ' . $product_id . ' ', 'fs_products_categories_comments' );
		echo $rs ? 1 : 0;
		if ($rs) {
			$this->recal_comments ( $product_id );
		}
		return;
	}
	
	function recal_comments($product_id) {
		$list = $this->get_records ( 'product_id = ' . $product_id, 'fs_products_categories_comments', 'id,published' );
		$total_published = 0;
		foreach ( $list as $item ) {
			if ($item->published == 1) {
				$total_published ++;
			}
		}
		$row ['comments_published'] = $total_published;
		$row ['comments_unread'] = 0;
		$row ['comments_total'] = count ( $list );
		$rs = $this->_update ( $row, 'fs_products_categories', 'id = ' . $product_id . ' ' );
		return $rs;
	}
	function update_unread_for_comments($product_id) {
		$row ['readed'] = 1;
		$this->_update ( $row, 'fs_products_categories_comments', 'product_id = ' . $product_id );
		
		$row2 ['comments_unread'] = 0;
		$this->_update ( $row2, 'fs_products_categories', 'id = ' . $product_id . ' ' );
		return;
	}
	
	function save_comment() {
		$name = FSInput::get ( 'name' );
		$text = FSInput::get ( 'text' );
		$product_id = FSInput::get ( 'product_id', 0, 'int' );
		$parent_id = FSInput::get ( 'parent_id', 0, 'int' );
		if (! $name ||  ! $text || ! $product_id){
			echo 0;
			return false;
		}
			
		$time = date ( 'Y-m-d H:i:s' );	
		$row ['name'] = $name;
		$row ['email'] = $_SESSION['ad_useremail'];
		$row ['comment'] = $text;
		$row ['product_id'] = $product_id;
		$row ['parent_id'] = $parent_id;
		$row ['published'] = 1;
		$row ['readed'] = 1;
		$row ['created_time'] = $time;
		$row ['edited_time'] = $time;
		
		$rs = $this -> _add($row, 'fs_products_categories_comments');
		echo $rs?1:0;
		if ($rs)
			$this->recal_comments ( $product_id );
		return $rs;
	}
	
	function edit_comment() {
		$text = FSInput::get ( 'text' );
		$product_id = FSInput::get ( 'product_id', 0, 'int' );
		$comment_id = FSInput::get ( 'comment_id', 0, 'int' );
		$parent_id = FSInput::get ( 'comment_id', 0, 'int' );
		if (!$text || !$product_id){
			echo 0;
			return false;
		}
			
		$time = date ( 'Y-m-d H:i:s' );	
//		$row ['name'] = $name;
//		$row ['email'] = $_SESSION['cms_useremail'];
		$row ['comment'] = $text;
		$row ['product_id'] = $product_id;
//		$row ['parent_id'] = $parent_id;
//		$row ['published'] = 1;
//		$row ['readed'] = 1;
//		$row ['created_time'] = $time;
		$row ['edited_time'] = $time;
		
		$rs = $this -> _update($row, 'fs_products_categories_comments',' id = '.$comment_id);
		echo $rs?1:0;
		if ($rs)
			$this->recal_comments ( $product_id );
		return $rs;
	}
}
?>
