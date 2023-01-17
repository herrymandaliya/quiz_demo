$(document).ready(function() {
	$('#formlogin').validate({
		ignore: [],
		rules: {
			login: {
					required: true,
			},
			password: {
				required: true
			},
		},
		messages: {
			login: {
					required: 'Please enter number or email.',
			},
			password: {
				required: 'Please enter your password.'
			},
		},
		submitHandler: submitHandlerLogin
	});

	// $('#formregistration').validate({
	// 	rules: {
	// 		firstname: {
	// 			required: true
	// 		},
	// 		lastname: {
	// 			required: true
	// 		},
	// 		phoneno: {
	// 			required: true
	// 		},
	// 		email: {
	// 			required: true,
	// 			email: true
	// 		},
	// 		password: {
	// 			required: true,
	// 			minlength: minimumallowedpasswordlength
	// 		},
	// 		password_confirmation: {
	// 			required: true,
	// 			minlength: minimumallowedpasswordlength,
	// 			equalTo : "#password"
	// 		},
	// 	},
	// 	messages: {
	// 		firstname: {
	// 			required: getTranslation('Please enter first name.')
	// 		},
	// 		lastname: {
	// 			required: getTranslation('Please enter last name.')
	// 		},
	// 		phoneno: {
	// 			required: getTranslation('Please enter phone number.')
	// 		},
	// 		email: {
	// 			required: getTranslation('Please enter email address.'),
	// 			email: getTranslation('Please enter a valid email address.')
	// 		},
	// 		password: {
  //               required: getTranslation('Please enter your password.'),
  //               minlength: getTranslation('Please enter password at least #length# characters long.', '#length#', minimumallowedpasswordlength.toString() )
  //           },
  //           password_confirmation: {
  //               required: getTranslation('Please enter your confirm password.'),
  //               minlength: getTranslation('Please enter password at least #length# characters long.', '#length#', minimumallowedpasswordlength.toString() ),
	// 			equalTo : getTranslation("Password and the confirm password doesn't match.")
	// 		},
	// 	},
	// 	submitHandler: submitHandlerRegister
	// });

});

function submitHandlerLogin(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseLogin,
        error: formResponseError
    });
}

function formResponseLogin(responseText, statusText) {
    var form = $('#formlogin');
    hideLoader();
    enableFormButton(form);
	if(statusText == 'success') {
		if(responseText.type == 'success') {
			window.location.href = responseText.redirectUrl;
		}
		else {
			showError(responseText.caption, responseText.errormessage);
			if(responseText.errorfields !== undefined) {
				highlightInvalidFields(form, responseText.errorfields);
			}
		}
	}
    else {
		showError(getTranslation('Unable to communicate with server.'));
	}
}

// function submitHandlerRegister(form) {
// 	disableFormButton(form);
// 	showLoader();
// 	$(form).ajaxSubmit({
// 		dataType: 'json',
//         success: formResponseRegister,
//         error: formResponseError
//     });
// }

// function formResponseRegister(responseText, statusText){
// 	var form = $('#formregistration');

// 	hideLoader();
// 	enableFormButton(form);

// 	if(statusText == 'success') {
// 		if(responseText.type == 'success') {
// 			showSuccess(responseText.caption, null, function() {
// 				resetForm('#formregistration');
// 			});
// 		}
// 		else {
// 			showError(responseText.caption);
// 			if(responseText.errorfields !== undefined) {
// 				highlightInvalidFields(form, responseText.errorfields);
// 			}
// 		}
// 	}
// 	else {
// 		showError(getTranslation('Unable to communicate with server.'));
// 	}
// }
