<?php

try {
    require_once '../dbconn.inc.php';
    require_once 'player_model.inc.php';
    require_once 'player_controller.inc.php';

    $result = getTeams($pdo);

    header('Content-Type: application/json');
    // Send a success response
    echo json_encode(['status' => 'success', 'message' => $result]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Error deleting Player: ' . $e->getMessage()]);
}
