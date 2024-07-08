<?php
global $config, $tmpl;

$tmpl->addStylesheet('contact', 'modules/contact/assets/css');
$tmpl->addScript('form', 'modules/contact/assets/js');
$tmpl->addTitle(FSText::_('Liên hệ'));
$alert_info = array(
    0 => FSText::_('Bạn chưa nhập tên'),
    1 => FSText::_('Bạn chưa nhập số điện thoại'),
    2 => FSText::_('Bạn chưa nhập email'),
    3 => FSText::_('Bạn chưa nhập địa chỉ'),
    4 => FSText::_('Bạn chưa nhập nội dung'),
    5 => FSText::_('Số điện thoại không đúng định dạng'),
    6 => FSText::_('Số điện thoại từ 10 đến 12 số'),
    7 => FSText::_('Email không đúng định dạng'),
    8 => FSText::_('Vui lòng nhập mã code'),
);
?>
<input type="hidden" id="alert_info" value='<?php echo json_encode($alert_info) ?>' />

<div class="section-banner">
    <?php echo $tmpl->load_direct_blocks('banners', ['category_id' => '5', 'style' => 'default']); ?>
</div>
<div class="container">
    <div class="map-contact">
        <?php echo $config['gg_map'] ?>
    </div>
    <div class="contact-box">
        <div class="left-box">
            <h2 class="title_contact">
                <?php echo $config['name_company'] ?>
            </h2>
            <div class="line_contact">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="48" height="48" rx="24" fill="#FAB731" />
                    <path d="M24 14C19.8581 14 16.5 17.3581 16.5 21.5C16.5 23.1309 17.0347 24.6275 17.9234 25.8531C17.9394 25.8825 17.9419 25.9153 17.96 25.9434L22.96 33.4434C23.1919 33.7913 23.5825 34 24 34C24.4175 34 24.8081 33.7913 25.04 33.4434L30.04 25.9434C30.0584 25.9153 30.0606 25.8825 30.0766 25.8531C30.9653 24.6275 31.5 23.1309 31.5 21.5C31.5 17.3581 28.1419 14 24 14ZM24 24C22.6194 24 21.5 22.8806 21.5 21.5C21.5 20.1194 22.6194 19 24 19C25.3806 19 26.5 20.1194 26.5 21.5C26.5 22.8806 25.3806 24 24 24Z" fill="white" />
                </svg>
                <div class="line_right">
                    <p class="m-0"><?php echo $config['address'] ?></p>
                </div>
            </div>
            <div class="line_contact">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="48" height="48" rx="24" fill="#FAB731" />
                    <path d="M29.62 22.75C29.19 22.75 28.85 22.4 28.85 21.98C28.85 21.61 28.48 20.84 27.86 20.17C27.25 19.52 26.58 19.14 26.02 19.14C25.59 19.14 25.25 18.79 25.25 18.37C25.25 17.95 25.6 17.6 26.02 17.6C27.02 17.6 28.07 18.14 28.99 19.11C29.85 20.02 30.4 21.15 30.4 21.97C30.4 22.4 30.05 22.75 29.62 22.75Z" fill="white" />
                    <path d="M33.23 22.75C32.8 22.75 32.46 22.4 32.46 21.98C32.46 18.43 29.57 15.55 26.03 15.55C25.6 15.55 25.26 15.2 25.26 14.78C25.26 14.36 25.6 14 26.02 14C30.42 14 34 17.58 34 21.98C34 22.4 33.65 22.75 33.23 22.75Z" fill="white" />
                    <path d="M23.05 26.95L21.2 28.8C20.81 29.19 20.19 29.19 19.79 28.81C19.68 28.7 19.57 28.6 19.46 28.49C18.43 27.45 17.5 26.36 16.67 25.22C15.85 24.08 15.19 22.94 14.71 21.81C14.24 20.67 14 19.58 14 18.54C14 17.86 14.12 17.21 14.36 16.61C14.6 16 14.98 15.44 15.51 14.94C16.15 14.31 16.85 14 17.59 14C17.87 14 18.15 14.06 18.4 14.18C18.66 14.3 18.89 14.48 19.07 14.74L21.39 18.01C21.57 18.26 21.7 18.49 21.79 18.71C21.88 18.92 21.93 19.13 21.93 19.32C21.93 19.56 21.86 19.8 21.72 20.03C21.59 20.26 21.4 20.5 21.16 20.74L20.4 21.53C20.29 21.64 20.24 21.77 20.24 21.93C20.24 22.01 20.25 22.08 20.27 22.16C20.3 22.24 20.33 22.3 20.35 22.36C20.53 22.69 20.84 23.12 21.28 23.64C21.73 24.16 22.21 24.69 22.73 25.22C22.83 25.32 22.94 25.42 23.04 25.52C23.44 25.91 23.45 26.55 23.05 26.95Z" fill="white" />
                    <path d="M33.97 30.33C33.97 30.61 33.92 30.9 33.82 31.18C33.79 31.26 33.76 31.34 33.72 31.42C33.55 31.78 33.33 32.12 33.04 32.44C32.55 32.98 32.01 33.37 31.4 33.62C31.39 33.62 31.38 33.63 31.37 33.63C30.78 33.87 30.14 34 29.45 34C28.43 34 27.34 33.76 26.19 33.27C25.04 32.78 23.89 32.12 22.75 31.29C22.36 31 21.97 30.71 21.6 30.4L24.87 27.13C25.15 27.34 25.4 27.5 25.61 27.61C25.66 27.63 25.72 27.66 25.79 27.69C25.87 27.72 25.95 27.73 26.04 27.73C26.21 27.73 26.34 27.67 26.45 27.56L27.21 26.81C27.46 26.56 27.7 26.37 27.93 26.25C28.16 26.11 28.39 26.04 28.64 26.04C28.83 26.04 29.03 26.08 29.25 26.17C29.47 26.26 29.7 26.39 29.95 26.56L33.26 28.91C33.52 29.09 33.7 29.3 33.81 29.55C33.91 29.8 33.97 30.05 33.97 30.33Z" fill="white" />
                </svg>
                <div class="line_right">
                    <p class="text_bold"> <?php echo FSText::_('Điện thoại') ?> </p>
                    <p> <?php echo $config['hotline'] ?> </p>
                </div>
            </div>
            <div class="line_contact">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="48" height="48" rx="24" fill="#FAB731" />
                    <path d="M29 15.5H19C16 15.5 14 17 14 20.5V27.5C14 31 16 32.5 19 32.5H29C32 32.5 34 31 34 27.5V20.5C34 17 32 15.5 29 15.5ZM29.47 21.59L26.34 24.09C25.68 24.62 24.84 24.88 24 24.88C23.16 24.88 22.31 24.62 21.66 24.09L18.53 21.59C18.21 21.33 18.16 20.85 18.41 20.53C18.67 20.21 19.14 20.15 19.46 20.41L22.59 22.91C23.35 23.52 24.64 23.52 25.4 22.91L28.53 20.41C28.85 20.15 29.33 20.2 29.58 20.53C29.84 20.85 29.79 21.33 29.47 21.59Z" fill="white" />
                </svg>
                <div class="line_right">
                    <p class="text_bold"> <?php echo FSText::_('Email') ?> </p>
                    <p> <?php echo $config['email'] ?> </p>
                </div>
            </div>
            <div class="line_contact">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="48" height="48" rx="24" fill="#FAB731" />
                    <path d="M29 15.5H19C16 15.5 14 17 14 20.5V27.5C14 31 16 32.5 19 32.5H29C32 32.5 34 31 34 27.5V20.5C34 17 32 15.5 29 15.5ZM29.47 21.59L26.34 24.09C25.68 24.62 24.84 24.88 24 24.88C23.16 24.88 22.31 24.62 21.66 24.09L18.53 21.59C18.21 21.33 18.16 20.85 18.41 20.53C18.67 20.21 19.14 20.15 19.46 20.41L22.59 22.91C23.35 23.52 24.64 23.52 25.4 22.91L28.53 20.41C28.85 20.15 29.33 20.2 29.58 20.53C29.84 20.85 29.79 21.33 29.47 21.59Z" fill="white" />
                </svg>
                <div class="line_right">
                    <p class="text_bold"> <?php echo FSText::_('Website') ?> </p>
                    <p> <?php echo $config['website'] ?> </p>
                </div>
            </div>
        </div>
        <div class="right-box">
            <p class="heading-contact"> <?php echo FSText::_('Liên hệ với chúng tôi') ?> </p>

            <div class="summary_contact">
                <p>
                    <?php echo FSText::_('Mọi thắc mắc và yêu cầu hỗ trợ. Vui lòng để lại thông tin tại đây. Chúng tôi sẽ xem xét và phản hồi sớm nhất.') ?>
                </p>
                <p>
                    <span>"</span>
                    <span style="color:red"> * </span>
                    <span>"</span>
                    <span> <?php echo ' ' . FSText::_('trường bắt buộc.') ?> </span>
                </p>
            </div>
            <form action="" method="post" class="form-contact" name="frmContact" id="frmContact">
                <div class="box">
                    <label for="c_name">
                        <span>
                            <?php echo FSText::_('Họ và tên') . ' ' ?>
                        </span>
                        <span style="color:red">
                            *
                        </span>
                    </label>
                    <input type="text" class="form-control" name="c_name" id="c_name" placeholder="<?php echo FSText::_('Nhập họ và tên') ?>">
                </div>
                <div class="box">
                    <label for="c_telephone">
                        <span>
                            <?php echo FSText::_('Số điện thoại') . ' ' ?>
                        </span>
                        <span style="color:red">
                            *
                        </span>
                    </label>
                    <input type="text" class="form-control" name="c_telephone" id="c_telephone" placeholder="<?php echo FSText::_('Nhập số điện thoại') ?>">
                </div>
                <div class="box">
                    <label for="c_email">
                        <span>
                            <?php echo FSText::_('Email') . ' ' ?>
                        </span>
                        <span style="color:red">
                            *
                        </span>
                    </label>
                    <input type="text" class="form-control" name="c_email" id="c_email" placeholder="<?php echo FSText::_('Nhập email của bạn') ?>">
                </div>
                <div class="box">
                    <label for="c_address">
                        <span>
                            <?php echo FSText::_('Địa chỉ') . ' ' ?>
                        </span>

                    </label>
                    <input type="text" class="form-control" name="c_address" id="c_address" placeholder="<?php echo FSText::_('Nhập địa chỉ của bạn') ?>">
                </div>

                <div class="box w-100 box-area">
                    <label for="c_email">
                        <span>
                            <?php echo FSText::_('Nội dung liên hệ') . ' ' ?>
                        </span>

                    </label>
                    <textarea class="form-control" name="c_content" id="c_content" rows="5" placeholder="<?php echo FSText::_('Nhập nội dung tin nhắn') ?>"></textarea>
                </div>
                <div class="box w-100 box-area">
                    <a class="submitFrmC" href="javascript:void(0)" title="<?php echo FSText::_('Gửi liên hệ') ?>">
                        <?php echo FSText::_('Gửi liên hệ') ?>
                    </a>
                    <input type="hidden" name="module" value="contact">
                    <input type="hidden" name="view" value="contact">
                    <input type="hidden" name="task" value="save">
                </div>
            </form>
        </div>
    </div>
</div>