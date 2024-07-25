<?php
	ini_set('display_errors', 0);
	ini_set('display_startup_errors', 0);
	error_reporting(0);
// models 
include 'modules/' . $module . '/models/users.php';

class UsersControllersUsers
{
	var $module;
	var $gid;
	function __construct()
	{
		$module = 'users';
		$this->module = $module;
		$this->gid = FSInput::get('gid');
	}
	function display()
	{
		$sort_field  = FSInput::get('sort_field');
		$sort_direct = FSInput::get('sort_direct');
		$sort_direct = $sort_direct ? $sort_direct : 'asc';

		if (@$sort_field) {
			$_SESSION['userlist_sort_field']  =  $sort_field;
			$_SESSION['userlist_sort_direct']  = $sort_direct;
		}

		$keysearch = FSInput::get('keysearch');
		if (isset($_POST['keysearch'])) {
			$_SESSION['ss_usr_keysearch']  =  $_POST['keysearch'];
		}
		//			$select_cat = FSInput::get('select_cat');

		if (isset($_POST['select_group'])) {
			$_SESSION['ss_usr_group']  =  $_POST['select_group'];
		}

		// call models
		$model = new UsersModelsUsers();

		$all_groups = $model->getUserGroupsAll();
		$list = $model->getUserList();
		$pagination = $model->getPagination();


		// call views

		include 'modules/' . $this->module . '/views/users/list.php';
	}


	function add()
	{
		$model = new UsersModelsUsers();
		$groups_all = $model->getUserGroupsAll();
		include 'modules/' . $this->module . '/views/users/detail.php';
	}
	function edit()
	{
		$model = new UsersModelsUsers();
		$data = $model->getUserById();
		$groups_all = $model->getUserGroupsAll();
		$groups_contain_user = $model->getUserGroupsByUser();
		include 'modules/' . $this->module . '/views/users/detail.php';
	}
	function remove()
	{
		$model = new UsersModelsUsers();

		$rows = $model->remove();
		if ($rows) {
			setRedirect('index.php?module=users&view=users', $rows . ' ' . FSText::_('record was deleted'));
		} else {
			setRedirect('index.php?module=users&view=users', FSText::_('Not delete'), 'error');
		}
	}
	function published()
	{
		$model = new UsersModelsUsers();
		$rows = $model->published(1);
		if ($rows) {
			setRedirect('index.php?module=users&view=users', $rows . ' ' . FSText::_('record was published'));
		} else {
			setRedirect('index.php?module=users&view=users', FSText::_('Error when published record'), 'error');
		}
	}
	function unpublished()
	{
		$model = new UsersModelsUsers();
		$rows = $model->published(0);
		if ($rows) {
			setRedirect('index.php?module=users&view=users', $rows . ' ' . FSText::_('record was unpublished'));
		} else {
			setRedirect('index.php?module=users&view=users', FSText::_('Error when unpublished record'), 'error');
		}
	}
	function apply()
	{
		$model = new UsersModelsUsers();
		$id = FSInput::get('id');

		// check password and repass
		$password = FSInput::get('password');
		$repass = FSInput::get('repass');


		if (@$id) {
			if ($password && ($password != $repass)) {
				setRedirect('index.php?module=users&view=users', FSText::_('You must enter a valid password'), 'error');
			}
		} else {
			if (!$password || ($password != $repass)) {
				setRedirect('index.php?module=users&view=users', FSText::_('You must enter a valid password'), 'error');
			}
		}
		// call Models to save
		$cid = $model->save();
		 
		if ($cid) {
			setRedirect("index.php?module=users&view=users&task=edit&cid=$cid", FSText::_('Saved'));
		} else {
			setRedirect('index.php?module=users&view=users', FSText::_('Not save'), 'error');
		}
	}
	function save()
	{
		$model = new UsersModelsUsers();
		// check password and repass
		$password = FSInput::get('password');
		$repass = FSInput::get('repass');
		$id = FSInput::get('id');
		if (@$id) {
			if ($password && ($password != $repass)) {
				setRedirect('index.php?module=users&view=users', FSText::_('You must enter a valid password'), 'error');
			}
		} else {
			if (!$password || ($password != $repass))
				setRedirect('index.php?module=users&view=users', FSText::_('You must enter a valid password'), 'error');
		}

		// call Models to save
		$cid = $model->save();
		 
		if ($cid) {
			setRedirect('index.php?module=users&view=users&cid=' . $cid, FSText::_('Saved'));
		} else {
			setRedirect('index.php?module=users&view=users', FSText::_('Not save'), 'error');
		}
	}

	function cancel()
	{
		setRedirect('index.php?module=users&view=users');
	}

	/*********************************** CREATE LINK *********************************/

	function linked()
	{
		$model = new UsersModelsUsers();
		$linked_list = $model->getCreateLink();
		$parent_list = $model->getParentLink();

		$cid = FSInput::get('cid');
		if ($cid) {
			$linked = $model->getLinkedById($cid);
		}
		include 'modules/' . $this->module . '/views/users/linked.php';
	}
	/*********************************** end CREATE LINK *********************************/
}
