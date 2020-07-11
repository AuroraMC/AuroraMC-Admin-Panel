<?php

include_once '../../database/db-connect.php';

if(isset($_POST['editnameid'])) {
    $id = filter_input(INPUT_POST, 'editnameid', FILTER_SANITIZE_NUMBER_INT);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $name = urldecode($name);

    if ($sql = $mysqli->prepare("UPDATE rules SET name = ? WHERE rule_id = ?")) {
        $sql->bind_param('si', $name, $id);
        $sql->execute();
    } else {
        return "ERROR";
    }
}

if(isset($_POST['editdescid'])) {
    $id = filter_input(INPUT_POST, 'editdescid', FILTER_SANITIZE_NUMBER_INT);
    $name = filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_STRING);
    $name = urldecode($name);

    if ($sql = $mysqli->prepare("UPDATE rules SET description = ? WHERE rule_id = ?")) {
        $sql->bind_param('si', $name, $id);
        $sql->execute();
    } else {
        return "ERROR";
    }
}

if(isset($_POST['archiveid'])) {
    $id = filter_input(INPUT_POST, 'archiveid', FILTER_SANITIZE_NUMBER_INT);

    if ($sql = $mysqli->prepare("UPDATE rules SET active = 0 WHERE rule_id = ?")) {
        $sql->bind_param('i', $id);
        $sql->execute();
    } else {
        return "ERROR";
    }
}

if(isset($_POST['newname'])) {
    $name = filter_input(INPUT_POST, 'newname', FILTER_SANITIZE_STRING);
    $name = urldecode($name);
    $name = str_replace("&#39;", "'", $name);
    $desc = filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_STRING, array('flags' => FILTER_FLAG_ENCODE_AMP));
    $desc = urldecode($desc);
    $desc= str_replace("&#39;", "'", $desc);

    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_NUMBER_INT);
    $weight = filter_input(INPUT_POST, 'weight', FILTER_SANITIZE_NUMBER_INT);

    $warning = filter_input(INPUT_POST, 'warning', FILTER_SANITIZE_NUMBER_INT);

    if ($sql = $mysqli->prepare("INSERT INTO rules(name, description, weight, type, requires_warning) VALUES (?,?,?,?,?)")) {
        $sql->bind_param('ssiii', $name, $desc, $weight, $type,$warning);
        $sql->execute();

        if ($sql = $mysqli->prepare("SELECT rule_id FROM rules ORDER BY rule_id DESC LIMIT 1")) {
            $sql->execute();    // Execute the prepared query.
            $sql->store_result();

            // get variables from result.
            $sql->bind_result($id);
            $sql->fetch();

            echo $id;
        } else {
            echo "ERROR";
        }
    } else {
        echo "ERROR";
    }
}

if(isset($_POST['togglewarning'])) {
    $id = filter_input(INPUT_POST, 'togglewarning', FILTER_SANITIZE_NUMBER_INT);

    if ($mysql = $mysqli->prepare("SELECT requires_warning FROM rules WHERE rule_id = ?")) {
        $mysql->bind_param("i",$id);
        $mysql->execute();
        $mysql->store_result();

        $warning = null;
        $mysql->bind_result($warning);
        $mysql->fetch();
        if ($warning == 1) {
            if ($mysql = $mysqli->prepare("UPDATE rules SET requires_warning = 0 WHERE rule_id = ?")) {
                $mysql->bind_param("i",$id);
                $mysql->execute();
                echo "<strong>No</strong>";
            } else {
                echo "ERROR";
            }
        } else {
            if ($mysql = $mysqli->prepare("UPDATE rules SET requires_warning = 1 WHERE rule_id = ?")) {
                $mysql->bind_param("i",$id);
                $mysql->execute();
                echo "<strong>Yes</strong>";
            } else {
                echo "ERROR";
            }
        }
    } else {
        echo "ERROR";
    }
}
