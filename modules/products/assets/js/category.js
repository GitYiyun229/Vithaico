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
    let id = parseInt(load.attr('category'));

    if (isElementInViewport($('.loading-scroll')[0]) && totalCurrent < total) {
        load.fadeIn().append(loadingHtml);
        load.attr('page', page);
        load.attr('total-current', totalCurrent + limit);
        
        loadMoreContent(page, limit, id, load);       
    }
}, 1000));

// function isElementInViewport(el) {
//     var rect = el.getBoundingClientRect();
//     return (
//         rect.top >= 0 &&
//         rect.left >= 0 &&
//         rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
//         rect.right <= (window.innerWidth || document.documentElement.clientWidth)
//     );
// }

function loadMoreContent(page, limit, id, load) {
    let price = $('input[name=price]').val();
    let filter = $('input[name=filter]').val();
    let sort = $('input[name=sort]').val();

    $.ajax({
        url: "index.php?module=products&view=cat&task=loadMore&raw=1",
        type: 'GET',
        data: {page, limit, id, price, filter, sort},
        dataType: 'html',
        success: function (result) {
            $(".section-products").append(result);
            load.fadeOut().html('');
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
            load.fadeOut().html('');
        }
    });
}

$('.filter-more').click(function(e) {
    e.preventDefault();

    $(this).closest('.filter-group').find('.filter-item').removeClass('d-none');
    $(this).addClass('d-none');
})

$('.filter-check').on('change', function(){
    let arrPrice = [];
    let arrFilter = [];
  
    $('.filter-check:checked').each(function() {
        let filter = $(this).attr('filter');
        let value = $(this).val();

        switch (filter) {
            case 'price':
                arrPrice.push(value);
                break;
            case 'filter':
                arrFilter.push(value);
                break;
        }
    })

    if (arrPrice.length) {
        $('input[name=price]').val(arrPrice.join(','))
    } else {
        $('input[name=price]').remove();
    }

    if (arrFilter.length) {
        $('input[name=filter]').val(arrFilter.join(','))
    } else {
        $('input[name=filter]').remove();
    }

    if (!$('input[name=sort]').val()) {
        $('input[name=sort]').remove();
    }

    $('.page-products-category').submit()
})

$('.filter-sort').click(function(e) {
    e.preventDefault();
    let data = $(this).attr('data');
    $('input[name=sort]').val(data);
    $('.page-products-category').submit()
})

$('.button_filter').click(function(e){
    e.preventDefault();
    $('.section-item').toggle();
})

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