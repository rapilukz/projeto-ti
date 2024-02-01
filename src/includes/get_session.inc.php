<?php

try {
    session_start();
    $loggedInUserId = isset($_SESSION["user_id"]) ? true : false;

    header('Content-Type: application/json');
    // Send a success response
    echo json_encode(['status' => 'success', 'message' => $loggedInUserId]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Error deleting Trainer: ' . $e->getMessage()]);
}
