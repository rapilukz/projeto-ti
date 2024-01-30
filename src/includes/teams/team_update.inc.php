<?php

if (isset($_POST['id']) && isset($_POST["name"]) && isset($_POST["year"]) && isset($_POST["country"])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $year = $_POST["year"];
    $country = $_POST["country"];

    try {
        require_once '../dbconn.inc.php';
        require_once 'team_model.inc.php';
        require_once 'team_controller.inc.php';


        // ERROR HANDLERS
        $errors = [];

        if (isTeamTaken($pdo, $name, $id)) {
            $errors[] = "Team already exists";
        }

        if ($year > "2099" || $year < "1800") {
            $errors[] = "Invalid Year";
        }

        if ($errors) {
            echo json_encode(['status' => 'error', 'message' => $errors]);
            die();
        }

        updateTeamData($pdo, $id, $name, $year, $country);

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
