<!DOCTYPE HTML>
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        window.onload = function () {
            var options = {
                chart: {
                    type: 'line',
                    zoom: {
                        enabled: false
                    },
                    height: '400px',
                    width: '1000px',
                    background: '#32373A'
                },
                series: [{
                    name: 'Online Players',
                    data: [{x: 1633435255918, y: 30},{x: 1633435256918, y: 40},{x: 1633435257918, y: 35},{x: 1633435258918, y: 37},{x: 1633435259918, y: 41},{x: 1633435260918, y: 29},{x: 1633435261918, y: 21},{x: 1633435262918, y: 55},{x: 1633435263918, y: 48}]
                },{
                    name: 'Crystal Quest',
                    data: [{x: 1633435255918, y: 20},{x: 1633435256918, y: 15},{x: 1633435257918, y: 12},{x: 1633435258918, y: 26},{x: 1633435259918, y: 23},{x: 1633435260918, y: 28},{x: 1633435261918, y: 6},{x: 1633435262918, y: 48},{x: 1633435263918, y: 42}]
                }],
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
            var element = document.getElementById("chart");
            var chart = new ApexCharts(element, options);

            chart.render();
        }
    </script>
</head>
<body>
<div id="chart" style="max-height: 50px">
</div>
</body>
</html>