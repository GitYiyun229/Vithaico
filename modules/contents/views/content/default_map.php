<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&language=vi"></script>
<?php
    global $tmpl; 
    $tmpl->addScript('map_contact','modules/contact/assets/js');
?>
<script>
    function getLocation(location,show){
                      
        var positions = [];
                positions[0] = [20.159996, 105.517391,7];// Singapo
                <?php foreach($address as $item){ ?>
                positions[<?php echo $item-> id; ?>] = [<?php echo $item->latitude ;?>,<?php echo $item->longitude ;?>,15];
                <?php } ?>
        
        var locations = [];
                <?php  foreach($address as $item){ ?>
                locations[<?php echo $item-> id; ?>] = ['<div class="item-row-map"></div>',<?php echo $item->latitude ;?>,<?php echo $item->longitude ;?>];
                <?php } ?>
        
        var image = '/images/map-contents.png';
        var map = new google.maps.Map(document.getElementById('map-canvas'), {
          zoom: positions[location][2],
          center: new google.maps.LatLng(positions[location][0], positions[location][1]),
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        
        var infowindow = new google.maps.InfoWindow();
        var marker, i;
        
        <?php  foreach($address as $item){ ?>                
            marker = new google.maps.Marker({
                  position: new google.maps.LatLng(locations[<?php echo $item->id; ?>][1], locations[<?php echo $item->id; ?>][2]),
                  map: map,
                  icon: image,
            });
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                  return function() {
                    var id = <?php echo $item->id; ?>;
                    check_exist_id(id);
                    infowindow.setContent(locations[<?php echo $item->id; ?>][0]);
                    infowindow.open(map, marker);
                    marker.setIcon('https://www.google.com/mapfiles/marker_green.png');
                  }
            })(marker, i));
       <?php  } ?>
}
</script>
<h4 class="title-map" style="font-size: 18px;line-height: 22px;font-weight: normal;margin-bottom: 15px;">
    <?php echo FSText::_('Bản đồ Hệ thống đại lý tại Việt Nam'); ?>
</h4>
<div id="map-canvas" style="height: 508px;margin-bottom: 30px;"></div>
	
