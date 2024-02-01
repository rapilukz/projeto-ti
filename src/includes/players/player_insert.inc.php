<?php

if (isset($_POST["name"]) && isset($_POST["position"]) && isset($_POST["birthdate"]) && isset($_POST["team"])) {
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

        if (nameIsTaken($pdo, $name, "")) {
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

        $result = insertPlayerData($pdo, $name, $position, $birthdate, $teamId["team_id"]);

        header('Content-Type: application/json');
        // Send a success response
        echo json_encode(['status' => 'success', 'message' => $result]);
        die();
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error inserting team: ' . $e->getMessage()]);
        die("Query Failed: " . $e->getMessage());
    }
} else {
    $errors = ["Missing fields"];
    echo json_encode(['status' => 'error', 'message' => $errors]);
    die();
}
