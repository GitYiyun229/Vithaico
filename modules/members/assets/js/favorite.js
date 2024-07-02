const loadingHtml = '<div class="loadingio-spinner"><div class="ldio"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>';

const debounce = (mainFunction, delay) => {
    let timer;
    return function (...args) {
        clearTimeout(timer);
        timer = setTimeout(() => {
            mainFunction(...args);
        }, delay);
    };
};

$(window).on('scroll', debounce(function () {
    let load = $('.loading-scroll');
    let page = parseInt(load.attr('page')) + 1;
    let totalCurrent = parseInt(load.attr('total-current'));
    let total = parseInt(load.attr('total'));
    let limit = parseInt(load.attr('limit'));

    if (isElementInViewport($('.loading-scroll')[0]) && totalCurrent < total) {
        load.fadeIn().append(loadingHtml);
        load.attr('page', page);
        load.attr('total-current', totalCurrent + limit);
        
        loadMoreContent(page, limit, load);       
    }
}, 300));

function isElementInViewport(el) {
    var rect = el.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

function loadMoreContent(page, limit, load) {
    let items = load.attr('items');
    $.ajax({
        url: "index.php?module=members&view=favorite&task=loadMore&raw=1",
        type: 'GET',
        data: {page, limit, items},
        dataType: 'html',
        success: function (result) {
            $(".section-more").append(result);
            load.fadeOut().html('');
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
            load.fadeOut().html('');
        }
    });
}