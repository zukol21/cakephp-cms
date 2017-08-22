(function ($) {
    $('.datetimepicker').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        timePicker: true,
        drops: 'down',
        timePicker24Hour: true,
        timePickerIncrement: 5,
        locale: {
            format: 'YYYY-MM-DD HH:mm',
            firstDay: 1
        }
    });
})(jQuery);