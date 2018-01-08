$(document).ready(function(){
    $.ajax({
        // url: "http://www.mywebserver.com/samba/all/php_course/php_course_project/beontime/html_php/manager_operations/manager_track_emphours_backend.php",
        url: "http://beontime.byethost16.com/beontime/html_php/employee_operations/manager_track_emphours_backend.php",
        method: "GET",

        success: function(data) {



            var player = [];
            var score = [];

            for(var i in data) {
                player.push("Employee Name: " + data[i].FirstName);
                score.push(data[i].time);
            }

            var chartdata = {
                labels: player,
                datasets : [
                    {
                        label: 'Employee Hours',
                        backgroundColor: 'rgba(200, 200, 200, 0.75)',
                        borderColor: 'rgba(200, 200, 200, 0.75)',
                        hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                        hoverBorderColor: 'rgba(200, 200, 200, 1)',
                        data: score
                    }
                ]
            };

            var ctx = $("#mycanvas");

            var barGraph = new Chart(ctx, {
                type: 'bar',
                data: chartdata
            });
        },
        error: function(data) {
            console.log(data);
        }
    });
});