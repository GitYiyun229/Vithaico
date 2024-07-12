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
    margin: 1,
    dots: false,
    arrows: true,
    centerMode: false,
    focusOnSelect: true,
    vertical: true,
    verticalSwiping: true,
    prevArrow:
      '<button class="slick-prev"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 7.5L10 12.5L5 7.5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
    nextArrow:
      '<button class="slick-next"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 12.5L10 7.5L5 12.5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
    responsive: [
      {
        breakpoint: 500,
        settings: {
          vertical: false,
          verticalSwiping: false,
        },
      },
    ],
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

// const loadingHtml =
//   '<div class="loadingio-spinner"><div class="ldio"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>';

// const debounce = (mainFunction, delay) => {
//   let timer;
//   return function (...args) {
//     clearTimeout(timer);
//     timer = setTimeout(() => {
//       mainFunction(...args);
//     }, delay);
//   };
// };

// $(window).on(
//   "scroll",
//   debounce(function () {
//     let load = $(".loading-scroll");
//     let page = parseInt(load.attr("page")) + 1;
//     let totalCurrent = parseInt(load.attr("total-current"));
//     let total = parseInt(load.attr("total"));
//     let limit = parseInt(load.attr("limit"));

//     if (isElementInViewport($(".loading-scroll")[0]) && totalCurrent < total) {
//       load.fadeIn().append(loadingHtml);
//       load.attr("page", page);
//       load.attr("total-current", totalCurrent + limit);
//       loadMoreContent(page, limit, load);
//     }
//   }, 300)
// );

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

// $(".slider-for").slick({
//   slidesToShow: 1,
//   slidesToScroll: 1,
//   arrows: false,
//   fade: false,
//   asNavFor: ".slider-nav",
// });

// $(".slider-nav").slick({
//   slidesToShow: 5,
//   slidesToScroll: 1,
//   asNavFor: ".slider-for",
//   margin: 10,
//   dots: false,
//   arrows: true,
//   centerMode: false,
//   focusOnSelect: true,
//   // infinite: true,
//   prevArrow:
//     '<button class="slick-prev"><svg width="24" height="48" viewBox="0 0 24 48" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_84_2901)"><path d="M0 0L2.09815e-06 48L16 48C20.4183 48 24 44.4183 24 40L24 8C24 3.58172 20.4183 -8.92511e-07 16 -6.99382e-07L0 0Z" fill="black" fill-opacity="0.24"/><path d="M9.5 29L14.5 24L9.5 19" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></g><defs><clipPath id="clip0_84_2901"><path d="M0 0L2.09815e-06 48L16 48C20.4183 48 24 44.4183 24 40L24 8C24 3.58172 20.4183 -8.92511e-07 16 -6.99382e-07L0 0Z" fill="white"/></clipPath></defs></svg></button>',
//   nextArrow:
//     '<button class="slick-next"><svg width="24" height="48" viewBox="0 0 24 48" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_84_2900)"><path d="M24 0L24 48L8 48C3.58172 48 -1.94158e-06 44.4183 -1.74846e-06 40L-3.49691e-07 8C-1.56562e-07 3.58172 3.58172 -8.92511e-07 8 -6.99382e-07L24 0Z" fill="black" fill-opacity="0.24"/><path d="M14.5 29L9.5 24L14.5 19" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></g><defs><clipPath id="clip0_84_2900"><path d="M24 0L24 48L8 48C3.58172 48 -1.94158e-06 44.4183 -1.74846e-06 40L-3.49691e-07 8C-1.56562e-07 3.58172 3.58172 -8.92511e-07 8 -6.99382e-07L24 0Z" fill="white"/></clipPath></defs></svg></button>',
//   responsive: [
//     {
//       breakpoint: 500,
//       settings: {
//         vertical: false,
//         verticalSwiping: false,
//       },
//     },
//   ],
// });

$(".slider-related").slick({
  slidesToShow: 4,
  slidesToScroll: 1,
  arrows: true,
  infinite: false,
  prevArrow:
    '<button class="slick-prev"><svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11 21L1 11L11 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg></button>',
  nextArrow:
    '<button class="slick-next"><svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 21L11 11L1 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg></button>',
  responsive: [
    {
      breakpoint: 1000,
      settings: {
        slidesToShow: 3,
      },
    },
    {
      breakpoint: 500,
      settings: {
        slidesToShow: 2,
      },
    },
  ],
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

  // let price = parseInt($(".p-type.active").attr("price"));
  let price = parseInt($("#price").attr("data-price"));
  // let sub = parseInt($(".p-type.active").attr("data-sub"));

  let quantity = $("#order-quantity").val();
  let quantityMax = $("#order-quantity").attr("max");
  console.log(image);
  console.log(product);
  console.log(price);
  console.log(quantity);
  console.log(quantityMax);
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
      image,
      token,
    },
    dataType: "JSON",
    success: function (result) {
      console.log(result);
      flashMessage(result.error, result.message);
      $("header .cart-text-quantity").text(result.total);
      if (result.newItem) {
        $(".cart-hover-body").append(`
               
        <div class="cart-hover-item position-relative">
            <a href="${result.newItem.url}" class=""><img src="${
          result.newItem.image
        }" alt="${result.newItem.product_name}" class="img-fluid"></a>
            <div>
                <a href="${result.newItem.url}">
                    <div class="mb-1">${result.newItem.product_name}</div>
                    <div class="sub-name">${result.newItem.sub_name}</div>
                    <div class="item-price d-flex flex-wrap align-items-center justify-content-between">
                        <p>${result.newItem.price
                          .toString()
                          .replace(/\B(?=(\d{3})+(?!\d))/g, ".")}
                        <span class="span-price-origin">${result.newItem.price_origin
                          .toString()
                          .replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</span>
                        </p>
                        <p>x ${result.newItem.quantity}</p>
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
// select.addEventListener("click", () => {
//   options_list.classList.toggle("active");
//   select.querySelector(".fa-angle-down").classList.toggle("fa-angle-up");
// });

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
