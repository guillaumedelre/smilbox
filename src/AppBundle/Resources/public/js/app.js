$( document ).ready(function() {
    $('#btn-selfie-capture').click(function(){
        jQuery.ajax({
            url: "http://127.0.0.1:8000/selfie/capture",
            context: document.body
        }).done(function(data) {
            console.log(data);
        })
    });
    $('#btn-timelaps-capture').click(function(){
        jQuery.ajax({
            url: "http://127.0.0.1:8000/timelaps/capture",
            context: document.body
        }).done(function(data) {
            console.log(data);
        })
    });

    $('input[type=range]').change(function() {
        $('#range-current-value').html($(this).val());
    });
});