$(document).ready(function() {
	$(".languagedropdown li a").click(function(){
	    var slug = $(this).data('slug');
        var language = $(this).data('language');
	    var languageid = $(this).data('languageid');
	    $.ajax({
            url: baseurl()+'/localization',
            data: {'slug': slug, 'language': language, 'languageid': languageid},
            type : "POST",
            dataType : 'json',
            beforeSend : function(data) {
                showLoader();
            },
            success : function(data) {
                location.reload();
            },
            error: formResponseError
        });
	});
});
