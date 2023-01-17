
$(document).ready(function() {
	$('#formproject').validate({
		disabled: true,
		rules: {
			title: {
				required: true
			},
			start_date: {
				required: true
			},
			end_date: {
				required: true
			},
			client_id: {
				required: true
			},
			priority: {
				required: true
			},
			manager_id: {
				required: true
			},
		},
		messages: {
			title: {
				required: 'Please enter title.'
			},
			start_date: {
				required: 'Please select start date.'
			},
			end_date: {
				required: 'Please select end date.'
			},
			client_id: {
				required: 'Please select client.'
			},
			priority: {
				required: 'Please select priority.'
			},
			manager_id: {
				required: 'Please select project manager.'
			},
		}
	});

	$('.datetimepicker2').datetimepicker({
        format: 'YYYY-MM-DD',
        icons: {
            up: "fa fa-angle-up",
            down: "fa fa-angle-down",
            next: 'fa fa-angle-right',
            previous: 'fa fa-angle-left'
        }
    });

    $('#start_date').datetimepicker({  
         minDate:new Date()
      });

	showHideTeamMember();
	$('#teammembers').on('select2:select', function (e) {
	    var data = e.params.data;
	    var userid = data.id;
	    var image = data.element.dataset.image;
	    var name = data.element.dataset.name;
	    var designation = data.element.dataset.designation;

	    if(userid != ""){
		    var flag = true;
		    $('#member-lists tr input[name="teammemberid[]"]').each(function(index, element){
		    	if(userid == $(this).val()){
		    		flag = false;
		    	}
		    });

		    if(flag){
			    var html = '<tr>'+
		                        '<td>'+
		                            '<h2 class="table-avatar">'+
		                                '<a href="profile.html" class="avatar">'+
		                                    '<img alt="" src="'+image+'">'+
		                                '</a>'+
		                                '<a> '+name+' <span>'+designation+'</span></a>'+
		                                '<input type="hidden" name="teammemberid[]" value="'+userid+'">'+
		                           '</h2>'+
		                        '</td>'+
		                        '<td class="text-center">'+
                                    '<div class="chat-checkbox">'+
                                        '<input type="checkbox" name="haspermission" checked>'+
                                        '<input type="hidden" name="chatpermission[]" value="1">'+
                                    '</div>'+
                                '</td>'+
		                        '<td class="text-right">'+
                                    '<span class="position-relative">'+
                                        '<span class="remove-member remove-icon">'+
                                            '<i class="fa fa-trash text-danger"></i>'+
                                        '</span>'+
                                    '</span>'+
                                '</td>'+
		                    '</tr>';

		        $('#member-lists').append(html);
	        }
	        else {
	        	showError('Team member already added.');
	        }
	        showHideTeamMember();
        }
	});

	$(document).on('click', '.remove-member', function(){
		$(this).parents('tr').remove();
		showHideTeamMember();
	});

	$(document).on('change', 'input[name="haspermission"]', function(){
		if($(this).is(":checked")) {
			$(this).siblings('input[name="chatpermission[]"]').val(1);
		}
		else {
			$(this).siblings('input[name="chatpermission[]"]').val(0);
		}
	});
});

function showHideTeamMember() {
	if($('#member-lists tr').length > 0) {
		$('#team-member-box').removeClass('d-none');
	}
	else {
		$('#team-member-box').addClass('d-none');
	}
}

function formResponse(responseText, statusText) {
    var form = $('#formproject');
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
