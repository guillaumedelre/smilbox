$(document).ready(function () {
    $('#btn-selfie-capture').click(function () {
        jQuery.ajax({
            url: "http://127.0.0.1:8000/selfie/capture",
            context: document.body
        }).done(function (data) {
            console.log(data);
        })
    });

    $('#btn-selfie-warhol').click(function () {
        jQuery.ajax({
            url: "http://127.0.0.1:8000/selfie/capture/warhol",
            context: document.body
        }).done(function (data) {
            console.log(data);
        })
    });

    $('#btn-timelaps-capture').click(function () {
        jQuery.ajax({
            url: "http://127.0.0.1:8000/timelaps/capture",
            context: document.body
        }).done(function (data) {
            console.log(data);
        })
    });

    $('input[type=range]').change(function () {
        $.each($('.range-current-value'), function (i, $el) {
            var optionId = $($('.range-current-value')[i]).attr('data-range');
            var optionValue = $('#' + optionId).val();
            var refreshZone = $($('.range-current-value')[i]);
            refreshZone.html(optionValue);
        });
    });

    $('#btn-submit').click(function () {
        $('form')[0].submit();
    });

    $('#btn-reset').click(function () {
        $('form')[0].reset();
        $('input[type=range]').trigger('change');
    });
});