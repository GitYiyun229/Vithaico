<?php 
	class ProductsModelsManufactor extends FSModels
	{
		function __construct()
		{
			$this -> limit = 20;
			
			$this -> table_items = FSTable_ad::_('fs_products');
			$this -> table_name = FSTable_ad::_('fs_products_manufactor');
			$this -> check_alias = 1;
			$this -> call_update_sitemap = 1;
			$this -> arr_img_paths = array(
						array('large',320,320,'resize_image'),
						array('small',100,100,'cut_image')
					);
            $this -> arr_img_paths_icon = array(
                array('large',200,200,'cut_image'),
                array('small',100,100,'cut_image'),

            );
            $this -> arr_img_paths_icon_hover = array(
                array('large',200,200,'cut_image'),
                array('small',100,100,'cut_image'),

            );
            $cyear = date('Y');
			$cmonth = date('m');
			$cday = date('d');
			$this -> img_folder = 'images/products/cat/'.$cyear.'/'.$cmonth;
			$this -> field_img = 'image';
			$this -> field_except_when_duplicate = array(array('list_parents','id'),array('alias_wrapper','alias'));
			parent::__construct();
		}
		function save($row = array(), $use_mysql_real_escape_string = 1){
			
			//$row['content'] = htmlspecialchars_decode(FSInput::get('content'));
            $id = FSInput::get('id',0,'int');
            $get_gift = $this->get_record_by_id($id,$this -> table_name);
            // print_r($get_gift);die;
            //echo $get_gift->user_id;die;

            // $row['summary'] = htmlspecialchars_decode(FSInput::get('summary'));

            $image_name = $_FILES["image"]["name"];
            if($image_name){
                $image = $this->upload_image('image','_'.time(),3000000,$this -> arr_img_paths);
                if($image){
                    $row['image'] = $image;
                }
            }
            $icon_name = $_FILES["icon"]["name"];
            if($icon_name){
                $icon = $this->upload_image('icon','_'.time(),3000000,$this -> arr_img_paths_icon);
                if($icon){
                    $row['icon'] = $icon;
                }
            }
            $icon_name_hover = $_FILES["avatar"]["name"];
            if($icon_name_hover){
                $icon_hover = $this->upload_image('avatar','_'.time(),3000000,$this -> arr_img_paths_icon_hover);
                if($icon_hover){
                    $row['avatar'] = $icon_hover;
                }
            }
            // $user_id = strpos($get_gift->user_id,$_SESSION['ad_userid']);
            // if($user_id == false){
            //     $row['user_id'] = $get_gift->user_id.','.$_SESSION['ad_userid'];
            // }else{
            //     $row['user_id'] = $get_gift->user_id;
            // }
            // print_r($row);die;
			return parent::save($row);
		}

	}
	
?>