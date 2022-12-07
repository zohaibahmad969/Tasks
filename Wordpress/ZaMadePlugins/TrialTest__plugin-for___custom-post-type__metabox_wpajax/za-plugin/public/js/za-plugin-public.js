jQuery(document).ready(function ($) {
	$("#website_post_form").submit(function (e) {
		e.preventDefault();
		
		$(".za-preloader").css("display", "block");
		$.ajax({
			url: '/wp-admin/admin-ajax.php',
			type: 'POST',
			data: {
				'action': 'save_websites_post_data',
				'username': $("#za_username").val(),
				'website_url': $("#za_website_url").val()
			},
			success: function (response) {
				$(".za-preloader").css("display", "none");
				$("#za_username").val();
				$("#za_website_url").val();

				if(response){
					alert("Your website data is saved");
				}else{
					alert("Some error occured");
				}
			},
			error: function (error) {
				console.log(error);
			}
		});
	});
});
