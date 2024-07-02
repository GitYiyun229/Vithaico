$('.form-select2').each(function(){
    let idModal = $(this).closest('.modal').attr('id');
    $(this).select2({
        dropdownParent: $('#' + idModal),
    })
})

$('.form-province').on('change', function(){
	let code = $(this).val();
    let idModal = $(this).closest('.modal').attr('id');
	loadDistrict(code, idModal);
})

$('.form-district').on('change', function(){
	let code = $(this).val();
    let idModal = $(this).closest('.modal').attr('id');
	loadWard(code, idModal);
})

function loadDistrict(code, idModal){
	$.ajax({
        url: "index.php?module=products&view=cart&task=loadDistrict&raw=1",
        type: 'POST',
        data: {code},
        dataType: 'JSON',
        success: function (result) {
			let pills = [];
			result.forEach(function(item, index){
				pills.push({id: item.code, text: item.name});
			})
			$('#'+idModal).find('.form-district').empty().select2({
                dropdownParent: $('#' + idModal),
				data: pills
			});
			loadWard(pills[0].id, idModal)
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
        }
    });
}

function loadWard(code, idModal){
	$.ajax({
        url: "index.php?module=products&view=cart&task=loadWard&raw=1",
        type: 'POST',
        data: {code},
        dataType: 'JSON',
        success: function (result) {
			let pills = [];
			result.forEach(function(item, index){
				pills.push({id: item.code, text: item.name});
			})
			$('#'+idModal).find('.form-ward').empty().select2({
                dropdownParent: $('#' + idModal),
				data: pills
			});
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
        }
    });
}

$('.btn-save-address').click(function(e) {
    e.preventDefault();
    if (validateAddress($(this))) {
        $(this).closest('form').submit()
    }  
})

$('.remove-address').click(function(e) {
    e.preventDefault();
    let _this = $(this);
    let id = _this.attr('data-id');
  
    $.ajax({
        url: "index.php?module=members&view=address&task=removeAddress&raw=1",
        type: 'POST',
        data: {token, id},
        dataType: 'JSON',
        success: function (result) {
			if (!result.error) {
                _this.closest('.item-address').remove()
            }
            flashMessage(result.error, result.message);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
        }
    });
})

function validateAddress(el) {
    let name = el.closest('form').find('input[name=name]').val().trim();
    let telephone = el.closest('form').find('input[name=telephone]').val().trim();
    let address = el.closest('form').find('input[name=address]').val().trim();
    let province = el.closest('form').find('select[name=province]').val();
    let district = el.closest('form').find('select[name=district]').val();
    let ward = el.closest('form').find('select[name=ward]').val();

    $('.label_error').remove();

    if (!name) {
        el.closest('form').find('input[name=name]').focus().after('<div class="label_error text-red">Vui lòng nhập họ tên</div>')
        return false;
    }

    if (!telephone) {
        el.closest('form').find('input[name=telephone]').focus().after('<div class="label_error text-red">Vui lòng nhập số điện thoại</div>')
        return false;  
    }

    if (!regexTelephone.test(telephone)) {
        el.closest('form').find('input[name=telephone]').focus().after('<div class="label_error text-red">Số điện thoại không đúng định dạng</div>')
        return false;  
    }

    if (!address) {
        el.closest('form').find('input[name=address]').focus().after('<div class="label_error text-red">Vui lòng nhập địa chỉ</div>')
        return false;
    }

    if (!province || province == 0) {
        el.closest('form').find('select[name=province]').select2('open').after('<div class="label_error text-red">Vui lòng chọn Tỉnh/ Thành phố</div>')
        return false;
    }

    if (!district || district == 0) {
        el.closest('form').find('select[name=district]').select2('open').after('<div class="label_error text-red">Vui lòng chọn Quận/ Huyện</div>')
        return false;
    }

    if (!ward || ward == 0) {
        el.closest('form').find('select[name=ward]').select2('open').after('<div class="label_error text-red">Vui lòng chọn Phường/ Xã</div>')
        return false;
    }

    return true;
}