function networkChangeServerCreate(network) {
    if (network === 'MAIN') {
        document.getElementById("extra_create_server").style.visibility = "hidden";
        document.getElementById("extra_create_server").style.display = "none";
    } else {
        document.getElementById("extra_create_server").style.visibility = "visible";
        document.getElementById("extra_create_server").style.display = "block";
    }
}

function serverCreate(server, network, game, extradetails) {
    document.getElementById("create-server-button").classList.remove("btn-default");
    document.getElementById("create-server-button").classList.add("btn-secondary");
    document.getElementById("create-server-button").disabled = true;
    $.ajax({
        url:'/mission-control/utils/create-server.php',
        type: 'post',
        data: "server=" + encodeURIComponent(server) + "&network=" + encodeURIComponent(network) + "&game=" + encodeURIComponent(game) + "&extradetails=" + encodeURIComponent(extradetails),
        success: function(result) {
            alert(result);
            document.getElementById("create-server-button").classList.add("btn-default");
            document.getElementById("create-server-button").classList.remove("btn-secondary");
            document.getElementById("create-server-button").disabled = false;
        }
    });
}