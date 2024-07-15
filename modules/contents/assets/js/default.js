// $('.carousel-main-slide').flickity({
//     wrapAround: true,
//     // contain: true,
//     pageDots: false,
//     prevNextButtons: true,
//     // autoPlay: 5000,
//     autoPlay: true,
//     pauseAutoPlayOnHover: false,
//     cellAlign: 'center',
//     arrowShape: {
//         x0: 15,
//         x1: 60, y1: 40,
//         x2: 70, y2: 30,
//         x3: 35
//     }
// });
//
// $('.carousel-nav-slide').flickity({
//     asNavFor: '.carousel-main-slide',
//     contain: true,
//     pageDots: false,
//     // autoPlay: 5000,
//     autoPlay: true,
//     wrapAround: true,
//     prevNextButtons: false,
//     pauseAutoPlayOnHover: false,
//     cellAlign: 'center'
// });
//
// $('.carousel-contents-slide').flickity({
//     wrapAround: true,
//     contain: true,
//     pageDots: false,
//     prevNextButtons: true,
//     autoPlay: true,
//     pauseAutoPlayOnHover: false,
//     cellAlign: 'left',
//     arrowShape: {
//         x0: 30,
//         x1: 60, y1: 30,
//         x2: 65, y2: 25,
//         x3: 40
//     }
//
// });

$(document).ready(function () {
  $(".history-cas-text").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    fade: false,
    asNavFor: ".history-cas",
    centerPadding: "150px",
    dots: false,
    nextArrow:
      '<button class="n-btn"><svg class="flickity-button-icon" viewBox="0 0 100 100"><path d="M 15,50 L 60,90 L 70,80 L 35,50  L 70,20 L 60,10 Z" class="arrow" transform="translate(100, 100) rotate(180) "></path></svg></button>',
    prevArrow:
      '<button class="p-btn"><svg class="flickity-button-icon" viewBox="0 0 100 100"><path d="M 15,50 L 60,90 L 70,80 L 35,50  L 70,20 L 60,10 Z" class="arrow"></path></svg></button>',
    centerMode: true,
    autoplay: true,
    autoplaySpeed: 5000,
    responsive: [
      {
        breakpoint: 1199,
        settings: {
          centerPadding: "150px",
        },
      },
      {
        breakpoint: 769,
        settings: {
          centerPadding: "0",
        },
      },
    ],
  });

  $(".history-cas").slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    asNavFor: ".history-cas-text",
    dots: false,
    centerMode: true,
    focusOnSelect: true,
    arrows: false,
    autoplay: true,
    autoplaySpeed: 5000,
    responsive: [
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 3,
          centerPadding: "0",
        },
      },
      {
        breakpoint: 769,
        settings: {
          slidesToShow: 1,
          centerPadding: "50px",
        },
      },
    ],
  });
});

window.onload = function () {
  var ScrollPos =
    $(".ul-grid .active").closest("li").offset().left +
    $(".ul-grid .active").closest("li").outerWidth(true) / 2 +
    $(".menu-left").scrollLeft() -
    $(".menu-left").width() / 2;
  // console.log(ScrollPos);
  $(".menu-left").animate(
    {
      scrollLeft: ScrollPos,
    },
    100
  );

  var el = document.getElementById("h2_c");
  el.scrollIntoView({
    behavior: "smooth",
  });
};

expand_filter();
function expand_filter() {
  $(".title").click(function (e) {
    var id = $(this).attr("data-id");
    $("#" + id).slideToggle("slow");
    $(this).find(".showmore").toggleClass("rotate");
  });
}
