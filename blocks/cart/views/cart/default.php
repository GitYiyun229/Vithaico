<?php
global $tmpl;
$tmpl->addStylesheet('default', 'blocks/cart/assets/css');
// print_r($_SESSION['cart']);
?>

<div class="cart-hover-bg">
    <div class="cart-hover">
        <?php
        $link_cart = FSRoute::_('index.php?module=products&view=cart');
        $html = '';
        if (!empty($_SESSION['cart'])) {
            @$list_cart = $_SESSION['cart'];
            $total_all = 0;
            $i = 0;
            $i < count($list_cart);
            $total_quan_bg = 0;
            foreach ($list_cart as $crd) {
                $total_quan_bg += $crd["quantity"];
                $total_all += $crd['price'] * $crd['quantity'];
                ++$i;
            }
            $check_total_quan = (!empty($_SESSION['cart'])) ? $total_quan_bg : '0';
            $html .= '
                    <div class="cart-hover-header">
                        <span class="normal_text">
                            ' . FSText::_('Đơn hàng') . '
                        </span>
                        <span class="total_all">
                            ' . format_money($total_all) . '
                        </span>
                        <span>
                            -
                        </span>
                        <span class="total_courses">
                            ' . $check_total_quan . ' ' . FSText::_('sản phẩm') . '
                        </span>
                    </div>
                ';

            $html .= '
                    <div class="cart-hover-body">
                ';
            $j = 0;
            $j < count($list_cart);
            foreach ($list_cart as $item) {
                $html .= '
                    <div class="cart-hover-item">
                        <div class="img-box">
                            <img src="' . $item['image'] . '" alt="' . $item['course_name'] . '" class="img-fluid">
                        </div>
                        <div class="info-box">
                            <p class="course_name">
                                ' . $item['course_name'] . '
                            </p>
                            <div class="date_teetime">
                                <span>
                                    ' . $item['date'] . '
                                </span>
                                <span>
                                    ' . $item['teetime'] . '
                                </span>
                            </div>
                            <div class="quantity_price">
                                ' . $item['quantity'] . ' x ' . $item['price'] . '
                            </div>
                        </div>
                    </div>
                    ';
                ++$j;
            }
            $html .= '
                    </div>
                    <a class="btn-link-cart" href="' . FSRoute::_('index.php?module=courses&view=cart') . '">
                        ' . FSText::_('Xem giỏ hàng') . '
                    </a>
                ';
        } else {
            $html .= '
                <p class="no_cart-item">' . FSText::_('Your cart is empty') . ' !</p>
            ';
        }
        echo $html;
        ?>
    </div>
</div>