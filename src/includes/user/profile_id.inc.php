<?php

try {
    session_start();
    $userId = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;

    header('Content-Type: application/json');
    // Send a success response
    echo json_encode(['status' => 'success', 'message' => $userId]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Error deleting Trainer: ' . $e->getMessage()]);
}
