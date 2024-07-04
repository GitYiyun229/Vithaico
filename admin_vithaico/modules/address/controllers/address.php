<?php
	class AddressControllersAddress extends Controllers
	{
		function __construct()
		{
			$this->view = 'address' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data('');
            $province = $model->get_categories_tree2();
            $cities = $model-> get_records('published = 1','fs_cities','id,name');
            $district = $model-> get_records('published = 1','fs_districts','id,name');
            $is_atm = array(
                '1'=>'ATM',
                '2'=>'Phòng giao dịch',
            );
			$pagination = $model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
        function add()
        {
            $model = $this->model;
            $dataCity = $model->get_city();
            $cities = $model-> get_records('published = 1','fs_local_cities','id,name');
            $district = $model-> get_records('published = 1','fs_local_districts','id,name');
            include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
        }

        function edit()
        {
            $id = FSInput::get('id');
            $model = $this->model;
            $data = $model->get_record_by_id($id);
            $cities = $model-> get_records('published = 1','fs_local_cities','id,name');
            $district = $model-> get_records('published = 1','fs_local_districts','id,name');
            $dataCity = $model->get_city();
            //$days = $model -> get_days($data -> id);
            include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
        }
        function district()
        {
            $model = $this->model;
            $cid = FSInput::get('cid');
            $rs = $model->getDistricts($cid);

            $json = '['; // start the json array element
            $json_names = array();
            foreach ($rs as $item) {
                $json_names[] = "{id: $item->id, name: '$item->name'}";
            }
            $json .= implode(',', $json_names);
            $json .= ']'; // end the json array element
            echo $json;
        }

        function ajax_district()
        {
            $model  = $this -> model;
            $cid = FSInput::get('cid',0,'int');
            $rs  = $model -> get_district($cid);
            // $json = '['; // start the json array element
            // $json_names = array();
            // foreach( $rs as $item)
            // {
            //     $json_names[] = "{id: $item->id, name: '$item->name'}";
            // }
            // $json .= implode(',', $json_names);
            // $json .= ']'; // end the json array element
            echo json_encode($rs);
        }

        // function is_atm()
        // {
        //     $this->is_check('is_atm',1,'is_atm');
        // }
        // function unis_atm()
        // {
        //     $this->unis_check('is_atm',0,'un_atm');
        // }
	}
	
?>