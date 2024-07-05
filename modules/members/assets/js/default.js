$(".form-select2").select2();

$(".form-province").on("change", function () {
  let code = $(this).val();
  loadDistrict(code);
});

$(".form-district").on("change", function () {
  let code = $(this).val();
  loadWard(code);
});

function loadDistrict(code) {
  $.ajax({
    url: "index.php?module=products&view=cart&task=loadDistrict&raw=1",
    type: "POST",
    data: { code },
    dataType: "JSON",
    success: function (result) {
      let pills = [];
      result.forEach(function (item, index) {
        pills.push({ id: item.code, text: item.name });
      });
      $(".form-district").empty().select2({
        data: pills,
      });
      loadWard(pills[0].id);
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      console.log(
        "Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối."
      );
    },
  });
}

function loadWard(code) {
  $.ajax({
    url: "index.php?module=products&view=cart&task=loadWard&raw=1",
    type: "POST",
    data: { code },
    dataType: "JSON",
    success: function (result) {
      let pills = [];
      result.forEach(function (item, index) {
        pills.push({ id: item.code, text: item.name });
      });
      $(".form-ward").empty().select2({
        data: pills,
      });
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      console.log(
        "Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối."
      );
    },
  });
}

let countInterval;

$(".submit-dashboard").click(function (e) {
  e.preventDefault();

  if (!notEmpty("name", "Vui lòng nhập họ và tên")) {
    return false;
  }

  $(".page-dashboard").submit();
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

$(document).on("click", ".modal-back", function (e) {
  e.preventDefault();

  $(this).closest(".modal-body").find(".modal-step-2").hide();
  $(this).closest(".modal-body").find(".modal-step-1").show();
});

function countDownOTP() {
  let endTime = new Date().getTime() + 61 * 1000;

  countInterval = setInterval(function () {
    let currentTime = new Date().getTime();
    let timeDifference = endTime - currentTime;
    if (timeDifference > 0) {
      // var minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
      let seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

      $(".re-send-count-down").text(seconds + "s");
    } else {
      // $('.re-send-count-down').text('Hết thời gian');
      clearInterval(countInterval);
      $(".re-send-count-down").text("");
      $(".otp-text").hide();
      $(".otp-btn").show();
    }
  }, 1000);
}

$("#btn-submit-telephone").click(function (e) {
  e.preventDefault();

  let _this = $(this);
  let telephone = $("#telephone").val();

  if (!telephone.trim()) {
    invalid("telephone", "Vui lòng nhập số điện thoại của bạn");
    return false;
  }

  if (!regexTelephone.test(telephone)) {
    invalid("telephone", "Số điện thoại chưa đúng định dạng.");
    return false;
  }

  getOTP(telephone, "", _this);
});

$("#btn-submit-telephone-otp").click(function (e) {
  e.preventDefault();

  let _this = $(this);
  let telephone = $("#telephone").val();

  saveChangeInfoDashboard(telephone, "", _this);
});

$("#btn-submit-email").click(function (e) {
  e.preventDefault();

  let _this = $(this);
  let email = $("#email").val();

  if (!email.trim()) {
    invalid("email", "Vui lòng nhập email của bạn");
    return false;
  }

  if (!regexEmail.test(email)) {
    invalid("email", "Email chưa đúng định dạng.");
    return false;
  }

  getOTP("", email, _this);
});

$("#btn-submit-email-otp").click(function (e) {
  e.preventDefault();

  let _this = $(this);
  let email = $("#email").val();

  saveChangeInfoDashboard("", email, _this);
});

function getOTP(telephone = "", email = "", _this) {
  $.ajax({
    url: "index.php?module=members&view=dashboard&task=getChangeOTP&raw=1",
    type: "POST",
    data: { telephone, email, token },
    dataType: "JSON",
    success: function (result) {
      console.log(result);
      if (result.error) {
        telephone
          ? invalid("telephone", result.message)
          : invalid("email", result.message);
      } else {
        telephone
          ? $(".telephone-change-text").text(telephone)
          : $(".email-change-text").text(email);

        _this.closest(".modal-body").find(".modal-step-1").hide();
        _this.closest(".modal-body").find(".modal-step-2").show();

        _this.closest(".modal-body").find(".form-otp:first-child").focus();

        $(".otp-text").show();
        $(".otp-btn").hide();

        countDownOTP();
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
}

function saveChangeInfoDashboard(telephone, email, _this) {
  let otp = [];
  let error = [];
  _this
    .closest(".modal-body")
    .find(".form-otp")
    .each(function (index) {
      let item = $(this).val().trim();
      if (!item) {
        error.push(index + 1);
      }
      otp.push(item);
    });

  if (error.length) {
    _this
      .closest(".modal-body")
      .find(".otp-message")
      .text("Vui lòng nhập mã OTP");
    _this
      .closest(".modal-body")
      .find(".form-otp:nth-child(" + error[0] + ")")
      .focus();
    return false;
  }

  $.ajax({
    url: "index.php?module=members&view=dashboard&task=saveChangeInfoDashboard&raw=1",
    type: "POST",
    data: { token, otp, telephone, email },
    dataType: "JSON",
    success: function (result) {
      console.log(result);
      if (result.error) {
        _this.closest(".modal-body").find(".otp-message").text(result.message);
      } else {
        clearInterval(countInterval);
        location.reload();
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
}

$("#btn-submit-password").click(function (e) {
  e.preventDefault();

  let password = $("#current_password").val().trim();
  let new_password = $("#new_password").val().trim();
  let re_new_password = $("#re_new_password").val().trim();
  $(".label_error").remove();
  if (!password) {
    invalid("current_password", "Vui lòng nhập mật khẩu");
  } else if (!new_password) {
    invalid("new_password", "Vui lòng nhập mật khẩu mới");
  } else if (!re_new_password || new_password !== re_new_password) {
    invalid("re_new_password", "Mật khẩu nhập lại không đúng");
  }
  if (checkRulePassword(password, new_password, re_new_password)) {
    console.log(3452343242);
    $.ajax({
      url: "index.php?module=members&view=dashboard&task=updatePassword&raw=1",
      type: "POST",
      data: { password, new_password, re_new_password, token },
      dataType: "JSON",
      success: function (result) {
        console.log(result);
        if (result.error) {
          invalid("current_password", result.message);
        } else {
          location.href = result.return;
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
  }
  return false;
});
$("input[name=new_password]").on("input", function () {
  let password = $("#current_password").val().trim();
  let new_password = $("#new_password").val().trim();
  let re_new_password = $("#re_new_password").val().trim();
  checkRulePassword(password, new_password, re_new_password);
});
function checkRulePassword(password, new_password, re_new_password) {
  let updateRuleStatus = (selector, isValid) => {
    $(selector)
      .addClass(isValid ? "success" : "error")
      .removeClass(isValid ? "error" : "success");
  };
  updateRuleStatus(".lowercase-rule", /[a-z]/.test(new_password));
  updateRuleStatus(".uppercase-rule", /[A-Z]/.test(new_password));
  updateRuleStatus(".min-rule", /^.{8,}$/.test(new_password));
  return (
    $(".password-rule.error").length === 0 && password && re_new_password === new_password );
}
