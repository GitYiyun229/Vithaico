const memberModal = new bootstrap.Modal(
  document.getElementById("memberModal"),
  {}
);
let countInterval;

$(document).on("click", ".btn-login", function (e) {
  e.preventDefault();
  $(".layout-modal").hide();
  $(".layout-login").show();
  memberModal.show();
});

$(document).on("click", ".btn-register", function (e) {
  e.preventDefault();
  $(".layout-modal").hide();
  $(".layout-register-telephone").show();
  memberModal.show();
});

$(document).on("click", ".modal-member-tab", function (e) {
  e.preventDefault();
  let tab = $(this).attr("data");
  $(".layout-modal").hide();
  $(".layout-" + tab).show();
});

$(document).on("input", ".form-otp", function () {
  let oldValue = $(this).val().toString().substring(0, 1);
  let newValue = oldValue.replace(/[^0-9]/g, oldValue);
  newValue = newValue ? newValue : "";
  $(this).val(newValue);

  if ($(this).val().length === 1) {
    var nextInput = $(this).next(".form-otp");
    if (nextInput.length) {
      $(this).addClass("active");
      nextInput.focus().addClass("active");
    }
  }
});

$(document).on("keydown", ".form-otp", function (e) {
  if (e.which === 8 && $(this).val().length === 0) {
    var prevInput = $(this).prev(".form-otp");
    if (prevInput.length) {
      $(this).removeClass("active");
      prevInput.focus();
    }
  }
});

$(document).on("paste", ".form-otp", function (e) {
  e.preventDefault();
  var pastedData = (e.originalEvent || e).clipboardData.getData("text");
  var characters = pastedData.split("");

  $(".form-otp").each(function (index, element) {
    if (characters[index]) {
      $(element).val(characters[index]).addClass("active").focus();
    }
  });
});

$("#btn-submit-register-telephone").click(function (e) {
  e.preventDefault();
  let telregister = $("input[name=telregister]").val();
  let nameregister = $("input[name=nameregister]").val();
  let emailregister = $("input[name=emailregister]").val();
  let passregister = $("input[name=passregister]").val();
  let repassregister = $("input[name=repassregister]").val();

  if (!nameregister.trim()) {
    invalid("nameregister", "Vui lòng nhập tên của bạn");
    return false;
  }

  // if (!emailregister.trim()) {
  //   invalid("emailregister", "Vui lòng nhập địa chỉ email của bạn");
  //   return false;
  // }

  // if (!passregister.trim()) {
  //   invalid("passregister", "Vui lòng nhập mật khẩu của bạn");
  //   return false;
  // }
  // if (!repassregister.trim()) {
  //   invalid("passregister", "Vui lòng nhập mật khẩu của bạn");
  //   return false;
  // }

  // if (!telregister.trim()){
  //     invalid('telregister', 'Vui lòng nhập số điện thoại của bạn')
  //     return false;
  // }

  // if (!regexTelephone.test(telregister)){
  //     invalid('telregister', 'Số điện thoại chưa đúng định dạng.')
  //     return false;
  // }

  $.ajax({
    url: "index.php?module=members&view=register&task=registerTelephone&raw=1",
    type: "POST",
    data: { telregister, token },
    dataType: "JSON",
    success: function (result) {
      console.log(result);
      if (result.error) {
        invalid("telregister", result.message);
      } else {
        $(".register-otp-tel").text(telregister);
        $(".layout-modal").hide();
        $(".layout-register-otp").show();
        $(".form-otp:first-child").focus();
        $(".otp-text").show();
        $(".otp-btn").hide();
        // countDownOTP();
      }
      return;
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      console.log(
        "Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối."
      );
      return;
    },
  });
});
$("#btn-submit-register-otp").click(function (e) {
  e.preventDefault();
  let otp = [];
  let error = [];
  $(".form-otp").each(function (index) {
    let item = $(this).val().trim();
    if (!item) {
      error.push(index + 1);
    }
    otp.push(item);
  });

  if (error.length) {
    $(".otp-message").text("Vui lòng nhập mã OTP");
    $(".form-otp:nth-child(" + error[0] + ")").focus();
    return false;
  }

  $.ajax({
    url: "index.php?module=members&view=register&task=registerOTP&raw=1",
    type: "POST",
    data: { token, otp },
    dataType: "JSON",
    success: function (result) {
      console.log(result);
      if (result.error) {
        $(".otp-message").text(result.message);
      } else {
        clearInterval(countInterval);
        $(".layout-modal").hide();
        $(".layout-register-password").show();
      }
      return;
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      console.log(
        "Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối."
      );
      return;
    },
  });
});

$("#btn-re-send-otp").click(function (e) {
  e.preventDefault();

  $.ajax({
    url: "index.php?module=members&view=register&task=reSendOTP&raw=1",
    type: "POST",
    data: { token },
    dataType: "JSON",
    success: function (result) {
      console.log(result);
      return;
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      console.log(
        "Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối."
      );
      return;
    },
  });

  $(".form-otp").removeClass("active").val("");
  $(".form-otp:first-child").focus();
  $(".otp-text").show();
  $(".otp-btn").hide();

  countDownOTP();
});

$("#btn-submit-register-password").click(function (e) {
  e.preventDefault();
  let telregister = $("input[name=telregister]").val();
  let nameregister = $("input[name=nameregister]").val();
  let emailregister = $("input[name=emailregister]").val();
  let passregister = $("input[name=passregister]").val();
  let repassregister = $("input[name=repassregister]").val();

  if (!nameregister.trim()) {
    invalid("nameregister", "Vui lòng nhập tên của bạn");
    return false;
  }

  if (!emailregister.trim()) {
    invalid("emailregister", "Vui lòng nhập địa chỉ email của bạn");
    return false;
  }

  if (!passregister.trim()) {
    invalid("passregister", "Vui lòng nhập mật khẩu của bạn");
    return false;
  }
  if (!repassregister.trim()) {
    invalid("passregister", "Vui lòng nhập mật khẩu của bạn");
    return false;
  }

  if (!telregister.trim()) {
    invalid("telregister", "Vui lòng nhập số điện thoại của bạn");
    return false;
  }

  if (!regexTelephone.test(telregister)) {
    invalid("telregister", "Số điện thoại chưa đúng định dạng.");
    return false;
  }
  if (checkRulePassword()) {
    let password = $("input[name=passwordregister]").val();
    let _this = $(this);
    _this
      .html(
        `<div class="spinner-border text-light" role="status"><span class="visually-hidden">Loading...</span></div>`
      )
      .css("pointer-events", "none");

    $.ajax({
      url: "index.php?module=members&view=register&task=register&raw=1",
      type: "POST",
      data: { token, password },
      dataType: "JSON",
      success: function (result) {
        console.log(result);

        _this.html(`Đăng ký`).css("pointer-events", "auto");
        $(".layout-modal").hide();
        $(".layout-register-success").show();

        return;
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        console.log(
          "Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối."
        );
        return;
      },
    });
  }
});

$("input[name=passwordregister]").on("input", function () {
  checkRulePassword();
});

// function countDownOTP() {
//     let endTime = new Date().getTime() + (61 * 1000);

//     countInterval = setInterval(function() {
//         let currentTime = new Date().getTime();
//         let timeDifference = endTime - currentTime;
//         if (timeDifference > 0) {
//             // var minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
//             let seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

//             $('.re-send-count-down').text(seconds + 's');
//         } else {
//             // $('.re-send-count-down').text('Hết thời gian');
//             clearInterval(countInterval);
//             $('.re-send-count-down').text('');
//             $('.otp-text').hide();
//             $('.otp-btn').show();
//         }
//     }, 1000);
// }

function checkRulePassword() {
  let value = $("input[name=passwordregister]").val();

  let updateRuleStatus = (selector, isValid) => {
    $(selector)
      .addClass(isValid ? "d-block" : "error")
      .removeClass(isValid ? "error" : "d-block");
  };
  //check pass
  updateRuleStatus(".lowercase-rule", /[a-z]/.test(value));
  updateRuleStatus(".uppercase-rule", /[A-Z]/.test(value));
  updateRuleStatus(".min-rule", /^.{8,}$/.test(value));
  //check name

  return $(".password-rule.error").length === 0;
}

$("#form-login").on("keypress", function (e) {
  if (e.which == 13 && !e.shiftKey) {
    $("#btn-submit-login").click();
  }
});

$("#btn-submit-login").click(function (e) {
  e.preventDefault();

  let userlog = $("#userlog").val().trim();
  let passlog = $("#passlog").val();
  let redirect = $("#form-login input[name=redirect]").val();

  if (!regexEmail.test(userlog) && !regexTelephone.test(userlog) && !userlog) {
    invalid("userlog", "Vui lòng nhập email hoặc số điện thoại!");
    return false;
  }

  if (!passlog) {
    invalid("passlog", "Vui lòng nhập mật khẩu!");
    return false;
  }

  $.ajax({
    url: "index.php?module=members&view=log&task=login&raw=1",
    type: "POST",
    data: { token, userlog, passlog, redirect },
    dataType: "JSON",
    success: function (result) {
      console.log(result);

      if (result.error) {
        invalid("userlog", result.message);
      } else {
        location.href = result.redirect;
      }

      return;
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      console.log(
        "Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối."
      );
      return;
    },
  });
});
