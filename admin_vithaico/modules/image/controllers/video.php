<?php
	class ImageControllersVideo extends Controllers
	{
		function __construct()
		{
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data('');
			$config = $model -> get_all_config();
			$pagination = $model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
        function get_other_images(){
                $list_other_images = $this->model->get_other_images();   
                include 'modules/' . $this->module . '/views/' . $this->view . '/detail_images_list.php';
        } 
        /**
        * Upload nhiều ảnh cho sản phẩm
        */ 
        function upload_other_images(){
                $this->model->upload_other_images();
         }
         /**
         * Xóa ảnh
         */ 
         function delete_other_image(){
                $this->model->delete_other_image();
         }

         /**
         * Sắp xếp ảnh
         */
        function sort_other_images(){
                $this->model->sort_other_images();
        } 
        function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$data = $model->get_record_by_id($id);
			$config = $model -> get_all_config();
			//$data_ext = $model->getProductExt($data -> tablename,$data->id);
			
			
			// add hidden input tag : ext_id into detail form 
			//$this->params_form = array('ext_id'=>@$data_ext -> id) ;			
			$uploadConfig = base64_encode('edit|'.$id);			
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
        
        function is_hot()
    	{
    		$this->is_check('is_hot',1,'is_hot');
    	}
    	function unis_hot()
    	{
    		$this->unis_check('is_hot',0,'un_hot');
    	}
	}
?>