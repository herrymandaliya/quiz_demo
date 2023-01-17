

$(document).ready(function() {

  //   jQuery.validator.setDefaults({
	// 	debug: false,
	// 	onsubmit: true,
	// 	onfocusout: false,
	// 	onkeyup: false,
	// 	onclick: false,
	// 	errorElement: "span",
	// 	errorPlacement: function (error, element) {
  //           error.addClass('invalid-feedback');
  //           element.closest('.form-group').append(error);
  //       }
	// });

	$('#formotpverify').validate({
		rules: {
			otpverify: {
				required: true
			},
		},
		messages: {
			otpvotpverifyerify: {
				required: 'Please enter Otp.'
			},
		},
		submitHandler: submitHandlerOtpVerify
	});

});

function submitHandlerOtpVerify(form) {
	// disableFormButton(form);
	// showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseOtpVerify,
        error: formResponseError
    });
}

function formResponseOtpVerify(responseText, statusText){
	var form = $('#formotpverify');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			showSuccess(responseText.caption, null, function() {
				resetForm('#formotpverify');
				window.location.href = responseText.redirectUrl;
			});
		}
		else {
			showError(responseText.caption);
			if(responseText.errorfields !== undefined) {
				highlightInvalidFields(form, responseText.errorfields);
			}
		}
	}
	else {
		showError(getTranslation('Unable to communicate with server.'));
	}
}
