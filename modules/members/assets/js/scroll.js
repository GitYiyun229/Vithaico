window.onload = function() {
    var ScrollPos = ($('.user-menu-side ul li.selected').closest('li').offset().left) + ($('.user-menu-side ul li.selected').closest('li').outerWidth(true) / 2) + ($('.user-menu-side ul').scrollLeft()) - ($('.user-menu-side ul').width() / 2);
    // console.log(ScrollPos);
    $('.user-menu-side ul').animate({
        scrollLeft: ScrollPos - 10
    }, 100);
};