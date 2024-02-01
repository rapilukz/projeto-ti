<?php

if (isset($_POST['id'])) {

    try {
        require_once '../dbconn.inc.php';
        require_once 'player_model.inc.php';
        require_once 'player_controller.inc.php';

        $playerId = $_POST['id'];

        deletePlayer($pdo, $playerId);

        header('Content-Type: application/json');
        // Send a success response
        echo json_encode(['status' => 'success', 'message' => 'Player deleted successfully']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error deleting Player: ' . $e->getMessage()]);
    }
} else {
    // Send an error response if user_id is not provided
    echo json_encode(['status' => 'error', 'message' => 'Player Id not provided']);
}
