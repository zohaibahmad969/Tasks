( function ( $ ) {
	$( document ).ready( function () {
		$( 'body' ).on( 'submit.edit-post', '#post', function () {
			// If the title isn't set
			if ( $( "#title" ).val().replace( / /g, '' ).length === 0 ) {
				// Show the alert
				window.alert( 'The title is required.' );
				// Hide the spinner
				$( '#major-publishing-actions .spinner' ).hide();
				// The buttons get "disabled" added to them on submit. Remove that class.
				$( '#major-publishing-actions' ).find( ':button, :submit, a.submitdelete, #post-preview' ).removeClass( 'disabled' );
				// Focus on the title field.
				$( "#title" ).focus();
				return false;
			}
			else {
				$( '#major-publishing-actions .spinner' ).show();	
			}
		});
	});
}( jQuery ) );
