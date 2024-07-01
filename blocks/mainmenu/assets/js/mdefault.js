// $(function() {
// 	 $("#menu").mmenu({
//         extensions: ["widescreen", "theme-white", "effect-slide"],
//         counters: !0,
//         navbar 		: {
// 			title		: 'Advanced menu'
// 		},
// 	});
// });
// $(function() {
// 	$("#menu").mmenu({
// 		extensions: ["widescreen", "theme-white", "effect-slide"],
// 		// navbar 		: false,
// 		counters: !0,
// 		navbars		: {
// 			height 	: 2,
// 			content : [ 
// 				'<a href="#/" class=""><img src="http://lorempixel.com/60/60/people/1/" /></a>'
// 			]
// 		}
// 	});
// });
$(function() {
	var anchor = $('#mmhome_anchor').val();
	var image = $('#mmhome_image').val();
	$('nav#menu_left').mmenu({
		extensions: ["widescreen", "theme-white", "effect-slide"],
		counters	: true,
		navbar 		: {
			title		: '',
		},
		navbars		: {
				height 	: 2,
				content		: [ 
					'<a href="'+anchor+'" class="mmhome"><img src="'+image+'" /></a>'
				]
			}
		
	});
});
