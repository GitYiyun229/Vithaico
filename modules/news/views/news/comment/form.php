<div class="form-post">
    <h6>Viết bình luận của bạn</h6>
    <p>Địa chỉ email của bạn sẽ được bảo mật. Các trường bắt buộc được đánh dấu <span>*</span></p>
    <form class="frmCmt" action="index.php?module=news&view=news&task=save_comment&id=<?php echo $data->id ?>" method="post" id="comments-news">
        <div class="input-cmt">
            <label for="content">Nội dung <span>*</span></label>
            <textarea rows="4" id="content" class="form-control" placeholder="<?php echo FSText::_('Mời bạn thảo luận, vui lòng nhập Tiếng Việt có dấu') ?>" name="content"></textarea>
        </div>
        <div class="input-cmt input-cmt50">
            <label for="fullname">Họ tên <span>*</span></label>
            <input id="fullname" name="fullname" class="form-control" type="text" placeholder="<?php echo FSText::_('Họ tên') ?>"/>
        </div>
        <div class="input-cmt input-cmt50">
            <label for="email">Email <span>*</span></label>
            <input id="email" name="email" class="form-control" type="text" placeholder="<?php echo FSText::_('Email') ?>"/>
        </div>
        <div class="input-cmt input-last">
            <a class="send-comment-news remove-link"><?php echo FSText::_("Gửi bình luận") ?></a>
            <input id="link" type="hidden" name="link" value="<?php echo FSRoute::_("index.php?module=news&view=news&id=$data->id&ccode=$data->alias") ?>">
        </div>
    </form>
</div>
<input type="hidden" id="news_id" value="<?php echo $data->id ?>"/>