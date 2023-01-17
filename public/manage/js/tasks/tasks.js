var searchVal = '';
var page = 1;
var indexUpdate;
var tabCounter = 0;
var tablength = $('.category-modal .tab-pane').length;

$(document).ready(function() {
    loadData(page, searchVal);
    $('#searchform').validate();

    if ($('.kanban-wrap').length > 0) {
        $(".kanban-wrap").sortable({
            connectWith: ".kanban-wrap",
            handle: ".kanban-box",
            placeholder: "drag-placeholder",
            change: function( event, ui ) {
                // console.log(ui);
                // console.log($(ui.item[0]).data('project_id'));
                // console.log('change',$(ui.item[0]).parents('.kanban-list').data('status'));
                // console.log($(this));
            },
            stop: function( event, ui ) {
                // console.log('stop');
                // console.log($(ui.item[0]).data('project_id'));
                // console.log('change',$(ui.item[0]).parents('.kanban-list').data('status'));
                // console.log($(this));
                var orderArr = [];
                $(ui.item[0]).parents('.kanban-list').find('.card.panel').each(function(index, ele){
                    orderArr.push($(ele).data('project_id'));
                });
                updateOrder(orderArr);
            } ,
            receive: function( event, ui ) {
                console.log('receive');
                var project_id = $(ui.item[0]).data('project_id');
                var status = $(ui.item[0]).parents('.kanban-list').data('status');
                updateStatus(project_id, status);
            }  
        });
    }   

    $('.category-box').click(function(e){
        $('.category-box').removeClass('selected');
        $('.category-box input').removeAttr('checked');
        $(this).addClass('selected');
        $(this).find('input').attr('checked', true);
    });

    $('#formproject').validate({
        ignore: ".ignore",
        rules: {
            category_id: {
                required: true
            },
            title: {
                required: true
            },
            start_date: {
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
            category_id: {
                required: 'Please select category.'
            },
            title: {
                required: 'Please enter title.'
            },
            start_date: {
                required: 'Please select start date.'
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
        },
        submitHandler: submitHandlerProject
    });

    $('#project-tab input, #project-tab select').addClass('ignore');
    $('#confirm-tab input').addClass('ignore');

    $('.datetimepicker2').datetimepicker({
        format: 'YYYY-MM-DD',
        icons: {
            up: "fa fa-angle-up",
            down: "fa fa-angle-down",
            next: 'fa fa-angle-right',
            previous: 'fa fa-angle-left'
        }
    });

    $('#btnsubmit').click(function(e){
       dd($('#formproject').valid());
        if($('#formproject').valid()) {
            if(tabCounter < tablength) {        
                tabCounter = tabCounter + 1;
            }
            dd(tabCounter);
            dd(tablength-1);
            if(tabCounter <= tablength-1) {
                $('.category-modal .nav-item').eq(tabCounter).trigger('click');
                if(tabCounter > 0){
                    $('#btnback').removeClass('d-none');
                }    
                $( ".tab-pane" ).eq(tabCounter).find('input').removeClass('ignore');
                $( ".tab-pane" ).eq(tabCounter).find('select').removeClass('ignore');
            }
            else {
                $('#formproject').submit();
            }
            
        }
    });

    $('#btnback').click(function(){
        var activeTab = $('.category-modal .tab-pane.active').index();
        if(activeTab >= 0) {
            $( ".tab-pane" ).eq(tabCounter).find('input').addClass('ignore');
            $( ".tab-pane" ).eq(tabCounter).find('select').addClass('ignore');
            tabCounter = tabCounter - 1;      
            $('.category-modal .nav-item').eq(tabCounter).trigger('click');
            if(tabCounter == 0){
                $('#btnback').addClass('d-none');
            }          
        }
        // if(tabCounter)
    });
});

function submitHandlerProject(form) {
    disableFormButton(form);
    showLoader();
    $(form).ajaxSubmit({
        dataType: 'json',
        success: formResponseProject,
        error: formResponseError
    });
}

// function submitForm(form) {
//     disableFormButton(form);
//     showLoader();
//     $(form).ajaxSubmit({
//         dataType: 'json',
//         success: formResponseProject,
//         error: formResponseError
//     });
// }

function formResponseProject(responseText, statusText) {
    var form = $('#formproject');
    hideLoader();
    enableFormButton(form);
    resetForm(form);
    if(statusText == 'success') {
        if(responseText.type == 'success') {
            showSuccess(responseText.caption, responseText.successmessage, function() {
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
        showError('Unable to communicate with server.');
    }
}

function updateOrder(orderArr) {
    ajaxUpdate(baseurl() + '/tasks/order-update', { project_ids: orderArr }, function(responseText, statusText) {
        hideLoader();
        if(statusText == 'success') {
            if(responseText.type == 'success') {
                // showSuccess(responseText.caption, '', function(){
                //     loadData(1, searchVal);
                // });
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

function updateStatus(project_id, status) {
    ajaxUpdate(baseurl() + '/tasks/status-update', { project_id: project_id, status: status }, function(responseText, statusText) {
        hideLoader();
        if(statusText == 'success') {
            if(responseText.type == 'success') {
                // showSuccess(responseText.caption, '', function(){
                //     loadData(1, searchVal);
                // });
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

function submitHandler(form) {
    disableFormButton(form);
    showLoader();
    searchVal = $('#searchtextbox').val();
    loadData(page, searchVal);
}

function loadData(page, search) {
    showLoader();
    ajaxFetch(baseurl() + '/tasks/load', { page: page, search: search }, formResponse);
}

function formResponse(responseText, statusText) {
    var form = $('#searchform');
    enableFormButton(form);

    hideLoader();
    $('#searchtextbox').val(searchVal);

    if(statusText == 'success') {
        responseText = jQuery.parseJSON(responseText);
        $('#project-discussion .kanban-wrap').html(responseText.discussion_projects_html);
        $('#project-todo .kanban-wrap').html(responseText.todo_projects_html);
        $('#project-inprogress .kanban-wrap').html(responseText.progress_projects_html);
        $('#project-qa .kanban-wrap').html(responseText.qa_projects_html);
        $('#project-done .kanban-wrap').html(responseText.done_projects_html);
        $('#project-backlog .kanban-wrap').html(responseText.backlog_projects_html);
        
        $(document).tooltip({selector: '[data-toggle="tooltip"]'});
    }
    else {
        showError('Unable to communicate with server.');
    }
}

function deleteEntity(user_id) {
    showModal();
    confirmDialoue("Delete", 'Are you sure you want to delete this project?', function(e){
        if (e) {
            ajaxUpdate(baseurl() + '/tasks/destroy', { user_id: user_id }, function(responseText, statusText) {
                hideLoader();
                if(statusText == 'success') {
                    if(responseText.type == 'success') {
                        showSuccess(responseText.caption, '', function(){
                            loadData(1, searchVal);
                        });
                    }
                    else {
                        showError(responseText.caption);
                    }
                }
                else {
                    showError('Unable to communicate with server.');
                }
            });
        }
        else {
            hideModal();
        }
    });
}


