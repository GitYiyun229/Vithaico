$(document).ready(function () {
  var $carousel = $(".slider-for");

  $carousel.slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    fade: true,
    asNavFor: ".slider-nav",
    prevArrow:
      '<svg width="40" height="40" class="slick-prev" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1540_10364)"><rect width="40" height="40" rx="20" transform="matrix(-1 0 0 1 40 0)" fill="#F4F8FA"/><path d="M22 24L18 20L22 16" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></g><defs><clipPath id="clip0_1540_10364"><rect width="40" height="40" rx="20" transform="matrix(-1 0 0 1 40 0)" fill="white"/></clipPath></defs></svg>',
    nextArrow:
      '<svg width="40" height="40" class="slick-next" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1540_10368)"><rect width="40" height="40" rx="20" fill="#F4F8FA"/><path d="M18 24L22 20L18 16" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></g><defs><clipPath id="clip0_1540_10368"><rect width="40" height="40" rx="20" fill="white"/></clipPath></defs></svg>',
  });
  $(".slider-nav").slick({
    slidesToShow: 5,
    slidesToScroll: 1,
    asNavFor: ".slider-for",
    dots: false,
    vertical: true,
    focusOnSelect: true,
    arrows: false,
  });

  // $(".list_material-item > .material-item").click(function (e) {
  //   $(".list_material-item > .material-item").removeClass("active");
  //   $(this).addClass("active");
  //   let product_id = $("#product_id").val();
  //   let material_id = $(this).attr("data-id");
  //   if ($("#list_size-item > .size-item").length > 0) {
  //     $.ajax({
  //       type: "GET",
  //       dataType: "html",
  //       url: "/index.php?module=products&view=product&raw=1&task=load_size_by_material",
  //       data: { material_id, product_id },
  //       success: function (data) {
  //         // let firstElementProcessed = false;
  //         var respond = JSON.parse(data);

  //         var data_size = respond.list_size_by_material;
  //         var array_size = JSON.parse("[" + data_size + "]");
  //         $(".list_size-item > .size-item").addClass("disable");

  //         array_size.forEach((element) => {
  //           $("#size_" + element).removeClass("disable");
  //           // if (!firstElementProcessed) {
  //           //   $('#size_' + element).addClass('active');
  //           //   firstElementProcessed = true;
  //           // }
  //           $(".list_size-item > .disable").removeClass("active");
  //         });
  //       },
  //     });
  //   }
  //   e.preventDefault();
  // });

  // $(".list_size-item > .size-item").click(function (e) {
  //   $(".list_size-item > .size-item").removeClass("active");
  //   $(this).addClass("active");
  //   e.preventDefault();
  // });

  // $(".buy-now").click(async function (e) {
  //   if ($("#list_size-item > .size-item").hasClass("active")) {
  //     e.preventDefault();

  //     $("#size-message").hide();
  //     await addCartPrd();
  //   } else {
  //     $("#size-message").text("Vui lòng chọn size").show();
  //     return false;
  //   }
  // });
});




function isElementInViewport(el) {
  var rect = el.getBoundingClientRect();
  return (
    rect.top >= 0 &&
    rect.left >= 0 &&
    rect.bottom <=
      (window.innerHeight || document.documentElement.clientHeight) &&
    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
  );
}

function loadMoreContent(page, limit, load) {
  $.ajax({
    url: "index.php?module=products&view=product&task=loadMore&raw=1",
    type: "GET",
    data: { page, limit },
    dataType: "html",
    success: function (result) {
      $(".section-more").append(result);
      load.fadeOut().html("");
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      console.log(
        "Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối."
      );
      load.fadeOut().html("");
    },
  });
}


$(".slider-related").slick({
  slidesToShow: 4,
  slidesToScroll: 1,
  arrows: true,
  infinite: false,
  prevArrow:
    '<button class="slick-prev"><svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11 21L1 11L11 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg></button>',
  nextArrow:
    '<button class="slick-next"><svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 21L11 11L1 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg></button>',
});

$(".count-down").each(function (e) {
  countdowwn($(this));
});

function countdowwn(element) {
  let e = element.attr("time-end");
  let l = new Date(e).getTime();
  let n = setInterval(function () {
    let e = new Date().getTime();
    let t = l - e;
    let a = Math.floor(t / 864e5);
    let s = Math.floor((t % 864e5) / 36e5);
    let o = Math.floor((t % 36e5) / 6e4);
    e = Math.floor((t % 6e4) / 1e3);

    element.html(`
            <span>${a}</span>
            :
            <span>${s}</span>
            :
            <span>${o}</span>
            :
            <span>${e}</span>
        `);

    if (t < 0) {
      clearInterval(n), element.html("Đã hết khuyến mại");
    }
  }, 1e3);
}

$(".p-type").click(function (e) {
  e.preventDefault();
  let data = $(this).attr("data");
  let price = $(this).attr("price-format");
  let priceOld = $(this).attr("price-old-format");
  let priceDiscount = $(this).attr("price-discount-format");

  if (data && data != "0") {
    $(".slider-nav").slick("slickGoTo", data);
  }

  $(".p-type").removeClass("active");
  $(this).addClass("active");

  $(".p-price-public").html(price);
  $(".p-price-origin").html(priceOld);
  $(".p-price-discount").html(priceDiscount);
});

$(document).ready(function () {
  if ($(".p-type").length) {
    $(".p-type.active").click();
  }
});

$(".btn-more-less").click(function () {
  $(this).toggleClass("less");
  $(".description-main").toggleClass("less");
});

$(".comment-filter").click(function (e) {
  e.preventDefault();
  let data = $(this).attr("data-filter");

  $(".comment-filter").removeClass("active");
  $(this).addClass("active");

  if (data != 0) {
    $(".item-comment").hide();
    $(".item-comment.filter-" + data).show();
  } else {
    $(".item-comment").show();
  }
});

$(".more-comment").click(function (e) {
  e.preventDefault();
});

$(".add-cart").click(function (e) {
  e.preventDefault();

  addCart();
});

$(".buy-now").click(async function (e) {
  e.preventDefault();
  let url = $(this).attr("href");

  await addCart(url);

  // location.href = url;
});

async function addCart(url = null) {
  let image = $(".slider-for .slick-active img").attr("src");
  let product = parseInt($("#product").val());
  let price = parseInt($("#price").attr("data-price"));
  let quantity = $("#order-quantity").val();
  let coin = parseInt($("#price").attr("data-coin"));
  let quantityMax = $("#order-quantity").attr("max");

  if (!parseInt(quantity)) {
    flashMessage(true, "Vui lòng nhập số!");
    $("#order-quantity").focus();
    return false;
  }

  if (parseInt(quantity) <= 0) {
    flashMessage(true, "Số lượng đặt sản phẩm tối thiểu là 1!");
    $("#order-quantity").focus();
    return false;
  }

  if (parseInt(quantity) > parseInt(quantityMax)) {
    flashMessage(true, "Số lượng đặt sản phẩm tối đa là " + quantityMax + "!");
    $("#order-quantity").focus();
    return false;
  }

  quantity = quantity ? parseInt(quantity) : 1;

  $.ajax({
    url: "index.php?module=products&view=cart&task=addCart&raw=1",
    type: "POST",
    data: {
      product,
      quantity,
      price,
      coin,
      image,
      token,
    },
    dataType: "JSON",
    success: function (result) {
      console.log(result);
      flashMessage(result.error, result.message);
      $("header .cart-text-quantity").text(result.total);
      $(".text_tamtinh .cart-text-quantity-2").text(result.total_order);
      if (result.newItem) {
        $(".cart-hover-body").append(`
               
        <div class="cart-hover-item position-relative">
            <a href="${result.newItem.url}" class=""><img src="${
          result.newItem.image
        }" alt="${result.newItem.product_name}" class="img-fluid"></a>
            <div>
                <a href="${result.newItem.url}">
                    <div class="mb-1">${result.newItem.product_name}</div>
                    <p class="mb-1">x ${result.newItem.quantity}</p>
                    <div class="item-price d-flex flex-wrap align-items-center justify-content-between">
                        <p class="mb-1">${result.newItem.price
                          .toString()
                          .replace(/\B(?=(\d{3})+(?!\d))/g, ".")}/
                        <span>${result.newItem.coin}VT-Coin</span>
                        </p>
                    
                    </div>
                </a>
            </div>
                <a href="" class="delete-cart position-absolute top-0 end-0" data-id="${
                  result.newItem.product_id
                }">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.6201 2.38L2.38013 11.62M2.38013 2.38L11.6201 11.62" stroke="#757575" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                </a>
        </div>
                `);
      }

      if (url) {
        location.href = url;
      }
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      console.log(
        "Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối."
      );
      return false;
    },
  });
}

$(".add-like.no-add").click(function (e) {
  e.preventDefault();
  let product_id = $("#product").val();

  $.ajax({
    url: "index.php?module=members&view=favorite&task=addFavorite&raw=1",
    type: "POST",
    data: { product_id, token },
    dataType: "JSON",
    success: function (result) {
      console.log(result);
      flashMessage(result.error, result.message);

      if (!result.error) {
        $(".add-like.no-add").addClass("added").removeClass("no-add");
      }
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      console.log(
        "Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối."
      );
    },
  });
});
$(".button_filter").click(function (e) {
  e.preventDefault();
  $(".section-item").toggle();
});

const select = document.querySelector(".select");
const options_list = document.querySelector(".options-list");
const options = document.querySelectorAll(".option");

//show & hide options list
select.addEventListener("click", () => {
  options_list.classList.toggle("active");
  select.querySelector(".fa-angle-down").classList.toggle("fa-angle-up");
});

//select option
options.forEach((option) => {
  option.addEventListener("click", () => {
    options.forEach((option) => {
      option.classList.remove("selected");
    });
    select.querySelector("span").innerHTML = option.innerHTML;
    option.classList.add("selected");
    options_list.classList.toggle("active");
    select.querySelector(".fa-angle-down").classList.toggle("fa-angle-up");
  });
});
