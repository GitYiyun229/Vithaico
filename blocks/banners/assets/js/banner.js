$(document).ready(function () {
  let owl = $(".banner-carousel");
  let onHover = 0;

  // owl.on('translated.owl.carousel', function(event){
  //   onHover = 1;
  // });

  owl.owlCarousel({
    margin: 0,
    loop: true,
    nav: true,
    dots: false,
    autoplay: true,
    items: 1,
    autoplayHoverPause: true,
  })

  $(".owl-prev").click(function(){
    onHover = 0;
  })

  $(".owl-next").click(function(){
    onHover = 0;
  })

  $(".owl-prev").hover(function () {
    let transformValue = $(".banner-carousel .owl-stage").css("transform");
    transformValue = new WebKitCSSMatrix(transformValue);
    transformValue = transformValue.m41;  
    let prev = transformValue + 50;
    onHover = 1;
    $('.banner-carousel .owl-stage').css('transform', 'translateX('+prev+'px)');
  }, function () {
    if (onHover == 1) {
      let transformValue = $(".banner-carousel .owl-stage").css("transform");
      transformValue = new WebKitCSSMatrix(transformValue);
      transformValue = transformValue.m41 - 50;  
      $('.banner-carousel .owl-stage').css('transform', 'translateX('+transformValue+'px)');
    } 
    onHover = 0;
  });

  $(".owl-next").hover(function () {
    let transformValue = $(".banner-carousel .owl-stage").css("transform");
    transformValue = new WebKitCSSMatrix(transformValue);
    transformValue = transformValue.m41;  
    let next = transformValue - 50;
    onHover = 1;
    $('.banner-carousel .owl-stage').css('transform', 'translateX('+next+'px)');
  }, function () {
    if (onHover == 1) {
      let transformValue = $(".banner-carousel .owl-stage").css("transform");
      transformValue = new WebKitCSSMatrix(transformValue);
      transformValue = transformValue.m41 + 50;  
      $('.banner-carousel .owl-stage').css('transform', 'translateX('+transformValue+'px)');
    }
    onHover = 0;
  });

});


