// document.addEventListener("DOMContentLoaded", function () {
//   var menuHeader = document.getElementById("menu-header-usa");
//   var menuHover = document.getElementById("menu-hover");
//   var megaLinks = document.querySelectorAll(".mega-links-item");
//   var menuAll = document.getElementById("menu--all");
//   function addActivesToMenu(dataId) {
//     var menu0 = document.querySelectorAll(".menu0-" + dataId);
//     var menu_items = document.querySelectorAll(".menu-item-" + dataId);
//     var menu_headers = document.querySelectorAll(".menu-header-" + dataId);

//     menu0.forEach(function (item) {
//       item.classList.add("actives");
//     });

//     menu_headers.forEach(function (header) {
//       header.classList.add("actives");
//     });

//     menu_items.forEach(function (item) {
//       item.classList.add("actives");
//     });
//   }
//   function updateMenuAllDataId(dataId) {
//     menuAll.setAttribute("data-id", dataId);
//   }
//   function removeActivesFromMenu(dataId) {
//     var menu0 = document.querySelectorAll(".menu0-" + dataId);
//     menu0.forEach(function (item) {
//       item.classList.remove("actives");
//     });

//     var menu_headers = document.querySelectorAll(".menu-header-" + dataId);
//     menu_headers.forEach(function (header) {
//       header.classList.remove("actives");
//     });

//     var menu_items = document.querySelectorAll(".menu-item-" + dataId);
//     menu_items.forEach(function (item) {
//       item.classList.remove("actives");
//     });
//   }

//   megaLinks.forEach(function (link) {
//     link.addEventListener("mouseenter", function () {
//       var dataId = link.getAttribute("data-id");
//       menuAll.setAttribute("data-id", dataId);
//       updateMenuAllDataId(dataId);
//       addActivesToMenu(dataId);
//     });
//   });

//   megaLinks.forEach(function (link) {
//     link.addEventListener("mouseleave", function () {
//       var dataId = link.getAttribute("data-id");
//       menuAll.setAttribute("data-id", dataId);
//       updateMenuAllDataId(dataId);
//       removeActivesFromMenu(dataId);
//     });
//   });

//   menuHeader.addEventListener("mouseover", function () {
//     menuHover.classList.add("d-block");
//   });

//   menuHeader.addEventListener("mouseleave", function (e) {
//     if (!menuHeader.contains(e.relatedTarget)) {
//       menuHover.classList.remove("d-block");
//     }
//   });
// });
