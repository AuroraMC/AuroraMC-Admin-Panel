<?php
include_once '../../database/db-connect.php';
include_once "../../utils/functions.php";

sec_session_start();

$account_type = login_check($mysqli);
if (!$account_type) {
    header("Location: ../login");
    return;
}

if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV" && $account_type != "DEV") {
    header("Location: ../login");
    return;
}

$servers_main = "ERROR";
$servers_alpha = "ERROR";
$servers_test = "ERROR";

$proxies_main = "ERROR";
$proxies_alpha = "ERROR";
$proxies_test = "ERROR";

$players_main = $redis->get('playercount.main');
$players_alpha = $redis->get('playercount.alpha');
$players_test = $redis->get('playercount.test');

if ($sql = $mysqli->prepare("SELECT count(*) FROM servers WHERE network = 'MAIN'")) {
    $sql->execute();
    $results2 = $sql->get_result();
    $results = $results2->fetch_array(MYSQLI_NUM);
    $results2->free_result();
    $sql->free_result();
    $servers_main = $results[0];
}
if ($sql = $mysqli->prepare("SELECT count(*) FROM proxies WHERE network = 'MAIN'")) {
    $sql->execute();
    $results2 = $sql->get_result();
    $results = $results2->fetch_array(MYSQLI_NUM);
    $results2->free_result();
    $sql->free_result();
    $proxies_main = $results[0];
}

if ($sql = $mysqli->prepare("SELECT count(*) FROM servers WHERE network = 'alpha'")) {
    $sql->execute();
    $results2 = $sql->get_result();
    $results = $results2->fetch_array(MYSQLI_NUM);
    $results2->free_result();
    $sql->free_result();
    $servers_alpha = $results[0];
}
if ($sql = $mysqli->prepare("SELECT count(*) FROM proxies WHERE network = 'alpha'")) {
    $sql->execute();
    $results2 = $sql->get_result();
    $results = $results2->fetch_array(MYSQLI_NUM);
    $results2->free_result();
    $sql->free_result();
    $proxies_alpha = $results[0];
}

if ($sql = $mysqli->prepare("SELECT count(*) FROM servers WHERE network = 'test'")) {
    $sql->execute();
    $results2 = $sql->get_result();
    $results = $results2->fetch_array(MYSQLI_NUM);
    $results2->free_result();
    $sql->free_result();
    $servers_test = $results[0];
}
if ($sql = $mysqli->prepare("SELECT count(*) FROM proxies WHERE network = 'test'")) {
    $sql->execute();
    $results2 = $sql->get_result();
    $results = $results2->fetch_array(MYSQLI_NUM);
    $results2->free_result();
    $sql->free_result();
    $proxies_test = $results[0];
}
$core = $redis->get("build.core");
$engine = $redis->get("build.engine");
$game = $redis->get("build.game");
$lobby = $redis->get("build.lobby");
$duels = $redis->get("build.duels");
$build = $redis->get("build.build");

$data = array(
    "main" => array(
        "servers" => $servers_main,
        "proxies" => $proxies_main,
        "players" => $players_main
    ),
    "test" => array(
        "servers" => $servers_test,
        "proxies" => $proxies_test,
        "players" => $players_test
    ),
    "alpha" => array(
        "servers" => $servers_alpha,
        "proxies" => $proxies_alpha,
        "players" => $players_alpha
    ),
    "builds" => array(
        "core" => $core,
        "engine" => $engine,
        "game" => $game,
        "lobby" => $lobby,
        "duels" => $duels,
        "build" => $build,
    )
);

echo json_encode($data);
