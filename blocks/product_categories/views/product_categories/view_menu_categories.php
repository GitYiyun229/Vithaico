<?php
global $tmpl, $user, $config;
$Itemid = FSInput::get('Itemid', 16, 'int');
$tmpl->addStylesheet('default', 'blocks/product_categories/assets/css');
$tmpl->addScript('default', 'blocks/product_categories/assets/js');
?>