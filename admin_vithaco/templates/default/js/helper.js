/**
 * Default function.  Usually would be overriden by the component
 */
function submitbutton(pressbutton) {
    if (pressbutton == 'remove') {
        if (confirm('Bạn có chắc chắn muốn xóa?'))
            submitform(pressbutton);
    } else {
        submitform(pressbutton);
    }
}
/**
 * Submit the admin form
 */
function submitform(pressbutton) {
    if (pressbutton == 'export') {
        url_current = window.location.href;
        url_current = url_current.replace('#', '');
        window.open(url_current + '&task=export');
        return;
    }
    if (pressbutton) {
        document.adminForm.task.value = pressbutton;
    }
    if (typeof document.adminForm.onsubmit == "function") {
        document.adminForm.onsubmit();
    }

    if (document.adminForm.task.value != 'cancel') {

    }

    document.adminForm.submit();
}

/*
 * Ordering
 */
function tableOrdering(order, dir, task) {
    var form = document.adminForm;
    form.sort_field.value = order;
    form.sort_direct.value = dir;
    submitform(task);
}
/*
 * Check checkbox
 */
function isChecked(isitchecked) {
    if (isitchecked == true) {
        document.adminForm.boxchecked.value++;
    }
    else {
        document.adminForm.boxchecked.value--;
    }
}
function checkAll(n, fldName) {
    if (!fldName) {
        fldName = 'cb';
    }
    var f = document.adminForm;
    var c = f.toggle.checked;
    var n2 = 0;
    for (i = 0; i < n; i++) {
        cb = eval('f.' + fldName + '' + i);
        if (cb) {
            cb.checked = c;
            n2++;
        }
    }
    if (c) {
        document.adminForm.boxchecked.value = n2;
    } else {
        document.adminForm.boxchecked.value = 0;
    }
}

function checkAll2(n, fldName) {
    if (!fldName) {
        fldName = 'c';
    }
    var f = document.adminForm2;
    var c = f.toggle.checked;
    var n2 = 0;
    for (i = 0; i < n; i++) {
        cb = eval('f.' + fldName + '' + i);
        if (cb) {
            cb.checked = c;
            n2++;
        }
    }
    if (c) {
        document.adminForm2.boxchecked.value = n2;
    } else {
        document.adminForm2.boxchecked.value = 0;
    }
}

function listItemTask(id, task)
{
    var f = document.adminForm;
    cb = eval('f.' + id);
    if (cb) {
        for (i = 0; true; i++) {
            cbx = eval('f.cb' + i);
            if (!cbx)
                break;
            cbx.checked = false;
        } // for
        cb.checked = true;
        f.boxchecked.value = 1;
        submitbutton(task);
    }
    return false;
}
function deleteMenu(id, parent_id, url) {
    var r = confirm("Bạn chắc chắn muốn xóa ?")
    if (r == true) {
        $.get(url, {id: id, parent_id: parent_id},
        function (data) {
            $('.' + data).remove();
            alert("Xóa thành công !");
        });
    }
}
/**** CREATE LINKED*******/
function creat_link(object) {
    window.open("index2.php?module=menus&view=items&task=linked&object=" + object, "", "height=600,width=700,menubar=0,resizable=1,scrollbars=1,statusbar=0,titlebar=0,toolbar=0");
}
function link_to_data(str_link) {
    window.opener.document.getElementById("mnu_link").value = str_link;
    window.close();
}
function link_from_linked()
{
    ob = document.getElementById("linked");
    if (ob.value == 0) {
        alert("You have not created a link !");
        ob.focus();
        return false;
    }
    window.opener.document.getElementById("mnu_link").value = ob.value;
    window.close();
}
/*************** CHECK FORM ***************/
//If the length of the element's string is 0 then display helper message
function notEmpty(elemid, helperMsg) {
    elem = document.getElementById(elemid);
    if(elemid == 'category_id'){
        var val_em = $('#'+elemid).val();
        if (val_em == 0 || elem.value.length == 0) {
            document.getElementById('msg_error').innerHTML = helperMsg;
            $('#msg_error').parent().show();
    		alert(helperMsg);
            elem.focus(); // set the focus to this input
            return false;
        }
    }else if(elemid == 'image'){
        var check_image = $('#check_'+elemid).val();
        //alert(elemid);
        if(check_image == 0){
            if (elem.value.length == 0) {
                document.getElementById('msg_error').innerHTML = helperMsg;
                $('#msg_error').parent().show();
        		alert(helperMsg);
                elem.focus(); // set the focus to this input
                return false;
            }
        }
    }else{
       if (elem.value.length == 0) {
            document.getElementById('msg_error').innerHTML = helperMsg;
            $('#msg_error').parent().show();
    		alert(helperMsg);
            elem.focus(); // set the focus to this input
            return false;
        }
    }
    return true;
}

function notEmpty2(elemid, txt_default, helperMsg) {
    elem = $('#' + elemid);
    if (!elem.val() || elem.val().length == 0) {
        document.getElementById('msg_error').innerHTML = helperMsg;
        $('#msg_error').parent().show();
//		alert(helperMsg);
        elem.focus(); // set the focus to this input
        return false;
    } else if (elem.val() == txt_default) {
        document.getElementById('msg_error').innerHTML = helperMsg;
        $('#msg_error').parent().show();
		alert(helperMsg);
        elem.focus(); // set the focus to this input
        return false;
    }
    return true;
}

function lengthMaxword(elemid, max, helperMsg) {
    elem = $('#' + elemid);
    var uInput = elem.val();
    var res = uInput.split(" ");
    for(i=0;i <= res.length;i++ ){
        var lang = res[i];
        //alert(res);
        if(lang && lang.length > max){
//            document.getElementById('msg_error').innerHTML = helperMsg;
            $('#msg_error').parent().show();
            alert(helperMsg);
            elem.focus(); // set the focus to this input
            return false;
            break;
        }
    }
    return true;
}

function lengthMin(elemid, min, helperMsg) {
    elem = $('#' + elemid);
    var uInput = elem.val();
    if (uInput.length >= min) {
        return true;
    } else {
        document.getElementById('msg_error').innerHTML = helperMsg;
        $('#msg_error').parent().show();
        alert(helperMsg);
        elem.focus(); // set the focus to this input
        return false;
    }
}

function lengthMax(elemid, max, helperMsg) {
    elem = $('#' + elemid);
    var uInput = elem.val();
    if (uInput.length <= max) {
        return true;
    } else {
        document.getElementById('msg_error').innerHTML = helperMsg;
        $('#msg_error').parent().show();
		alert(helperMsg);
        elem.focus(); // set the focus to this input
        return false;
    }
}
// check kiem tra co' ky' tu' hoa trong chuoi hay khong
function uppercase(elemid,helperMsg){
    elem = $('#' + elemid);
    var uInput = elem.val();

    var isnum = /[A-Z]/.test(uInput);
    if (isnum) {
        return true;
    }else {
        document.getElementById('msg_error').innerHTML = helperMsg;
        $('#msg_error').parent().show();
        elem.focus(); // set the focus to this input
        return false;
    }
}
// check kiem tra co' so' trong chuoi hay khong
function number_pass(elemid,helperMsg){
    elem = $('#' + elemid);
    var uInput = elem.val();

    var isnum = /[0-9]/.test(uInput);
    if (isnum) {
        return true;
    }else {
        document.getElementById('msg_error').innerHTML = helperMsg;
        $('#msg_error').parent().show();
        elem.focus(); // set the focus to this input
        return false;
    }
}

// in ra thong bao'
function invalid(elemid,helperMsg){
    elem = document.getElementById(elemid);
    document.getElementById('msg_error').innerHTML = helperMsg;
    $('#msg_error').parent().show();
    alert(helperMsg);
    elem.focus();
}

// in ra thong bao'
function invalid2(elemid,helperMsg){
    elem = document.getElementById(elemid);
    document.getElementById('msg_error').innerHTML = helperMsg;
    $('#msg_error').parent().show();
    //alert(helperMsg);
    elem.focus();
}

//If the element's string matches the regular expression it is all numbers
function isNumeric(elemid, helperMsg) {
    elem = document.getElementById(elemid);
    var numericExpression = /^[0-9]+$/;
    if (elem.value.match(numericExpression)) {
        return true;
    } else {
        document.getElementById('msg_error').innerHTML = helperMsg;
		alert(helperMsg);
        elem.focus();
        return false;
    }
}
//If the element's string matches the regular expression it is all numbers
function isNumber(elemid, helperMsg) {
    elem = document.getElementById(elemid);
    var numericExpression = /[0-9]/;
    if (elem.value.match(numericExpression)) {
        return true;
    } else {
        document.getElementById('msg_error').innerHTML = helperMsg;
		alert(helperMsg);
        elem.focus();
        return false;
    }
}
//chứa kí tự In Hoa
function isKitu_hoa(elemid, helperMsg) {
    elem = document.getElementById(elemid);
    var numericExpression =  /[A-Z]/;
    if (elem.value.match(numericExpression)) {
        return true;
    } else {
        document.getElementById('msg_error').innerHTML = helperMsg;
		alert(helperMsg);
        elem.focus();
        return false;
    }
}
//If the element's string matches the regular expression it is all letters
function isAlphabet(elemid, helperMsg) {
    elem = document.getElementById(elemid);
    var alphaExp = /^[a-zA-Z]+$/;
    if (elem.value.match(alphaExp)) {
        return true;
    } else {
        document.getElementById('msg_error').innerHTML = helperMsg;
		alert(helperMsg);
        elem.focus();
        return false;
    }
}

//If the element's string matches the regular expression it is numbers and letters
function isAlphanumeric(elemid, helperMsg) {
    elem = document.getElementById(elemid);
    var alphaExp = /^[0-9a-zA-Z]+$/;
    if (elem.value.match(alphaExp)) {
        return true;
    } else {
        document.getElementById('msg_error').innerHTML = helperMsg;
		alert(helperMsg);
        elem.focus();
        return false;
    }
}
// Limit length
function lengthRestriction(elemid, min, max) {
    elem = document.getElementById(elemid);
    var uInput = elem.value;
    if (uInput.length >= min && uInput.length <= max) {
        return true;
    } else {
        document.getElementById('msg_error').innerHTML = "Please enter between " + min + " and " + max + " characters";
		alert("Please enter between " +min+ " and " +max+ " characters");
        elem.focus();
        return false;
    }
}
// Select box ( multi select)
function madeSelection(elemid, helperMsg) {
    elem = document.getElementById(elemid);
    var i;
    for (i = 0; i < elem.options.length; i++) {
        console.log(elem.options[i].value);
        if (elem.options[i].selected && (elem.options[i].value != "")) {
            return true;
        }
    }
    document.getElementById('msg_error').innerHTML = helperMsg;
    return false;
}
// Email
function emailValidator(elemid, helperMsg) {
    elem = document.getElementById(elemid);
    var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
    if (elem.value.match(emailExp)) {
        return true;
    } else {
        document.getElementById('msg_error').innerHTML = helperMsg;
		alert(helperMsg);
        elem.focus();
        return false;
    }
}

function isChart_db(elemid, helperMsg) {
    elem = document.getElementById(elemid);
    var numericExpression = /[~`!#$%\^&*+=[\]\\';,/{}|\\":<>\?]/;
    if (elem.value.match(numericExpression)) {
        alert(helperMsg);
//        document.getElementById('msg_error').innerHTML = helperMsg;
        elem.focus();
        return true;
    } else {

        return false;
    }
}
// Password and repassword
function checkMatchPass(helperMsg) {
    elem_value = document.getElementById('password').value;
    elem2_value = document.getElementById('repass').value;
    if (elem_value != elem2_value)
    {
        document.getElementById('msg_error').innerHTML = helperMsg;
        return false;
    }
    return true;
}

function checkMatchPass_2(pass, repass, helperMsg) {
    elem_value = $('#' + pass).val();
    elem2_value = $('#' + repass).val();
    if (elem_value != elem2_value) {
        document.getElementById('msg_error').innerHTML = helperMsg;
		alert(helperMsg);
        elem.focus();
        return false;
    } else {
        return true;
    }
}
/*check số điện thoại*/
function isPhone(elemid, helperMsg) {
    elem = $('#' + elemid);
    var numericExpression = /^[0-9 .]+$/;
    if (elem.val().match(numericExpression)) {
        return true;
    } else {
        document.getElementById('msg_error').innerHTML = helperMsg;
		alert(helperMsg);
        elem.focus();
        return false;
    }
}
/*check emai;i*/
function isEmail(elemid, helperMsg) {
    elem = $('#' + elemid);
    var numericExpression = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
    if (elem.val().match(numericExpression)) {
        return true;
    } else {
        document.getElementById('msg_error').innerHTML = helperMsg;
		alert(helperMsg);
        elem.focus();
        return false;
    }
}
/* Upgrade */
function init_position_box(box) {
    var winH = $(window).height();
    var winW = $(window).width();
    box.css('top', winH / 2 - box.height() / 2);
    box.css('left', winW / 2 - box.width() / 2);
}
$(document).ready(function () {
    $('.select2-temp').select2();

    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.scrollToTop').fadeIn().addClass('active');
        } else {
            $('.scrollToTop').fadeOut().removeClass('active');
        }
    });

    //Click event to scroll to top
    $('.scrollToTop').click(function () {
        $('html, body').animate({scrollTop: 0}, 800);
        return false;
    });
    /* Tính lại width của toolbar*/
    var $width = $('#box-content').width();
    $('#wrap-toolbar').css('width', $width + 'px');
    $(window).resize(function () {
        var $width = $('#box-content').width();
        $('#wrap-toolbar').css('width', $width + 'px');
    });
    /* Đính thanh toolbar lên top */
    $(window).scroll(function () {
        if ($(this).scrollTop() > 150) {
            //$('#wrap-toolbar').css({'position':'fixed', 'top':'0','left':'0','width':'100%', 'z-index': '9999'});
            $('#wrap-toolbar').addClass('toolbar-fix');
        } else {
            //$('#wrap-toolbar').css({'position':'relative', 'top':'auto','z-index': '1'});
            $('#wrap-toolbar').removeClass('toolbar-fix');
        }
    });
    /* Hiển thị menu hiện tại */
    current = $('.selected').parent().parent().parent('ul');
    if (current) {
        current.show();
        parrent_current = $('.selected').parent().parent().parent().parent().parent('ul');
        if (parrent_current)
            parrent_current.show();
    }
    $('#menu-bar .has-child .a_has_child').click(function () {
        var $child = $(this).parent().next('ul:first');
        if ($($child).css("display") == "none")
            $($child).css("display", "block");
        else
            $($child).css("display", "none");
    });
    /* Gán chiều cao tối thiểu cho Box content */
    var min_height = $('#sidebar').height();
    $('#box-content').css('min-height', min_height + 'px');
});
function remove_image(module, view, id, field, divNum) {
    if (confirm('Bạn chắc chắn muốn xóa ảnh này?')) {
        $.ajax({
            url: "index.php?module=" + module + "&view=" + view + "&raw=1&task=delete_image",
            type: "get",
            data: {field: field, id: id},
            error: function () {
                alert("Lỗi xoa dữ liệu");
            },
            success: function () {
                $("#" + divNum).remove();
                $("#check_" + field).val(0);
            }
        });
    } else {
        return false;
    }
}

function remove_file(module, view, id, field, divNum) {
    if (confirm('Bạn chắc chắn muốn file này?')) {
        $.ajax({
            url: "index.php?module=" + module + "&view=" + view + "&raw=1&task=delete_file",
            type: "get",
            data: {field: field, id: id},
            error: function () {
                alert("Lỗi xóa dữ liệu");
            },
            success: function () {
                $("." + divNum).remove();
                $("#check_" + field).val(0);
            }
        });
    } else {
        return false;
        file:choose:resizedImage
    }
}

function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

// $('.btn-image').click(function () {
//     var name = $(this).attr('data-name');
//     selectFileWithCKFinder(name);
// });
function selectFileWithCKFinder(elementId) {

    CKFinder.popup({
        chooseFiles: true,
        width: 800,
        height: 600,

        onInit: function (finder) {
            console.log(finder);
            finder.on('files:choose', function (evt) {
                var file = evt.data.files.first();
                console.log(evt);
                var output = document.getElementById(elementId);
                var outputHtml = document.getElementById('html_' + elementId);
                output.value = file.getUrl().substring(1);
                outputHtml.innerHTML = '<img class="img-responsive" src="' + URL_ROOT + '/' + escapeHtml(output.value) + '">';
            });

            finder.on('file:choose:resizedImage', function (evt) {
                console.log(evt);
                var output = document.getElementById(elementId);
                output.value = evt.data.resizedUrl.substring(1);
                var outputHtml = document.getElementById('html_' + elementId);
                outputHtml.innerHTML = '<img class="img-responsive" src="' + URL_ROOT + '/' + escapeHtml(output.value) + '">';
            });
        }
    });
}

$(document).on("click",".select",function(event){
    let id = $(this).attr('data-id');
    $('#'+id).select2('destroy').find('option').prop('selected', 'selected').end().select2();
});
$(document).on("click",".deselect",function(event){
    let id = $(this).attr('data-id');
    $('#'+id).select2('destroy').find('option').prop('selected', false).end().select2();
});

$(document).on('change', '.radio-custom', function() {
    if ($(this).val() == 'all') {
        $(this).parent().next().select2('destroy').find('option').prop('selected', 'selected').end().select2();
    } else {
        $(this).parent().next().select2('destroy').find('option').prop('selected', false).end().select2();
    }
});

$(document).ready(function() {
    let box;
    $(document).on('change', 'input[type="file"]', function() {
        box = $(this).attr('data-class');
        readURL(this, box);
    })

    if ($('.btn-image').length) {
        $('.btn-image').click(function () {
            var name = $(this).attr('data-name');
            selectFileWithCKFinder(name);
        });
    }
});

function readURL(input, box) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.' + box).attr('src', e.target.result);
            $('.' + box).text(input.files[0].name);
        };
        reader.readAsDataURL(input.files[0]);
    }
}