$(document).ready(function(){
    $.validator.addMethod('date', function(value, element, param) {
        return (value != 0) && (value <= 31) && (value == parseInt(value, 10));
    }, 'Please enter a valid date!');
    $.validator.addMethod('month', function(value, element, param) {
        return (value != 0) && (value <= 12) && (value == parseInt(value, 10));
    }, 'Please enter a valid month!');
    $.validator.addMethod('year', function(value, element, param) {
        return (value != 0) && (value >= 1900) && (value == parseInt(value, 10));
    }, 'Please enter a valid year not less than 1900!');
    $.validator.addMethod('username', function(value, element, param) {
        var nameRegex = /^[a-zA-Z0-9]+$/;
        return value.match(nameRegex);
    }, 'Only a-z, A-Z, 0-9 characters are allowed');

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
			firstname: {
				required: true
			},
			lastname: {
				required: true
			},
			phoneno: {
				required: true
			},
			email: {
				required: true,
				email: true
			},
			password: {
				required: true,
			},
			password_confirmation: {
				required: true,
				equalTo : "#password"
			},
		},
		messages: {
			firstname: {
				required: 'Please enter first name.'
			},
			lastname: {
				required: 'Please enter last name.'
			},
			phoneno: {
				required: 'Please enter phone number.'
			},
			email: {
				required: 'Please enter email address.',
				email: 'Please enter a valid email address.'
			},
			password: {
                required: 'Please enter your password.'
            },
            password_confirmation: {
                required: 'Please enter your confirm password.'
			},
		},
		submitHandler: submitHandlerRegister
	});
    $("#myForm").multiStepForm(
    {
        // defaultStep:0,
        // beforeSubmit : function(form, submit){
        //     console.log("called before submiting the form");
        //     console.log(form);
        //     console.log(submit);
        // },
        // validations:val,
        callback : function(){
            alert('here');
          }

    }
    ).navigateTo(0);
});

$('.next').click(function(e){
    e.preventDefault();
    $('#formregistration').validate();

})
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
		showError('Unable to communicate with server.');
	}
}

//GET PRODUCT ID
$('.price-box').click(function(){
    var value = $(this).data("planid");
    $('.product-key').val(value);
});


