show_box_search(1);
function show_box_search(){
	$('.button-search').mouseover(function(){
//		var status=$('.block-search').css('display');
//		if(status == 'none'){
			$('.block-search').css({'display':'block'});
//		}else{
//			$('.block-search').css({'display':'none'});
//		}
		
	});
	$('.button-search').mouseout(function(){
//		var status=$('.block-search').css('display');
//		if(status == 'none'){
//			$('.block-search').css({'display':'block'});
//		}else{
			$('.block-search').css({'display':'none'});
//		}
		
	});
}