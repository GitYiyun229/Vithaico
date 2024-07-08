<div class="map col-md-8 no-gutters left-col">
  <?php
  $json2 = '[';
  $json_names_2 = array();

  foreach (@$list as $item) {
    $json_names_2[] = "['" . $item->name . '<br/>' . $item->address . "'," . $item->latitude . "," . $item->longitude . "]";
  }
  //$img = URL_ROOT.'modules/contact/assets/images/icon_gd.png';
  $json2 .= implode(',', $json_names_2);
  $json2 .= ']';

  ?>
  <div id="map">
    <div id="gmap" style="width: 100%; height: 400px;"></div>
  </div>
  <script type="text/javascript">
    var oldMarker;

    function initialize() {
      var locations = <?php echo $json2 ?>;
      var host = location.host;
      var protocol = location.protocol;
      var url = protocol + "//" + host;

      var latlng = new google.maps.LatLng(<?php echo $latitude ?>, <?php echo $longitude ?>);
      var markers = [];
      var image = '/images/arrow-up1.png';
      var myOptions = {
        zoom: 13,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
      };
      var map = new google.maps.Map(document.getElementById("gmap"), myOptions);

      function placeMarker(locations) {
        var infowindow = new google.maps.InfoWindow();
        for (i = 0; i < locations.length; i++) {
          if (locations[i][4] == 1) {
            marker = new google.maps.Marker({
              position: new google.maps.LatLng(locations[i][1], locations[i][2]),
              map: map,
              animation: google.maps.Animation.DROP,

            });
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
              return function() {
                infowindow.setContent(locations[i][0]);
                infowindow.open(map, marker);
              }
            })(marker, i));
          } else {
            marker = new google.maps.Marker({
              position: new google.maps.LatLng(locations[i][1], locations[i][2]),
              map: map,
              animation: google.maps.Animation.DROP,
            });
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
              return function() {
                infowindow.setContent(locations[i][0]);
                infowindow.open(map, marker);
              }
            })(marker, i));
          }
        }

      }
      placeMarker(locations);
    }
    google.maps.event.addDomListener(window, 'load', initialize());
  </script>
</div>
<div class="col-md-4 no-gutters right-col">
  <div class="showroom-address mt-3 mt-md-0">
    <h4 class="text-uppercase">Tìm showroom của Suntek</h4>
    <!-- <label for="province">Tỉnh thành phố</label><br /> -->
    <select class="select2-box" id="province">
      <option>Chọn Tỉnh / Thành phố</option>
      <?php foreach ($list_city_name as $item) { ?>
        <option value="<?php echo $item["id"] ?> "><?php echo $item["name"] ?></option>
      <?php } ?>
    </select>
  </div>
  <div class="wrapper-showroom style-3">
    <?php foreach ($list as $item) { ?>
      <div class="showroom-address">
        <h4 class="text-uppercase"><?php echo $item->name?></h4>

        <div class="d-flex align-items-start">
          <img alt="local" class="mr-3" src="/img/hethongshowroom/local.png" />
          <p><?php echo $item->address?></p>
        </div>

        <div class="d-flex align-items-start">
          <img alt="phone" class="mr-3" src="/img/hethongshowroom/phone (1).png" />
          <p><?php echo $item->phone?></p>
        </div>
      </div>
    <?php } ?>
  </div>
</div>