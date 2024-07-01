<!--<script src="http://maps.google.com/maps/api/js?key=AIzaSyB7H0Asoc2NhQLbloEAbCPYg2my-oxX_p4" type="text/javascript"></script>-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB7H0Asoc2NhQLbloEAbCPYg2my-oxX_p4&libraries=geometry,places&callback=initialize&sensor=false" async defer></script>
<?php
global $tmpl;
$tmpl->addStylesheet('cat', 'modules/address/assets/css');
$tmpl->addStylesheet('jquery.mCustomScrollbar', 'modules/address/assets/css');
$tmpl->addScript('jquery.mCustomScrollbar.concat.min', 'modules/address/assets/js');
$tmpl->addScript('cat', 'modules/address/assets/js', 'bottom');
$total = count($list);
$i = 0;

if ($data) {
    $seo_title = $data->seo_title ? $data->seo_title : $data->name;
    $seo_keyword = $data->seo_keyword ? $data->seo_keyword : $seo_title;
    $seo_description = $data->seo_description ? $data->seo_description : $data->address;
    $tmpl->addTitle($seo_title);
    $tmpl->addMetakey($seo_keyword);
    $tmpl->addMetades($seo_description);
}
?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&language=vi"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXTSbsa6RsBB0ftvHTrBSIpsc11BNEKAI&libraries=geometry,places&callback=initialize&sensor=false" async defer></script>

<?php if ($tmpl->count_block('default-position')) { ?>
    <?php $tmpl->load_position('default-position'); ?>
<?php } ?>
<script type="text/javascript">
    function initialize(address, latitude, longitude, info, zoom) {
        var map;
        var bounds = new google.maps.LatLngBounds();
        var mapOptions = {
            mapTypeId: 'roadmap'
        };
        var image = '../templates/default/img/arrow-up1.png';
        map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
        map.setTilt(45);
        var markers2 = {
        <?php
        foreach($list as $value){
        ?>
        <?php echo $value->id; ?>:
        '<div class="info_content"><div class="map-top"><h4><?php echo $value->name ?></h4><p><?php echo "Địa chỉ: " . $value->address ?></p><p><?php echo "Điện thoại: " . $value->phone ?></p><p><?php echo "Email: " . $value->email ?></p></div><div class="map-bottom"><?php foreach ($info_other as $value_other) {
            if ($value->id == $value_other->record_id) {
                echo "<p>" . $value_other->source . "</p>";
            }
        } ?></div></div>',
        <?php
        }
        ?>
    }
        ;

        if (address != '' && latitude != '' && longitude != '') {
            var markers = [
                [address, latitude, longitude]
            ];
        } else {
            var markers = [
                <?php
                foreach($list as $value){
                ?>
                ["<?php echo $value->name; ?>", <?php echo $value->latitude; ?>,<?php echo $value->longitude; ?>],
                <?php
                }
                ?>


            ];

        }
        if (info == 0) {
            var infoWindowContent = [
                <?php
                foreach($list as $value){
                ?>
                ['<div class="info_content">' + '<div class="map-top"><h4><?php echo $value->name ?></h4><p><?php echo "Địa chỉ: " . $value->address ?></p><p><?php echo "Điện thoại: " . $value->phone ?></p><p><?php echo "Email: " . $value->email ?></p></div>' + '<div class="map-bottom"><?php foreach ($info_other as $value_other) {
                    if ($value->id == $value_other->record_id) {
                        echo "<p>" . $value_other->source . "</p>";
                    }
                } ?></div></div>'],
                <?php
                }
                ?>
            ];
        } else {
            var infoWindowContent = [
                [markers2[info]]
            ];
        }
        var infoWindow = new google.maps.InfoWindow(), marker, i;

        // Loop through our array of markers & place each one on the map
        for (i = 0; i < markers.length; i++) {
            var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
            bounds.extend(position);
            marker = new google.maps.Marker({
                position: position,
                map: map,
                title: markers[i][0],
                icon: '../templates/default/img/arrow-up1.png'
            });

            // Allow each marker to have an info window
            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infoWindow.setContent(infoWindowContent[i][0]);

                    infoWindow.open(map, marker);
                }
            })(marker, i));

            // Automatically center the map fitting all markers on the screen
            map.fitBounds(bounds);
        }

        // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
        var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function (event) {
            if (zoom) {
                this.setZoom(zoom);
            } else {
                this.setZoom(<?php echo $_SESSION["city"] ? "20" : "20"; ?>);
            }
            google.maps.event.removeListener(boundsListener);
        });

    }

    jQuery(function ($) {
        initialize('', '', '', 0, 7);
        <?php if($data){ alert(123); ?>
        setTimeout(function () {
            initialize('<?php echo $data->address ?>', '<?php echo $data->latitude ?>', '<?php echo $data->longitude ?>', '<?php echo $data->id ?>', 19);
        }, 1000);
        goSetIdTop('news-info');
        <?php } ?>
    });
</script>

<!-- Breadcrumb -->
<?php $tmpl->load_direct_blocks('breadcrumbs'); ?>

<div class="container">
    <!--    <div id="news-info" style="height: 40px"></div>-->
    <div class="block block-news block-news-default">
        <div class="block-content">
            <div class="row">
                <div class="col-lg-7">
                    <div id="map_canvas"></div>
                </div>
                <div class="col-lg-5">
                    <h3 class="title-add"><?php echo FSText::_('Tìm kiếm theo địa chỉ')?></h3>
                    <div class="wrapper-select-add">
                        <select name="province" id="province" onchange="changeCity22(this.value,'district');">
                            <option value="">--Chọn tỉnh/thành phố--</option>
                            <?php foreach ($dataCity as $province) { ?>
                                <option <?php if (@$_SESSION["city"] == $province->id) echo 'selected="selected"'; ?>
                                        value="<?php echo $province->id; ?>">
                                    <?php echo $province->name; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <select name="district" id="district" onchange="changeDistrict(this.value,' ')">
                            <option value="0">--Chọn Quận/Huyện--</option>
                            <?php foreach ($district as $city) { ?>
                                <option <?php if (@$_SESSION["district"] == $city->id) echo 'selected="selected"'; ?>
                                        value="<?php echo $city->id; ?>">
                                    <?php echo $city->name; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="wrapper-list-agency">
                        <ul class="list-item-agency">
                            <?php
                            $html = "";
                            foreach ($list as $value) {
                                $link = FSRoute::_('index.php?module=address&view=address&task=detail&id=' . $value->id . '&code=' . $value->alias);
                                ?>
                                <li class="item-agency cf">
                                    <div class="wrapper-info-agency">
                                        <h2 class="name-agency">
                                            <a href="javascript:void();"><?php echo $value->name; ?></a>
                                        </h2>
                                        <p class="add-agency"><?php echo $value->address; ?></p>
                                        <p class="add-phone"><?php echo $value->phone; ?></p>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div><!--end: .col-lg-6-->
            </div><!--end: .row-->
        </div><!--end: .block-content-->
    </div><!--end: .block-news-default-->

    <div id="news-info" style="height: 40px"></div>
</div>
