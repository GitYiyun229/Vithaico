<?php
global $config; 
global $tmpl;
$tmpl -> addScript('connect','modules/connect/assets/js');
$tmpl -> addStylesheet('connect','modules/connect/assets/css'); 
//$tmpl -> addTitle(FSText::_('Liên hệ'));
$Itemid = FSInput::get('Itemid', 0);
?>
<?php if($tmpl->count_block('aside-position')){?>
    <aside id="aside" class="aside-contact">
        <?php $tmpl->load_direct_blocks('menu', array('group'=>5)); ?>
        <?php $tmpl->load_position('aside-position');?>
    </aside><!--end: #aside-->
<?php }?>
<section id="content" class="home row">
    <div class="more-news clearfix contact-form">
        <div class="sub-more-news col-sm-6">
            <span>Liên hệ với <?php echo $config['site_name']?></span>
<!--            <p><i class="fa fa-map-marker" aria-hidden="true"></i> Địa chỉ : --><?php //echo $config['address']?><!--</p>-->
<!--            <p><i class="fa fa-phone" aria-hidden="true"></i> Điện thoại : --><?php //echo $config['hotline']?><!--</p>-->
<!--            <p><i class="fa fa-envelope-o" aria-hidden="true"></i> Email : --><?php //echo $config['admin_email']?><!--</p>-->
<!--            <p><i class="fa fa-wikipedia-w" aria-hidden="true"></i> Website : --><?php //echo URL_ROOT?><!--</p>-->
            <?php echo $config['address']?>
        </div><!--end: .sub-more-news-->
        <div class="sub-more-news col-sm-6">
            <form class="row" id="frm_contact" method="post" action="#" name="contact" onsubmit="return validContact()" >
                <div class="bound-input col-sm-6">
                    <input value="" name="contact_name" id="contact_name" placeholder="Họ và tên" type="text" />
                </div>

                <div class="bound-input col-sm-6">
                    <input value="" name="contact_address" id="contact_address" placeholder="Email" type="text" />
                </div>

                <div class="bound-input col-sm-12">
                    <textarea name='message' id='message' placeholder="Nội dung"></textarea>
                </div>

                <div class="bound-input col-sm-4">
                    <input type="text" id="txtCaptcha" value="" placeholder="Mã bảo mật" name="txtCaptcha" size="5" />
                </div>
                
                <div class="bound-input col-sm-4">
                    <a href="javascript:changeCaptcha();"  title="Click here to change the captcha" class="code-view" >&nbsp
                        <img id="imgCaptcha" src="libraries/jquery/ajax_captcha/create_image.php" /></a>
                </div>

                <div class="bound-input col-sm-4">
                    <a class="btn-submit" href="javascript:void(0);" onclick="validContact();" title="Gửi liên hệ">Gửi liên hệ</a>
                </div>

                <input type="hidden" name="module" value="connect"/>
                <input type="hidden" name="task" value="save"/>
                <input type="hidden" name="view" value="connect"/>
                <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>"/>
            </form>
        </div><!--end: .sub-more-news-->
    </div><!--end: .more-news-->
</section><!--end: #content-->