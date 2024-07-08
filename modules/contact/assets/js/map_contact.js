$(document).ready(function() {

    $(document).on('select2:select', function (e) { 
    let address = $('#select2-province-container').text()
    let $id = $('#province').val();
    $.ajax({
      type: 'GET',
      dataType: 'html',
      url: '/index.php?module=contact&view=contact&raw=1&task=getmap',
      data: "&id=" + $id,
      success: function (data) {
          let res = data;
          // console.log(data);
          // $("#map").attr("src", $(res.content).attr("src"));
          $(".filter-city").html(data)
          $('.select2-box').select2();
          // $("#select2-province-container").attr("title", address)
      }
    });
  });
  function detailMap(res) {
    let html = 
    `
    <div class="showroom-address">
        <h4 class="text-uppercase">${res.name}</h4>

        <div class="d-flex align-items-start">
            <img alt="local" class="mr-3" src="/img/hethongshowroom/local.png" />
            <p>${res.address}</p>
        </div>

        <div class="d-flex align-items-start">
            <img alt="phone" class="mr-3" src="/img/hethongshowroom/phone (1).png" />
            <p>${res.phone}</p>
        </div>
    </div>
    `
    $(".wrapper-showroom").append(html)
  }
})