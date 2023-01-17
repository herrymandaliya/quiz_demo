

var page = 1;


function loadData(page, search) {
    showLoader();
    ajaxFetch(baseurl() + '/client/load', { page: page, search: search }, formResponse);
}
