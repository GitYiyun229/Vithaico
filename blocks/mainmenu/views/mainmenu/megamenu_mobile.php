<?php
global $tmpl, $config, $user;

$tmpl->addStylesheet('megamenu_moblie', 'blocks/mainmenu/assets/css');
$tmpl->addStylesheet('mmenu', 'blocks/mainmenu/assets/css');
$tmpl->addStylesheet('menu_mobile', 'blocks/mainmenu/assets/css');
$tmpl->addScript('mmenu', 'blocks/mainmenu/assets/js');
$tmpl->addScript('megamenu_moblie', 'blocks/mainmenu/assets/js');
$Itemid = FSInput::get('Itemid');
$logo = URL_ROOT . $config['logo'];
?>
<style>
    @media (max-width: 768px) {
        li.lang_mb.mm-listitem {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            justify-items: center;
        }

        a.lang_link_mobile.mm-listitem__text {
            padding: 10px !important;
        }

        a.lang_link_mobile.mm-listitem__text img {
            max-width: 30px !important;
            max-height: 30px !important;
        }
    }
</style>
<?php
$arr_root = array();
$arr_children = array();
$current_root = 0;
foreach ($list as $item) {
    if ($item->level == 0) {
        $arr_root[] = $item;
        $current_root = $item->id;
    } else if ($item->level == 1) {
        if (!isset($arr_children[$item->parent_id]))
            $arr_children[$item->parent_id] = array();
        $arr_children[$item->parent_id][] = $item;
    } else {
        $arr_children[$current_root][] = $item;
    }
}
?>
<nav id="">

    <ul>
        <li>
            <a href="<?= URL_ROOT ?>" class="logo">
                <img src="<?= URL_ROOT . $config['logo'] ?>" alt="logo" class="img-fluid">
            </a>
        </li>
        <?php $url = $_SERVER['REQUEST_URI']; ?>
        <?php $url = substr($url, strlen(URL_ROOT_REDUCE)); ?>
        <?php $url = URL_ROOT . $url; ?>
        <?php if (isset($list) && !empty($list)) { ?>
            <?php $t = 0; ?>
            <?php foreach ($arr_root as $item) { ?>
                <?php $link = FSRoute::_($item->link); ?>
                <?php $class = ''; ?>
                <?php
                $attr = '';
                if ($item->target == '_blank')
                    $attr .= ' target="_blank " ';
                ?>
                <?php if ($url == $link) $class = 'active'; ?>
                <?php if (isset($arr_children[$item->id]) && count($arr_children[$item->id])) {
                    $class = 'class="icon_hover"';
                } else {
                    $class = '';
                } ?>
                <li class=" level_1 <?php echo $class; ?> ">
                    <a <?php echo $attr ?> href="<?php echo $link; ?>" <?php echo $class; ?> title="<?php echo $item->name; ?>" rel="<?php // echo $item->rel; 
                                                                                                                                        ?>"><?php echo $item->name; ?></a>
                    <?php if (isset($arr_children[$item->id]) && count($arr_children[$item->id])) { ?>
                        <ul class="me-float">
                            <?php foreach ($arr_children[$item->id] as $child) { ?>
                                <?php $link_child = FSRoute::_($child->link); ?>
                                <li><a <?php echo $attr ?> href="<?php echo $link_child; ?>" title="<?php echo $child->name; ?>" rel="<?php // echo $child->rel; 
                                                                                                                                        ?>"><?php echo $child->name; ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </li>
            <?php } // end foreach($list as $item)
            ?>
        <?php }  // end if(isset($list) && !empty($list)) 
        ?>

        <?php echo $tmpl->load_direct_blocks('search', array('style' => 'lang_mobile')); ?>



    </ul>


</nav>
<!-- End -->
<input type="hidden" id="link_home" value="<?php echo URL_ROOT ?>">
<input type="hidden" id="link_login" value="<?php echo URL_ROOT . '/account/login' ?>">
<!-- <input type="hidden" id="fb" value="</?php echo $config['facebook'] ?>">
<input type="hidden" id="ytb" value="</?php echo $config['youtube'] ?>">
<input type="hidden" id="twitter" value="</?php echo $config['twitter'] ?>"> -->
<input type="hidden" id="user" value="<?php echo !empty($user->userID) ? $user->userID : '' ?>">