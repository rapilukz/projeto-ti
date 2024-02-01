<?php

if (isset($_POST['id']) && isset($_POST["name"]) && isset($_POST["license"]) && isset($_POST["team"])) {
    $id = $_POST["id"];
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

        if (nameIsTaken($pdo, $name, $id)) {
            $errors[] = "Player already exists";
        }
        if ($errors) {
            echo json_encode(['status' => 'error', 'message' => $errors]);
            die();
        }

        $teamId = getTeamId($pdo, $team);
        updateTrainerData($pdo, $id, $name, $license, $teamId["team_id"]);

        header('Content-Type: application/json');
        // Send a success response
        echo json_encode(['status' => 'success', 'message' => 'Team updated successfully']);
        die();
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error updating team: ' . $e->getMessage()]);
        die("Query Failed: " . $e->getMessage());
    }
} else {
    $errors = ["Fill in All fields"];
    echo json_encode(['status' => 'error', 'message' => $errors]);
    die();
}
