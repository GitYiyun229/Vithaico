$(document).ready(function () {
    var alert_member = $('#alert_member').val();
    alert_members1 = alert_member ? JSON.parse(alert_member) : [];

    $('.submitRegister').click(function () {
        if (checkRegister())
            $('form#frmRegister').submit();
    });

    $('.submitLogin').click(function () {
        if (checkLogin())
            $('#frmLogin').submit();
    });
});

function checkLogin() {

    $('label.label_error').prev().remove();
    $('label.label_error').remove();

    if (!notEmpty("log_email", alert_members1[2])) {
        return false;
    }
    if (!emailValidator("log_email", alert_members1[3])) {
        return false;
    }
    if (!notEmpty("log_pass", alert_members1[1])) {
        return false;
    }
    var $data = $('form#frmLogin').serialize();
    $('body').append('<div id="load"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '/index.php?module=members&view=members&raw=1&task=do_login',
        data: $data,
        success: function (data) {
            $('#load').remove();
            if (data.error == true) {
                $image = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2"><circle class="path circle" fill="none" stroke="#D06079" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/><line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3"/><line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2"/></svg>';
                open_alert($image,data.message);
            }
            else {
                $(window.location).attr('href', data.redirect);
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $('#load').remove();
            alert('There was an error uploading to the server. Please check the connection.');
        }
    });
    return false;
}

function checkRegister() {

    $('label.label_error').prev().remove();
    $('label.label_error').remove();

    if (!notEmpty("reg_name", alert_members1[0])) {
        return false;
    }
    if (!notEmpty("reg_tel", alert_members1[9])) {
        return false;
    }
    if (!isPhone("reg_tel", alert_members1[11])) {
        return false;
    }
    if (!lengthMin("reg_tel",10, alert_members1[10])) {
        return false;
    }
    if (!lengthMax("reg_tel",12, alert_members1[10])) {
        return false;
    }
    if (!notEmpty("reg_email", alert_members1[2])) {
        return false;
    }
    if (!emailValidator("reg_email", alert_members1[3])) {
        return false;
    }
    if (!notEmpty("reg_pass", alert_members1[4])) {
        return false;
    }
    if (!lengthMin("reg_pass",6, alert_members1[8])) {
        return false;
    }

    var $data = $('form#frmRegister').serialize();

    $('body').append('<div id="load"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '/index.php?module=members&view=members&raw=1&task=do_register',
        data: $data,
        success: function (data) {
            $('#load').remove();
            $html = data.message;
            if (data.error == false) {
                $image = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2"><circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/><polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/></svg>';
                // $("#frmRegister")[0].reset();
                // open_alert($image,$html);
                $(window.location).attr('href', data.redirect);
            }
            if (data.error == true) {
                $image = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2"><circle class="path circle" fill="none" stroke="#D06079" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/><line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3"/><line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2"/></svg>';
                open_alert($image, $html);
                $('#a_message').click(function () {
                    if(data.type == 'tel'){
                        $('#reg_tel').focus();
                    }
                    if(data.type == 'email') {
                        $('#reg_email').focus();
                    }
                    // if(data.type == 'username') {
                    //     $('#res_name').focus();
                    // }
                });
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $('#load').remove();
            alert('There was an error uploading to the server. Please check the connection.');
        }
    });
}

function open_alert($image,$mess) {
    $('#alert_message').html($image + '<p>' + $mess + '</p>');
    $('#alert_modal').fadeIn().addClass('show');
}
function close_alert() {
    $('#alert_modal').fadeOut().removeClass('show');
}