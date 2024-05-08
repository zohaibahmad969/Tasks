jQuery(document).ready(function($) {
		$('.website-main-menu a[href^="#"]').on('click', function(event) {
			let crnt = $(this);
			var target = $($(this).attr('href'));
			
			event.preventDefault();
			var scrollOffset = $(window).width() < 768 ? 110 : 150; // Adjust offset for mobile
			
			if ($("body").hasClass('home')) {
				
				$("#ha-megamenu-main-menu").removeClass('active');
				$('html, body').stop().animate({
					scrollTop: target.offset().top - scrollOffset
				}, 1000);
				
			} else {
				window.location.href = '/' + crnt.attr('href');
			}
			
			return false; // Prevent default behavior of the anchor link
		});
		
		
		// Check if the URL contains a hash
		if (window.location.hash) {
			var targetId = window.location.hash.substring(1); // Extract section ID from the URL
			var target = $("#" + targetId); // Get the target section by ID
			if (target.length) {
				var scrollOffset = $(window).width() < 768 ? 110 : 150; // Adjust offset for mobile
				$('html, body').stop().animate({
					scrollTop: target.offset().top - scrollOffset
				}, 1000);
			}
		}


	});
