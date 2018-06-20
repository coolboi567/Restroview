/*[ Back to top ]
===========================================================*/
var windowH = $(window).height()/2;

$(window).on('scroll',function(){
	if ($(this).scrollTop() > windowH) {
		$("#myBtn").css('display','flex');
	} else {
		$("#myBtn").css('display','none');
	}
});

$('#myBtn').on("click", function(){
	$('html, body').animate({scrollTop: 0}, 300);
});
/*=============================================================*/
$('.closebtn').on('click', function(){
	$(this).parent().slideUp("slow", function(){
		// $(this).remove();
	});
})
/*=============================================================*/
$(window).on('load', function () {
	$(".loader").fadeOut("slow", function() {
		$(".loader").remove();
	});
});
$(window).ready( function() {
	$('.selection-2').select2();
});