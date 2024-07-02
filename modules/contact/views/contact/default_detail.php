<?php
    global $tmpl;
    $tmpl->addScript('contact','modules/contact/assets/js');
?>
<input type="hidden" id="root" value="<?php echo URL_ROOT ?>">
<!--<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBf8NH9DYMkhllBNi4s11FA9QiFG0Yv2BY&sensor=true&libraries=places&language=en"></script>-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXTSbsa6RsBB0ftvHTrBSIpsc11BNEKAI&libraries=geometry,places&callback=initialize&sensor=false" async defer></script>

<script>
    function getLocation(location,show){
        var positions = [];
                positions[0] = [10.755398430864796,106.67279161512852,11];
                <?php foreach($data as $item){ ?>
                positions[<?php echo $item-> id; ?>] = [<?php echo $item->latitude ;?>,<?php echo $item->longitude ;?>,13];
                <?php } ?>
        var locations = [];
                <?php  foreach($data as $item){
                    //$link = FSRoute::_('index.php?module=products&view=product&code='.$item->alias.'&ccode='.$item->category_alias.'&id='.$item->id.'&Itemid=5');
//                    $image_small = str_replace('/original/', '/large/', $item->image);
                ?>
                locations[<?php echo $item-> id; ?>] = ['<div class="item-row-map" style="width:320px;"><?php echo $item->name ;?></br><?php echo $item->address ;?></br><?php echo $item->phone ;?></div>',<?php echo $item->latitude ;?>,<?php echo $item->longitude ;?>];
                <?php } ?>
        var URL_ROOT = $('#root').val();
        var image = URL_ROOT+'/images/arrow-up1.png';
        var map = new google.maps.Map(document.getElementById('map-canvas'), {
          zoom: positions[location][2],
          center: new google.maps.LatLng(positions[location][0], positions[location][1]),
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var infowindow = new google.maps.InfoWindow();
        var marker, i;
        if(show==true){
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[location][1], locations[location][2]),
                    map: map,
                    icon: image,
                });
                infowindow.setContent(locations[location][0]);
                infowindow.open(map, marker);
                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                      var id = location;
                      // check_exist_id(id);
                      infowindow.setContent(locations[location][0]);
                      infowindow.open(map, marker);
                      marker.setIcon('https://www.google.com/mapfiles/marker_green.png');
                    }
              })(marker, i));
        }else{
                <?php  foreach($data as $item){ ?>
                    marker = new google.maps.Marker({
                          position: new google.maps.LatLng(locations[<?php echo $item->id; ?>][1], locations[<?php echo $item->id; ?>][2]),
                          map: map,
                          icon: image,
                    });
                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                          return function() {
                            // note dữ liệu id
                            var id = <?php echo $item->id; ?>;
                            // check_exist_id(id);
                            infowindow.setContent(locations[<?php echo $item->id; ?>][0]);
                            infowindow.open(map, marker);
                            marker.setIcon('https://www.google.com/mapfiles/marker_green.png');
                          }
                    })(marker, i));
               <?php  } ?>
        }
}
</script>

<div id="map-canvas" style="height: 562px;"></div>