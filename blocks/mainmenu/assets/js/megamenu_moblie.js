
$(function () {
  new Mmenu(document.querySelector("#mySidenav"), {
    offCanvas: {
      position: "left",
    },
    theme: "light",
  });
});

$(document).ready(function () {
  let alert1 = $("#alert_ip").val();
  $("#keyword").keypress(function (e) {
    if (e.which == 13) {
      val1 = $("#keyword").val();
      search = $("#url").val();
      // alert(val1);
      if (val1) {
        link = $("#keyword").attr("data-url");
        link1 = link + search + ".html?keyword=" + val1;

        // alert(link1);
        window.location = link1;
        return false;
      } else {
        alert(alert1);
        return false;
      }
    }
  });
});
