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

// $("#btn-submit-register-password").click(function (e) {
//   e.preventDefault();
//     $("label.label_error").prev().remove();
//     $("label.label_error").remove();
//   let nameregister = $("input[name=nameregister]").val();
//   let emailregister = $("input[name=emailregister]").val();
//   let passwordregister = $("input[name=passwordregister]").val();
//   let repassregister = $("input[name=repassregister]").val();

//   if (!nameregister.trim()) {
//     invalid("nameregister", "Vui lòng nhập tên của bạn");
//     return false;
//   }

//   if (!emailregister.trim()) {
//     invalid("emailregister", "Vui lòng nhập địa chỉ email của bạn");
//     return false;
//   }

//   if (!passwordregister.trim()) {
//     invalid("passwordregister", "Vui lòng nhập mật khẩu của bạn");
//     return false;
//   }

//   if (!repassregister.trim()) {
//     invalid("repassregister", "Vui lòng nhập mật khẩu của bạn");
//     return false;
//   }

//     let password = $("input[name=passwordregister]").val();
//     let _this = $(this);
//     _this.html(`<div class="spinner-border text-light" role="status"><span class="visually-hidden">Loading...</span></div>`).css("pointer-events", "none");
// $.ajax({
//   url: "index.php?module=members&view=register&task=register&raw=1",
//   type: "POST",
//   data: { token, password },
//   dataType: "JSON",
//   success: function (result) {
//     console.log(result);

//     _this.html(`Đăng ký`).css("pointer-events", "auto");
//     $(".layout-modal").hide();
//     $(".layout-register-success").show();

//     return;
//   },
//   error: function (XMLHttpRequest, textStatus, errorThrown) {
//     console.log(
//       "Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối."
//     );
//     return;
//   },
// });

// });

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
$(document).ready(function () {
  var alert_member = $("#alert_member").val();
  alert_members1 = alert_member ? JSON.parse(alert_member) : [];
  $("#btn-submit-register").click(function (e) {
    if (checkRegister()) $("form#form-register").submit();
  });
});

function checkRegister() {
  $("label.label_error").prev().remove();
  $("label.label_error").remove();

  if (!notEmpty("nameregister", alert_members1[0])) {
    return false;
  }

  if (!notEmpty("emailregister", alert_members1[2])) {
    return false;
  }
  if (!emailValidator("emailregister", alert_members1[3])) {
    return false;
  }

  if (!notEmpty("passregister", alert_members1[4])) {
    return false;
  }
  if (!lengthMin("passregister", 8, alert_members1[8])) {
    return false;
  }
  if (!notEmpty("repassregister", alert_members1[5])) {
    return false;
  }
  if (!lengthMin("repassregister", 8, alert_members1[8])) {
    return false;
  }
  let name = $("input[name=nameregister]").val();
  let email = $("input[name=emailregister]").val();
  let password = $("input[name=passregister]").val();
  let repassword = $("input[name=repassregister]").val();
  let _this = $(this);
  _this
    .html(
      `<div class="spinner-border text-light" role="status"><span class="visually-hidden">Loading...</span></div>`
    )
    .css("pointer-events", "none");
  $.ajax({
    url: "index.php?module=members&view=register&task=register&raw=1",
    type: "POST",
    data: { token, name, email, password, repassword },
    dataType: "JSON",
    success: function (result) {
      if (result.error == false) {
        _this.html(`Đăng ký`).css("pointer-events", "auto");
        $(".register-success-telephone").html(email);
        $(".layout-modal").hide();
        $(".layout-register-success").show();
        let endTime = new Date().getTime() + 11 * 1000;

        countInterval = setInterval(function () {
          let currentTime = new Date().getTime();
          let timeDifference = endTime - currentTime;
          if (timeDifference > 0) {
            let seconds = Math.floor((timeDifference % (1000 * 10)) / 1000);
            $(".re-send-count-down-callback").text(seconds + "s");
          } else {
            clearInterval(countInterval);
            $(".re-send-count-down-call-back").text("");
            window.location.reload();
          }
        }, 1000);
      }
      if (result.error == true) {
        _this.html(result.message).css("pointer-events", "auto");
        if (result.type == "pass") {
          invalid("repassregister", result.message);
        }
        if (result.type == "email") {
          invalid("emailregister", result.message);
        }
      }
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      console.log(
        "Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối."
      );
      return;
    },
  });
}

function open_alert($image, $mess) {
  $("#alert_message").html($image + "<p>" + $mess + "</p>");
  $("#alert_modal").fadeIn().addClass("show");
}

function close_alert() {
  $("#alert_modal").fadeOut().removeClass("show");
}
