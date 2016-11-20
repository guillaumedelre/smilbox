var openPhotoSwipe = function (items) {
    var pswpElement = document.querySelectorAll('.pswp')[0];

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

$(document).ready(function () {

    $('a.selfie').click(function () {
        var filter = $(this).data('filter');

        jQuery.ajax({
            url: "http://127.0.0.1:8000/selfie/capture/" + filter,
            context: document.body
        }).done(function (data) {
            if (false == data.error) {
                openPhotoSwipe(data.items);
            }
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