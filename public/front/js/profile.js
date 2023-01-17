$(document).ready(function() {
	$('#formprofile').validate({
		ignore: [],
		rules: {
			firstname: {
                required: true
            },
            lastname: {
                required: true
            },
			email: {
                required: true,
                email: true
            },
            phoneno: {
                required: true
            },
            currentpassword: {
				required:function(a,b){
                    if($('#password_confirmation').val() != '' || $('#password').val() != ''){
                        return true;
                    }
                    else{
                        return false;
                    }
                }
			},
			password: {
				required:function(){
					if($('#password_confirmation').val() != '' || $('#currentpassword').val() != ''){
						return true;
					}
					else{
						return false;
					}
				}
			},
			password_confirmation: {
				required:function(a,b){
					if($('#password').val() != '' || $('#currentpassword').val() != ''){
						return true;
					}
					else{
						return false;
					}
				},
				equalTo:'#password'
			}
		},
		messages: {
			firstname: {
                required: getTranslation('Please enter first name.')
            },
            lastname: {
                required: getTranslation('Please enter last name.')
            },
			email: {
                required: getTranslation('Please enter your email.'),
                email: getTranslation('Please enter a valid email address.')
            },
            phoneno: {
                required: getTranslation('Please enter phone number.')
            },
            currentpassword: {
				required: getTranslation('Please enter current password.')
			},
			password: {
				required: getTranslation('Please enter your password.')
			},
			password_confirmation: {
				required: getTranslation('Please enter your confirm password.'),
				equalTo: getTranslation("Password and the confirm password doesn't match.")
			},
		},
		submitHandler: submitHandlerLogin
	});

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
    var form = $('#formprofile');
    hideLoader();
    enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			showSuccess(responseText.caption, null, function() {
				refreshPage();
			});
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
