<?php
global $tmpl, $config, $user;
$tmpl->addStylesheet('megamenu_mobile', 'blocks/mainmenu/assets/css');
$tmpl->addStylesheet('mmenu', 'blocks/mainmenu/assets/css');
$tmpl->addScript('mmenu', 'blocks/mainmenu/assets/js');
$tmpl->addScript('megamenu_mobile', 'blocks/mainmenu/assets/js');
$Itemid = FSInput::get('Itemid');
$lang = FSInput::get('lang');
$logo = URL_ROOT . $config['logo'];

$parents = array_unique(array_map(function ($item) {
    return $item->parent_id;
}, $list_mobile));
function showMenu($menu, $parent, $parents)
{
    echo $parent != 0 && in_array($parent, $parents) ? '<ul class="me-float">' : null;
    foreach ($menu as $item) {
        $attr = $item->target == '_blank' ? ' target="_blank" ' : '';
        if ($item->parent_id == $parent) {
            echo '<li>';
            echo '<a href="' . FSRoute::_($item->link) . '" ' . $attr . '>' . $item->name . '</a>';
            showMenu($menu, $item->id, $parents);
            echo '</li>';
        }
    }
    echo $parent != 0 && in_array($parent, $parents) ? '</ul>' : null;
}
?>

<nav id="mySidenav">
    <ul>
        <?php showMenu($list_mobile, 0, $parents) ?>
        <?php if (!empty($list_top)) {
            foreach ($list_top as $item) {
        ?>
                <li>
                    <a href="<?php echo FSRoute::_($item->link) ?>"><?php echo $item->name ?></a>
                </li>
        <?php }
        } ?>
    </ul>

  
</nav>
<!-- End -->