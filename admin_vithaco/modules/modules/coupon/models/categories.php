<?php 
	class CouponModelsCategories extends ModelsCategories
	{
		function __construct()
		{
			
//			$this -> table_items = FSTable_ad::_('fs_news');
			$this -> table_name = FSTable_ad::_('fs_coupon_categories');
			$this -> check_alias = 1;
			$this -> call_update_sitemap = 1;

			// exception: key (field need change) => name ( key change follow this field)
			$this -> field_except_when_duplicate = array(array('list_parents','id'),array('alias_wrapper','alias'));
			// config for save
			$cyear = date('Y');
			$cmonth = date('m');
			//$cday = date('d');
			$this -> img_folder = 'images/coupon/cat/'.$cyear.'/'.$cmonth;
			$this -> field_img = 'image';
			parent::__construct();
			$this -> limit = 100;
            
           // $this -> array_synchronize = array($this -> table_items=>array('id'=>'category_id','alias'=>'category_alias','name'=>'category_name'
//                                                                            ,'published'=>'published_cate','alias_wrapper'=>'category_alias_wrapper'));
		}
        
	}
	
?>