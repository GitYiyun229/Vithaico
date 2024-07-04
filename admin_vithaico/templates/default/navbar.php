<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php" title="CMS Admin - Finalstyle">
            <img style="height: 50px; padding-top: 10px" src="/images/user-icon.svg" />
        </a>
    </div>

    <?php
    $language = $_SESSION['ad_lang'];
    $url_current  = $_SERVER['REQUEST_URI'];
    $sort_admin = $_SERVER['SCRIPT_NAME'];
    $sort_admin = str_replace('/index.php','',$sort_admin);
    $pos = strripos($sort_admin,'/');
    $sort_admin = substr($sort_admin,($pos+1));
    $url_current = substr($url_current,strlen(URL_ROOT_REDUCE));
    $url_current =  trim(preg_replace('/[&?]ad_lang=[a-z]+/i', '', $url_current));
    //						echo $url_current;
    function create_url_for_lang($url,$lang,$sort_admin){
        if(!$url)
            return URL_ROOT.$sort_admin.'/index.php?ad_lang='.$lang;
        if(strpos($url, 'index.php') === false)
            return URL_ROOT.$sort_admin.'/index.php?ad_lang='.$lang;
        if(substr($url,-9) == 'index.php')
            return URL_ROOT.$sort_admin.'/index.php?ad_lang='.$lang;
        if($url == 'index.php')
            return URL_ROOT.$sort_admin.'index.php?ad_lang='.$lang;
        return URL_ROOT.$url.'&ad_lang='.$lang;
    }
    $lang_arr = array('en'=>'English','vi'=>'Viet Nam');
    //print_r($language);die;
    ?>
    
    <ul class="nav navbar-top-links navbar-right">
<!--        <li class="dropdown">-->
<!--            <a class="dropdown-toggle" data-toggle="dropdown" href="#">-->
<!--                --><?php //echo " <img src='".URL_ROOT.$folder_admin.'/templates/default/images/'.$language.".jpg'  />";?>
<!--                <i class="fa fa-caret-down"></i>-->
<!--            </a>-->
<!--            <ul class="dropdown-menu dropdown-user">-->
<!--                --><?php
//                foreach ($lang_arr as $key => $value){
//                    $class = $key;
//                    $class .= ($key == $language)?' current ':'';
//                    echo " <li>
//                                <a href='". create_url_for_lang($url_current,$key,$sort_admin)."' class='".$class."' title='".$value."' >
//                                    <img src='".URL_ROOT.$folder_admin.'/templates/default/images/'.$key.".jpg' alt='".$value."' />
//                                    ".$value."
//                                </a>
//                              </li>";
//                }
//                ?>
<!--           </ul>-->
<!--       </li>-->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>
                <?php echo $_SESSION['ad_username']; ?>&nbsp;
                <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li>
                    <a href="index.php?module=users&view=log&task=logout">
                        <i class="fa fa-sign-out fa-fw"></i> <?php echo FSText::_('Logout') ?>
                    </a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <?php require('modules/menus/admin.php');?>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>