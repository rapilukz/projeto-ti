<?php

if (isset($_POST["name"]) && isset($_POST["license"]) && isset($_POST["team"])) {
    $name = $_POST["name"];
    $license = $_POST["license"];
    $team = $_POST["team"];

    try {
        require_once '../dbconn.inc.php';
        require_once 'trainer_model.inc.php';
        require_once 'trainer_controller.inc.php';

        // ERROR HANDLERS
        $errors = [];

        if (isInputEmpty($name, $license, $team)) {
            $errors[] = "Fill in all fields";
        }

        if (nameIsTaken($pdo, $name, "")) {
            $errors[] = "Trainer already exists";
        }


        if ($errors) {
            echo json_encode(['status' => 'error', 'message' => $errors]);
            die();
        }


        $teamId = getTeamId($pdo, $team);

        $result = insertTrainerData($pdo, $name, $license, $teamId["team_id"]);

        header('Content-Type: application/json');
        // Send a success response
        echo json_encode(['status' => 'success', 'message' => $result]);
        die();
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error inserting trainer: ' . $e->getMessage()]);
        die("Query Failed: " . $e->getMessage());
    }
} else {
    $errors = ["Missing fields"];
    echo json_encode(['status' => 'error', 'message' => $errors]);
    die();
}
