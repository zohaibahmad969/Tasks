( function ( $ ) {
	$( document ).ready( function () {
		$( 'body' ).on( 'submit.edit-post', '#post', function () {
			// If a checkbox isn't selected
			if ( $( "#title" ).val().replace( / /g, '' ).length > 0 ) {
			if ($("#taxonomy-tax_ride_type input[type=checkbox]:checked").length === 0 || $("#taxonomy-tax_ride_height input[type=checkbox]:checked").length === 0) {
      			window.alert('Please assign both a Ride Type and Ride Height category.');
				$( '#major-publishing-actions .spinner' ).hide();
				$( '#major-publishing-actions' ).find( ':button, :submit, a.submitdelete, #post-preview' ).removeClass( 'disabled' );
      			return false;
  			}
			else {
				$( '#major-publishing-actions .spinner' ).show();	
			}
			}
		});
	});
}( jQuery ) );
