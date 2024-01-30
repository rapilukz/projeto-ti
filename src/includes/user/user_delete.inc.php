<?php

try {
    require_once '../dbconn.inc.php';
    require_once 'user_model.inc.php';
    require_once 'user_controller.inc.php';

    $users = getUsers($pdo);

    header('Content-Type: application/json');
    echo json_encode($users);
} catch (PDOException $e) {
    die("Query Failed: " . $e->getMessage());
}
