$(function () {

    $('#start_date_time_picker').datetimepicker({
        // display date only, no time. remove below line will show time picker
        format: 'MMM DD, YYYY'
    });
    $('#end_date_time_picker').datetimepicker({
        // display date only, no time. remove below line will show time picker
        format: 'MMM DD, YYYY',
        useCurrent: false //Important! See issue #1075
    });
    $("#start_date_time_picker").on("dp.change", function (e) {
        $('#end_date_time_picker').data("DateTimePicker").minDate(e.date);
    });
    $("#end_date_time_picker").on("dp.change", function (e) {
        $('#start_date_time_picker').data("DateTimePicker").maxDate(e.date);
    });
});