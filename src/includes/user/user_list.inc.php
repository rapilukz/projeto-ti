<?php

try {
    require_once '../dbconn.inc.php';
    require_once 'user_model.inc.php';
    require_once 'user_controller.inc.php';

    $users = getUsers($pdo);

    // Check if $_SESSION["user_id"] is in the list of users
    session_start();
    $loggedInUserId = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;

    foreach ($users as &$user) {
        if ($loggedInUserId !== null && $user['user_id'] == $loggedInUserId) {
            // If the user is logged in, set the 'same_user' property to true
            $user['same_user'] = true;
        } else {
            // If the user is not logged in or does not match, set 'same_user' to false
            $user['same_user'] = false;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($users);
} catch (PDOException $e) {
    die("Query Failed: " . $e->getMessage());
}
