const regexTelephone = /^0[0-9]{9}$/;
const regexEmail = /^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,}$/;
const token = $("#csrf-token").val();

const tooltipTriggerList = document.querySelectorAll(
  '[data-bs-toggle="tooltip"]'
);
const tooltipList = [...tooltipTriggerList].map(
  (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
);

function flashMessage(error, message) {
  error = error ? "error" : "success";
  let time = 800;

  $("#flash-message .message").html(message);
  $("#flash-message-container").fadeIn().delay(time).fadeOut();
  $("#flash-message").addClass(error);

  setTimeout(function () {
    $("#flash-message").removeClass(error);
  }, time + 800);
}

$(".number-only").on("input", function () {
  let oldValue = $(this).val();
  let newValue = $(this)
    .val()
    .replace(/[^0-9]/g, oldValue);
  // newValue = newValue ? newValue : 1;
  newValue = newValue ? newValue : 1;
  $(this).val(newValue);
});

$(".plus").on("click", function () {
  var oldValue = $(this).prev("input").val();
  oldValue = oldValue ? oldValue : 1;
  var newVal = parseFloat(oldValue) + 1;
  $(this).prev("input").val(newVal);
});

$(".subtract").on("click", function () {
  var oldValue = $(this).next("input").val();
  oldValue = oldValue > 1 ? parseFloat(oldValue) : 2;
  var newVal = oldValue - 1;
  $(this).next("input").val(newVal);
});

$(".toggle-password").click(function (e) {
  e.preventDefault();

  if ($(this).prev("input").attr("type") === "text") {
    $(this).prev("input").attr("type", "password");
    $(this).find("svg:nth-child(2)").hide();
    $(this).find("svg:nth-child(1)").show();
  } else {
    $(this).prev("input").attr("type", "text");
    $(this).find("svg:nth-child(2)").show();
    $(this).find("svg:nth-child(1)").hide();
  }
});

// Bắt sự kiện khi người dùng click vào nút upload ảnh
$(".btn-upload-image").click(function (e) {
  e.preventDefault();
  // Kích hoạt sự kiện click trên input ẩn để chọn file
  $(this).prev(".input-upload-image").click();
});

// Bắt sự kiện khi người dùng thay đổi file ảnh trong input
$(document).on("change", ".input-upload-image", function () {
  // Gọi hàm readURL để xử lý việc hiển thị ảnh và đẩy dữ liệu vào input trong form
  readURL(this);
});

function readURL(input) {
  let element = input;
  for (let i = 0; i < 3; i++) {
    if (element && element.nextElementSibling) {
      element = element.nextElementSibling;
    } else {
      element = null;
      break;
    }
  }
  if (element) {
    element.remove();
  }

  if (input.files && input.files[0]) {
    // Giới hạn file <= 1Mb
    if (input.files[0].size > 1048576) {
      invalid(input.id, "Vui lòng nhập ảnh kích thước không quá 1 MB");
      return false;
    }
    var reader = new FileReader();
    reader.onload = function (e) {
      // Cập nhật ảnh cho cả hai input
      let imgElements = document.getElementsByClassName(
        input.getAttribute("data-img")
      );
      Array.from(imgElements).forEach(function (imgElement) {
        imgElement.src = e.target.result;
      });

      // Đẩy dữ liệu ảnh vào input trong form
      const mainFormImageInput = document.getElementById("image");
      if (mainFormImageInput) {
        mainFormImageInput.files = input.files;
      }
    };
    reader.readAsDataURL(input.files[0]);
  }

  // Tạm thời bỏ dòng này để không gọi submit form tự động
  $(".page-dashboard-image").submit();
}

let isCartHoverVisible = false;

$(document).click(function (event) {
  var target = $(event.target);
  if (!target.closest(".cart_header").length) {
    $(".cart-hover").css("display", "none");
    isCartHoverVisible = false;
  }
});

$(".cart_header > svg").click(function () {
  if (isCartHoverVisible) {
    console.log(1);
    $(".cart-hover").css("display", "none");
    isCartHoverVisible = false;
  } else {
    console.log(2);
    $(".cart-hover").css("display", "block");
    isCartHoverVisible = true;
  }
});

// JavaScript để xử lý sự kiện cuộn trang
var goTopButton = document.getElementById("go-top");

// Hiển thị nút Go Top khi cuộn xuống
window.addEventListener("scroll", function () {
  if (window.pageYOffset > 100) {
    goTopButton.style.display = "flex";
  } else {
    goTopButton.style.display = "none";
  }
});

$(".delete-cart").click(function (e) {
  e.preventDefault();
  let index = $(this).attr("data-id");
  let remove = 1;
  $.ajax({
    url: "index.php?module=products&view=cart&task=updateCart&raw=1",
    type: "POST",
    data: { index, remove },
    dataType: "JSON",
    success: function (result) {
      location.reload();
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      location.reload();
    },
  });
});
