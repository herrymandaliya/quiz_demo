var searchVal = '';
var page = 1;

$(document).ready(function() {
	loadData(page, searchVal);
	$('#searchform').validate();
});

function submitHandler(form) {
	disableFormButton(form);
	showLoader();
	searchVal = $('#searchtextbox').val();
	loadData(page, searchVal);
}

function loadData(page, search) {
    showLoader();
    ajaxFetch(baseurl() + '/project-media/load', { page: page, search: search }, formResponse);
}

function formResponse(responseText, statusText) {
	var form = $('#searchform');
	enableFormButton(form);

	hideLoader();
	$('#searchtextbox').val(searchVal);

	if(statusText == 'success') {
		$('#tabledata').html(responseText);
		if($('#ajaxpagingdata').length > 0 && $.trim($('#ajaxpagingdata > td').html()) != '') {

			$('#pagingdata').html($('#ajaxpagingdata > td').html()).show();
			$('#ajaxpagingdata').remove();

			$('#pagingdata a[href]').click(function(event) {
				event.preventDefault();
				var arr = $(this).attr('href').split('page=');
				page = parseInt(arr[arr.length-1]);
				if(isNaN(page)) { page = 1; }
				loadData(page, searchVal);
			});
		}
		else {
			$('#ajaxpagingdata').remove();
			$('#pagingdata').html('').hide();
		}
		$(document).tooltip({selector: '[data-toggle="tooltip"]'});
	}
	else {
		showError('Unable to communicate with server.');
	}
}


