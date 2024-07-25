$('.status-filter').click(function(e) {
    e.preventDefault();
    let status = $(this).attr('status');

    $('.status-filter').removeClass('active');
    $(this).addClass('active');

    if (status == 'all') {
        $('.item-order').show();
    } else {
        $('.item-order').hide();
        $('.item-order[status=' + status + ']').show();
    }
})

$('.review-rating-item').hover(function() {
    toggleStar(parseInt($(this).attr('value')))
}, function() {
    toggleStar(parseInt($(this).closest('form').find('input[name=rate]').val()))
})

$('.review-rating-item').click(function() {
    let value = parseInt($(this).attr('value'));
    $(this).closest('form').find('input[name=rate]').val(value);
    toggleStar(value);
    let rate_title = [
        'Tệ',
        'Không hài lòng',
        'Bình thường',
        'Hài lòng',
        'Tuyệt vời'
    ];
    $(this).closest('form').find('.review-title').html('<span class="fw-medium text-red">' + rate_title[value - 1] + '</span>');
})

function toggleStar(value) {
    $(`.review-rating-item`).removeClass('active')
    for (let i = 1; i <= value; i++) {
        $(`.review-rating-item:eq(${i - 1})`).addClass('active')
    }
}

$('input[type=file]').change(function() {
    const files = this.files;
    const maxAllowedFiles = 5;

    $(this).closest('form').find('.list-image-review').empty();

    if (files.length > maxAllowedFiles) {
        console.log('Chỉ được up tối đa ' + maxAllowedFiles + ' ảnh');
        flashMessage(true, 'Chỉ được up tối đa ' + maxAllowedFiles + ' ảnh');
    }
     
    for (let i = 0; i < Math.min(maxAllowedFiles, files.length); i++) {
        const file = files[i];
        const image = $('<img class="img-fluid">').addClass('uploaded-image');
        const reader = new FileReader();
        reader.onload = function(e) {
            image.attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
        $(this).closest('form').find('.list-image-review').append(image);
    }

    if (!$(this).closest("form").find('.submit-image').hasClass('active')) {
        $(this).closest("form").find('.submit-image').addClass('active')
    }

    $(this).closest("form").find('.submit-image').find('span').html(`${files.length > maxAllowedFiles ? maxAllowedFiles : files.length}/${maxAllowedFiles}`)
})

$('.submit-image').click(function(e){
    e.preventDefault();
    $(this).closest("form").find('input[type=file]').click();
})

$('.form-submit').click(function(e){
    e.preventDefault();
    $(this).closest('form').find('.review-rate p').remove()
    let rate = $(this).closest('form').find('input[name=rate]').val();
    let comment = $(this).closest('form').find('textarea[name=comment]').val();
    
    if(rate == 0) {
        $(this).closest('form').find('.review-rate').append('<p class="text-red">Vui lòng đánh giá sản phẩm</p>')
        return false;
    }

    if(!comment) {
        $(this).closest('form').find('textarea[name=comment]').attr('placeholder', 'Vui lòng nhập nội dung đánh giá').focus()
        return false;
    }

    $(this).closest('form').submit()
})