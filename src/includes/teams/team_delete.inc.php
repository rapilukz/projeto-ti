<?php

if (isset($_POST['id'])) {

    try {
        require_once '../dbconn.inc.php';
        require_once 'team_model.inc.php';
        require_once 'team_controller.inc.php';
        $teamId = $_POST['id'];

        deleteTeam($pdo, $teamId);

        header('Content-Type: application/json');
        // Send a success response
        echo json_encode(['status' => 'success', 'message' => 'Team deleted successfully']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error deleting team: ' . $e->getMessage()]);
    }
} else {
    // Send an error response if user_id is not provided
    echo json_encode(['status' => 'error', 'message' => 'Team Id not provided']);
}
