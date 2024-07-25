<?php 
	class ContactModelsContact_order extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'contact_order';
			$this -> table_name = 'fs_contact_order';
			parent::__construct();
		}
	}
	
?>