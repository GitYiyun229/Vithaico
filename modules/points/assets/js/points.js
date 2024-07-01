$(document).ready(function() {
    var owl = $('.slide_point');
    owl.owlCarousel({
        margin: 20,
        loop: true,
        nav: true,
        dots: false,
        lazyLoad:true,
        responsiveClass:true,
        autoplay:true,
        autoplayTimeout:2000,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 2
            },
            1000: {
                items: 3
            },
            1600: {
                items: 3
            }
        }
    })
    $( ".owl-prev").html('<i class="fa fa-caret-left"></i>');
    $( ".owl-next").html('<i class="fa fa-caret-right"></i>');
})
$('.input2').keypress(function(event) {
    if (event.keyCode == 13 || event.which == 13) {
        var $phone = $(this).val();
        if (!$phone && $phone == '' ){
            alert('Bạn phải nhập số điện thoại')
            return false;
        }
        // alert(url_root);
        $.ajax({
            type : 'GET',
            dataType: 'html',
            url : url_root+"index.php?module=points&view=search_point&task=display&raw=1",
            data: "phone="+$phone,
            success : function(data){
                // $("#searh_list").html(data);
                $("#wrapper-popup").html(data);
                ajax_pop_cart();
                $(".wrapper-popup").show();
                $(".full").show();
            }
        });
    }
});
function ajax_pop_cart() {
    $("#close-cart").click(function () {
        $(".wrapper-popup-2").hide();
        $(".wrapper-popup").hide();
        $(".full").hide();
    });
}