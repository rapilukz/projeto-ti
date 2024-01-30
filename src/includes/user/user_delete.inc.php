<?php

if (isset($_POST['id'])) {

    try {
        require_once '../dbconn.inc.php';
        require_once 'user_model.inc.php';
        require_once 'user_controller.inc.php';
        $userId = $_POST['id'];

        deleteUser($pdo, $userId);

        header('Content-Type: application/json');
        // Send a success response
        echo json_encode(['status' => 'success', 'message' => 'User deleted successfully']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error deleting user: ' . $e->getMessage()]);
    }
} else {
    // Send an error response if user_id is not provided
    echo json_encode(['status' => 'error', 'message' => 'User ID not provided']);
}
