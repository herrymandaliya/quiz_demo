var designationData = {};
$(document).ready(function() {
	$('#formdesignation').validate({
		disabled: true,
		rules: {
			name: {
				required: true
			},
		},
		messages: {
			name: {
				required: 'Please enter name.'
			},
		}
	});

});


function formResponse(responseText, statusText) {
    var form = $('#formdesignation');
    hideLoader();
    enableFormButton(form);
	if(statusText == 'success') {
		if(responseText.type == 'success') {
			showSuccess(responseText.caption, null, function() {
				window.location.href = responseText.redirectUrl;
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
		showError('Unable to communicate with server.');
	}
}
