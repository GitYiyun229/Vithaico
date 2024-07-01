<?php
class FSSecurity
{
	function __construct()
	{
		
	}
	function checkLogin()
	{
		if(!isset($_SESSION['username']))
		{
			$Itemid = 11;
			$url = FSRoute::_("index.php?module=users&task=login&Itemid=$Itemid");
			$msg = FSText :: _("Bạn phải đăng nhập để sử dụng tính năng này");
			setRedirect($url,$msg,'error');
		}
		else 
			return true;
	}
	function checkEsoresLogin(){
		$this -> checkLogin();
		if(!isset($_SESSION['estore_id']))
		{
			echo "<script>alert('You do not have permission');history.go(-1)</script>";
			return false;
		}
		else 
			return true;
	}
	
	// check for estore : saneps
	function checkEsoresLogin1()
	{
		if(!isset($_SESSION['e-email']))
		{
			$Itemid = 9;
			$url = FSRoute::_("index.php?module=estores&task=login&Itemid=$Itemid");
			$msg = FSText :: _("B&#7841;n ph&#7843;i &#273;&#259;ng nh&#7853;p gian h&#224;ng &#273;&#7875; s&#7917; d&#7909;ng t&#237;nh n&#259;ng n&#224;y");
			setRedirect($url,$msg,'error');
		}
		else 
			return true;
	}
}