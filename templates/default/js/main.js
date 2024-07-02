const regexTelephone = /^0[0-9]{9}$/;
const regexEmail = /^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,}$/;
const token = $('#csrf-token').val();

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

function flashMessage(error, message){
    error = error ? 'error' : 'success';
    let time = 800;

    $('#flash-message .message').html(message);
    $('#flash-message-container').fadeIn().delay(time).fadeOut();
    $('#flash-message').addClass(error);

    setTimeout(function(){
        $('#flash-message').removeClass(error);
    }, time + 800);
}

$('.number-only').on('input', function(){
    let oldValue = $(this).val();
	let newValue = $(this).val().replace(/[^0-9]/g, oldValue);
	// newValue = newValue ? newValue : 1;
	newValue = newValue ? newValue : 1;
    $(this).val(newValue);
});

$(".plus").on("click", function () {
    var oldValue = $(this).prev('input').val();
    oldValue = oldValue ? oldValue : 1;
    var newVal = parseFloat(oldValue) + 1;
    $(this).prev('input').val(newVal);
});

$(".subtract").on("click", function () {
    var oldValue = $(this).next('input').val();
    oldValue = oldValue > 1 ? parseFloat(oldValue) : 2;
    var newVal = oldValue - 1;
    $(this).next('input').val(newVal);
});

$('.toggle-password').click(function(e) {
    e.preventDefault(); 

    if ($(this).prev('input').attr('type') === 'text') {
        $(this).prev('input').attr('type', 'password');
        $(this).find('svg:nth-child(2)').hide()
        $(this).find('svg:nth-child(1)').show()
    } else {
        $(this).prev('input').attr('type', 'text');
        $(this).find('svg:nth-child(2)').show()
        $(this).find('svg:nth-child(1)').hide()
    }
})

$('.btn-upload-image').click(function(e) {
    e.preventDefault();
    $(this).prev('.input-upload-image').click();
})

$(document).on('change', '.input-upload-image', function() {
    readURL(this);
})

function readURL(input) {
    if(input.nextElementSibling.nextElementSibling.nextElementSibling) {
        input.nextElementSibling.nextElementSibling.nextElementSibling.remove()
    }
    if (input.files && input.files[0]) {
        //Giới hạn file <= 1Mb
        if (input.files[0].size > 1048576) {
            invalid(input.id, 'Vui lòng nhập ảnh kích thước không quá 1 MB')
            return false;
        }
        var reader = new FileReader();
        reader.onload = function (e) {
            input.previousElementSibling.src = e.target.result
        };
        reader.readAsDataURL(input.files[0]);
    }
}
