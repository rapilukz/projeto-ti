<?php

if (isset($_POST['id']) && isset($_POST["name"]) && isset($_POST["position"]) && isset($_POST["birthdate"]) && isset($_POST["team"])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $position = $_POST["position"];
    $birthdate = $_POST["birthdate"];
    $team = $_POST["team"];

    try {
        require_once '../dbconn.inc.php';
        require_once 'player_model.inc.php';
        require_once 'player_controller.inc.php';


        // ERROR HANDLERS
        $errors = [];

        if (isInputEmpty($name, $position, $birthdate, $team)) {
            $errors[] = "Fill in all fields";
        }

        if (nameIsTaken($pdo, $name, $id)) {
            $errors[] = "Player already exists";
        }

        if (strtotime($birthdate) >= time()) {
            $errors[] = "Invalid Birthdate";
        }

        if ($errors) {
            echo json_encode(['status' => 'error', 'message' => $errors]);
            die();
        }

        $teamId = getTeamId($pdo, $team);
        updatePlayerData($pdo, $id, $name, $position, $birthdate, $teamId["team_id"]);

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
