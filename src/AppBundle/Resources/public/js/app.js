$( document ).ready(function() {
    $('#btn-selfie').click(function(){
        jQuery.ajax({
            url: "http://127.0.0.1:8000/selfie",
            context: document.body
        }).done(function(data) {
            console.log(data);
        })
    })
});