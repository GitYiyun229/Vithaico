<?php
$view = FSInput::get('view');
// $tmpl->addScript('scroll', 'modules/members/assets/js');
?>
<form class="page-content page-dashboard-image p-4 bg-white page-border-radius d-flex  justify-content-center" method="POST" enctype="multipart/form-data">
    <div class="d-flex align-items-center gap-2 mb-3 user-name-sidebar justify-content-center">

        <div class="item-image-user position-relative">
            <!-- <img src="/modules/members/assets/images/no_image_user.svg" alt="user" class="img-fluid img-image"> -->
            <img src="<?php echo URL_ROOT . $this->userImage ?>" alt="user" class="img-fluid img-image">
            <input type="file" class="input-upload-image d-none" name="image" id="image" accept=".png, .jpg, .jpeg" data-img="img-image">
            <a href="" class="btn-upload-image position-absolute">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="24" height="24" rx="12" fill="black" fill-opacity="0.4" />
                    <path d="M5.33398 9.58449C5.33398 9.35094 5.33398 9.23417 5.34373 9.13582C5.43772 8.18719 6.18816 7.43674 7.13679 7.34275C7.23515 7.33301 7.35822 7.33301 7.60437 7.33301C7.69922 7.33301 7.74664 7.33301 7.78691 7.33057C8.30106 7.29943 8.75129 6.97493 8.94341 6.49701C8.95846 6.45958 8.97252 6.41739 9.00065 6.33301C9.02878 6.24863 9.04284 6.20644 9.05789 6.16901C9.25002 5.69109 9.70024 5.36658 10.2144 5.33545C10.2547 5.33301 10.2991 5.33301 10.3881 5.33301H13.6132C13.7022 5.33301 13.7466 5.33301 13.7869 5.33545C14.3011 5.36658 14.7513 5.69109 14.9434 6.16901C14.9585 6.20644 14.9725 6.24863 15.0007 6.33301C15.0288 6.41739 15.0428 6.45958 15.0579 6.49701C15.25 6.97493 15.7002 7.29943 16.2144 7.33057C16.2547 7.33301 16.3021 7.33301 16.3969 7.33301C16.6431 7.33301 16.7662 7.33301 16.8645 7.34275C17.8131 7.43674 18.5636 8.18719 18.6576 9.13582C18.6673 9.23417 18.6673 9.35094 18.6673 9.58449V14.7997C18.6673 15.9198 18.6673 16.4798 18.4493 16.9077C18.2576 17.284 17.9516 17.5899 17.5753 17.7817C17.1475 17.9997 16.5874 17.9997 15.4673 17.9997H8.53398C7.41388 17.9997 6.85383 17.9997 6.426 17.7817C6.04968 17.5899 5.74372 17.284 5.55197 16.9077C5.33398 16.4798 5.33398 15.9198 5.33398 14.7997V9.58449Z" stroke="white" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M12.0007 14.9997C13.4734 14.9997 14.6673 13.8058 14.6673 12.333C14.6673 10.8602 13.4734 9.66634 12.0007 9.66634C10.5279 9.66634 9.33398 10.8602 9.33398 12.333C9.33398 13.8058 10.5279 14.9997 12.0007 14.9997Z" stroke="white" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        </div>
    </div>
    <?php echo csrf::displayToken() ?>
    <input type="hidden" name="module" value="members">
    <input type="hidden" name="view" value="dashboard">
    <input type="hidden" name="task" value="saveDashboard_image">
    <input type="hidden" name="id" value="<?php echo $user->userID ?>">
</form>
<div class="user-menu-sidebar mb-3 pb-3">
    <h4>Thông tin tài khoản</h2>
        <a href="<?php echo FSRoute::_('index.php?module=members&view=dashboard') ?>" class="<?php echo $view == 'dashboard'  ? 'active' : '' ?>">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.1585 18.3333C17.1585 15.1083 13.9501 12.5 10.0001 12.5C6.05013 12.5 2.8418 15.1083 2.8418 18.3333M14.1668 5.83332C14.1668 8.13451 12.3013 9.99999 10.0001 9.99999C7.69894 9.99999 5.83346 8.13451 5.83346 5.83332C5.83346 3.53214 7.69894 1.66666 10.0001 1.66666C12.3013 1.66666 14.1668 3.53214 14.1668 5.83332Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Tài khoản của tôi
        </a>
        <a href="<?php echo FSRoute::_('index.php?module=members&view=orders') ?>" class="<?php echo $view == 'orders'  ? 'active' : '' ?>">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6.66667 10.1667H12.5M6.66667 13.5H10.3167M13.3333 3.34999C16.1083 3.49999 17.5 4.52499 17.5 8.33332V13.3333C17.5 16.6667 16.6667 18.3333 12.5 18.3333H7.5C3.33333 18.3333 2.5 16.6667 2.5 13.3333V8.33332C2.5 4.53332 3.89167 3.49999 6.66667 3.34999M8.33333 4.99999H11.6667C13.3333 4.99999 13.3333 4.16666 13.3333 3.33332C13.3333 1.66666 12.5 1.66666 11.6667 1.66666H8.33333C7.5 1.66666 6.66667 1.66666 6.66667 3.33332C6.66667 4.99999 7.5 4.99999 8.33333 4.99999Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Đơn hàng của tôi
        </a>

        <a href="<?php echo FSRoute::_('index.php?module=members&view=address') ?>" class="<?php echo $view == 'address'  ? 'active' : '' ?>">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.0001 11.1917C11.436 11.1917 12.6001 10.0276 12.6001 8.59166C12.6001 7.15572 11.436 5.99166 10.0001 5.99166C8.56414 5.99166 7.40008 7.15572 7.40008 8.59166C7.40008 10.0276 8.56414 11.1917 10.0001 11.1917Z" stroke="currentColor" stroke-width="1.5" />
                <path d="M3.01675 7.07499C4.65842 -0.141675 15.3501 -0.133341 16.9834 7.08333C17.9417 11.3167 15.3084 14.9 13.0001 17.1167C11.3251 18.7333 8.67508 18.7333 6.99175 17.1167C4.69175 14.9 2.05842 11.3083 3.01675 7.07499Z" stroke="currentColor" stroke-width="1.5" />
            </svg>
            Sổ địa chỉ
        </a>
        <a href="<?php echo FSRoute::_('index.php?module=members&view=favorite') ?>" class="<?php echo $view == 'introduce'  ? 'active' : '' ?>">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.517 17.3417C10.2337 17.4417 9.76699 17.4417 9.48366 17.3417C7.06699 16.5167 1.66699 13.075 1.66699 7.24168C1.66699 4.66668 3.74199 2.58334 6.30033 2.58334C7.81699 2.58334 9.15866 3.31668 10.0003 4.45001C10.842 3.31668 12.192 2.58334 13.7003 2.58334C16.2587 2.58334 18.3337 4.66668 18.3337 7.24168C18.3337 13.075 12.9337 16.5167 10.517 17.3417Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Sản phẩm yêu thích
        </a>

        <!-- //new -->
        <a href="<?php echo FSRoute::_('index.php?module=members&view=introduce') ?>" class="<?php echo $view == 'introduce'  ? 'active' : '' ?>">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12.5493 16.1587C15.1493 16.4087 16.5326 15.1921 17.2326 12.1837L18.0493 8.70041C18.866 5.21708 17.7993 3.49208 14.3076 2.67541L12.916 2.35041C10.1326 1.69208 8.47431 2.23375 7.49931 4.25041M12.5493 16.1587C12.1326 16.1254 11.6826 16.0504 11.1993 15.9337L9.79931 15.6004C6.32431 14.7754 5.24931 13.0587 6.06597 9.57541L6.88264 6.08375C7.04931 5.37541 7.24931 4.75875 7.49931 4.25041M12.5493 16.1587C12.0326 16.5087 11.3826 16.8004 10.591 17.0587L9.27431 17.4921C5.96597 18.5587 4.22431 17.6671 3.14931 14.3587L2.08264 11.0671C1.01597 7.75875 1.89931 6.00875 5.20764 4.94208L6.52431 4.50875C6.86597 4.40041 7.19097 4.30875 7.49931 4.25041M10.5326 7.10875L14.5743 8.13375M9.71597 10.3337L12.1326 10.9504" stroke="#757575" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>

            Thống kê danh sách F1
        </a>
        <a href="<?php echo FSRoute::_('index.php?module=members&view=favorite') ?>" class="<?php echo $view == 'favorite'  ? 'active' : '' ?>">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.0436 8.74362C14.8121 10.9185 13.5797 12.9566 11.5406 14.1339C8.15267 16.0899 3.82057 14.9292 1.86456 11.5413L1.65623 11.1804M0.954324 7.25553C1.18583 5.08062 2.41815 3.04252 4.45731 1.86521C7.84521 -0.0908 12.1773 1.06998 14.1333 4.45789L14.3417 4.81873M0.910156 13.0545L1.5202 10.7778L3.79691 11.3879M12.201 4.61124L14.4777 5.22128L15.0878 2.94458M7.99897 4.24956V7.99956L10.0823 9.24956" stroke="#757575" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>

            Lịch sử giao dịch
        </a>
        <a href="<?php echo FSRoute::_('index.php?module=members&view=favorite') ?>" class="<?php echo $view == 'favorite'  ? 'active' : '' ?>">
            <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12.5493 15.1587C15.1493 15.4087 16.5326 14.1921 17.2326 11.1837L18.0493 7.70041C18.866 4.21708 17.7993 2.49208 14.3076 1.67541L12.916 1.35041C10.1326 0.69208 8.47431 1.23375 7.49931 3.25041M12.5493 15.1587C12.1326 15.1254 11.6826 15.0504 11.1993 14.9337L9.79931 14.6004C6.32431 13.7754 5.24931 12.0587 6.06597 8.57541L6.88264 5.08375C7.04931 4.37541 7.24931 3.75875 7.49931 3.25041M12.5493 15.1587C12.0326 15.5087 11.3826 15.8004 10.591 16.0587L9.27431 16.4921C5.96597 17.5587 4.22431 16.6671 3.14931 13.3587L2.08264 10.0671C1.01597 6.75875 1.89931 5.00875 5.20764 3.94208L6.52431 3.50875C6.86597 3.40041 7.19097 3.30875 7.49931 3.25041M10.5326 6.10875L14.5743 7.13375M9.71597 9.33375L12.1326 9.95041" stroke="#757575" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>


            Thống kê đơn hàng F1
        </a>
        <a href="<?php echo FSRoute::_('index.php?module=members&view=favorite') ?>" class="<?php echo $view == 'favorite'  ? 'active' : '' ?>">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.95901 14.0506V15.7423C8.95901 17.1756 7.62567 18.334 5.984 18.334C4.34233 18.334 3.00065 17.1756 3.00065 15.7423V14.0506M8.95901 14.0506C8.95901 15.4756 7.62567 16.5006 5.984 16.5006M8.95901 14.0506V11.7586C8.95901 11.042 8.62569 10.392 8.09236 9.9253C7.55069 9.45864 6.809 9.16699 5.984 9.16699C4.334 9.16699 3.00065 10.3253 3.00065 11.7586V14.0506M8.95901 14.0506C8.95901 15.484 7.62567 16.5006 5.984 16.5006M3.00065 14.0506C3.00065 15.484 4.334 16.5006 5.984 16.5006M3.00065 14.0506C3.00065 15.4756 4.34233 16.5006 5.984 16.5006M17.4994 11.7086C17.966 11.692 18.3327 11.317 18.3327 10.8587V9.14197C18.3327 8.68363 17.966 8.30867 17.4994 8.292M17.4994 11.7086H15.866C14.966 11.7086 14.141 11.0503 14.066 10.1503C14.016 9.62532 14.216 9.13365 14.566 8.79198C14.8744 8.47532 15.2994 8.292 15.766 8.292H17.4994M17.4994 11.7086L17.4993 12.917C17.4993 15.417 15.8327 17.0837 13.3327 17.0837H11.2493M17.4994 8.292L17.4993 7.08366C17.4993 4.80033 16.1077 3.20865 13.9577 2.95865C13.7577 2.92532 13.5493 2.91699 13.3327 2.91699H5.83268C5.59935 2.91699 5.37435 2.93366 5.15768 2.96699C3.03268 3.23366 1.66602 4.81699 1.66602 7.08366V8.75033M8.95768 11.7586C8.95768 12.1753 8.84101 12.5586 8.64101 12.892C8.14935 13.7003 7.141 14.2086 5.97433 14.2086C4.80767 14.2086 3.79932 13.692 3.30766 12.892C3.10766 12.5586 2.99104 12.1753 2.99104 11.7586C2.99104 11.042 3.32435 10.4003 3.85769 9.93364C4.39935 9.45864 5.14099 9.17533 5.96599 9.17533C6.79099 9.17533 7.53268 9.46698 8.07435 9.93364C8.62435 10.392 8.95768 11.042 8.95768 11.7586Z" stroke="#757575" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>

            Thống kê hoa hồng
        </a>
        <a href="<?php echo FSRoute::_('index.php?module=members&view=favorite') ?>" class="<?php echo $view == 'favorite'  ? 'active' : '' ?>">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.91602 11.4587C7.91602 12.267 8.54103 12.917 9.30769 12.917H10.8743C11.541 12.917 12.0827 12.3503 12.0827 11.642C12.0827 10.8837 11.7494 10.6087 11.2577 10.4337L8.74935 9.55866C8.25768 9.38366 7.92436 9.117 7.92436 8.35033C7.92436 7.65033 8.46601 7.07533 9.13268 7.07533H10.6993C11.466 7.07533 12.091 7.72533 12.091 8.53366M9.99935 6.25033V13.7503M18.3327 10.0003C18.3327 14.6003 14.5993 18.3337 9.99935 18.3337C5.39935 18.3337 1.66602 14.6003 1.66602 10.0003C1.66602 5.40033 5.39935 1.66699 9.99935 1.66699M18.3327 5.00033V1.66699M18.3327 1.66699H14.9993M18.3327 1.66699L14.166 5.83366" stroke="#757575" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>

            Chi trả hoa hồng
        </a>


        <a href="<?php echo FSRoute::_('index.php?module=members&view=log&task=logout') ?>">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.41634 6.30001C7.67467 3.30001 9.21634 2.07501 12.5913 2.07501H12.6997C16.4247 2.07501 17.9163 3.56668 17.9163 7.29168V12.725C17.9163 16.45 16.4247 17.9417 12.6997 17.9417H12.5913C9.24134 17.9417 7.69967 16.7333 7.42467 13.7833M12.4997 10H3.01634M4.87467 7.20835L2.08301 10L4.87467 12.7917" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Đăng xuất
        </a>
</div>

<div>
    <div class="text-grey fw-semibold"><?= FSText::_('Bạn cần hỗ trợ?') ?></div>
    <div><span class="text-grey"><?= FSText::_('Vui lòng gọi') ?></span> <a href="tel:<?php echo $config['hotline'] ?>"><b><?php echo $config['hotline'] ?></b></a></div>
    <div class="text-grey"><?= FSText::_('(miễn phí cước gọi)') ?></div>
</div>