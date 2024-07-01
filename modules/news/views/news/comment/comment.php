<?php if (!empty(@$list_comment)) { ?>
    <div class="list-cmt">
        <?php foreach ($list_comment as $item) { ?>
            <div class="lv0-cmt lv-cmt">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30">
                    <g id="Group_667" data-name="Group 667" transform="translate(-808 -2180)">
                        <rect id="Rectangle_3082" data-name="Rectangle 3082" width="30" height="30" transform="translate(808 2180)" fill="#f9920f"/>
                        <path id="_" data-name="" d="M15.3,13.45a7.707,7.707,0,0,1-12.6,0C2.963,11.571,3.727,9.9,5.434,9.673a4.82,4.82,0,0,0,7.132,0C14.273,9.9,15.037,11.571,15.3,13.45ZM12.857,6.429A3.857,3.857,0,1,1,9,2.571,3.858,3.858,0,0,1,12.857,6.429ZM18,9a9,9,0,1,0-9,9A9,9,0,0,0,18,9Z" transform="translate(814 2186)" fill="#fff"/>
                    </g>
                </svg>

                <div class="cmt-detail">
                    <p class="cmt-name"><?php echo $item->name ?></p>
                    <p class="cmt-cmt"><?php echo $item->comment ?></p>
                    <div class="action">
                        <a data-id="<?php echo $item->id ?>" class="remove-link reply">
                            <i class="fa fa-commenting" aria-hidden="true"></i> <?php echo FSText::_('Trả lời') ?>
                        </a>
                        <a data-id="<?php echo $item->id ?>" class="like-link" data-check="0">
                            <?php $p = $item->add_point == 0 ? '' : $item->add_point ?>
                            <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <b><?php echo $p ?></b> <?php echo FSText::_('Hữu ích') ?>
                        </a>
                        <span><?php echo date('H:i:s d/m/Y ', strtotime($item->created_time)) ?></span>
                    </div>
                </div>
            </div>
            <?php foreach ($item->childs as $val) { ?>
                <div class="lv1-cmt lv-cmt">
                    <?php if($val->is_admin == 1) {?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30">
                            <g id="Group_668" data-name="Group 668" transform="translate(-808 -2214)">
                                <rect id="Rectangle_3083" data-name="Rectangle 3083" width="30" height="30" transform="translate(808 2214)" fill="#f9920f"/>
                                <path id="Vector_3_" data-name="Vector (3)" d="M6.016,0H17.984l3.008,4.75L24,9.5l-3.008,4.75L17.984,19H6.016L3.008,14.25,0,9.5,3.008,4.75ZM12,2.685c4.108,0,7.439,3.039,7.439,6.786S16.108,16.256,12,16.256,4.561,13.217,4.561,9.47,7.892,2.685,12,2.685Z" transform="translate(811 2220)" fill="#fff" fill-rule="evenodd"/>
                            </g>
                        </svg>
                    <?php } else {?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30">
                            <g id="Group_667" data-name="Group 667" transform="translate(-808 -2180)">
                                <rect id="Rectangle_3082" data-name="Rectangle 3082" width="30" height="30" transform="translate(808 2180)" fill="#f9920f"/>
                                <path id="_" data-name="" d="M15.3,13.45a7.707,7.707,0,0,1-12.6,0C2.963,11.571,3.727,9.9,5.434,9.673a4.82,4.82,0,0,0,7.132,0C14.273,9.9,15.037,11.571,15.3,13.45ZM12.857,6.429A3.857,3.857,0,1,1,9,2.571,3.858,3.858,0,0,1,12.857,6.429ZM18,9a9,9,0,1,0-9,9A9,9,0,0,0,18,9Z" transform="translate(814 2186)" fill="#fff"/>
                            </g>
                        </svg>
                    <?php } ?>
                    <div class="cmt-detail">
                        <p class="cmt-name"><?php echo $val->name ?> <?php if($val->is_admin == 1) echo '<span class="span_admin">Quản trị viên</span>' ?></p>
                        <p class="cmt-cmt"><?php echo $val->comment ?></p>
                        <div class="action">
                            <a data-id="<?php echo $item->id ?>" class="remove-link reply">
                                <i class="fa fa-commenting" aria-hidden="true"></i> <?php echo FSText::_('Trả lời') ?>
                            </a>
                            <a data-id="<?php echo $val->id ?>" class="like-link" data-check="0">
                                <?php $point = $val->add_point == 0 ? '' : $val->add_point ?>
                                <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <b><?php echo $point ?></b> <?php echo FSText::_('Hữu ích') ?>
                            </a>
                            <span><?php echo date('H:i:s d/m/Y ', strtotime($val->created_time)) ?></span>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
        <!-- <a class="more-comment">Tải thêm bình luận</a> -->
    </div>
<?php } ?>