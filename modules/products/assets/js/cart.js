$('.number-only').on('change', function(){
	let index = $(this).attr('data-id');
	let quantity = $(this).val();
	updateCart(index, quantity);
})

$(".plus").on("click", function () {
    let input = $(this).prev('input');
	let index = input.attr('data-id');
	let quantity = input.val();
	updateCart(index, quantity);
});

$(".subtract").on("click", function () {
    let input = $(this).next('input');
	let index = input.attr('data-id');
	let quantity = input.val();
	updateCart(index, quantity);
});

function updateCart(index, quantity){
	$.ajax({
        url: "index.php?module=products&view=cart&task=updateCart&raw=1",
        type: 'POST',
        data: {index, quantity},
        dataType: 'JSON',
        success: function (result) {
            location.reload()
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            location.reload()
        }
    });
}

$('.delete-cart').click(function(e){
	e.preventDefault();
	let index = $(this).attr('data-id');
	let remove = 1;

	$.ajax({
        url: "index.php?module=products&view=cart&task=updateCart&raw=1",
        type: 'POST',
        data: {index, remove},
        dataType: 'JSON',
        success: function (result) {
            location.reload()
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            location.reload()
        }
    });
})

addSelect2()

function addSelect2() {
    $('.form-select2').each(function(){
        let idModal = $(this).closest('.modal').attr('id');
        if (idModal == undefined) {
            idModal = $(this).closest('form').attr('id');
        }
        $(this).select2({
            dropdownParent: $('#' + idModal),
        })
    })
}

$(document).on('change', '.form-province', function(){
	let code = $(this).val();
    let idModal = $(this).closest('.modal').attr('id');
    if (idModal == undefined) {
        idModal = $(this).closest('form').attr('id');
    }
    if (code != 0 || code != '') {
        loadDistrict(code, idModal, $(this));
    }
})

$(document).on('change', '.form-district', function(){
	let code = $(this).val();
    let idModal = $(this).closest('.modal').attr('id');
    if (idModal == undefined) {
        idModal = $(this).closest('form').attr('id');
    }

    if (code != 0 || code != '') {
        loadWard(code, idModal, $(this));
    }
})

function loadDistrict(code, idModal, element){
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
			element.closest('form').find('.form-district').empty().select2({
                dropdownParent: $('#' + idModal),
				data: pills
			});
            if (pills[0].id) {
                loadWard(pills[0].id, idModal, element)
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
        }
    });
}

function loadWard(code, idModal, element){
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
			element.closest('form').find('.form-ward').empty().select2({
                dropdownParent: $('#' + idModal),
				data: pills
			});
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
        }
    });
}

$('.submit-cart').click(function(e) {
    e.preventDefault();
    if (validateAddress($(this))) {
        $('#form-cart').submit()
    }
})

$('.btn-add-more-address').click(function(e){
    e.preventDefault();

    $('.modal-body-list').hide()
    $('.modal-body-add').show()
})

$('.btn-cancel-add-more-address').click(function(e){
    e.preventDefault();

    $('.modal-body-list').show()
    $('.modal-body-add').hide()

    resetAddress();
})

$(document).on('click', '.btn-save-address', function(e) {
    e.preventDefault();
    let el = $(this);
    if (validateAddress(el)) {
        let name = el.closest('form').find('input[name=name]').val().trim();
        let telephone = el.closest('form').find('input[name=telephone]').val().trim();
        let address = el.closest('form').find('input[name=address]').val().trim();
        let province = el.closest('form').find('select[name=province]').val();
        let district = el.closest('form').find('select[name=district]').val();
        let ward = el.closest('form').find('select[name=ward]').val();
        let is_default = el.closest('form').find('input[name=default]').prop('checked');
        let id = el.closest('form').find('input[name=id]').val() ?? 0;

        let provinceName = el.closest('form').find('select[name=province]').select2('data')[0].text;
        let districtName = el.closest('form').find('select[name=district]').select2('data')[0].text;
        let wardName = el.closest('form').find('select[name=ward]').select2('data')[0].text;

        $.ajax({
            url: "index.php?module=members&view=address&task=saveAddress&raw=1",
            type: 'POST',
            data: {token, name, telephone, address, province, district, ward, default: is_default != false ? 1 : 0, id},
            dataType: 'JSON',
            success: function (result) {
                // console.log(result);
                flashMessage(result.error, result.message);

                if (!result.error) {
                    if (result.data.default == 1) {
                        el.closest('.modal').find('input[name=default]').prop('checked', false);
                        el.closest('.modal').find('.item-address .text-nowrap').html('');
                        el.closest('form').find('input[name=default]').prop('checked', true);
                    }

                    if (id) {
                        el.closest('.user-address').find('.item-address').attr('data-address', JSON.stringify(result.data))
                        el.closest('.user-address').find('.item-address div:first-child div:nth-child(1)').text(result.data.name)
                        el.closest('.user-address').find('.item-address div:first-child div:nth-child(2)').text(result.data.telephone)
                        el.closest('.user-address').find('.item-address div:first-child div:nth-child(3)').text(`${result.data.address}, ${wardName}, ${districtName}, ${provinceName}`)
                        if (result.data.default == 1) {
                            el.closest('.user-address').find('.item-address .text-nowrap').html('<div class="position-absolute text-grey is-default">Mặc định</div>')
                        }
                    } else {
                        $('.modal-body-list').show();
                        $('.modal-body-add').hide();

                        resetAddress();
                        
                        $('.user-address-list').append(generateNewAddress(result, province, district, ward, provinceName, districtName, wardName))

                        addSelect2()
                    }
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
            }
        });
    }
})

$(document).on('click', '.item-address', function() {
    let data = JSON.parse($(this).attr('data-address'));
    // console.log(data);return
    $('#name').val(data.name);
    $('#telephone').val(data.telephone);
    $('#address').val(data.address);
    $('#province').val(data.province_id).trigger('change');
    $('#district').val(data.district_id).trigger('change');
    $('#ward').val(data.ward_id).trigger('change');
    
    $('#modalAddress').modal('toggle');
})

$(document).on('click', '.btn-cancel', function() {
    let data = JSON.parse($(this).closest('.user-address').find('.item-address').attr('data-address'));

    $(this).closest('.user-address').find('form input[name=name]').val(data.name)
    $(this).closest('.user-address').find('form input[name=telephone]').val(data.telephone)
    $(this).closest('.user-address').find('form input[name=address]').val(data.address)
    $(this).closest('.user-address').find('form select[name=province]').val(data.province_id).trigger('change');
    $(this).closest('.user-address').find('form select[name=district]').val(data.district_id).trigger('change');
    $(this).closest('.user-address').find('form select[name=ward]').val(data.ward_id).trigger('change');
    $(this).closest('.user-address').find('form input[name=default]').prop("checked", data.default == 1 ? true : false);
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

function resetAddress(){
    $('.modal-body-add form').trigger('reset');
    $('.modal-body-add form select[name=province]').val(0).trigger('change');
    $('.modal-body-add form select[name=district]').empty().append(new Option('Quận/Huyện', 0, false, false)).trigger('change');
    $('.modal-body-add form select[name=ward]').empty().append(new Option('Phường/Xã', 0, false, false)).trigger('change');
}

function generateNewAddress(result, province, district, ward, provinceName, districtName, wardName) {
    let listPovince;
    let listDistrict;
    let listWard;
    
    result.data.province.forEach(function(item){
        listPovince += `
            <option value="${item.code}" ${item.code == province ? `selected` : ``}>${item.name}</option>
        `
    })

    result.data.district.forEach(function(item){
        listDistrict += `
            <option value="${item.code}" ${item.code == district ? `selected` : ``}>${item.name}</option>
        `
    })

    result.data.ward.forEach(function(item){
        listWard += `
            <option value="${item.code}" ${item.code == ward ? `selected` : ``}>${item.name}</option>
        `
    })

    return `
        <div class="user-address position-relative mb-3 ">
            <div class="item-address p-3 d-flex align-items-end justify-content-between gap-3 position-relative" data-address='${JSON.stringify(result.data)}'>
                <div>
                    <div class="fw-medium">${result.data.name}</div>
                    <div class="fw-medium">${result.data.telephone}</div>
                    <div class="fw-medium">${provinceName}, ${districtName}, ${wardName}, ${result.data.address}</div>
                </div>
                <div class="text-nowrap">
                    ${result.data.default == 1 ? `<div class="position-absolute text-grey is-default">Mặc định</div>` : ``}
                </div>
            </div>
            <a class="btn-show-form" data-bs-toggle="collapse" href="#addressForm${result.data.id}" role="button" aria-expanded="false" aria-controls="addressForm${result.data.id}">
                Sửa
            </a>
            <div class="collapse" id="addressForm${result.data.id}">
                <div class="card card-body">
                    <form action="" method="POST" class="modal-form">
                        <input type="hidden" name="id" value="${result.data.id}">
                        <div class="col">
                            <input type="text" class="form-control" name="name" placeholder="Họ và tên" value="${result.data.name}">
                        </div>
                        <div class="col">
                            <input type="tel" class="form-control" name="telephone" placeholder="Số điện thoại" value="${result.data.telephone}">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="address" placeholder="Địa chỉ (Ví dụ: Số 23, ngõ 66, hồ tùng mậu)" value="${result.data.address}">
                        </div>
                        <div class="col">
                            <select name="province" class="form-control form-select2 form-province">
                                <option value="0">Tỉnh/TP</option>
                                ${listPovince}
                            </select>
                        </div>
                        <div class="col">
                            <select name="district" class="form-control form-select2 form-district">
                                ${listDistrict}
                            </select>
                        </div>
                        <div class="col">
                            <select name="ward" class="form-control form-select2 form-ward">
                                ${listWard}
                            </select>
                        </div>
                        <div class="col col-12 form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="default" ${result.data.default == 1 ? `checked` : ``} id="default${result.data.id}">
                            <label class="form-check-label" for="default${result.data.id}">
                                Đặt làm địa chỉ mặc định
                            </label>
                        </div>
                        <div class="col col-12 d-flex align-items-center justify-content-between">
                            <a href="" class="fw-medium remove-address" data-id="${result.data.id}">Xóa địa chỉ</a>
                            <div class="d-flex align-items-center gap-3">
                                <a class="btn-form btn-cancel" data-bs-toggle="collapse" href="#addressForm${result.data.id}" role="button" aria-expanded="false" aria-controls="addressForm${result.data.id}">
                                    Hủy
                                </a>
                                <a href="" class="btn-form btn-save-address">Lưu</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>     
        </div>
    `
}

$(document).on('click', '.remove-address', function(e) {
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
                _this.closest('.user-address').remove()
            }
            flashMessage(result.error, result.message);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
        }
    });
})