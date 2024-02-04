/*
 * Copyright (c) 2021-2024 Ethan P-B. All Rights Reserved.
 */

function networkChangeServerCreate(network) {
    if (network === 'TEST') {
        document.getElementById("extra_create_server").style.visibility = "visible";
        document.getElementById("extra_create_server").style.display = "block";
    } else {
        document.getElementById("extra_create_server").style.visibility = "hidden";
        document.getElementById("extra_create_server").style.display = "none";
    }
}

function networkChangeProxyCreate(network) {
    if (network === 'TEST') {
        document.getElementById("extra_create_proxy").style.visibility = "visible";
        document.getElementById("extra_create_proxy").style.display = "block";
    } else {
        document.getElementById("extra_create_proxy").style.visibility = "hidden";
        document.getElementById("extra_create_proxy").style.display = "none";
    }
}

function serverCreate(server, network, game, extradetails) {
    document.getElementById("create-server-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/server/create.php',
        type: 'post',
        data: "server=" + encodeURIComponent(server) + "&network=" + encodeURIComponent(network) + "&game=" + encodeURIComponent(game) + "&extradetails=" + encodeURIComponent(extradetails),
        success: function(result) {
            alert(result);
            document.getElementById("create-server-button").disabled = false;
        }
    });
}

function serverClose(server, network) {
    document.getElementById("close-server-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/server/close.php',
        type: 'post',
        data: "server=" + encodeURIComponent(server) + "&network=" + encodeURIComponent(network),
        success: function(result) {
            alert(result);
            document.getElementById("close-server-button").disabled = false;
        }
    });
}

function serverRestart(server, network) {
    document.getElementById("restart-server-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/server/restart.php',
        type: 'post',
        data: "server=" + encodeURIComponent(server) + "&network=" + encodeURIComponent(network),
        success: function(result) {
            alert(result);
            document.getElementById("restart-server-button").disabled = false;
        }
    });
}

function proxyCreate(network, extradetails) {
    document.getElementById("create-proxy-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/proxy/create.php',
        type: 'post',
        data: "network=" + encodeURIComponent(network) + "&extradetails=" + encodeURIComponent(extradetails),
        success: function(result) {
            alert(result);
            document.getElementById("create-proxy-button").disabled = false;
        }
    });
}

function proxyClose(server, network) {
    document.getElementById("close-proxy-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/proxy/close.php',
        type: 'post',
        data: "proxy=" + encodeURIComponent(server) + "&network=" + encodeURIComponent(network),
        success: function(result) {
            alert(result);
            document.getElementById("close-proxy-button").disabled = false;
        }
    });
}

function proxyRestart(server, network) {
    document.getElementById("restart-proxy-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/proxy/restart.php',
        type: 'post',
        data: "proxy=" + encodeURIComponent(server) + "&network=" + encodeURIComponent(network),
        success: function(result) {
            alert(result);
            document.getElementById("restart-proxy-button").disabled = false;
        }
    });
}

function enableNetwork(network) {
    document.getElementById("enable-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/network/enable.php',
        type: 'post',
        data: "network=" + encodeURIComponent(network),
        success: function(result) {
            alert(result);
            document.getElementById("enable-button").disabled = false;
        }
    });
}

function disableNetwork(network) {
    document.getElementById("disable-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/network/disable.php',
        type: 'post',
        data: "network=" + encodeURIComponent(network),
        success: function(result) {
            alert(result);
            document.getElementById("disable-button").disabled = false;
        }
    });
}

function updateNetwork(core, lobby, engine, game, duels, build, event, pathfinder, arguments) {
    let modules = [];
    if (core !== "") {
        modules.push("core:" + core);
    }
    if (lobby !== "") {
        modules.push("lobby:" + lobby);
    }
    if (engine !== "") {
        modules.push("engine:" + engine);
    }
    if (game !== "") {
        modules.push("game:" + game);
    }
    if (duels !== "") {
        modules.push("duels:" + duels);
    }
    if (build !== "") {
        modules.push("build:" + build);
    }
    if (event !== "") {
        modules.push("event:" + event);
    }
    if (pathfinder !== "") {
        modules.push("pathfinder:" + pathfinder);
    }

    if (!arguments || arguments === "") {
        arguments = "NONE";
    }
    console.log(modules.join(";") + "&arguments=" + arguments);
    document.getElementById("update-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/network/update.php',
        type: 'post',
        data: "data=" + encodeURIComponent(modules.join(";") + "&" + arguments),
        success: function(result) {
            alert(result);
            document.getElementById("update-button").disabled = false;
            document.getElementById("main-core").value = "";
            document.getElementById("main-lobby").value = "";
            document.getElementById("main-engine").value = "";
            document.getElementById("main-game").value = "";
            document.getElementById("main-duels").value = "";
            document.getElementById("main-build").value = "";
            document.getElementById("main-event").value = "";
            document.getElementById("main-pathfinder").value = "";
            document.getElementById("main-arguments").value = "";

            $('#updateModal').modal('hide');
        }
    });
}

function enableAlpha() {
    document.getElementById("enable-alpha-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/alpha/enable.php',
        type: 'post',
        success: function(result) {
            alert(result);
            document.getElementById("enable-alpha-button").disabled = false;
        }
    });
}

function disableAlpha() {
    document.getElementById("disable-alpha-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/alpha/disable.php',
        type: 'post',
        success: function(result) {
            alert(result);
            document.getElementById("disable-alpha-button").disabled = false;
        }
    });
}

function updateAlphaNetwork(core, lobby, engine, game, duels, build, event, pathfinder) {
    let modules = [];
    if (core !== "") {
        modules.push("core;" + core);
    }
    if (lobby !== "") {
        modules.push("lobby;" + lobby);
    }
    if (engine !== "") {
        modules.push("engine;" + engine);
    }
    if (game !== "") {
        modules.push("game;" + game);
    }
    if (duels !== "") {
        modules.push("duels;" + duels);
    }
    if (build !== "") {
        modules.push("build;" + build);
    }
    if (event !== "") {
        modules.push("event;" + event);
    }
    if (pathfinder !== "") {
        modules.push("pathfinder;" + pathfinder);
    }
    document.getElementById("update-alpha-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/alpha/update.php',
        type: 'post',
        data: "data=" + encodeURIComponent(modules.join(",")),
        success: function(result) {
            alert(result);
            document.getElementById("update-alpha-button").disabled = false;
            $('#alphaModal').modal('hide');
        }
    });
}

function enableGame(game, network) {
    document.getElementById("enable-game-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/game/enable.php',
        type: 'post',
        data: "game=" + encodeURIComponent(game) + "&network=" + encodeURIComponent(network),
        success: function(result) {
            alert(result);
            document.getElementById("enable-game-button").disabled = false;
        }
    });
}

function disableGame(game, network) {
    document.getElementById("disable-game-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/game/disable.php',
        type: 'post',
        data: "game=" + encodeURIComponent(game) + "&network=" + encodeURIComponent(network),
        success: function(result) {
            alert(result);
            document.getElementById("disable-game-button").disabled = false;
        }
    });
}

function monitoringToggle(enabled, game, network) {
    document.getElementById("monitoring-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/game/monitor.php',
        type: 'post',
        data: "enabled=" + encodeURIComponent(enabled) + "&game=" + encodeURIComponent(game) + "&network=" + encodeURIComponent(network),
        success: function(result) {
            alert(result);
            document.getElementById("monitoring-button").disabled = false;
        }
    });
}

function maintenanceMode(network, mode) {
    document.getElementById("maintenance-mode-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/maintenance/mode.php',
        type: 'post',
        data: "mode=" + encodeURIComponent(mode) + "&network=" + encodeURIComponent(network),
        success: function(result) {
            alert(result);
            document.getElementById("maintenance-mode-button").disabled = false;
        }
    });
}

function maintenanceMotd(network, motd) {
    document.getElementById("maintenance-motd-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/maintenance/maintenance-motd.php',
        type: 'post',
        data: "motd=" + encodeURIComponent(motd) + "&network=" + encodeURIComponent(network),
        success: function(result) {
            alert(result);
            document.getElementById("maintenance-motd-button").disabled = false;
        }
    });
}

function normalMotd(network, motd) {
    document.getElementById("normal-motd-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/maintenance/normal-motd.php',
        type: 'post',
        data: "motd=" + encodeURIComponent(motd) + "&network=" + encodeURIComponent(network),
        success: function(result) {
            alert(result);
            document.getElementById("normal-motd-button").disabled = false;
        }
    });
}

function onLoad() {
    $.ajax({
        url:'/mission-control/utils/get-totals.php',
        type: 'get',
        success: function(result) {
            result = JSON.parse(result);
            document.getElementById("servers-main").innerHTML = result["main"]["servers"];
            document.getElementById("proxies-main").innerHTML = result["main"]["proxies"];
            document.getElementById("players-main").innerHTML = result["main"]["players"];

            document.getElementById("servers-alpha").innerHTML = result["alpha"]["servers"];
            document.getElementById("proxies-alpha").innerHTML = result["alpha"]["proxies"];
            document.getElementById("players-alpha").innerHTML = result["alpha"]["players"];

            document.getElementById("servers-test").innerHTML = result["test"]["servers"];
            document.getElementById("proxies-test").innerHTML = result["test"]["proxies"];
            document.getElementById("players-test").innerHTML = result["test"]["players"];

            document.getElementById("core").innerHTML = result["builds"]["core"];
            document.getElementById("engine").innerHTML = result["builds"]["engine"];
            document.getElementById("game").innerHTML = result["builds"]["game"];
            document.getElementById("lobby").innerHTML = result["builds"]["lobby"];
            document.getElementById("duels").innerHTML = result["builds"]["duels"];
            document.getElementById("build").innerHTML = result["builds"]["build"];

            document.getElementById("content").style.display = null;
            document.getElementById("ring").style.display = "none";
        }
    });
}

function loadGraphs() {
    const x = ["NETWORK_PLAYER_TOTALS","NETWORK_PROXY_TOTALS","UNIQUE_PLAYER_TOTALS","UNIQUE_PLAYER_JOINS","NETWORK_SERVER_TOTALS","GAMES_STARTED","GAME_PLAYER_TOTAL","PLAYERS_PER_GAME"];
    const z =
        {"NETWORK_PLAYER_TOTALS": "Players",
            "NETWORK_PROXY_TOTALS": "Proxies",
            "UNIQUE_PLAYER_TOTALS": "Unique Players",
            "UNIQUE_PLAYER_JOINS": "Unique Joins",
            "NETWORK_SERVER_TOTALS": "Servers",
            "GAMES_STARTED": "Games Started",
            "GAME_PLAYER_TOTAL": "Players In Game",
            "PLAYERS_PER_GAME": "Players Per Game"};
    const y = ["DAILY", "WEEKLY", "ALLTIME"];
    x.forEach(function (metric) {
       y.forEach(function (time) {
            $.ajax({
                url: "/mission-control/utils/functions.php",
                type: "post",
                data: "stat=" + metric + "&time=" + time,
                success: function (result) {
                    let json = JSON.parse(result);let orderedJSON = [];
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
                                text: z[metric]
                            }
                        },
                        tooltip: {
                            x: {
                                format: 'hh:mm:ss TT'
                            }
                        }
                    }
                    let element = document.getElementById(time + "-" + metric);
                    let chart = new ApexCharts(element, options);

                    chart.render();
                    graphFinish();
                }
            })
        });


    });
}

let total = 0;

function graphFinish() {
    total++;
    if (total >= 24) {
        document.getElementById("content").style.display = null;
        document.getElementById("ring").style.display = "none";
    }
}