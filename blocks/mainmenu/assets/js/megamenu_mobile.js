


$(document).ready(function () {
  $("#mySidenav").mmenu({
    classes: "mm-white mm-slide",
    searchfield: false,
    counters: false,
    header: false,
    offCanvas: {
      position: "left",
    },
  });
  
  let alert1 = $("#alert_ip").val();
  $("#keyword").keypress(function (e) {
    if (e.which == 13) {
      val1 = $("#keyword").val();
      search = $("#url").val();
      if (val1) {
        link = $("#keyword").attr("data-url");
        link1 = link + search + ".html?keyword=" + val1;
        window.location = link1;
        return false;
      } else {
        alert(alert1);
        return false;
      }
    }
  });
});
