<?php

use Google\Service\PeopleService\Url;

global $tmpl, $config;
// $tmpl->addStylesheet('header');
//$tmpl -> addScript('styles','blocks/mainmenu/assets/js');
$tmpl->addStylesheet('multilevel', 'blocks/mainmenu/assets/css');
$language = FSInput::get('lang', 'vi');

?>
<div class='mainmenu mainmenu-<?php echo $style; ?> clearfix'>

    <?php
    $Itemid = 7;
    $root_total = 0;
    $root_last = 0;
    for ($i = 1; $i <= count($list); $i++) {
        if (@$list[$i]->level == 0) {
            $root_total++;
            $root_last = $i;
        }
    }
    ?>
    <?php $url = $_SERVER['REQUEST_URI']; ?>
    <?php $url = substr($url, strlen(URL_ROOT_REDUCE)); ?>
    <?php $url = preg_replace('/(-page)\w+/', '', $url); ?>
    <?php $url = preg_replace('/\/sap-xep:\w+/', '', $url); ?>
    <?php $url = URL_ROOT . $url; ?>
    <div class="main-menu">
        <ul class="parent-ul mb-0">
            <?php
            $html = "";
            $i = 1;
            $num_child = array();
            $parant_close = 0;
            foreach ($list as $item) {
            ?>
            <?php
                $link = $item->link ? FSRoute::_($item->link) : '';
                $class = '';
                $class .= ' level' . $item->level;

                if ($url == $link)
                    $class .= ' activated ';

                // level = 1
                if ($item->level == 0) {
                    if ($i == 1)
                        $class .= ' first-item';
                    if ($i == ($root_last - 1))
                        $class .= ' last-item';
                    if ($i != ($root_last - 1))
                        $class .= ' menu-item';

                    $caret = '<span class="caret"></span>';
                }

                // level > 1
                else {
                    $parent = $item->parent_id;
                    // total children
                    $total_children_of_parent = @$list[$parent]->children;
                    if (isset($num_child[$parent])) {
                        if ($total_children_of_parent == $num_child[$parent]) {
                            $class .= ' first-sitem sub-menu-item ';
                        } else {
                            $class .= ' mid-sitem sub-menu-item ';
                        }
                    }
                    if ($total_children_of_parent > 1) {
                        $class .= ' dropdown-submenu ';
                    }

                    $caret = '';
                }
                $name = $item->name;
                $html .= '<li class="li_header ' . $class . '" >';
                $html .= '<a href="' . $link . '" data-target="#">';
                if ($item->icon) {
                    $html .= '<i class="' . $item->icon . '"></i>';
                }
                if ($item->level != 0) {
                    if ($item->image) {
                        $html .= '<img src="' . URL_ROOT . $item->image . '"/>';
                    }
                }
                $html .= $name;

                $html .= $item->parent_id == 0 ? '<svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 1L7 7L13 1" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg></a>' : '</a>';

                // browse child
                $num_child[$item->id] = $item->children;
                if ($item->children > 0)
                    $html .= '<ul class="dropdown-menu">';

                if (@$num_child[$item->parent_id] == 1) {
                    // if item has children => close in children last, don't close this item 
                    if ($item->children > 0) {
                        $parant_close++;
                    } else {
                        $parant_close++;
                        for ($i = 0; $i < $parant_close; $i++) {
                            $html .= '</ul>';
                        }
                        $parant_close = 0;
                        $num_child[$item->parent_id]--;
                    }
                }
                if (((@$num_child[$item->parent_id] == 0) && (@$item->parent_id > 0)) || !$item->children) {
                }
                if (@$num_child[$item->parent_id] >= 1)
                    $num_child[$item->parent_id]--;

                $html .= '</li>';

                $i++;
            }
            echo $html;
            ?>
            <!-- NEWS_TYPE for menu	-->

        </ul>
    </div>

</div>