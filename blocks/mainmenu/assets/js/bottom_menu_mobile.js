$(document).ready(function () {
	$("#procat").click(function () {
		$('#catpro').toggleClass('active');
		$('html body').toggleClass('overflow-y-hidden');
		if ($("#modal_1").data("bs.modal")?.isShown) {
			$("#modal_1").modal("hide");
		}
	});
	// document.getElementsByClassName('menubottom')[0].classList.add("active");
	// document.getElementsByClassName('show_cat')[0].classList.add("active");
	$("#modal_support").on('click', function () {
		$("#modal_1").modal();
	});

	$("#procat").on('click', function () {
		$('.fixed_top').addClass('is-sticky');
	});

	$('.menubottom').on('click', function(){
		let id = $(this).attr('data-id');
		$(".menubottom").removeClass("active");
		$(this).addClass("active");
		$(".show_cat").removeClass("active");
		$(".show_cat"+id).addClass("active");
	});
});
