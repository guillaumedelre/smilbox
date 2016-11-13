$( document ).ready(function() {
    $('#btn-selfie').click(function(){
        jQuery.ajax({
            url: "http://127.0.0.1:8000/selfie",
            context: document.body
        }).done(function(data) {
            console.log(data);
        })
    })
    $('#btn-timelaps').click(function(){
        jQuery.ajax({
            url: "http://127.0.0.1:8000/timelaps",
            context: document.body
        }).done(function(data) {
            console.log(data);
        })
    })
    $('#btn-help').click(function(){
        jQuery.ajax({
            url: "http://127.0.0.1:8000/help",
            context: document.body
        }).done(function(data) {
            console.log(data);
        })
    })
    $('#btn-settings').click(function(){
        jQuery.ajax({
            url: "http://127.0.0.1:8000/settings",
            context: document.body
        }).done(function(data) {
            console.log(data);
        })
    })
});