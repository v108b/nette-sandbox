$(function() {
    $('.slim-scroll').slimScroll({});

    $('.date-picker').datepicker({
        autoclose: true,
        format: 'dd.mm.yyyy',
        language: 'cs',
    });

    $('.date-picker-input').datepicker({
        autoclose: true,
        format: 'dd.mm.yyyy',
        language: 'cs',
    });

    $('textarea:not(.noresize)').autosize({
        append: false
    });

});