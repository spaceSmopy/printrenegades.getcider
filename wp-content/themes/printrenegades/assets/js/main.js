jQuery(document).ready(function($){

	$('.mobile-handler').click(function(){
		$('.site-navigation').toggleClass('opened-menu');
		$(this).toggleClass('active');
	});
	function adaptiveMenu(){
		$('.site-navigation').css('top', $('.header-cont').innerHeight());
	}
	adaptiveMenu();
	$(window).resize(function(){
		adaptiveMenu();
	});

	$('.sidebar-toggler').click(function(){
		$(this).toggleClass('active');
		$('.sidebar.menu').toggleClass('active');
	});

	$(".eModal-1").magnificPopup({
		type: "inline",
		closeOnContentClick: false,
		closeOnBgClick: true,
		preloader: false
  	});
  	
});