$(document).ready(function () {
    $('#fs-popup-sc').modal('show');

    $('#autumn_search').keyup(function () {
        var keyword = $(this).val();
        $.ajax({
            type: 'get',
            url: '/index.php?module=autumn&view=autumn&task=ajax_get_autumn&raw=1',
            dataType: 'html',
            data: {keyword: keyword},
            success: function (data) {
                $("#list_prd").html(data);
                return true;
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
            }
        });
        return false;
    });

});
$('.sale-carousel').owlCarousel({
    margin: 0,
    // loop: true,
    nav: true,
    dots: false,
    lazyLoad: true,
    responsiveClass: true,
    // autoplay: true,
    // smartSpeed: 10000,
    autoplayTimeout: 2000,
    responsive: {
        0: {
            items: 1.5,
            nav:false,
            smartSpeed: 2000,
            autoplay: false
        },
        768: {
            items: 3
        },
        992: {
            items: 5
        },
        1600: {
            items: 5
        }
    }
})
$(".sale-carousel .owl-prev").html('');
$(".sale-carousel .owl-next").html('');
$('.more_view .xemthem').click(function () {
    var pagecurrent = $(this).attr("data-pagecurrent");
    var nextpage = $(this).attr("data-nextpage");
    var limit = $(this).attr("limit");
    var cat_id = $(this).attr("data-catid");
    // đưa chuổi lấy về sang dạng số
    pagecurrent = Number(pagecurrent);
    nextpage = Number(nextpage);

    $(this).attr("data-pagecurrent", nextpage);
    $(this).attr("data-nextpage", nextpage + 1);
    // alert(limit);
    $.ajax({
        type: 'GET',
        dataType: 'html',
        url: '/index.php?module=autumn&view=autumn&raw=1&task=loadmore',
        data: '&cid=' + cat_id + '&pagecurrent=' + pagecurrent + '&limit=' + limit,
        success: function (html) {
            console.log(html);
            // console.log(html.length);
            if (html.length == '0') {
                // alert(1);
                // alert('Đã hết danh mục');
                $('.more_view').hide();
            } else
                $('.more_view').append(html);
        }
    });
})
$(".close_au").click(function () {
    $.ajax({
        type: 'get',
        url: '/index.php?module=autumn&view=autumn&task=ajax_get_close&raw=1',
        dataType: 'html',
        data: '',
        success: function (data) {
            // $("#list_prd").html(data);
            // return true;
            $('#fs-popup-sc').modal('hide');

        }

    });
});

function autumn($id_pro) {
    var $id = $id_pro;
    $.ajax({
        type: 'GET',
        dataType: 'html',
        url: '/index.php?module=autumn&view=autumn&raw=1&task=sbm_autumn',
        data: {id: $id},
        success: function (data) {
            $("#wrapper-popup-3").html(data);
            ajax_pop_cart();
            click_auumn();
            click_combo();
            // close();
            select_prd();
        }
    });
    $(".wrapper-popup-3").show();
    $(".full2").show();

}

function select_prd() {
    $(".sbm").click(function () {
        var id_old = $("#id_prd_old").val();
        var price = $("#price_autumn_1").val();
        var type_autumn = $("#type_autumn").val();
        var type_combo = $("#type_combo").val();
        $.ajax({
            type: 'GET',
            dataType: 'html',
            url: '/index.php?module=autumn&view=autumn&raw=1&task=list_products',
            data: "id=" + id_old + "&price=" + price + '&type_autumn=' + type_autumn + '&type_combo=' + type_combo,
            success: function (data) {
                $("#wrapper-popup-3").html(data);
                ajax_pop_cart();
                search_au();
                chonmay();
            }
        });
    });
}

function chonmay() {
    $(".change_prd").click(function () {
        var id = $(this).attr('data-id');
        // var id_old = $("#id_prd_old").val();
        // var price = $("#price_autumn_1").val();
        // var type_autumn = $("#type_autumn").val();
        // var type_combo = $("#type_combo").val();
        $.ajax({
            type: 'GET',
            dataType: 'html',
            url: '/index.php?module=autumn&view=autumn&raw=1&task=chonmay',
            data: "id=" + id,
            success: function (data) {
                $("#wrapper-popup-3").html(data);
                ajax_pop_cart();
                click_color();
                click_item();
                click_sbm();
                // var r = $('#species_input').val();
                // if (r != 0 && r != '') {
                //     click_ram();
                // }
                // var o = $('#origin_input').val();
                // if (o != 0 && o != '') {
                //     load_colorbyram_origin();
                // }
            }
        });
    });
}

function click_ram() {
    $(".ram_item").click(function () {
        var item = $(this).attr("data");
        var name = $(this).attr("name");
        var title = $(this).attr("name-item");
        $("." + item).removeClass("active");
        $("." + name).html(title);
        $(this).addClass("active");
        var ram = $(this).attr("ram_id");
        var id = $("#id_prd").val();
        $.ajax({
            type: 'get',
            url: '/index.php?module=autumn&view=autumn&raw=1&task=ajax_load_ram',
            dataType: 'json',
            data: {ram_id: ram, id: id},
            success: function ($json) {
                $(".origin").html($json.origin);
                $("#color_ajax").html($json.color);
                // load_click();
                active_color();
                click_color();
                load_colorbyram_origin();
                load_click_price();
                click_item();

                return true;
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
            }
        });
        return false;
    });

}

function load_colorbyram_origin() {
    $(".origin_item").click(function () {
        var item = $(this).attr("data");
        var name = $(this).attr("name");
        var title = $(this).attr("name-item");
        $("." + item).removeClass("active");
        $("." + name).html(title);
        $(this).addClass("active");
        var ram = $('.ram .active').attr("ram_id");
        var origin = $(this).attr("origin_id");
        // alert(origin);
        var id = $("#id_prd").val();
        $.ajax({
            type: 'get',
            url: '/index.php?module=autumn&view=autumn&raw=1&task=ajax_load_origin',
            dataType: 'json',
            data: {ram_id: ram, origin_id: origin, id: id},
            success: function ($json) {
                // $(".origin").html($json.origin);
                $("#color_ajax").html($json.color);
                active_color();
                click_color();
                load_click_price();
                click_item();

                return true;
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
            }
        });
        return false;
    });
}

function active_color() {
    var color_id = $('.active.Selector').attr("color_id");
    // var color_name = $('.active.Selector').attr("name-item");
    $('#color_input').val(color_id);

    color_id = "color-" + color_id;
    $('.image_item').removeClass('active');
    $('.' + color_id).addClass('active');
}

function click_color() {
    $('.Selector').click(function () {
        var color_id = $(this).attr("color_id");
        $('.Selector').removeClass('active');
        $(this).addClass('active');
        color_id = "color-" + color_id;
        $('.image_item').removeClass('active');
        $('.' + color_id).addClass('active');
    });
}

function load_click_price() {
    var title_origin = $(".origin .active").attr("name-item");
    $(".origin_title").html(title_origin);
    var title_ram = $(".ram .active").attr("name-item");
    $(".ram_title").html(title_ram);
    var title_color = $(".color .active").attr("name-item");
    $(".color_title").html(title_color);
    var discount = $('#discount').val();
    var color = $('.color .active').attr("color_id");
// alert(color);
    var ram = $('.ram .active').attr("ram_id");
    // var memory = $('.memory .active').attr("memory_id");
    var origin = $('.origin .active').attr("origin_id");
    if (!color) {
        color = 0;
    }
    if (!ram) {
        ram = 0;
    }
    if (!origin) {
        origin = 0;
    }

    $('#color_input').val(color);
    $('#species_input').val(ram);
    $('#origin_input').val(origin);
    product = $('#products_sub').val();
// alert(product);
    product = eval(product);
    var price_cu = $("#price_thucu").val();
    price_cu = parseInt(price_cu);
    var price = 0;
    var price_old = 0;
    var id = 0;
    for (var i = 0; i < product.length; i++) {
        if ((color == product[i].color_id) && (ram == product[i].species_id) && (origin == product[i].origin_id)) {
            id = product[i].id;
            price = product[i].price;
            price_old = product[i].price_old;
            break;
        }
    }
    $("#id_sub").val(id);

    // alert(id);
    if (discount != '1') {
        price = price_old;
    }
    $("#price").val(price);
    $("#price_old").val(price_old);
    price = parseInt(price);
    var price_them = price - price_cu;
    $("#price_them").val(price_them);
    price_them = price_them.toString();

    var format_money1 = "";
    var format_money2 = "";
    var format_money = "";

    while (parseInt(price_them) > 999) {
        format_money1 = "." + price_them.slice(-3) + format_money1;
        price_them = price_them.slice(0, -3);
    }
    price_them = price_them + format_money1;
    price_them = price_them + ' đ';
    $('.price_them').html(price_them);

    price = price.toString();
    while (parseInt(price) > 999) {
        format_money = "." + price.slice(-3) + format_money;
        price = price.slice(0, -3);
    }
    price = price + format_money;
    price = price + ' đ';
    $('.price_doi').html(price);
    price_old = price_old.toString();

    while (parseInt(price_old) > 999) {
        format_money2 = "." + price_old.slice(-3) + format_money2;
        price_old = price_old.slice(0, -3);
    }
    price_old = price_old + format_money2;
    price_old = price_old + ' đ';
    $('.priceold_doi').html(price_old);
}

function click_item() {
    $(".item_price").click(function () {
        var discount = $('#discount').val();
        var color = $('.color .active').attr("color_id");
// alert(color);
        var ram = $('.ram .active').attr("ram_id");
        // var memory = $('.memory .active').attr("memory_id");
        var origin = $('.origin .active').attr("origin_id");
        if (!color) {
            color = 0;
        }
        if (!ram) {
            ram = 0;
        }
        if (!origin) {
            origin = 0;
        }

        $('#color_input').val(color);
        $('#species_input').val(ram);
        $('#origin_input').val(origin);
        product = $('#products_sub').val();
// alert(product);
        product = eval(product);
        var price_cu = $("#price_thucu").val();
        price_cu = parseInt(price_cu);
        var price = 0;
        var price_old = 0;
        var id = 0;
        for (var i = 0; i < product.length; i++) {
            if ((color == product[i].color_id) && (ram == product[i].species_id) && (origin == product[i].origin_id)) {
                id = product[i].id;
                price = product[i].price;
                price_old = product[i].price_old;
                break;
            }
        }
        $("#id_sub").val(id);

        // alert(id);
        if (discount != '1') {
            price = price_old;
        }
        $("#price").val(price);
        $("#price_old").val(price_old);
        price = parseInt(price);
        var price_them = price - price_cu;
        $("#price_them").val(price_them);
        price_them = price_them.toString();

        var format_money1 = "";
        var format_money2 = "";
        var format_money = "";

        while (parseInt(price_them) > 999) {
            format_money1 = "." + price_them.slice(-3) + format_money1;
            price_them = price_them.slice(0, -3);
        }
        price_them = price_them + format_money1;
        price_them = price_them + ' đ';
        $('.price_them').html(price_them);

        price = price.toString();
        while (parseInt(price) > 999) {
            format_money = "." + price.slice(-3) + format_money;
            price = price.slice(0, -3);
        }
        price = price + format_money;
        price = price + ' đ';
        $('.price_doi').html(price);
        price_old = price_old.toString();

        while (parseInt(price_old) > 999) {
            format_money2 = "." + price_old.slice(-3) + format_money2;
            price_old = price_old.slice(0, -3);
        }
        price_old = price_old + format_money2;
        price_old = price_old + ' đ';
        $('.priceold_doi').html(price_old);
    });

}

function click_color1() {
    $(".click_cl").click(function () {
        var url = $("#url").val();
        var price_cu = $("#price_thucu").val();
        price_cu = parseInt(price_cu);
        var id = $(this).attr('data-id');
        var image = $(this).attr('data-image');
        var price = $(this).attr('data-price');
        price = parseInt(price);
        var price_old = $(this).attr('data-priceold');
        price_old = parseInt(price_old);
        $("#price").val(price);
        $("#price_old").val(price_old);
        $("#id_sub").val(id);
        var price_them = price - price_cu;
        $("#price_them").val(price_them);
        price_them = price_them.toString();
        var format_money1 = "";
        var format_money2 = "";
        var format_money = "";

        while (parseInt(price_them) > 999) {
            format_money1 = "." + price_them.slice(-3) + format_money1;
            price_them = price_them.slice(0, -3);
        }
        price_them = price_them + format_money1;
        price_them = price_them + ' đ';
        $('.price_them').html(price_them);

        price = price.toString();
        while (parseInt(price) > 999) {
            format_money = "." + price.slice(-3) + format_money;
            price = price.slice(0, -3);
        }
        price = price + format_money;
        price = price + ' đ';
        $('.price_doi').html(price);
        price_old = price_old.toString();

        while (parseInt(price_old) > 999) {
            format_money2 = "." + price_old.slice(-3) + format_money2;
            price_old = price_old.slice(0, -3);
        }
        price_old = price_old + format_money2;
        price_old = price_old + ' đ';
        $('.priceold_doi').html(price_old);

        $(".click_cl").removeClass('active');
        $(this).addClass('active');
        $(".image_color").attr("src", url + image);
    });
}

function ajax_pop_cart() {
    $("#close-cart").click(function () {
        $(".wrapper-popup-3").hide();
        $(".full2").hide();
    });
}

function click_auumn() {
    $(".item_au").click(function () {
        var autumn = $(this).attr("data-autumn");

        // var type_autumn = $("#type_autumn").val();
        // alert(type_autumn);
        if (autumn == 1) {
            $(".combo_11").show();
            var type_combo = $("#type_combo").val();
        } else {
            $(".combo_11").hide();
            var type_combo = 0;
        }
        var price_2 = 0;
        if (type_combo) {
            var price_2 = $(".item_price_" + type_combo).attr("data-price-combo");
            price_2 = parseInt(price_2);
        }
        var price_1 = $(this).attr("data-price");
        price_1 = parseInt(price_1);


        var type = $(this).attr("data-type");
        $('.type_au').html(type);

        var autumn_price = $("#price_autumn").val();
        autumn_price = parseInt(autumn_price);
        $(".item_au").removeClass('active');

        $(this).addClass('active');
        var price = 0;

        price = autumn_price - price_1 + price_2;
        // }
        $('#price_autumn_1').val(price);
        $('#price_autumn_2').val(price);
        $('#type_autumn').val(autumn);

        price = price.toString();
        var format_money = "";
        while (parseInt(price) > 999) {
            format_money = "." + price.slice(-3) + format_money;
            price = price.slice(0, -3);
        }
        price = price + format_money;
        price = price + ' đ';
        $('.price_10').html(price);

    });
}

function click_sbm() {
    $('#submitchange').click(function () {
        if (checkFormsubmit()) {
            document.change_product.submit();
        }
    });
}

function click_combo() {
    $(".item_combo").click(function () {
        var type_autumn = $("#type_autumn").val();
        var price_2 = 0;
        if (type_autumn) {
            price_2 = $(".item_price1_" + type_autumn).attr("data-price");
            price_2 = parseInt(price_2);
        }
        var combo = $(this).attr("data-combo");
        var combo_input = $("#type_combo").val();
        if (combo == combo_input) {
            $(this).removeClass('active');
            $('#type_combo').val('');
            var price_1 = 0;
        } else {
            $(".item_combo").removeClass('active');
            $(this).addClass('active');
            $('#type_combo').val(combo);
            var price_1 = $(this).attr("data-price-combo");
        }
        price_1 = parseInt(price_1);
        var autumn_price = $("#price_autumn").val();
        autumn_price = parseInt(autumn_price);

        var price = 0;

        price = autumn_price + price_1 - price_2;
        // }
        $('#price_autumn_1').val(price);

        price = price.toString();
        var format_money = "";
        while (parseInt(price) > 999) {
            format_money = "." + price.slice(-3) + format_money;
            price = price.slice(0, -3);
        }
        price = price + format_money;
        price = price + ' đ';
        $('.price_10').html(price);

    });
}

function close() {
    $(".sbm").click(function () {
        var id_old = $("#id_prd_old").val();
        var price = $("#price_autumn_1").val();
        var type_autumn = $("#type_autumn").val();
        var type_combo = $("#type_combo").val();

        $.ajax({
            type: 'GET',
            dataType: 'html',
            url: '/index.php?module=autumn&view=autumn&raw=1&task=set_session',
            data: "id=" + id_old + "&price=" + price + '&type_autumn=' + type_autumn + '&type_combo=' + type_combo,
            success: function (data) {
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
            }
        });
        $(".all").hide();
        $(".full2").hide();
    });

}

function search_au() {
    $('#autumn_search1').keyup(function () {
        var keyword = $(this).val();
        // var id_old = $("#id_prd_old").val();
        // alert(id_old);
        // var price = $("#price_autumn_1").val();
        $.ajax({
            type: 'get',
            url: '/index.php?module=autumn&view=autumn&task=ajax_get_autumn1&raw=1',
            dataType: 'html',
            data: {keyword: keyword},
            success: function (data) {
                $("#list_prd_1").html(data);
                chonmay();
                return true;
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
            }
        });
        return false;
    });
}

function checkFormsubmit() {
    if (!notEmpty("sender_name", "Bạn phải nhập họ tên")) {
        return false;
    }
    if (!notEmpty("sender_telephone", "Bạn phải nhập số phone")) {
        return false;
    }
    if (!isPhone("sender_telephone", "Số điện thoại không hợp lệ")) {
        return false;
    }
    if (!lengthMin("sender_telephone", "10", "Số điện thoại không hợp lệ")) {
        return false;
    }
    if (!lengthMax("sender_telephone", "10", "Số điện thoại không hợp lệ")) {
        return false;
    }
    return true;
}
