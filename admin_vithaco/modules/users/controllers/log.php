<?php
// models 
include 'modules/users/models/log.php';

class UsersControllersLog
{
	var $module;
	var $gid;
	function __construct()
	{
		$module = 'users';
	}
	function display()
	{
		include 'modules/users/views/log/login.php';
	}

	function login()
	{
		$model = new UsersModelsLog();
		$user = $model->login();
		if ($user) {
			setRedirect('index.php');
		} else {
			setRedirect('index.php?module=users&view=log&task=display', FSText::_('Your username and pass is invalid'));
		}
	}
	function logout()
	{
		$model = new UsersModelsLog();
		$data = $model->logout();
		if(isset($_COOKIE['adLog']) ) {
			unset($_COOKIE['adLog']);
			setcookie('adLog', '', -1, '/');
		}		
		setRedirect('index.php?module=users&view=log&task=display');
	}
}
