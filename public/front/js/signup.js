

$(document).ready(function() {


    jQuery.validator.setDefaults({
		debug: false,
		onsubmit: true,
		onfocusout: false,
		onkeyup: false,
		onclick: false,
		errorElement: "span",
		errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        }
	});

	$('#formregistration').validate({
		rules: {
			name: {
				required: true
			},
			phone_no: {
				required: true
			},
			email: {
				required: true,
				email: true
			},
			password: {
				required: true,
				minlength: 8
			},
			password_confirmation: {
				required: true,
				minlength: 8,
				equalTo : "#password"
			},
		},
		messages: {
			name: {
				required: getTranslation('Please enter name.')
			},
			phone_no: {
				required: getTranslation('Please enter phone number.')
			},
			email: {
				required: getTranslation('Please enter email address.'),
				email: getTranslation('Please enter a valid email address.')
			},
			password: {
                required: getTranslation('Please enter your password.'),
                minlength: getTranslation('Please enter password at least #length# characters long.' )
            },
            password_confirmation: {
                required: getTranslation('Please enter your confirm password.'),
                minlength: getTranslation('Please enter password at least #length# characters long.' ),
				equalTo : getTranslation("Password and the confirm password doesn't match.")
			},
		},
		submitHandler: submitHandlerRegister
	});

});

function submitHandlerRegister(form) {
	// disableFormButton(form);
	// showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseRegister,
        error: formResponseError
    });
}

function formResponseRegister(responseText, statusText){
	var form = $('#formregistration');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			showSuccess(responseText.caption, null, function() {
				resetForm('#formregistration');
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
