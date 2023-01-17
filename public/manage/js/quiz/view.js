var fileindex = 0;
var totfileCount = 0;
var messageid = 0;
var sendingFile = false;
var totalLastMessageLen = 0;
$(document).ready(function() {

	$('#formprojectmessage').validate({
		rules: {
			message: {
				required: true
			}
		},
		messages: {
			message: {
				required: 'Please enter message.'
			}
		},
		submitHandler: submitHandlerprojectmessage
	});


	$('.send-msg-btn').click(function(e){
		e.preventDefault();

		if($('#messageFiles').get(0).files.length > 0) {
			// uploadfiles($('#messageFiles').get(0).files);
			sendMessage();
		}
		else {
			$('#formprojectmessage').submit();
		}
	});


	var project_id = $("#formprojectmessage #project_id").val();
	if(project_id != "" && project_id != "undefined") {

		loadMessages(project_id);
	}

	setInterval(function(){
		if(!sendingFile){
		  	if(project_id != "" && project_id != "undefined") {
				loadMessages(project_id);
			}
		}
	}, 5000);

	setTimeout(function(){
		$(".chat-wrap-inner").animate({
				  scrollTop: $('.chat-wrap-inner')[0].scrollHeight - $('.chat-wrap-inner')[0].clientHeight
				}, 50);
	},2000);

});

function getMyMessages() {
	if(!sendingFile){
	  	if(project_id != "" && project_id != "undefined") {
			loadMessages(project_id);
		}
	}
}

function sendMessage() {
	sendingFile = true;
	var data = { 
		project_id: $('#project_id').val(),
		message: $('#message').val(),
		media: true,
	};
	ajaxUpdate(baseurl() + '/projects/sendmessage', data, function(responseText, statusText) {

		if(statusText == 'success') {
			if(responseText.type == 'success') {
				messageid = responseText.projectmessage_id;
				getMessage();
		    }
		    else {
		        showError(responseText.caption);
		    }
		}
		else {
			showError('Unable to communicate with server.');
		}
	}, true);
}

/* load document messages */
function getMessage(){
	// showLoader();
	ajaxFetch(baseurl() + '/projects/getmessage', { projectmessage_id:messageid }, function(responseText, statusText) {
		// hideLoader();
		if(statusText == 'success') {
			$('#loadmessages').append(responseText);
			setFile();
		}
		else {
			showError('Unable to communicate with server.');
		}

	},true);
}

function sendFile() {


	if($('#messageFiles').get(0).files.length > fileindex) {
		uploadfiles($('#messageFiles').get(0).files);
	}
	else {
		$('#messageFiles').val('');
		sendingFile = false;
		$('input[name="message"]').val('');
	}
}

function setFile() {
	var html = '';
	$.each($('#messageFiles').get(0).files, function(index, file) {
		html += '<div class="file-box file-box'+index+'">'+
                    '<span class="file-name text-ellipsis">'+file.name+'</span>'+
                    '<div class="d-flex justify-content-between">'+
                        '<div class="file-size">Size: '+formatBytes(file.size)+'</div>'+
                        '<div class="file-download">'+
                            '<a href="#" class="fa fa-download"></a></div>'+
                    '</div>'+
                    '<div class="file-progress d-block"></div>'+
                    '<div class="file-progress-status d-block"><span>0%</span></div>'+
                '</div>'
	});

	$('#chat'+messageid+' .upload-wrapper').html(html);
	$(".chat-wrap-inner").animate({
				  scrollTop: $('.chat-wrap-inner')[0].scrollHeight - $('.chat-wrap-inner')[0].clientHeight
				}, 50);
	sendFile();
	
}

function formatBytes(bytes, decimals = 2) {
    if (bytes === 0) return '0 Bytes';

    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

    const i = Math.floor(Math.log(bytes) / Math.log(k));

    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

function uploadfiles(files_list) {
	
	var file = files_list[fileindex];
	
	var formData = new FormData();
    formData.append('file', file);
    formData.append('projectmessage_id', messageid);

    $.ajax({
        url:baseurl() + "/projects/send-media-message",
        method:"POST",
        data:formData,
        contentType:false,
        cache: true,
        processData: false,
        xhr: function() {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    var percentComplete = (evt.loaded / evt.total) * 100;
                    //Do something with upload progress here
                    var percentVal = parseInt(percentComplete);
                    // OnProgress(percentVal, index);
                    $('#chat'+messageid+' .file-box'+fileindex+' .file-progress').css("width", percentVal+"%");
                    $('#chat'+messageid+' .file-box'+fileindex+' .file-progress-status span').text(percentVal+"%");

                }
           }, false);
           return xhr;
        },
        beforeSend: function(){
             // beforeSend(index);
        },
        afterSend: function(){
             // beforeSend(index);
        },
        success:function(data){
            if(data.type == 'success') {
            	$('#chat'+messageid+' .file-box'+fileindex+' .file-progress').css("width", "0%");
            	$('#chat'+messageid+' .file-box'+fileindex+' .file-progress').removeClass("d-block");
            	$('#chat'+messageid+' .file-box'+fileindex+' .file-progress-status span').text("0%");
            	$('#chat'+messageid+' .file-box'+fileindex+' .file-progress-status').removeClass("d-block");
            	fileindex++;
            	sendFile();
                // progressComplete(index, data);
            }
            else {
                showError(data.caption, data.errormessage);
            }
            
        },
        error:function(){
            // failedFile[index] = file;
            // setFailedImage(index);
        },
        complete: function() {
            // setQueueAjax(index);
        }
    });
}


/* load document messages */
function loadMessages(project_id){
	// showLoader();
	ajaxFetch(baseurl() + '/projects/getmessages', { project_id:project_id }, function(responseText, statusText) {
		// hideLoader();
		if(statusText == 'success') {
			if($(responseText).length != totalLastMessageLen) {
				$('#loadmessages').html(responseText);
			}
			totalLastMessageLen = $(responseText).length;
		}
		else {
			showError('Unable to communicate with server.');
		}

	},true);
}
function submitHandlerprojectmessage(form) {
	// showLoader();
	$('input[name="message"]').attr('readonly', true);
	disableFormButton(form);
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseprojectmessage,
        error: formResponseError
    });
}


function formResponseprojectmessage(responseText, statusText) {
    var form = $('#formprojectmessage');
    $('input[name="message"]').attr('readonly', false);
    enableFormButton(form);
	if(statusText == 'success') {
		if(responseText.type == 'success') {
			var project_id = $("#formprojectmessage #project_id").val();
			loadMessages(project_id);
			$("#formprojectmessage").trigger('reset');

			setTimeout(function(){
				$(".chat-wrap-inner").animate({
						  scrollTop: $('.chat-wrap-inner')[0].scrollHeight - $('.chat-wrap-inner')[0].clientHeight
						}, 50);
			},2000);
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
/* load document messages */
