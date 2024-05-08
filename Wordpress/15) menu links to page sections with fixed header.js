
	jQuery(document).ready(function($){
		$('.website-main-menu a[href^="#"]').on('click', function(event) {
			var target = $($(this).attr('href'));
			if (target.length) {
				event.preventDefault();
				var scrollOffset = $(window).width() < 768 ? 110 : 150; // Adjust offset for mobile
				$("#ha-megamenu-main-menu").removeClass('active');
				$('html, body').stop().animate({
					scrollTop: target.offset().top - scrollOffset
				}, 1000);
			}
			return false; // Prevent default behavior of the anchor link
		});
	});
