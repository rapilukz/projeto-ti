<?php

if (isset($_POST['id'])) {

    try {
        require_once '../dbconn.inc.php';
        require_once 'trainer_model.inc.php';
        require_once 'trainer_controller.inc.php';

        $trainerId = $_POST['id'];

        deleteTrainer($pdo, $trainerId);

        header('Content-Type: application/json');
        // Send a success response
        echo json_encode(['status' => 'success', 'message' => 'Trainer deleted successfully']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error deleting Trainer: ' . $e->getMessage()]);
    }
} else {
    // Send an error response if user_id is not provided
    echo json_encode(['status' => 'error', 'message' => 'Trainer Id not provided']);
}
