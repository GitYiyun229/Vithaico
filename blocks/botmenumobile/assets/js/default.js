$(document).ready(function () {
	$('#submitbt_faq').click(function () {
		url = '';
		var keyword = $('#keyword_faq').val();
		var link_search = $('#link_search_faq').val();
		if (keyword != 'Nhập từ khóa tìm kiếm...' && keyword != '') {
			url += '&keyword=' + keyword;
			var check = 1;
		} else {
			var check = 0;
		}
		if (check == 0) {
			alert('Bạn phải nhập từ khóa tìm kiếm');
			return false;
		}
		if (link_search.indexOf("&") == '-1')
			var link = link_search + '/' + keyword + '.html';
		else
			var link = link_search + '&keyword=' + keyword + '&Itemid=16';
		window.location.href = link;
		return false;
	})

  $(".cat_prd").click(function (e) {
    e.preventDefault();
    $("#mySidenav").toggle();
  });
  $("#close-menu").click(function (e) {
    e.preventDefault();
    $("#mySidenav").toggle();
  });
  $(".member").click(function (e) {
    e.preventDefault();
    $(".box_members_click").toggle();

  });
});
