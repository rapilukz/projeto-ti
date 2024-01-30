<?php

if (isset($_POST['id'])) {

    try {
        require_once '../dbconn.inc.php';
        require_once 'user_model.inc.php';
        require_once 'user_controller.inc.php';
        $userId = $_POST['id'];


        $result = getUserData($pdo, $userId);

        header('Content-Type: application/json');
        // Send a success response
        echo json_encode(['status' => 'success', 'message' => $result]);
        die();
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error user data: ' . $e->getMessage()]);
        die();
    }
} else {
    echo json_encode(['status' => 'error', 'message' => "Missing User Id"]);
    die();
}
