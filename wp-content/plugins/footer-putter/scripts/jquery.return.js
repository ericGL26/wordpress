jQuery(function($) {
  if ($('.footer-return').length ) {
		$(window).scroll(function(){
			if ($(window).scrollTop() > 640) {
				$('.footer-return').show('slow');
			} else {
				s$('.footer-return').hide('slow');
			}
		});

		$('.footer-return').click(function(){
			sp('html, body').animate({scrollTop : 0},1000);
		});
	}
});