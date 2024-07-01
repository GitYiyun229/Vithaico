<div class="content-home">
    <div class="home-info">
        <div class="panel panel-info">
            <div class="panel-heading">Hệ thống quản lý nội dung (CMS) – Website <strong><?php echo $site_name;?></strong></div>
            <div class="table-responsive">
                <table class="table table-striped table-hover" >
                    <tr>
                        <td>Tên miền</td>
                        <td><a target="_blank" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'];?>"><?php echo $_SERVER['SERVER_NAME'];?></a></td>
                    </tr>
                    <tr>
                        <td>IP Host</td>
                        <td><?php echo $_SERVER['REMOTE_ADDR'];?></td>
                    </tr>
                    <tr>
                        <td>Tài khoản đăng nhập</td>
                        <td><?php echo $_SESSION['ad_username']; ?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><?php echo $_SESSION['ad_useremail']; ?></td>
                    </tr>
                </table>
            </div>
        </div><!--end: .home-main-->
    </div><!--end: .home-info-->    
</div><!--end: .content-home-->
<?php if(count($list)){
    $array_panel = array(
             1 => 'panel-default',
             2 => 'panel-primary',
             3 => 'panel-success',
             4 => 'panel-info',
             5 => 'panel-warning',
             6 => 'panel-danger',
             7 => 'panel-green',
             8 => 'panel-yellow',
             9 => 'panel-red',
    );
    function get_count($where = '',$table_name = ''){
		if(!$where)
			return;
		if(!$table_name)
			$table_name = $this -> table_name;
		$query = " SELECT count(*)
					  FROM ".$table_name."
					  WHERE ".$where ;
		
		global $db;
		$result = $db->getResult($query);
		return $result;
	}
?>
<div class="row">
    <?php foreach($list as $item){
        $link_ = '';
        $module = $item->module? $item->module:'';
        if($module){
            $view = $item->view? $item->view:$module;
            $link_ = 'index.php?module='.$module.'&view='.$view;
        }
        $link = $item->link? $item->link:$link_;
    ?>
    <div class="col-lg-3 col-md-6">
        <div class="panel <?php echo $array_panel[$item->code_color] ?>">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="<?php echo $item->icon ?> fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo get_count('published = 1 AND parent_id = '.$item->id,'fs_menus_admin'); ?></div>
                        <h5 style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;"><?php echo $item->name ?></h5>
                    </div>
                </div>
            </div>
            <a href="<?php echo $link; ?>">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <?php } ?>
</div>
<?php } ?>


