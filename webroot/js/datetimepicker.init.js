(function ($) {
    $('.datetimepicker').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        timePicker: true,
        drops: 'down',
        timePicker12Hour: false,
        timePickerIncrement: 5,
        format: 'YYYY-MM-DD HH:mm'
    });
})(jQuery);