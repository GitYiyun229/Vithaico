<?php
include 'blocks/cart/models/cart.php';
class CartBControllersCart
{
  function __construct()
  {
  }
  function display($parameters, $title)
  {
    global $user;
    $model = new CartBModelsCart();

    $quantity = 0;
    if (isset($_SESSION['cart'])) {
      $product_list = $_SESSION['cart'];
      foreach ($product_list as $item) {
        // $quantity += $item[1];
        $quantity += 1;
      }
    }

    $style = $parameters->getParams('style');
    $style = $style ? $style : 'default';
    $query_body = $model->set_query_body();
    $list_discount_all = $model->get_list_discount($query_body);
    if ($user->userID) {
      $level_member = $model->get_record('id = ' . $user->userInfo->group_id . '', FSTable::_('fs_members_group'));
    }
    include 'blocks/cart/views/cart/' . $style . '.php';
  }
}
