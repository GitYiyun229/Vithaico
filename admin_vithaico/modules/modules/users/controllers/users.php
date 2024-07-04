<?php
	// models 
	class UsersControllersUsers extends Controllers 
	{
		var $module;
		var $gid;
		function __construct()
		{
//			$module = 'users';
			$this->view = 'users';
			parent::__construct(); 
			$this->gid = FSInput::get('gid');
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
//			$select_cat = FSInput::get('select_cat');
			
			$model  = $this -> model;
			$list = $model->get_data('');
			
			// call views
			$pagination = $model->getPagination('');
			include 'modules/'.$this->module.'/views/users/list.php';
		}
		
		
		function add()
		{
			$model = $this -> model;
			$maxOrdering = $model->getMaxOrdering();
            //$list = $model->get_data();
	//		$groups_all = $model->getUserGroupsAll();
			include 'modules/'.$this->module.'/views/users/detail.php';
		}
		function edit()
		{
			$cds = FSInput::get('id',array(),'array');
			$cid = $cds[0];
			$model = $this -> model;
			$data = $model->get_record_by_id($cid);
	//		$groups_all = $model->getUserGroupsAll();
	//		$groups_contain_user = $model->getUserGroupsByUser();
			include 'modules/'.$this->module.'/views/users/detail.php';
		}
		
		function save()
		{
			$model = $this -> model;
			$id = FSInput::get('id');
			if(!$id){
				if($model->check_exits_email()){
					setRedirect('index.php?module=users&view=users',FSText :: _('Email này đã có người sử dụng'),'error');	
				}
				if($model->check_exits_username()){
					setRedirect('index.php?module=users&view=users',FSText :: _('Username này đã có người sử dụng'),'error');	
				}
			}
			// check password and repass
			$password = FSInput::get("password1");
			$repass = FSInput::get("re-password1");
            
			if(@$id)
			{
				$edit_pass = FSInput::get('edit_pass');
				if($edit_pass){
					if(!$password || ($password != $repass))
					{
						setRedirect('index.php?module=users&view=users',FSText :: _('You must enter a valid password'),'error');
					}
				}
			}
			else
			{
				if(!$password || ($password != $repass))
					setRedirect('index.php?module=users&view=users',FSText :: _('You must enter a valid password'),'error');	
			}
			
			// call Models to save
			$cid = $model->save();
			
			if($cid)
			{
				setRedirect('index.php?module=users&view=users&cid='.$cid,FSText :: _('Saved'));	
			}
			else
			{
				setRedirect('index.php?module=users&view=users',FSText :: _('Not save'),'error');	
			}
			
		}
		
		
		/*********************************** CREATE LINK *********************************/

		function linked()
		{
			$model = $this -> model;
			$linked_list = $model->getCreateLink();
			$parent_list = $model->getParentLink();
			
			$cid = FSInput::get('cid');
			if($cid)
			{
				$linked = $model -> getLinkedById($cid);
			}
			include 'modules/'.$this->module.'/views/users/linked.php';
			
		}
		/*********************************** end CREATE LINK *********************************/

		
		/*********************************** PERMISSION *********************************/

	function permission_save() {
		$model = $this->model;

		$id = FSInput::get('id',0,'int');
		$link = "index.php?module=users&view=users&task=permission&cid=".$id."" ;
		$rs = $model->permission_save ($id);
		
		// if not save
		if ($rs) {
			setRedirect ( $link, 'Đã lưu thành công' );
		} else {
			setRedirect ( $link, 'Bạn chưa lưu thành công', 'error' );
		}
	}
	function permission_apply() {
		$model = $this -> model;

		$id = FSInput::get('id',0,'int');
        
		$link =  'index.php?module=users&view=users&task=permission&cid='.$id ;
		$rs = $model->permission_save ($id);
		// if not save
		if ($rs) {
			setRedirect ( $link, 'Đã lưu thành công' );
		} else {
			setRedirect ( $link, 'Bạn chưa lưu thành công', 'error' );
		}
	}
	
	function permission(){
		$id = FSInput::get('cid');
        
        $link =  'index.php?module=users&view=users' ;     
		if(!$id || $id == 1 || $id==9){
			setRedirect($link, FSText::_('Không được quyền sửa user này') ,'error');
		}
		$model = $this -> model;
		$list_task = $model -> get_records('published = 1','fs_permission_tasks','*','ordering ASC, id ASC');
        
		$arr_task = array();
		foreach($list_task as $item){
			if(!isset($arr_task[$item -> module][$item -> view]))
				$arr_task[$item -> module][$item -> view] = array();
			$arr_task[$item -> module][$item -> view] = $item;	
		}
		
		// other
		$news_categories = $model->get_news_categories ();
		$products_categories = $model->get_products_categories ();
		
		$data = $model -> get_record_by_id($id,'fs_users');
        
		$list_permission = $model -> get_records(' user_id = '.$data -> id,'fs_users_permission','*','','','task_id');
		include 'modules/' . $this->module . '/views/' . $this->view . '/permission.php';
	}
    
    function display_page_fun(){
        $model = $this -> model;
        
        $n_module = FSInput::get('n_module');
        $n_view = FSInput::get('n_view');
        $user_id = FSInput::get('user_id',0,'int');
        if(!$n_module || !$n_view || !$user_id)
            return false;
        // list task phan quyen
        $task_fun = $model->get_record(' module = "'.$n_module.'" AND view = "'.$n_view.'"','fs_permission_tasks','list_function');

        // list fun phan quyen
        $list_field = $model->get_records(' published = 1 ','fs_permission_fun');

        // data save phan quyen
        $data = $model->get_record(' user_id = '.$user_id.' AND module = "'.$n_module.'" AND view = "'.$n_view.'" ','fs_users_permission_fun');
           
        include 'modules/' . $this->module . '/views/' . $this->view . '/display_page_fun.php';
    }
    
    function save_fun_permission(){
        $model = $this -> model;
        
        $n_module = FSInput::get('n_module');
        $n_view = FSInput::get('n_view');
        $user_id = FSInput::get('user_id',0,'int');
        
        if(!$n_module || !$n_view || !$user_id)
            setRedirect( 'index.php?module=users&view=users', 'lỗi,không có dữ liệu', 'error' );
            
        $link =  'index.php?module=users&view=users&task=permission&cid='.$user_id ;
		$rs = $model->save_fun_permission();
		// if not save
		if ($rs) {
			setRedirect ( $link, 'Đã lưu thành công' );
		} else {
			setRedirect ( $link, 'Bạn chưa lưu thành công', 'error' );
		}    
    }
    
    function display_page(){
        $model = $this -> model;
        
        $n_module = FSInput::get('n_module');
        $n_view = FSInput::get('n_view');
        $user_id = FSInput::get('user_id',0,'int');
        if(!$n_module || !$n_view || !$user_id)
            return false;
        
        
        
        $list_field = $model->get_records(' published = 1 AND module = "'.$n_module.'" AND view = "'.$n_view.'"','fs_permission_field');
        //if(!count($list_field))
//            return false;
        $data = $model->get_record(' user_id = '.$user_id.' AND module = "'.$n_module.'" AND view = "'.$n_view.'" ','fs_users_permission_field');
        
        include 'modules/' . $this->module . '/views/' . $this->view . '/display_page.php';
    }
    
    function save_field_permission(){
        $model = $this -> model;
        
        $n_module = FSInput::get('n_module');
        $n_view = FSInput::get('n_view');
        $user_id = FSInput::get('user_id',0,'int');
        
        if(!$n_module || !$n_view || !$user_id)
            setRedirect( 'index.php?module=users&view=users', 'lỗi,không có dữ liệu', 'error' );
            
        $link =  'index.php?module=users&view=users&task=permission&cid='.$user_id ;
		$rs = $model->save_field_permission();
		// if not save
		if ($rs) {
			setRedirect ( $link, 'Đã lưu thành công' );
		} else {
			setRedirect ( $link, 'Bạn chưa lưu thành công', 'error' );
		}    
    }
    
    function ajax_check_exist_email(){
		$model = $this -> model;
		if(!$model -> ajax_check_exits_email()){
			echo 0;
			return false;
		}
		echo 1;
		return true;
	}
    
    function ajax_check_exist_username(){
		$model = $this -> model;
		if(!$model -> ajax_check_exist_username()){
			echo 0;
			return false;
		}
		echo 1;
		return true;
	}
		
		/*********************************** end PERMISSION *********************************/		 
}
	
?>