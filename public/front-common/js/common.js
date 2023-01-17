// functions for form validation and submission
$(document).ready(function() {
	$.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

	jQuery.validator.setDefaults({
		debug: false,
		onsubmit: true,
		onfocusout: false,
		onkeyup: false,
		onclick: false,
		errorElement: "div",
		errorPlacement: function(error, element) {
			if (element.attr("class").indexOf("custom-control") != -1) {
	            error.insertAfter(element.parent());
			} else {
	            error.insertAfter(element);
	        }
		},
		invalidHandler: invalidHandler,
		highlight: highlightElement,
		unhighlight: unhighlightElement,
		submitHandler: submitHandler
	});


	$.validator.prototype.checkForm = function() {
		$(".form-group.has-error .error").remove();
		$(".form-group").removeClass('has-error');
	    //overriden in a specific page
	    this.prepareForm();
	    for (var i = 0, elements = (this.currentElements = this.elements()); elements[i]; i++) {
	        if (this.findByName(elements[i].name).length !== undefined && this.findByName(elements[i].name).length > 1) {
	            for (var cnt = 0; cnt < this.findByName(elements[i].name).length; cnt++) {
	                this.check(this.findByName(elements[i].name)[cnt]);
	            }
	        } else {
	            this.check(elements[i]);
	        }
	    }
	    return this.valid();
	};

	// if($('input[type="checkbox"], input[type="radio"]').not('.ignore-cls').length > 0) {
	// 	$('input[type="checkbox"], input[type="radio"]').not('.ignore-cls').iCheck({
	// 		checkboxClass: 'icheckbox_square-red',
	// 		radioClass: 'iradio_square-red'
	// 	});
	// }


	// if($('.colorpicker-element').length > 0) {
	// 	$('.colorpicker-element').colorpicker();
	// }

	bindPopupClick($('.bindPopup'));

	$('#ajax-popup').on('shown.bs.modal', function () {
		if(typeof popupLoaded == 'function') {
			popupLoaded();
		}
	});

	$('#ajax-popup').on('hidden.bs.modal', function (e) {
		$('#ajax-popup').html('');
	});

	$('#ajax-popup').on('hide.bs.modal', function (e) {
		if(typeof popupLoaded == 'function') {
			delete window.popupLoaded;
		}
	});

	$('[data-toggle="tooltip"]').each(function(){
		if($(this).hasClass('fixtitle')) {
			$(this).tooltip('fixTitle').tooltip('show');
		}
		else {
			$(this).tooltip({container: 'body'});
		}
	});

	jQuery.validator.addMethod('checkSlug', function(value, element) {
		return !(/[^A-Za-z0-9\-]/.test( value ));
	}, 'Only alphanumeric characters and hyphen(-) allowed for slug.');

	$(document).on("focusout", "input" ,function (event) {
		$(this).val($.trim($(this).val()));
	});


	$(document).on("click", "[data-id=clickable]", function(e) {
        var clickedObj = e.target;

        if($(clickedObj).is('a') || $(clickedObj).hasClass('custom-switch-btn') || $(clickedObj).hasClass('custom-switch-input')) {
            return true;
        }
        e.preventDefault();
        var href = $(this).find('.clickable').attr('href');
        window.location.href = href;
    });

    $(".logout-btn").click(function(event) {
		showLoader();
	    $.ajax({
	        url: baseurl()+'/logout',
	        type : "GET",
	        dataType : 'json',
	        success : function(responseText) {
	            if(responseText.type == "success") {
	                 window.location.href = baseurl() + '/';
	            }
	            else if(responseText.type == "error"){
	                // showError(responseText.caption, responseText.errormessage);
	                window.location.href = baseurl() + '/';
	            }
	        },
	        error: formResponseError
	    });
	});

	// GLOBAL SEARCH BUTTON CLICK
	$("#globalsearchbtn").click(function(event) {
		SetSearchData();
	});

	// // SEARCH TEXTBOX ENTER KEY PRESS
	// $(document).on("keypress", "#globalsearchtext", function(e) {
	// 	if (e.which == 13) {
	// 		SetSearchData();
	// 	}
	// });

	//setup before functions
    var typingTimer;
    var doneTypingInterval = 500;

	//on typing on product name
    $("#globalsearchtext").on("keyup input",function (event) {
        var keyCode = event.keyCode == 0 ? event.charCode : event.keyCode;
        if((keyCode >= 41 && keyCode <= 44) ||(keyCode >= 46 && keyCode <= 126) || keyCode == 8 || (keyCode >= 186 && keyCode <= 222)){
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        }
    });

    $( "#globalsearchtext" ).focus(function() {
		if($("#globalsearchtext").val() != ""){
			clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
		}
	});


});

function doneTyping(){
    globalsearchtext = $("#globalsearchtext").val().trim();
    if(globalsearchtext != '') {
        $.ajax({
            url: baseurl() + '/search-real-time',
            data: {'searchtext': globalsearchtext},
            type : 'POST',
            dataType : 'json',
            success : formResponseSearch,
            error: formResponseError
        });
    }else{
    	$(".searchlist-wrapper").css({"display": "none"});
    	$(".searchlist-wrapper-ul").html('');
    }
}

function formResponseSearch(responseText, statusText) {
     hideLoader();
     if(statusText == 'success') {
        hideExistingLog();
        if(responseText.type == 'success') {
            var html = '';
            var imagepath = '';

            if(responseText.products.length > 0){
                $.each(responseText.products, function(i, list) {

                	if(list.productcategorybycode != null){
                    	var imagepath = list.productcategorybycode.imagefilepath;
	                    html += '<li>'+
									'<a href="'+baseurl()+'/search?q='+responseText['searchtext']+'&c='+list.productcategorybycode.slug+'">'+
										'<div class="searchlist-box">'+
											'<div class="list-img">'+
												'<img src="'+imagepath+'">'+
											'</div>'+
											'<div class="list-content">'+
												'<h5>'+list.name+'</h5>'+
												'<p> In '+list.productcategorybycode.name+'</p>'+
											'</div>'+
										'</div>'+
									'</a>'+
								'</li>';
					}
					else {
						var imagepath = list.firstimage;
	                    html += '<li>'+
									'<a href="'+baseurl()+'/products/'+list.slug+'">'+
										'<div class="searchlist-box">'+
											'<div class="list-img">'+
												'<img src="'+imagepath+'">'+
											'</div>'+
											'<div class="list-content">'+
												'<h5>'+list.name+'</h5>'+
											'</div>'+
										'</div>'+
									'</a>'+
								'</li>';
					}
				});

            }else{
                html += getTranslation('Sorry, no results found!');
            }
            $(".searchlist-wrapper-ul").html(html);
            $(".searchlist-wrapper").css({"display": "block"});

        }
        else {
            showError(responseText.message);
        }
    }
    else {
        showError("Unable to communicate with server.");
    }
}

function SetSearchData(){
	showLoader();
	var searchtext = $("#globalsearchtext").val();
	window.location = baseurl() + "/search?q="+searchtext;
}

function bindPopupClick(popupobj) {
	$(popupobj).click(function(e) {
		e.preventDefault();
		showLoader();
		$.ajax({
			type: 'GET',
			url: $(this).attr('href'),
			cache: false,
			dataType: 'html',
			success: function(data, textStatus) {
				hideLoader();
				$('#ajax-popup').html(data);
				$('#ajax-popup').modal('show');
				// bind checkbox style within popup
				if($('#ajax-popup input[type="checkbox"], #ajax-popup input[type="radio"]').length > 0 && typeof iCheck == 'function') {
					$('#ajax-popup input[type="checkbox"], #ajax-popup input[type="radio"]').iCheck({
						checkboxClass: 'icheckbox_square-red',
						radioClass: 'iradio_square-red'
					});
				}
			},
			error: formResponseError
		});
	});
}

function invalidHandler(event, validator) {
	if(validator.errorList.length == 0) return;
	// showError('One or more invalid inputs found.', validator.errorList);
}

function hideExistingLog() {
	// $('.notify-alert').remove();
	$('.ui-pnotify').remove();
}
function hideExistingConfirm() {
	$('.notify-alert').remove();
}

function highlightElement(element) {
	$(element).closest('.form-group').addClass('has-error');
}

function unhighlightElement(element) {
	$(element).closest('.form-group').removeClass('has-error');
}

function highlightInvalidFields(form, fieldnames) {
	$(form).find('input, select, textarea').each(function() {
		var fieldname = $(this).attr('name');
		var index = $.inArray(fieldname, fieldnames);
		if(index == -1) {
			unhighlightElement($(this));
		}
		else {
			highlightElement($(this));
		}
	});
}

function submitHandler(form) {
	disableFormButton(form);
	showLoader();

	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponse,
        error: formResponseError
    });
}

function formResponseError (XMLHttpRequest, textStatus, errorThrown) {
	hideLoader();
	// showError('Server error. Please try again.');
	enableFormButton($('form'));
	console.log('ERROR: ' + XMLHttpRequest.statusText);
	console.log('ERROR: ' + XMLHttpRequest.errorThrown);
}

function disableFormButton(form) {
	$(form).find('input[type="submit"]').attr('disabled', 'disabled');
	$(form).find('button[type="submit"]').attr('disabled', 'disabled');
}

function enableFormButton(form) {
	$(form).find('input[type="submit"]').removeAttr('disabled');
	$(form).find('button[type="submit"]').removeAttr('disabled');
}


function showSuccess(caption, successList, callback) {
	hideExistingLog();
	var successListMsgs = '';

	if(successList && successList.length > 0){
		successListMsgs += '<ul class="ui-pnotify-ul">';
		for(var i = 0; i < successList.length; i++) {
		    successListMsgs += '<li class="ui-pnotify-li">'+successList[i]+'</li>';
	    }
		successListMsgs += '</ul>';
	}
	var notice = PNotify.success({
		styling: 'material',
		icons: 'material',
		delay: 3000,
		textTrusted: true,
	  	title: caption,
	  	text: successListMsgs,
	  	addClass: "pnotify-custom success",
	  	modules: {
		    Buttons: {
		    	closerHover: false,
		      	sticker: false
		    }
	  	},
	  	stack: { "dir1": "down", "dir2": "right", "firstpos1": 20, "firstpos2": ($(window).width() / 2) - 250 }
	});
	notice.on('click', function() {
		notice.close();
	});

	if(callback && typeof callback == 'function') {
		setTimeout(function() {
			callback();
		}, 3000);
	}
}

function showError(caption, errorList) {

	hideExistingLog();

	var errorListMsgs = '';

	if(errorList && jQuery.type(errorList) == 'array' && errorList.length > 0) {
		errorListMsgs += '<ul class="ui-pnotify-ul">';
		for(var i = 0; i < errorList.length; i++) {
		    errorListMsgs += '<li class="ui-pnotify-li">'+errorList[i]+'</li>';
	    }
		errorListMsgs += '</ul>';
	}
	else if(errorList && jQuery.type(errorList) == 'string') {
		errorListMsgs += '<ul class="ui-pnotify-ul"><li class="ui-pnotify-li">'+errorList+'</li></ul>';
	}

	var notice = PNotify.error({
		styling: 'material',
		icons: 'material',
		delay: 3000,
		textTrusted: true,
	  	title: caption,
	  	text: errorListMsgs,
	  	addClass: "pnotify-custom error",
	  	modules: {
		    Buttons: {
		    	closerHover: false,
		      	sticker: false
		    }
	  	},
	  	stack: { "dir1": "down", "dir2": "right", "firstpos1": 20, "firstpos2": ($(window).width() / 2) - 250 }
	});
	notice.on('click', function() {
		notice.close();
	});
}

function showWarning(caption, errorList) {

	hideExistingLog();

	var errorListMsgs = '';

	if(errorList && jQuery.type(errorList) == 'array' && errorList.length > 0) {
		errorListMsgs += '<ul class="ui-pnotify-ul">';
		for(var i = 0; i < errorList.length; i++) {
		    errorListMsgs += '<li class="ui-pnotify-li">'+errorList[i]+'</li>';
	    }
		errorListMsgs += '</ul>';
	}
	else if(errorList && jQuery.type(errorList) == 'string') {
		errorListMsgs += '<ul class="ui-pnotify-ul"><li class="ui-pnotify-li">'+errorList+'</li></ul>';
	}

	var notice = PNotify.info({
		styling: 'material',
		icons: 'material',
		delay: 3000,
		textTrusted: true,
	  	title: caption,
	  	text: errorListMsgs,
	  	addClass: "pnotify-custom warning",
	  	modules: {
		    Buttons: {
		    	closerHover: false,
		      	sticker: false
		    }
	  	},
	  	stack: { "dir1": "down", "dir2": "right", "firstpos1": 20, "firstpos2": ($(window).width() / 2) - 250 }
	});
	notice.on('click', function() {
		notice.close();
	});
}

function showInfo(caption, errorList) {

	hideExistingLog();

	var errorListMsgs = '';

	if(errorList && jQuery.type(errorList) == 'array' && errorList.length > 0) {
		errorListMsgs += '<ul class="ui-pnotify-ul">';
		for(var i = 0; i < errorList.length; i++) {
		    errorListMsgs += '<li class="ui-pnotify-li">'+errorList[i]+'</li>';
	    }
		errorListMsgs += '</ul>';
	}
	else if(errorList && jQuery.type(errorList) == 'string') {
		errorListMsgs += '<ul class="ui-pnotify-ul"><li class="ui-pnotify-li">'+errorList+'</li></ul>';
	}

	var notice = PNotify.info({
		styling: 'material',
		icons: 'material',
		delay: 3000,
		textTrusted: true,
	  	title: caption,
	  	text: errorListMsgs,
	  	addClass: "pnotify-custom info",
	  	modules: {
		    Buttons: {
		    	closerHover: false,
		      	sticker: false
		    }
	  	},
	  	stack: { "dir1": "down", "dir2": "right", "firstpos1": 20, "firstpos2": ($(window).width() / 2) - 250 }
	});
	notice.on('click', function() {
		notice.close();
	});
}


function confirmDialoue(caption, text, callback) {
	var notice = PNotify.notice({
		styling: 'material',
		icons: 'material',
	  	title: caption,
		text: text,
		hide: false,
		addClass: 'confirm-pnotify',
		stack: {
		    'dir1': 'down',
		    'modal': true,
		    'firstpos1': 25
		},
		modules: {
		    Confirm: {
		      	confirm: true
		    },
		    Buttons: {
		      	closer: false,
		      	sticker: false
		    },
		    History: {
		      	history: false
		    },
		 }
	});
	notice.on('pnotify.confirm', function() {
	  	callback(true);
	});
	notice.on('pnotify.cancel', function() {
	  	callback(false);
	});
}

function resetForm(form) {
	$(form).get(0).reset();
}

function refreshPage() {
	window.location.href = '';
}

function hidePopup(delay) {
	if(delay && typeof delay == 'number') {
		setTimeout(function(){
			$('#ajax-popup').modal('hide');
		}, delay);
	}
	else {
		$('#ajax-popup').modal('hide');
	}
}

function showLoader(loadingtext) {
	if(loadingtext === undefined) {
		loadingtext = 'Loading...';
	}
	$('#loader .loader-text').html(loadingtext);
	$('#loader').stop().show();
}

function hideLoader() {
	$('#loader').stop().hide();
}

function showModal() {

}

function hideModal() {

}

function scrollwindowTop() {
	$(document).scrollTop(0);
}

function scrollwindowToElement(element) {
	if($(element).length > 0) {
		if(element.offset().top-60 < $(document).scrollTop() && $(element).closest('#ajax-popup').length == 0) {
			$('html, body').animate({'scrollTop':element.offset().top-60}, 400);
		}
	}
}

function ajaxUpdate(Url, data, callBack, noLoader) {
	if(!noLoader) {
		showLoader();
	}
	$.ajax({
		type: 'POST',
		url: Url,
		cache: false,
		data: data,
		dataType: 'json',
		success: callBack,
		error: formResponseError
	});
}

function ajaxFetch(Url, data, callBack, noLoader){
	//showLoader();
	if(!noLoader) {
		showLoader();
	}
	$.ajax({
		type:'POST',
		url:Url,
		data:data,
		dataType:'html',
		success:callBack,
		error: formResponseError
	});
}

function baseurl() {
	return $.trim($('meta[name="base-url"]').attr('content'));
}

function dd($val) {
	console.log($val);
}

function getTranslation(message, key = null, value = null) {
	var msg = translate[message];

	if($.trim(msg) != "") {
		console.log(msg);

	}
	// if(key.length > 0){

	// 	for ( var i = 0, l = key.length; i < l; i++ ) {
	// 	    sum += arr[ i ];
	// 	}

	// 	text.replace("lollypops", "marshmellows");
	// }
	return msg;
}

function replaceText(message, key, value) {

}

function getTranslation(message, keys = "", values = "") {
	var msg = translate[message];
	keyarr = keys.split(",");
	valuearr = values.split(",");
	if( translate.hasOwnProperty(message) ){
		if(keys != ""){
			$.each(keyarr, function( key, value ) {
				msg = msg.replace(value, valuearr[key]);
			});
			// dd("1 -> "+msg);
			return msg;
		}
		else {
			// dd("2 -> "+msg);
			return msg;
		}
	}
	else {
		msg = message;
		if(keys != ""){
			$.each(keyarr, function( key, value ) {
				msg = msg.replace(value, valuearr[key]);
			});
			// dd("3 -> "+msg);
			return msg;
		}
		else {
			// dd("4 -> "+msg);
			return msg;
		}
	}
}

function formatPrice(price) {
	if($.trim(price) == '' || parseFloat(price) == 0) {
		var amount = 0;
		amount = amount.toFixed(2);
	}
	else {
		price = parseFloat(price);
		var amount = price.toFixed(2);
	}
	return amount;
}