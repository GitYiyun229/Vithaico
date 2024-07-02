<?php 
	class ProductsModelsCombo extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'combo';
			$this -> table_name = 'fs_combo';
			$this -> check_alias = 0;
			parent::__construct();
		}
        function save($row = array(), $use_mysql_real_escape_string = 0)
        {

            $price = FSInput::get('price');
//            echo $price;
            $row ['price'] = $price = $this->standart_money($price, 0);
//var_dump($row ['price']);die;


            $id = parent::save($row, 1);

            if (!$id) {
                Errors::setError('Not save');
                return false;
            }

            return $id;
        }

        function standart_money($money, $method)
        {
            $money = str_replace(',', '', trim($money));
            $money = str_replace(' ', '', $money);
            $money = str_replace('.', '', $money);
//		$money = intval($money);
            $money = (double)($money);
            if (!$method)
                return $money;
            if ($method == 1) {
                $money = $money * 1000;
                return $money;
            }
            if ($method == 2) {
                $money = $money * 1000000;
                return $money;
            }
        }
	}
?>