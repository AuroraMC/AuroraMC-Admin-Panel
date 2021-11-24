<!DOCTYPE HTML>
<?php
include_once '../../../../database/db-connect.php';

$account_type = login_check($mysqli);
if (!$account_type) {
    header("Location: ../../../../login");
}

if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV" && $account_type != "DEV") {
    header("Location: ../../../../login");
} ?>
<html>
<head>
    <title>daily</title>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script>
        window.onload = function () {

            $.ajax({
                url: "../../functions.php",
                type: "post",
                data: "stat=GAMES_STARTED&time=weekly",
                success: function (result) {
                    let json = JSON.parse(result);
                    let orderedJSON = [];
                    for (let x of json) {
                        orderedJSON.push({name: x.name, data: x.data.sort((a,b) => ((a.x > b.x)?1:((a.x < b.x)?-1:0)))});
                    }
                    orderedJSON.sort((a,b) => a.name.toLowerCase().localeCompare(b.name.toLowerCase()))
                    let options = {
                        chart: {
                            type: 'line',
                            zoom: {
                                enabled: true
                            },
                            height: '300px',
                            width: '600px',
                            background: '#32373A'
                        },
                        series: orderedJSON,
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
                                text:'Games Started'
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
<body style="margin:0">
<div id="chart" style="max-height: 300px">
</div>
</body>
</html>