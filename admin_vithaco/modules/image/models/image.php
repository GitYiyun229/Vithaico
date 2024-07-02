<?php 

	class ImageModelsImage extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this->view = 'images';
            $this->type = 'image';
			$this -> table_name = FSTable_ad::_('fs_image');
            $this-> table_name_img = FSTable_ad::_('fs_image_images');
			$this -> arr_img_paths = array(
                                            array('resized',286,142,'cut_image'),
                                            array('small',120,74,'cut_image'),
                                            //array('large',816,542,'cut_image')
                                        );
			// config for save
			$cyear = date('Y');
			$cmonth = date('m');
			$cday = date('d');
			$this -> img_folder = 'images/image/'.$cyear.'/'.$cmonth.'/'.$cday;
			//$this -> video_folder = 'images/image/videos/'.$cyear.'/'.$cmonth.'/'.$cday;
			$this -> check_alias = 0;
			$this -> field_img = 'image';
			
			parent::__construct();
		}


		function load_params() {
    		$module_params = $this->get_params ( 'libraries', 'image' );
    		if ($module_params) { // params from fs_config_modules
    			$this->module_params = $module_params;
    			$arr_img_paths = array ();
    			$arr_img_paths_other = array ();
    			
    			FSFactory::include_class ( 'parameters' );
    			$current_parameters = new Parameters ( $module_params );
    			// large size
    			$image_large_size = $current_parameters->getParams ( 'image_large_size' );
    			$image_large_method = $current_parameters->getParams ( 'image_large_method' );
    			if (! $image_large_method)
    				$image_large_method = 'resize_image'; // giữ nguyên dạng ảnh, thêm khoảng trắng
    			$image_large_width = $this->get_dimension ( $image_large_size, 'width' );
    			$image_large_height = $this->get_dimension ( $image_large_size, 'height' );
    			if (! $image_large_width && ! $image_large_height) {
    				$image_large_width = 374;
    				$image_large_height = 380;
    			}
                            
    			$arr_img_paths [] = array ('large', $image_large_width, $image_large_height, $image_large_method );
    			$arr_img_paths_other [] = array ('large', $image_large_width, $image_large_height, $image_large_method );
    			
    			// resized: ảnh đại diện trong trang danh sách
    			$image_resized_size = $current_parameters->getParams ( 'image_resized_size' );
    			$image_resized_method = $current_parameters->getParams ( 'image_resized_method' );
    			if (! $image_resized_method)
    				$image_resized_method = 'resize_image'; // giữ nguyên dạng ảnh, thêm khoảng trắng
    			
    
    			$image_resized_width = $this->get_dimension ( $image_resized_size, 'width' );
    			$image_resized_height = $this->get_dimension ( $image_resized_size, 'height' );
    			if (! $image_resized_width && ! $image_resized_height) {
    				$image_resized_width = 204;
    				$image_resized_height = 190;
    			}
    			$arr_img_paths [] = array ('resized', $image_resized_width, $image_resized_height, $image_resized_method );
                            $arr_img_paths_other [] = array ('resized', $image_resized_width, $image_resized_height, $image_resized_method );
    			
    			// small: ảnh nhỏ làm slideshow
    			$image_small_size = $current_parameters->getParams ( 'image_small_size' );
    			$image_small_method = $current_parameters->getParams ( 'image_small_method' );
    			if (! $image_small_method)
    				$image_small_method = 'resize_image'; // giữ nguyên dạng ảnh, thêm khoảng trắng
    			$image_small_width = $this->get_dimension ( $image_small_size, 'width' );
    			$image_small_height = $this->get_dimension ( $image_small_size, 'height' );
    //                        echo $image_small_width; die;
    			if ($image_small_width || $image_small_height) {
    				$arr_img_paths [] = array ('small', $image_small_width, $image_small_height, $image_small_method );
    				$arr_img_paths_other [] = array ('small', $image_small_width, $image_small_height, $image_small_method );
    			}
    			$this->arr_img_paths = $arr_img_paths;
    			$this->arr_img_paths_other = $arr_img_paths_other;
                            
    		} else {
    			// default
    			$this->arr_img_paths = array (array ('large', 374, 380, 'resize_image' ), array ('resized', 191, 143, 'cut_image' ), array ('small', 47, 35, 'resize_image' ) );
    			$this->arr_img_paths_other = array (array ('large', 817, 543, 'resize_image' ), array ('resized', 163, 122, 'cut_image'  ), array ('small', 101, 67, 'resize_image' ) );
    		}
    	}
        
        function get_dimension($size, $dimension = 'width') {
    		if (! $size)
    			return 0;
    		$array = explode ( 'x', $size );
    		if ($dimension == 'width') {
    			return (intval ( @$array [0] ));
    		} else {
    			return (intval ( @$array [1] ));
    		}
    	}
        function get_params($module, $view, $task = '') {
		
    		$where = '';
    		$where .= 'module = "' . $module . '" AND view = "' . $view . '"';
    		if ($task == 'display' || ! $task) {
    			$where .= ' AND ( task = "display" OR task = "" OR task IS NULL)';
    		} else {
    			$where .= ' AND task = "' . $task . '" ';
    		}
    		
    		$fstable = FSFactory::getClass ( 'fstable' );
    		global $db;
    		$sql = " SELECT params  FROM fs_config_modules
    				WHERE $where ";
    		$db->query ( $sql );
    		$rs = $db->getResult ();
    		return $rs;
    
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
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
            
            // estore
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$where .= ' AND a.category_id_wrapper like  "%,'.$filter.',%" ';
				}
			}	
            
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND  a.name LIKE '%".$keysearch."%' ";
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

        /*
		 * select in category of home
		 */
		function get_categories_tree()
		{
			global $db;
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_category_name." AS a
						  	WHERE published = 1 ORDER BY ordering ";         
			$sql = $db->query($query);
			$result = $db->getObjectList();
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($result);
			return $list;
		}
        
 	
	}
	
?>