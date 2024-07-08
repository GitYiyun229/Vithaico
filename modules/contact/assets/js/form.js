$(document).ready(function () {
  var alert_info = $("#alert_info").val();
  alert_info1 = alert_info ? JSON.parse(alert_info) : [];

  $(".submitFrmC").click(function () {
    if (checkFormsubmit2()) {
      $("#frmContact").submit();
    }
  });
});

function checkFormsubmit2() {
  if (!notEmpty("c_name", alert_info1[0])) {
    return false;
  }
  if (!notEmpty("c_telephone", alert_info1[1])) {
    return false;
  }
  if (!isPhone("c_telephone", alert_info1[5])) {
    return false;
  }
  if (!lengthMin("c_telephone", 10, alert_info1[6])) {
    return false;
  }
  if (!lengthMax("c_telephone", 13, alert_info1[6])) {
    return false;
  }
  if (!notEmpty("c_email", alert_info1[2])) {
    return false;
  }
  if (!emailValidator("c_email", alert_info1[7])) {
    return false;
  }
  if (!notEmpty("c_address", alert_info1[3])) {
    return false;
  }
  if (!notEmpty("c_content", alert_info1[4])) {
    return false;
  }
  return true;
}
