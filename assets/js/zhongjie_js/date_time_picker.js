$(function () {

    $('#startDateTimePicker').datetimepicker({
        // display date only, no time. remove below line will show time picker
        format: 'MMM DD, YYYY'
    });
    $('#endDateTimePicker').datetimepicker({
        // display date only, no time. remove below line will show time picker
        format: 'MMM DD, YYYY',
        useCurrent: false //Important! See issue #1075
    });

    // $("#startDateTimePicker").on("dp.change", function (e) {
    //     $('#endDateTimePicker').data("DateTimePicker").minDate(e.date);
    // });

    $("#endDateTimePicker").on("dp.change", function (e) {
        $('#startDateTimePicker').data("DateTimePicker").maxDate(e.date);
    });
});