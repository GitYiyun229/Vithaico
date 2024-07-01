<?php
global $tmpl, $config;
$img = $data->image ? URL_ROOT . str_replace('/original/', '/large/', $data->image) : '';
//$link = FSRoute::_("index.php?module=news&view=news&id=" . $data->id . "&code=" . $data->alias . "&ccode=" . $data->category_alias);
//$link = FSRoute::_("index.php?module=news&view=news&id=" . $data->id . "&ccode=" . $data->alias . "&code=" . $data->category_alias);
$link = FSRoute::_("index.php?module=news&view=news&ccode=" . $data->alias);
//var_dump($link);
$logo = URL_ROOT.$config['logo'];
$username = $data->action_username ? $data->action_username : 'didongthongminh';
$img = URL_ROOT . str_replace("/original/", "/original/", $data->image);
$schema = '
<script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "NewsArticle",
      "mainEntityOfPage": "' . $link . '",
      "headline": "' . str_replace('"', '\'', $data->title) . '",
      "author": {
          "@type": "Person",
          "name": "' . $username . '",
          "url": "' . $link . '"
        },
      "publisher": {
          "@type": "Organization",
          "name": "didongthongminh",
          "logo": {
            "@type": "ImageObject",
            "url": "https://didongthongminh.vn/images/logo 1.svg",
            "width": 600,
            "height": 60
            }
      },
      "image": {
        "@type": "ImageObject",
        "url": "' . $img . '",
        "height": 1280,
        "width": 720
      },
      "datePublished": "' . $data->created_time . '",
      "dateModified": "' . $data->updated_time . '"
    } 
</script>';

$stype_css_amp = '
                    body {
                            font-family: "Roboto", sans-serif;
                            line-height: 18px;
                            color: #333333;
                      }
                      .logo-image{
                          text-align: center;
                          display: block;
                      }
                      .amp-products {
                            color: #353535;
                            font-weight: 400;
                            overflow-wrap: break-word;
                            word-wrap: break-word;
                      }
                      .sl-table-content ol{
                            counter-reset: item;
                            list-style: none;
                            color: blue;
                      }
                      #tocDiv > ol > li::before{
                         content: counter(item)". ";
                         counter-increment: item;
                      }
                      #tocDiv > ol > li::marker{
                         display:none;
                      }
                      .sl-table-content #tocList li::before{
                         content: counters(item, ".") " "; 
                         counter-increment: item;
                      }
                      .sl-table-content #tocList li::marker{
                         display:none;
                      }
                      .sl-table-content #tocDiv li::before{
                         content: counters(item, ".") " "; 
                         counter-increment: item;
                      }
                      .sl-table-content #tocDiv li::marker{
                         display:none;
                      }
                      .sl-table-content h2,h3 a{
                        color:blue;
                        }
                      .amp-products amp-img {
                            margin: 0px auto;
                            width: 100%;
                            max-height: 250px;
                            max-width: 100%;
                            height:auto;
                        }
                      .amp-description {
                            font-family: "Roboto", sans-serif;
                            font-size: 18px;
                            text-align: left;
                            line-height: 25px;
                        }
                        .amp-description img{
                            max-width: 100%;
                            height:auto;
                            object-fit:contain;
                        }
                        .view {
                            display: inline-block;
                            color: #1E8E04;
                        }
                        header {
                            background-color: #ff6700;
                            position: relative;
                            border-bottom: 1px solid #dddddd;
                            padding: 10px 0px;
                        }
                        footer {
                            border-top: 1px solid #dddddd;
                            color: #ffffff;
                            font-size: 18px;
                            line-height: 24px;
                        }
                        .amp-container{
                            max-width: 840px;
                            margin: 0px auto;
                            padding: 0 10px;
                        }
                        .amp-name{
                            line-height:25px;
                        }
                        .navFrame{
                          background-color : #1E8E04;
                        }
                        .benmarch{
                          display: none;
                        }
                        .list_item_panel{
                          margin:0;
                          padding:0;
                        }
                        .list_item_panel li{
                          line-height:25px;
                        }
                        .list_item_panel li a{
                          color : #fff;
                          text-decoration : none;
                          font-size : 14px;
                          border-bottom : 1px solid #fff;
                          display : block;
                          padding :10px 0 10px 15px;
                        }

                        .titlehome {
                          display: block;
                          overflow: hidden;
                          line-height: 1.3em;
                          font-size: 18px;
                          color: #333;
                          text-transform: uppercase;
                          padding: 10px;
                          border-top: 8px solid #eee;
                          font-weight: 600;
                      }
                      .newslist {
                          display: block;
                          overflow: hidden;
                          padding: 0px;
                      }
                      .newslist li {
                          display: block;
                          overflow: hidden;
                          border-top: 1px solid #eee;
                          padding: 10px 0;
                          margin: 0 10px;
                          position: relative;
                      }
                      .newslist li a.linkimg {
                          float: left;
                          width: 100px;
                          margin-right: 10px;
                          max-height: 70px;
                      }
                      .newslist li a {
                          display: block;
                          overflow: hidden;
                          position: relative;
                          text-decoration : none;
                          color : #333;
                      }
                      .newslist li div {
                          overflow: hidden;
                      }
                      .newslist li div h3 {
                          display: inline;
                      }
                      .newslist li h3 {
                          display: block;
                          overflow: hidden;
                          line-height: 1.3em;
                          font-size: 15px;
                          color: #333;
                      }

                      .newslist li .timepost {
                          display: block;
                          overflow: hidden;
                          font-size: 12px;
                          color: #999;
                      }

                        .navButton,.navClose,.navFrame{top:0;text-align:left;display:block}#navscrim,.navButton:focus{opacity:0}#wrapper_header,body{position:relative}#wrapper_container{position:relative;z-index:0;width:100%;float:left}.navFrame,.sitenav{width:240px;position:absolute;transition:transform .5s cubic-bezier(0,1,0,1)}.logo_mobile{float:left;margin:0 0 0 30px}.navButton,.navClose{width: 100px;height: 58px;position:absolute;left:0;z-index:3;background-color:transparent;border:none;outline:0;color:#fff;font-size:25px;line-height:1.5em;padding:10px 0 0 10px;cursor:pointer}.navClose{left:240px;z-index:-1;visibility:hidden}.navFrame{background-color:#333;border:0;padding:0;margin:0;left:0;height:100%;box-sizing:border-box;z-index:2;transform:translateX(-245px);-webkit-transform:translateX(-245px)}.eclick_300_250,.eclick_320_50{margin:0 auto;text-align:center;display:inline-block;width:100%}.sitenav{top:45px;right:0;transform:translateX(-150px);-webkit-transform:translateX(-150px)}#navscrim{position:fixed;top:0;left:0;width:100vw;height:100vh;z-index:1;background-color:#999;transition:opacity 250ms cubic-bezier(0,.67,0,.67);pointer-events:none}.navButton:focus~.navFrame,.navButton:focus~.navFrame .sitenav{transform:translateX(0);-webkit-transform:translateX(0)}.navButton:focus~.navClose,.navFrame:active{z-index:3;visibility:visible}.navButton:focus~#navscrim,.navFrame:active~#navscrim{opacity:.75;pointer-events:auto}.eclick_320_50{height:50px}.eclick_300_250{height:250px}.amp-next-page-default-separator{border-bottom:2px solid red}.txt_adbyeclick{text-align:center;margin-bottom:10px;position:relative}.txt_adbyeclick:before{content:"";width:100%;height:1px;position:absolute;top:50%;margin-top:-.5px;left:0;background:#e7e7e7}.txt_adbyeclick span{background:#fff;padding:0 5px;display:inline-block;position:relative;z-index:1;font:400 14px arial;color:#999}

                        .breadcrumb{margin-bottom:0;padding:0;background:none}.breadcrumb .fl-left{float:left;font-weight:normal;margin:2px 0}.breadcrumb a{color:#626262;font-size:13px;font-weight:normal}.breadcrumb a span{color:#626262}.breadcrumbs_sepa{background:url("/blocks/breadcrumbs/assets/images/right_arrow.png") no-repeat scroll left center;float:left;margin:0 5px;margin-top:10px;padding:4px;text-indent:-999px}@media screen and (max-width: 767px){.breadcrumb{width:max-content}.breadcrumbs>.container>.row{overflow:hidden;margin:0}.breadcrumbs>.container>.row>.col-xs-12{overflow:auto;margin-top:13px;}.breadcrumbs>.container>.row>.col-xs-12::-webkit-scrollbar{width:0;display:none}.breadcrumbs_sepa{margin: 5px;padding: 14px 0 0 8px}}
                       table {border-collapse: collapse;} td {border: 1px solid #111; border-collapse: collapse; }
                       h2 {font-size: 21px;}
                    ';
//    var_dump($link);
$tmpl->load_amp(1, 1, $stype_css_amp, $schema, $link, '', 1);
?>
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
            <?php echo $tmpl->load_direct_blocks('breadcrumbs', array('style' => 'simple')); ?>
            </div>
        </div>
    </div>
</div>
<div class="amp-products">
    <h1 class="amp-name">
        <?php echo $data->title; ?>
    </h1><!-- END: .name-products -->
    <div>
        <p class='view'><?php echo date('d/m/Y', strtotime($data->created_time)); ?></p>
        <?php if ($data->author) { ?>
            <p class="view"> - <?php echo $data->author; ?></p>
        <?php } ?>
    </div>
    <div class="amp-description">
        <?php
        $description = html_entity_decode($data->content);

        $description = str_replace('arial=""', '', $description);
        $description = str_replace('<meta charset="utf-8" />', '', $description);
        // $description = str_replace('</iframe>', '', $description);
        $description = str_replace('<style type="text/css"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->
</style>', '', $description);

        $description = preg_replace('/v="([^"]*)"\s*\/?/', '', $description);
        $description = preg_replace('/onclick="([^"]*)"\s*\/?/', '', $description);
        $description = preg_replace('/border="([^"]*)"\s*\/?/', '', $description);
        $description = preg_replace('/new="([^"]*)"\s*\/?/', '', $description);
        $description = preg_replace('/roman="([^"]*)"\s*\/?/', '', $description);
        $description = preg_replace('/times="([^"]*)"\s*\/?/', '', $description);
        $description = preg_replace('/type="([^"]*)"\s*\/?/', '', $description);
        $description = preg_replace('/<font color="([^"]*)"\s*\/?>/', '', $description);

        // $description = preg_replace('/(<new>)|(<\/new>)/', '', $description);
        // $description = preg_replace('/(<roman>)|(<\/roman>)/', '', $description);
        // $description = preg_replace('/(<font color="#3498db">)|(<\/font>)/', '', $description);
        $description = preg_replace('/(<bold>)|(<\/bold>)/', '', $description);
        $description = preg_replace('/(<form>)|(<\/form>)/', '', $description);

        $description = preg_replace(
            '/onclick="([^"]*)"\s*\/?/',
            '',
            $description
        );

        $description = preg_replace(
            '/<img src="([^"]*)"\s*\/?>/',
            '<amp-img src="$1" width="1.5" height="1" layout="responsive"></amp-img>',
            $description
        );


        $description = preg_replace(
            '/<img alt="([^"]*)" src="([^"]*)"\s*\/?>/',
            '<amp-img src="$2" width="1.5" height="1" alt="$1" layout="responsive"></amp-img>',
            $description
        );

        $description = preg_replace(
            '/<img alt="([^"]*)" src="([^"]*)" style="([^"]*)"\s*\/?>/',
            '<amp-img src="$2" width="1.5" height="1" alt="$1" layout="responsive"></amp-img>',
            $description
        );
        $description = preg_replace(
            '/<img src="([^"]*)" style="([^"]*)"\s*\/?>/',
            '<amp-img src="$1" width="1.5" height="1" layout="responsive"></amp-img>',
            $description
        );
        $description = preg_replace(
            '/<img alt="([^"]*)" src="([^"]*)" title="([^"]*)"\s*\/?>/',
            '<amp-img src="$2" width="1.5" height="1" alt="$1" layout="responsive"></amp-img>',
            $description
        );

        $description = preg_replace(
            '/<img alt="([^"]*)" src="([^"]*)" style="([^"]*)" title="([^"]*)"\s*\/?>/',
            '<amp-img src="$2" width="1.5" height="1" alt="$1" title="$4" layout="responsive"></amp-img>',
            $description
        );

        $description = preg_replace(
            '/<img alt="([^"]*)" src="([^"]*)" style="([^"]*)" title="([^"]*)"\s*\/?>/',
            '<amp-img src="$2" width="1.5" height="1" alt="$1" title="$4" layout="responsive"></amp-img>',
            $description
        );

        $description = preg_replace(
            '/<img alt="([^"]*)" data-height="([^"]*)" data-width="([^"]*)" src="([^"]*)" style="([^"]*)" title="([^"]*)"\s*\/?>/',
            '<amp-img src="$4" width="1.5" height="1" alt="$1" title="$6" layout="responsive"></amp-img>',
            $description
        );
        // $description = str_replace("https://www.youtube.com/embed/", "", $description);
        $description = preg_replace(
            '/<iframe allow="([^"]*)" allowfullscreen="([^"]*)" frameheight="([^"]*)" src="([^"]*)" width="([^"]*)"\s*\/?>/',
            '<amp-youtube data-videoid="$4" layout="responsive" width="$5" height="$3"></amp-youtube>',
            $description
        );
        $description = preg_replace(
            '/<iframe allow="([^"]*)" allowfullscreen="([^"]*)" frameheight="([^"]*)" src="([^"]*)" title="([^"]*)" width="([^"]*)"\s*\/?>/',
            '<amp-youtube data-videoid="$4" layout="responsive" width="$6" height="$3"></amp-youtube>',
            $description
        );

        // $description = str_replace("https://www.youtube.com/embed/", "", $description);
        $description = str_replace(['<font face="Arial, Helvetica, sans-serif">', '</font>'], ['', ''], $description);

        $description = preg_replace(
            '/<iframe allow="([^"]*)" allowfullscreen="([^"]*)" frameborder="([^"]*)" height="([^"]*)" src="([^"]*)" style="([^"]*)" width="([^"]*)"\s*\/?>/',
            '<amp-youtube data-videoid="$5" layout="responsive" width="$7" height="$4"></amp-youtube>',
            $description
        );
        $description = preg_replace(
            '/<iframe allow="([^"]*)" allowfullscreen="([^"]*)" frameborder="([^"]*)" height="([^"]*)" src="([^"]*)" width="([^"]*)"\s*\/?>/',
            '<amp-youtube data-videoid="$5" layout="responsive" width="$6" height="$4"></amp-youtube>',
            $description
        );
        $description = preg_replace(
            '/<iframe allow="([^"]*)" allowfullscreen="([^"]*)" frameborder="([^"]*)" height="([^"]*)" src="([^"]*)" title="([^"]*)" width="([^"]*)"\s*\/?>/',
            '<amp-youtube data-videoid="$5" layout="responsive" width="$7" height="$4"></amp-youtube>',
            $description
        );
        $description = preg_replace(
            '/<iframe width="([^"]*)" height="([^"]*)" src="([^"]*)" frameborder="([^"]*)" allow="([^"]*)" allowfullscreen\s*\/?>/',
            '<amp-youtube data-videoid="$3" layout="responsive" width="$1" height="$2"></amp-youtube>',
            $description
        );

        $description = preg_replace(
            '/<iframe width="([^"]*)" height="([^"]*)" src="([^"]*)" frameallow="([^"]*)" allowfullscreen\s*\/?>/',
            '<amp-youtube data-videoid="$3" layout="responsive" width="$1" height="$2"></amp-youtube>',
            $description
        );

        $description = preg_replace(
            '/<iframe allowfullscreen="([^"]*)" frameborder="([^"]*)" height="([^"]*)" scrolling="([^"]*)" src="([^"]*)" width="([^"]*)"\s*\/?>/',
            '',
            $description
        );

        $description = preg_replace(
            '/<iframe allowfullscreen="([^"]*)" frameborder="([^"]*)" height="([^"]*)" scrolling="([^"]*)" src="([^"]*)" width="([^"]*)"\s*\/?>/',
            '',
            $description
        );

        $description = preg_replace(
            '/<iframe allow="([^"]*)" allowfullscreen="([^"]*)" frameborder="([^"]*)" height="([^"]*)" src="([^"]*)" width="([^"]*)"\s*\/?>/',
            '',
            $description
        );

        $description = preg_replace(
            '/<iframe loading="([^"]*)" title="([^"]*)" width="([^"]*)" height="([^"]*)" src="([^"]*)" frameallow="([^"]*)" allowfullscreen="([^"]*)">/',
            '<amp-iframe width="$3" height="$4" sandbox="allow-scripts allow-same-origin allow-presentation" layout="responsive" frameborder="0" src="$5">',
            $description
        );

        $description = preg_replace(
            '/<iframe allowfullscreen="([^"]*)" allowscriptaccess="([^"]*)" frameheight="([^"]*)" scrolling="([^"]*)" src="([^"]*)" width="([^"]*)">/',
            '<amp-iframe width="$6" height="$3" sandbox="allow-scripts allow-same-origin allow-presentation" layout="responsive" frameborder="0" src="$5">',
            $description
        );

        $description = preg_replace(
            '/<iframe allowfullscreen="([^"]*)" frameborder="([^"]*)" height="([^"]*)" src="([^"]*)" width="([^"]*)">/',
            '<amp-iframe width="$5" height="$3" sandbox="allow-scripts allow-same-origin allow-presentation" layout="responsive" frameborder="0" src="$4">',
            $description
        );

        $description = preg_replace(
            '/<iframe allowfullscreen="([^"]*)" frameheight="([^"]*)" src="([^"]*)" width="([^"]*)">/',
            '<amp-iframe width="$4" height="$2" sandbox="allow-scripts allow-same-origin allow-presentation" layout="responsive" frameborder="0" src="$3">',
            $description
        );

        $description = str_replace(
            '<iframe',
            '<amp-iframe',
            $description
        );

        $description = str_replace(
            'frameheight',
            'height',
            $description
        );

        $description = str_replace(
            '</iframe>',
            '<amp-img layout="fill" src="/images/not_picture.png" placeholder></amp-img></amp-iframe>',
            $description
        );

        // $description = str_replace(
        //     '</iframe>',
        //     '',
        //     $description
        // );
    
        $description = preg_replace(
            '#<style >(.*?)</style>#is',
            '',
            $description
        );
        $description = preg_replace(
            '#<style>(.*?)</style>#is',
            '',
            $description
        );
        $description = preg_replace('#<style type="text/css">.*?</style>#s', '', $description);
        echo html_entity_decode($description);
        ?>
    </div>
    <?php if (count($relate_news_list)) { ?>
        <h3 class="titlehome">Bài viết liên quan</h3>
        <ul class="newslist relate">
            <?php foreach ($relate_news_list as $item) {
                //                $link_news = FSRoute::_("index.php?module=news&view=news&code=" . $item->alias . "&id=" . $item->id . "&ccode=" . $item->category_alias);
                $link_news = FSRoute::_("index.php?module=news&view=news&ccode=" . $item->alias . "&id=" . $item->id . "&code=" . $item->category_alias);
                $images = URL_ROOT . str_replace('/original/', '/resize/', $item->image);
                ?>
                <li>
                    <a href="<?php echo $link_news; ?>" class="linkimg">
                        <amp-img src="<?php echo $images; ?>" width="100" height="70" layout="responsive">
                        </amp-img>
                    </a>
                    <div>
                        <h3>
                            <a href="<?php echo $link_news; ?>">
                                <?php echo $item->title; ?>
                            </a>
                        </h3>
                        <span class="timepost"><?php echo date('d/m/Y', strtotime($item->created_time)); ?></span>
                    </div>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>
</div>