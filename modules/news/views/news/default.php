<?php global $tmpl;
$tmpl->addStylesheet('detail', 'modules/news/assets/css');
$tmpl->addScript('form');
$tmpl->addScript('main');
$tmpl->addScript('jquery.toc', 'modules/news/assets/js');
$tmpl->addScript('detail', 'modules/news/assets/js');
?>
<div class="news_detail wapper-page wapper-page-detail">
    <div class="row">
        <div class="col-md-12">
            <?php echo $tmpl->load_direct_blocks('news_filter', array('style' => 'inline')); ?>
        </div>
        <div class="col-md-9">
           
            <div class="wapper-content-page mt20">
                <h1 class='content_title'>
                    <span><?php echo $data->title; ?></span>
                </h1>
                <div class="clock clearfix">
                    <span class='datetime'><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date('d/m/Y', strtotime($data->created_time)); ?></span>
                    <span class="view"><i class="fa fa-eye" aria-hidden="true"></i> <?php echo $data->hits; ?></span>
                    <span class="author">Tác giả: <span><?php echo $data->author; ?></span></span>
                    <?php echo $user->full_name; ?>
                </div>
                <?php if ((strpos($data->content, 'h2') == true)) { ?>
                    <div class="row">
                        <div class=" col-md-8">
                            <div class="toc-content rounded mb-4" id="left1">
                                <div class="title-toc-list d-flex justify-content-between p-3">
                                    <h3 class="title-toc"><i class="fa fa-bars mr-1"></i><span class="title"><?php echo FSText::_('Nội dung chính') ?></span></h3>
                                    <span class="button-select">
                                        <span class="tablecontent none">
                                            <img src="/images/index.svg" alt="mục lục">
                                        </span>
                                        <i class="fa fa-angle-down"></i>
                                    </span>
                                </div>
                                <div class="list-toc">
                                    <ol id="toc" class="p-3 pb-0"></ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                <?php } ?>
                <div class='description clearfix'>
                    <?php

                    $description = preg_replace(
                        '/<img alt="([^"]*)" src="([^"]*)" style="([^"]*)" title="([^"]*)"\s*\/?>/',
                        '<img alt="$1" data-src="$2" style="$3" title="$4">',
                        $description);
                    $description = preg_replace(
                        '/<img alt="([^"]*)" src="([^"]*)" title="([^"]*)"\s*\/?>/',
                        '<img alt="$1" data-src="$2" title="$3">',
                        $description);
                    $description = preg_replace(
                        '/<img alt="([^"]*)" src="([^"]*)" style="([^"]*)"\s*\/?>/',
                        '<img alt="$1" data-src="$2" style="$3">',
                        $description);
                    $description = preg_replace(
                        '/<img alt="([^"]*)" src="([^"]*)"\s*\/?>/',
                        '<img alt="$1" data-src="$2">',
                        $description);
                    $description = preg_replace(
                        '/<img  src="([^"]*)"\s*\/?>/',
                        '<img  data-src="$1">',
                        $description);
                    $description = str_replace('<table','<div class="tbl"><table',$description);
                    $description = str_replace('</table>','</table></div>',$description);
                    echo $data->content;
                    ?>
                </div>
                <div class="author">Tác giả <span><?php echo $data->author; ?></span></div>
                <?php if($user->summary !='') {?>
                    <div class="author_des">
                        <?php if($user->image !='') {?>
                            <div class="image">
                                <?php echo '<img src='.str_replace('/original/','/small/',$user->image).' alt="Tác giả"'.$user->full_name. '>'; ?>
                            </div>
                        <?php } ?>
                        <div class="sum">
                            <?php echo $user->summary;?>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($data->category_id == 4) { ?>
                <div class="apply_cv">
                    <script data-b24-form="click/16/xhkzpe" data-skip-moving="true">
                        (function(w,d,u){
                            var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/180000|0);
                            var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
                        })(window,document,'https://cdn.bitrix24.vn/b19243465/crm/form/loader_16.js');
                    </script>
                    <button>Ứng tuyển vào vị trí này</button>
                </div>
                    <style>
                        .b24-widget-button-wrapper{
                            display: none !important;
                        }
                        #fb-root {
                            display: none !important;
                        }
                    </style>
                <?php } ?>
                <?php if($data->tags != '' && $data->tags != null && $data->tags != ',,') {?>
                    <div class="list_tags">
                        <svg xmlns="http://www.w3.org/2000/svg" width="38" height="30" viewBox="0 0 38 30">
                            <g transform="translate(-823 -709)">
                                <path d="M0,15,9.5,0h19L38,15,28.5,30H9.5Z" transform="translate(823 709)" fill="#ff6700"/>
                                <path d="M4,2.857A1.143,1.143,0,1,1,2.857,1.714,1.139,1.139,0,0,1,4,2.857ZM13.527,8a1.187,1.187,0,0,0-.33-.812L6.813.813A3.148,3.148,0,0,0,4.857,0H1.143A1.151,1.151,0,0,0,0,1.143V4.857A3.1,3.1,0,0,0,.813,6.8L7.2,13.2a1.149,1.149,0,0,0,.8.33,1.187,1.187,0,0,0,.813-.33L13.2,8.8A1.149,1.149,0,0,0,13.527,8Zm3.429,0a1.187,1.187,0,0,0-.33-.812L10.241.813A3.148,3.148,0,0,0,8.286,0h-2A3.148,3.148,0,0,1,8.241.813l6.384,6.375a1.187,1.187,0,0,1,.33.813,1.149,1.149,0,0,1-.33.8l-4.2,4.2a1.278,1.278,0,0,0,1,.527,1.187,1.187,0,0,0,.813-.33L16.625,8.8A1.149,1.149,0,0,0,16.955,8Z" transform="translate(833.522 717.237)" fill="#fff"/>
                            </g>
                        </svg>
                        <span><?php echo FSText::_('Tags:') ?></span>
                        <?php $record = $this->model->get_records('id in (0'.$data->tags.'0)','fs_news_tags','name,id,alias') ?>
                        <?php foreach ($record as $item) {?>
                            <a href="<?php echo FSRoute::_('index.php?module=news&view=tags&ccode='.$item->alias) ?>" title="<?php echo $item->name ?>">
                                <?php echo $item->name ?>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>

                <div class="share">
                    <div class="fb-share-button" data-href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REDIRECT_URL']; ?>" data-layout="button_count"></div>
                    <div class="fb-like" data-href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REDIRECT_URL']; ?>" data-layout="button_count" data-action="like"></div>
                </div>
                <div class="clear"></div>

                <div class="watching">
                    <div class="current">
                        <span><?php echo FSText::_('Bạn đang xem:') ?></span> <?php echo $data->title ?>
                    </div>
                    <div class="control">
                        <?php @$link_before = @$this->model->get_record('id < '.$data->id.' and published = 1 ','fs_news','id,alias') ?>
                        <?php if(@$link_before) {?>
                            <a class="left" href="<?php echo FSRoute::_('index.php?module=news&view=news&ccode='.$link_before->alias) ?>" title="<?php echo FSText::_('Bài trước') ?>">
                                <i class="fa fa-angle-left"></i>
                                <?php echo FSText::_('Bài trước') ?>
                            </a>
                        <?php } ?>
                        <?php @$link_after = @$this->model->get_record('id > '.$data->id.' and published = 1 ','fs_news','id,alias') ?>
                        <?php if(@$link_after) {?>
                            <a class="right" href="<?php echo FSRoute::_('index.php?module=news&view=news&ccode='.$link_after->alias) ?>" title="<?php echo FSText::_('Bài tiếp') ?>" >
                                <?php echo FSText::_('Bài tiếp') ?>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        <?php } ?>
                    </div>
                </div>
                <?php if (@$products_related) { ?>
                    <div class="buy-bottom">
                        <div class="media-img ">
                            <img class="img-responsive " src="<?php echo URL_ROOT . str_replace('/original/', '/resized/', $products_related->image); ?>" alt="<?php echo $products_related->name; ?>">
                            <div class="lef-b">
                                <p><?php echo $products_related->name ?></p>
                                <span class='_price '>
                                    <?php echo format_money($products_related->price, ' đ') ?>
                                </span>
                            </div>
                        </div>
                        <div class="btn-add">
                            <a id="buy-now" href="<?php echo FSRoute::_('index.php?module=products&view=product&code=' . $products_related->alias . '&id=' . $products_related->id . '&ccode=' . $products_related->category_alias . '') ?>" class="btn-buy btn mt10" data-toggle="modal">
                                Mua hàng ngay
                            </a>
                            <?php if ($products_related->is_service == 0 && $products_related->is_accessories == 0) { ?>
                                <a id="buy-pig" href="<?php echo FSRoute::_('index.php?module=products&view=product&code=' . $products_related->alias . '&id=' . $products_related->id . '&ccode=' . $products_related->category_alias . '') ?>" class="btn-buy btn mt10" data-toggle="modal">
                                    Mua trả góp
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
<!--                --><?php //include_once 'default_related.php'; ?>
                <?php if($data->news_related) {?>
                    <div class="related">
                        <h4 class="title-related">
                            <svg xmlns="http://www.w3.org/2000/svg" width="43" height="36" viewBox="0 0 43 36">
                                <g id="news_related" transform="translate(-823 -709)">
                                    <path id="Polygon_22_1_" data-name="Polygon 22 (1)" d="M0,18,10.5,0h21L42,18,31.5,36h-21Z" transform="translate(824 709)" fill="#fff"/>
                                    <rect id="Rectangle_3085" data-name="Rectangle 3085" width="10" height="36" transform="translate(823 709)" fill="#fff"/>
                                    <path id="Polygon_22_1_2" data-name="Polygon 22 (1)" d="M0,18,10.5,0h21L42,18,31.5,36h-21Z" transform="translate(823 709)" fill="#ff6700"/>
                                    <circle id="Ellipse_351" data-name="Ellipse 351" cx="13" cy="13" r="13" transform="translate(831 714)" fill="#fff"/>
                                    <path id="Vector_2_" data-name="Vector (2)" d="M2.125,4.438H12.75V3.375H2.125Zm5.844,6.375h3.719V9.75H7.969Zm0-2.125H12.75V7.625H7.969Zm0-2.125H12.75V5.5H7.969Zm-5.844,4.25H6.906V5.5H2.125Zm12.75-8.5V.188H0V11.875A2.081,2.081,0,0,0,2.125,14H15.406S17,13.967,17,11.875V2.313ZM2.125,12.938a1.041,1.041,0,0,1-1.062-1.062V1.25h12.75V11.875a1.537,1.537,0,0,0,.359,1.063Z" transform="translate(835.5 719.906)" fill="#ff6700"/>
                                </g>
                            </svg>
                            <span><?php echo FSText::_('Bài viết liên quan') ?></span>
                        </h4>
                        <div class="list-related">
                            <?php foreach ($list_related as $item) {
                                $link = FSRoute::_('index.php?module=news&view=news&ccode='.$item->alias);
                                ?>
                                <div class="item-related">
                                    <a href="<?php echo $link ?>" title="<?php echo $item->title ?>">
                                        <img src="<?php echo URL_ROOT.str_replace('/original/','/resize/',$item->image) ?>" alt="<?php echo $item->title ?>" class="img-responsive">
                                    </a>
                                    <a class="name" href="<?php echo $link ?>" title="<?php echo $item->title ?>">
                                        <?php echo $item->title ?>
                                    </a>
                                    <div class="time-hits">
                                        <span><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date('d/m/Y',strtotime($item->created_time)) ?></span>
                                        <span><i class="fa fa-eye" aria-hidden="true"></i> <?php echo $item->hits ?></span>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>

                <div class="comment-area">
                    <h4 class="title-related">
                        <svg xmlns="http://www.w3.org/2000/svg" width="43" height="36" viewBox="0 0 43 36">
                            <g id="news_related" transform="translate(-823 -709)">
                                <path id="Polygon_22_1_" data-name="Polygon 22 (1)" d="M0,18,10.5,0h21L42,18,31.5,36h-21Z" transform="translate(824 709)" fill="#fff"/>
                                <rect id="Rectangle_3085" data-name="Rectangle 3085" width="10" height="36" transform="translate(823 709)" fill="#fff"/>
                                <path id="Polygon_22_1_2" data-name="Polygon 22 (1)" d="M0,18,10.5,0h21L42,18,31.5,36h-21Z" transform="translate(823 709)" fill="#ff6700"/>
                                <circle id="Ellipse_351" data-name="Ellipse 351" cx="13" cy="13" r="13" transform="translate(831 714)" fill="#fff"/>
                                <path id="_" data-name="" d="M7.071,1.428c3.134,0,5.786,1.768,5.786,3.857S10.205,9.143,7.071,9.143A8.66,8.66,0,0,1,5.535,9L5,8.9l-.442.311c-.2.141-.412.271-.623.392l.352-.844L3.315,8.2A3.541,3.541,0,0,1,1.286,5.285C1.286,3.2,3.938,1.428,7.071,1.428Zm0-1.286C3.164.143,0,2.443,0,5.285A4.807,4.807,0,0,0,2.672,9.313,5.192,5.192,0,0,1,1.5,10.981c-.11.131-.241.251-.2.442a.341.341,0,0,0,.321.291h.03a7.334,7.334,0,0,0,.864-.161A8.434,8.434,0,0,0,5.3,10.268a10.065,10.065,0,0,0,1.768.161c3.907,0,7.071-2.3,7.071-5.143S10.979.143,7.071.143Zm8.257,11.742A4.794,4.794,0,0,0,18,7.857a4.843,4.843,0,0,0-2.8-4.1,5.206,5.206,0,0,1,.231,1.527,5.8,5.8,0,0,1-2.6,4.681,9.862,9.862,0,0,1-5.756,1.748c-.291,0-.593-.02-.884-.04A8.709,8.709,0,0,0,10.929,13a10.055,10.055,0,0,0,1.768-.161,8.432,8.432,0,0,0,2.792,1.286,7.313,7.313,0,0,0,.864.161.343.343,0,0,0,.352-.291c.04-.191-.09-.311-.2-.442A5.193,5.193,0,0,1,15.328,11.885Z" transform="translate(836 719.785)" fill="#ff6700"/>
                            </g>
                        </svg>
                        <span><?php echo FSText::_('Bình luận') ?> (<?php echo $total_comment ?>)</span>
                    </h4>
                    <?php include_once 'comment/comment.php'?>
                    <?php include_once 'comment/form.php'?>
                </div>

<!--                <div class="frame-content  hidden-md hidden-sm hidden-xs">-->
<!--                    --><?// include_once("comment_facebook.php"); ?>
<!--                </div>-->


                <input type="hidden" value="<?php echo $data->id; ?>" name='news_id' id='news_id'/>
            </div>
        </div>
        <div class="col-md-3">
            <div class="block_newslist">
                <?php echo $tmpl->load_direct_blocks('newslist', array('style' => 'default', 'limit' => '5')); ?>
            </div>
            <?php echo $tmpl->load_direct_blocks('newslist', array('style' => 'sale', 'limit' => '5')); ?>
        </div>
    </div>

</div>
<?php $faq = json_decode($data->faq) ?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "NewsArticle",
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "<?php echo $link_news; ?>"
    },
    "headline": "<?php echo str_replace('"', '', $data->title) ?>",
    "image": "<?php echo URL_ROOT . str_replace('/original/', '/original/', $data->image) ?>",  
    "author": {
        "@type": "Person",
        "name": "<?php echo $data->action_username ? $data->action_username : 'Didongthongminh.vn' ?>"
    },  
    "publisher": {
        "@type": "Organization",
        "name": "Didongthongminh",
        "logo": {
            "@type": "ImageObject",
            "url": "https://didongthongminh.vn/images/config/lg_1648528949.svg"
        }
    },
    "datePublished": "<?php echo date('Y-m-d',strtotime($data->created_time)) ?>",
    "dateModified": "<?php echo date('Y-m-d',strtotime($data->updated_time)) ?>"
}
</script> 

<?php if(!empty($faq)) {?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [
        <?php foreach($faq as $i=>$item) {?>
            {
                "@type": "Question",
                "name": "<?php echo $item->question ?>",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "<?php echo $item->answer ?>"
                }   
            }<?php echo $i == count($faq) - 1 ? '' : ',' ?>
        <?php } ?> 
        ]
    }
    </script>
<?php } ?>