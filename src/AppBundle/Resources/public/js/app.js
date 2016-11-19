$(document).ready(function () {

    $('#btn-selfie-capture').click(function () {
        jQuery.ajax({
            url: "http://127.0.0.1:8000/selfie/capture/default",
            context: document.body
        }).done(function (data) {
            if (false == data.error) {
                openPhotoSwipe(data.filename, data.w, data.h);
            }
            console.log(data);
        })
    });

    $('#btn-selfie-warhol').click(function () {
        jQuery.ajax({
            url: "http://127.0.0.1:8000/selfie/capture/warhol",
            context: document.body
        }).done(function (data) {
            if (false == data.error) {
                openPhotoSwipe(data.filename, data.w, data.h);
            }
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

    var openPhotoSwipe = function (filename, w, h) {
        var pswpElement = document.querySelectorAll('.pswp')[0];

        // build items array
        var items = [
            {
                src: filename,
                w: w,
                h: h
            }
        ];

        // define options (if needed)
        var options = {
            // history & focus options are disabled on CodePen
            history: false,
            focus: false,

            showAnimationDuration: 0,
            hideAnimationDuration: 0

        };

        var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
        gallery.init();
    };
});