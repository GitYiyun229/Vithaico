<?php
global $config;
global $tmpl;
//$tmpl -> addTitle('Hệ thống cửa hàng');
$tmpl->addStylesheet('contact', 'modules/contact/assets/css');
$tmpl->addScript('contact', 'modules/contact/assets/js');
$latitude = 15.90306;
$longitude = 105.80669;
?>
<div class="box_map">
    <div class="row">
        <div class="col-md-12">
            <h1>Hệ thống cửa hàng Di Động Thông Minh</h1>
            <div class="list_address">
                <div class="list_faq_content " id="style-44">
                    <?php
                    $j = 0;
                    foreach ($data as $key) {
                        $json1 = "[['" . $key->name . "'," . $key->latitude . "," . $key->longitude . ",13,'" . $key->address . "']]";
                        ?>
                        <div class="item_ad col-md-4 " onclick="GetMap(<?php echo $json1; ?>,1)">
                            <div class="box">
                                <img src="<?= URL_ROOT . 'modules/contact/assets/images/icon_map.svg' ?>" alt="map"
                                     class="img-responsive">
                                <div class="left_map">
                                    <h3><?= $key->name ?></h3>
                                    <p class="address"><?= $key->address ?></p>
                                    <?php if (@$key->phone) { ?>
                                        <a class="phone" href="tel:<?= $key->phone ?>"><?= $key->phone ?></a>
                                    <?php } ?>
                                    <p class="map"><a href="<?= $key->googlemap ?>" target="_blank" title="Xem trên Bản đồ">Xem bản đồ</a> </p>
                                </div>
                            </div>
                            <?php if (@$key->image) { ?>
                                <div class="image">
                                    <a href="<?php echo $key->googlemap; ?>" target="_blank" title="<?= $key->name ?> - Xem trên Google Map">
                                        <img src="<?php echo URL_ROOT.$key->image; ?>" alt="map" class="img-responsive">
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                       
                        <?php $j++;} ?>
                </div>
            </div>
        </div>
        <!--
        <div class="col-md-8">
            <div class="map">
                <?php
                $json2 = '[';
                $json_names_2 = array();

                foreach (@$data as $item) {
                    $json_names_2[] = "['" . $item->name . "'," . $item->latitude . "," . $item->longitude . ",13,'" . $item->address . "']";
                }
                $json2 .= implode(',', $json_names_2);
                $json2 .= ']';
                ?>
                <div id="map">
                    <div id="gmap" style="width: 100%; height: 730px;"></div>
                </div>
                <script type='text/javascript'>
                    function GetMap(json='', type) {
                        var type = type;
                        if (json != '') {
                            var locations = json;
                        } else {
                            var locations = <?php echo $json2?>;
                        }
                        //var locations = <?php //echo $json2?>//;
                        console.log(locations.length);
                        var pinInfoBox;  //the pop up info box
                        var infoboxLayer = new Microsoft.Maps.EntityCollection();
                        var pinLayer = new Microsoft.Maps.EntityCollection();
                        var apiKey = "Apwotc2pglOqY_bLannByqBGVxp6nHjH6ZGhPsTBOyfdyHbaJZnV87ozNmjKBdlF";

                        map = new Microsoft.Maps.Map(document.getElementById("gmap"), {credentials: apiKey});

                        // Create the info box for the pushpin
                        pinInfobox = new Microsoft.Maps.Infobox(new Microsoft.Maps.Location(0, 0), {visible: false});
                        infoboxLayer.push(pinInfobox);


                        for (var i = 0; i < locations.length; i++) {
                            //add pushpins
                            var latLon = new Microsoft.Maps.Location(locations[i][1], locations[i][2]);
                            var pin = new Microsoft.Maps.Pushpin(latLon, {color: '#C3002F'});
                            pin.Title = locations[i][0];//usually title of the infobox
                            pin.Description = locations[i][4]; //information you want to display in the infobox
                            pinLayer.push(pin); //add pushpin to pinLayer
                            Microsoft.Maps.Events.addHandler(pin, 'click', displayInfobox);
                        }

                        map.entities.push(pinLayer);
                        map.entities.push(infoboxLayer);
                        if (type == 1) {
                            map.setView({
                                zoom: 15,
                                center: new Microsoft.Maps.Location(locations[0][1], locations[0][2])
                            });
                        } else {
                            map.setView({
                                zoom: 6,
                                center: new Microsoft.Maps.Location(<?php echo $latitude?>, <?php echo $longitude?>)
                            });
                        }

                    }

                    function displayInfobox(e) {
                        pinInfobox.setOptions({
                            title: e.target.Title,
                            description: e.target.Description,
                            visible: true,
                            offset: new Microsoft.Maps.Point(0, 25)
                        });
                        pinInfobox.setLocation(e.target.getLocation());
                    }

                    function hideInfobox(e) {
                        pinInfobox.setOptions({visible: false});
                    }

                </script>
                <script type='text/javascript'
                        src='https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=Apwotc2pglOqY_bLannByqBGVxp6nHjH6ZGhPsTBOyfdyHbaJZnV87ozNmjKBdlF&CountryRegion=VN'
                        async defer></script>
            </div>

        </div>
        -->
    </div>
</div>
