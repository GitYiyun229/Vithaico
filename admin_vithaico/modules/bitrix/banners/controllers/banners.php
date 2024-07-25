<?php
class BannersControllersBanners  extends Controllers
{
	function __construct()
	{

		$array_type = array(1 => 'Image', 2 => 'Flash', 3 => 'HTML', 4 => 'Image && HTML');
		$this->array_type = $array_type;
		$this->view = 'banners';
		parent::__construct();
	}
	function display()
	{
		parent::display();
		$sort_field = $this->sort_field;
		$sort_direct = $this->sort_direct;

		$model  = $this->model;
		$list = $model->get_data('');

		$categories = $model->get_all_record('fs_banners_categories');
		$pagination = $model->getPagination('');
		include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
	}
	function add()
	{
		$model = $this->model;
		$create_link = $model->getCreateLinks();
		$menus_items_all = $model->getMenuItems();
		$categories = $model->get_all_record('fs_banners_categories');
		$maxOrdering = $model->getMaxOrdering();
		$array_type = $this->array_type;
		$news_categories = $model->get_news_categories();
		$products_categories = $model->get_products_categories();
		$contents_categories = $model->get_contents_categories();
		include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
	}

	function edit()
	{
		$ids = FSInput::get('id', array(), 'array');
		$id = $ids[0];
		$model = $this->model;
		$create_link = $model->getCreateLinks();
		$menus_items_all = $model->getMenuItems();
		$news_categories = $model->get_news_categories();
		$products_categories = $model->get_products_categories();
		$contents_categories = $model->get_contents_categories();
		$categories = $model->get_all_record('fs_banners_categories');
		$data = $model->get_record_by_id($id);
		$array_type = $this->array_type;
		include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
	}
	/*********************************** CREATE LINK *********************************/

	function add_param()
	{
		$model  = $this->model;
		$created_link  = $model->get_linked_id();
		if (!$created_link)
			return;

		$field_display  = $created_link->add_field_display;
		$field_value  = $created_link->add_field_value;
		$add_param  = $created_link->add_parameter;

		// create array if add multi param
		$arr_field_value = explode(',', $field_value);
		$arr_add_param = explode(',', $add_param);


		$list = $model->get_data_from_table($created_link->add_table, $field_display, $field_value, $created_link->add_field_distinct);
		$pagination = $model->get_pagination_create_link($created_link->add_table, $field_display, $field_value, $created_link->add_field_distinct);
		include 'modules/' . $this->module . '/views/items/add_param.php';
	}
	//		function linked()F
	//		{
	//			$model = new MenusModelsItems();
	//			$linked_list = $model->getCreateLink();
	//			$parent_list = $model->getParentLink();
	//
	//			$cid = FSInput::get('cid');
	//			if($cid)
	//			{
	//				$linked = $model -> getLinkedById($cid);
	//			}
	//			include 'modules/'.$this->module.'/views/items/linked.php';
	//
	//		}
	/*********************************** end CREATE LINK *********************************/
}
