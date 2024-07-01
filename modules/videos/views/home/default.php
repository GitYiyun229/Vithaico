<?php
global $tmpl;
$tmpl->addTitle('Videos');
$tmpl->addStylesheet('slick', 'modules/videos/assets/css');
$tmpl->addStylesheet('slick-theme', 'modules/videos/assets/css');
$tmpl->addStylesheet('video', 'modules/videos/assets/css');
$tmpl->addScript('slick.min', 'modules/videos/assets/js');
$tmpl->addScript('video', 'modules/videos/assets/js');

?>
<?php if (IS_MOBILE == 1) { ?>
    <header>
        <a href="<?php echo URL_ROOT ?>" class="home_page">
            <img src="/modules/products/assets/images/didongthongminh.svg" alt="didongthongminh.vn" width="48"
                 height="48"
                 class="img-responsive site-logo-pc img_pc">
        </a>
    </header>
    <div class="video-slider">
        <?php
        $i = 0;
        foreach ($videos as $video) {
            $link = !empty($video->product_id) ? FSRoute::_('index.php?module=products&view=product&ccode=' . $video->product_alias) : null;
            ?>
            <div class="video-item">
                <video class="video-<?php echo $i ?>" src="<?php echo $i < 2 ? URL_ROOT . $video->video : null ?>"
                       autoplay muted loop playsinline controls></video>
                <div class="right_video">
                    <div class="item_icon">
                        <a href="" class="bo_icon click_like" data-id="<?php echo $video->id ?>"
                           data-like="<?php echo $video->hits ?>">
                            <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_2919_2199)">
                                    <path d="M9.44669 1.16675L4.66669 5.95341V14.5001H12.8734L15.3334 8.76675V5.83341H9.79335L10.54 2.24675L9.44669 1.16675ZM0.666687 6.50008H3.33335V14.5001H0.666687V6.50008Z"
                                          fill="black"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_2919_2199">
                                        <rect width="16" height="16" fill="white" transform="translate(0 0.5)"/>
                                    </clipPath>
                                </defs>
                            </svg>
                        </a>
                        <span class="text_icon text-<?php echo $video->id ?>"><?php echo $video->hits ?></span>
                    </div>
                    <div class="item_icon hidden">
                        <a href="" class="bo_icon">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_2919_2206)">
                                    <path d="M9.77778 4.59095V0.95459L16 7.31823L9.77778 13.6819V9.95459C5.33333 9.95459 2.22222 11.4091 0 14.591C0.888888 10.0455 3.55556 5.50004 9.77778 4.59095Z"
                                          fill="black"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_2919_2206">
                                        <rect width="16" height="15" fill="white" transform="matrix(-1 0 0 1 16 0.5)"/>
                                    </clipPath>
                                </defs>
                            </svg>

                        </a>
                        <span class="text_icon">Share</span>
                    </div>
                    <div class="item_icon">
                        <a href="<?php echo $link ?>" class="bo_icon">
                            <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_2919_2212)">
                                    <g clip-path="url(#clip1_2919_2212)">
                                        <path d="M6.0273 12.4626C5.48964 12.4626 4.97413 12.6746 4.59388 13.0519C4.21377 13.4293 4.00024 13.9413 4.00024 14.475C4.00024 15.0088 4.21379 15.5206 4.59388 15.8981C4.97413 16.2755 5.48967 16.4875 6.0273 16.4875C6.56481 16.4875 7.08047 16.2755 7.46057 15.8981C7.84067 15.5206 8.0542 15.0087 8.0542 14.475C8.05377 13.9414 7.83993 13.4299 7.45997 13.0525C7.07987 12.6753 6.56463 12.4631 6.02726 12.4625L6.0273 12.4626ZM6.0273 15.2454V15.2452C5.82146 15.2452 5.62422 15.164 5.47876 15.0196C5.3333 14.8752 5.25154 14.6794 5.25154 14.475C5.25154 14.2708 5.33329 14.075 5.47876 13.9304C5.62423 13.786 5.82148 13.7048 6.0273 13.7048C6.23299 13.7048 6.43038 13.786 6.57583 13.9304C6.7213 14.075 6.80305 14.2708 6.80305 14.475C6.80247 14.6789 6.72043 14.8744 6.57511 15.0183C6.42964 15.1623 6.23268 15.2432 6.02728 15.2432L6.0273 15.2454Z"
                                              fill="black"/>
                                        <path d="M12.5673 12.4625C12.0296 12.4625 11.514 12.6746 11.1337 13.0522C10.7536 13.4297 10.5402 13.9418 10.5403 14.4756C10.5405 15.0095 10.7543 15.5214 11.1347 15.8988C11.5151 16.276 12.0309 16.4877 12.5687 16.4875C13.1064 16.487 13.6221 16.2746 14.0019 15.8967C14.3818 15.5189 14.5949 15.0068 14.5943 14.4728C14.5932 13.9396 14.3792 13.4287 13.9993 13.0517C13.6193 12.6749 13.1044 12.463 12.5673 12.4624V12.4625ZM12.5673 15.2453V15.2451C12.3617 15.2451 12.1645 15.1641 12.019 15.0198C11.8735 14.8755 11.7918 14.6798 11.7915 14.4756C11.7914 14.2716 11.8728 14.0756 12.018 13.931C12.1633 13.7866 12.3603 13.7051 12.566 13.7047C12.7715 13.7044 12.9689 13.7851 13.1147 13.9291C13.2604 14.0731 13.3426 14.2687 13.343 14.4729C13.343 14.6771 13.2614 14.8731 13.1158 15.0175C12.9704 15.1619 12.7731 15.2431 12.5673 15.2431L12.5673 15.2453Z"
                                              fill="black"/>
                                        <path d="M15.3681 4.57806H7.74368C7.52024 4.57806 7.31367 4.69648 7.20195 4.88871C7.09009 5.0808 7.09009 5.31767 7.20195 5.50975C7.31367 5.70198 7.52024 5.8204 7.74368 5.8204H14.5816L13.4701 10.6073H6.07319L4.30692 1.83251C4.28452 1.72564 4.23419 1.62642 4.16102 1.54511C4.0877 1.46365 3.99417 1.40285 3.88972 1.36862L1.50409 0.540503C1.29316 0.466558 1.05867 0.509885 0.888783 0.654165C0.718733 0.798444 0.639309 1.02187 0.680183 1.24011C0.721061 1.45848 0.876125 1.63842 1.08706 1.71237L3.13493 2.4225L4.93259 11.3481L4.93244 11.3483C4.96096 11.4889 5.03747 11.6154 5.14933 11.7064C5.26105 11.7974 5.40114 11.8472 5.5456 11.8472H13.9684C14.11 11.8471 14.2471 11.7993 14.3578 11.7116C14.4684 11.624 14.5458 11.5018 14.5773 11.3649L15.9788 5.33756C16.0212 5.15327 15.977 4.95988 15.8585 4.81199C15.7401 4.6641 15.5601 4.57788 15.3698 4.57759L15.3681 4.57806Z"
                                              fill="black"/>
                                    </g>
                                </g>
                                <defs>
                                    <clipPath id="clip0_2919_2212">
                                        <rect width="16" height="16" fill="white" transform="translate(0 0.5)"/>
                                    </clipPath>
                                    <clipPath id="clip1_2919_2212">
                                        <rect width="15.3333" height="16" fill="white"
                                              transform="translate(0.666687 0.5)"/>
                                    </clipPath>
                                </defs>
                            </svg>

                        </a>
                        <span class="text_icon">Giỏ hàng</span>
                    </div>
                </div>
            </div>
            <?php $i++;
        } ?>
    </div>
    <input type="hidden" id="videos" value='<?php echo $urlVideo ?>'>
<?php } ?>
