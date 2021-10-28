<!DOCTYPE HTML>
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script>
        window.onload = function () {

            $.ajax({
                url: "../../functions.php",
                type: "post",
                data: "stat=GAME_PLAYER_TOTAL&time=daily",
                success: function (result) {
                    let json = JSON.parse(result);
                    let options = {
                        chart: {
                            type: 'line',
                            zoom: {
                                enabled: false
                            },
                            height: '300px',
                            width: '400px',
                            background: '#32373A'
                        },
                        series: json,
                        theme: {
                            mode: 'dark',
                            palette: 'palette1'
                        },
                        xaxis: {
                            type: 'datetime',
                            title: {
                                text:'Time'
                            }
                        },
                        yaxis: {
                            title: {
                                text:'Online Players'
                            }
                        },
                        tooltip: {
                            x: {
                                format: 'hh:mm:ss TT'
                            }
                        }
                    }
                    let element = document.getElementById("chart");
                    let chart = new ApexCharts(element, options);

                    chart.render();
                }
            })
        }
    </script>
</head>
<body>
<div id="chart" style="max-height: 50px">
</div>
</body>
</html>