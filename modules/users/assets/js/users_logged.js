click_tab_detail(1);

function click_tab_detail(){
	$('.users_tabs li').click(function(){
		var id=$(this).attr('id');
		$('.users_tabs').find('.activated').removeClass('activated');
		$('#'+id).addClass('activated');
		if(id == "tab1"){
			$('.tab_content').load("/index.php?module=users&task=edit&raw=1");
		}
		if(id == "tab2"){
			$('.tab_content').load("/index.php?module=users&task=address_book&raw=1");
		}
		if(id == "tab3"){
			$('.tab_content').load("/index.php?module=products&view=order&raw=1");
		}
		if(id == "tab4"){
		}
		if(id == "tab5"){
			$('.tab_content').load("/index.php?module=messages&task=inbox&raw=1");
		}
		if(id == "tab6"){
			$('.tab_content').load("/index.php?module=products&view=favourites&raw=1");
		}
	});
}
// $(document).ready(function () {
//     $('.time_1').each(function (index) {
//         var time_end = $(this).attr('data-time');
//         // alert(time_end);
//         var id = $(this).attr('data-i');
//         start(time_end, id);
//     });
// });
function start(time_end,id)
{
	// alert(time_end);
    var time_end1 = parseInt(time_end);
    var day =  new Date(time_end1).toLocaleDateString();
    // document.getElementById("time_"+id).innerHTML = day;
            $("#time_"+id).html(day);
}