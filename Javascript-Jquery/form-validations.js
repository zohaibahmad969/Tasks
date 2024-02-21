jQuery(document).ready(function($) {


	// Validations

  // Textarea maxlength
	$("textarea.maxlength-textarea").on("input", function() {
		var maxLength = parseInt($(this).attr('maxlength'));
		var currentLength = $(this).val().length;
		var remainingLength = maxLength - currentLength;
		
		if (remainingLength >= 0) {
			$(".textarea-char-limit .charCount").text(currentLength);
		} else {
			// If the user exceeds the character limit, truncate the input
			var trimmedText = $(this).val().substr(0, maxLength);
			$(this).val(trimmedText);
		}
	});

  // Email field and skipping html code
	$(document).on('input', '.email-field-only', function() {
		var inputValue = $(this).val();
		// Regular expression for email validation
		var emailRegex = /^[a-zA-Z0-9._+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
		// Regular expression to check for special characters other than "@"
		var specialCharRegex = /[^\w.+@-]/g;
		if (!emailRegex.test(inputValue) || specialCharRegex.test(inputValue)) {
			// Input does not match email pattern or contains invalid characters, remove them
			$(this).val(inputValue.replace(/[^\w.+@-]/g, ''));
		}
	});


  // Text field and skipping html code
	$(document).on('input', '.text-field-only', function() {
		var inputValue = $(this).val();
		// Regular expression to allow only letters and spaces
		var textRegex = /^[a-zA-Z\s]*$/;
		if (!textRegex.test(inputValue)) {
			// Input contains invalid characters, remove them
			$(this).val(inputValue.replace(/[^a-zA-Z\s]/g, ''));
		}
	});

 // Phone field and skipping html code
	$(document).on('input', '.phone-field-only', function() {
		var inputValue = $(this).val();
		// Regular expression to allow only numbers and limit to 15 digits
		var regex = /^\d{0,15}$/;
		if (!regex.test(inputValue)) {
			// Input contains invalid characters or exceeds 15 digits, remove them
			$(this).val(inputValue.replace(/\D/g, '').substring(0, 15));
		}
	});


// OTP digit field and skipping html code
	$(document).on('input', '.textNumber-field-only', function(e) {
		var inputValue = $(this).val();
		var keyCode = e.which || e.keyCode;
		
		// Check if the entered character is alphanumeric
		if (/^[a-zA-Z0-9]$/.test(inputValue)) {
			// Move focus to the next input field with class ".textNumber-field-only"
			$(this).next('.textNumber-field-only').focus();
		} else if (keyCode === 8) { // Backspace key
			// Move focus to the previous input field with class ".textNumber-field-only"
			$(this).prev('.textNumber-field-only').focus();
		} else {
			// Remove any invalid characters entered
			$(this).val('');
		}
	});


  // Textarea for text, numbers and skipping html code
	$(document).on('input', '.textNumberString-field-only', function() {
		var inputValue = $(this).val();
		// Regular expression to allow only letters, digits, and spaces
		var textNumberRegex = /^[a-zA-Z0-9\s]*$/;
		if (!textNumberRegex.test(inputValue)) {
			// Input contains invalid characters, remove them
			$(this).val(inputValue.replace(/[^a-zA-Z0-9\s]/g, ''));
		}
	});


});
