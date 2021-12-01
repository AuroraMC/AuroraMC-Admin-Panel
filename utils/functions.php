<?php
/*
 * Copyright (c) 2021 AuroraMC Ltd. All Rights Reserved.
 */

include_once 'database/db-connect.php';

function sec_session_start() {
    $session_name = 'amc_panel_session_id';   // Set a custom session name
    $secure = false;

    // This stops JavaScript being able to access the session id.
    $httponly = true;

    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: https://auroramc.net/");
        exit();
    }

    // Gets current cookies parameters.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params((60*60*24*7), $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);

    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();            // Start the PHP session
    session_regenerate_id();    // regenerated the session, delete the old one.
}

function login($username, $password, $code, $mysqli, $redis) {
    // Using prepared statements means that SQL injection is not possible.
    if ($sql = $mysqli->prepare("SELECT id, username, password, uuid
        FROM `accounts`
       WHERE username = ?
        LIMIT 1")) {
        $sql->bind_param('s', $username);  // Binds the email to the parameter.
        $sql->execute();    // Execute the prepared query.
        $sql->store_result();

        $user_id = null;
        $username = null;
        $db_password = null;
        $uuid = null;

        // get variables from result.
        $sql->bind_result($user_id, $username, $db_password, $uuid);
        $sql->fetch();

        if ($sql->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts

            if (checkbrute($user_id, $mysqli) == true) {
                // Account is locked
                return false;
            } else {
                // Check if the password in the database matches
                // the password the user submitted.
                if (password_verify($password, $db_password)) {
                    // Password is correct!
                    //Check the verification code.
                    $dbCode = $redis->get("panel.code." . $uuid);
                    if ($dbCode) {
                        if ($code != $dbCode) {
                            return false;
                        }
                    } else {
                        return false;
                    }


                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];

                    // Cross-site scripting protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;

                    // Cross-site scripting protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/",
                        "",
                        $username);
                    $_SESSION['username'] = $username;

                    $_SESSION['login_string'] = hash('sha512',
                        $db_password . $user_browser);
                    // Login successful.
                    return true;
                } else {
                    // Password is not correct
                    // We record this attempt in the database
                    $now = time();
                    $mysqli->query("INSERT INTO login_attempts(id, time)
                                    VALUES ('$user_id', '$now')");
                    return false;
                }
            }
        } else {
            // No user exists.
            return false;
        }
    }
}

function checkbrute($user_id, $mysqli) {
    // Get timestamp of current time (in seconds)
    $now = time();

    // All login attempts are counted from the past 2 hours (60 seconds * 60 minutes * 2 hours).
    $valid_attempts = $now - (2 * 60 * 60);

    if ($sql = $mysqli->prepare("SELECT time 
                             FROM `login_attempts` 
                             WHERE id = ? 
                            AND time > '$valid_attempts'")) {
        $sql->bind_param('i', $user_id);

        // Execute the prepared query.
        $sql->execute();
        $sql->store_result();

        // If there have been more than 5 failed logins
        if ($sql->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }
}

function login_check($mysqli) {
    // Check if all session variables are set
    if (isset($_SESSION['user_id'],
        $_SESSION['username'],
        $_SESSION['login_string'])) {

        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];

        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        if ($sql = $mysqli->prepare("SELECT password, account_type 
                                      FROM `accounts` 
                                      WHERE id = ? LIMIT 1")) {
            // Bind "$user_id" to parameter.
            $sql->bind_param('i', $user_id);
            $sql->execute();   // Execute the prepared query.
            $sql->store_result();

            $password = null;
            $account_type = null;

            if ($sql->num_rows == 1) {
                // If the user exists get variables from result.
                $sql->bind_result($password, $account_type);
                $sql->fetch();
                $login_check = hash('sha512', $password . $user_browser);


                if (hash_equals($login_check, $login_string) ){
                    // Logged In!!!!
                    return $account_type;
                } else {
                    // Not logged in
                    return false;
                }
            } else {
                // User doesn't exists, so is not logged in.
                return false;
            }
        } else {
            // Failed to prepare the SQL statement
            return false;
        }
    } else {
        // Not logged in
        return false;
    }
}