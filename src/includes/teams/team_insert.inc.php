<?php

if (isset($_POST["name"]) && isset($_POST["year"]) && isset($_POST["country"])) {
    $name = $_POST["name"];
    $year = $_POST["year"];
    $country = $_POST["country"];

    try {
        require_once '../dbconn.inc.php';
        require_once 'team_model.inc.php';
        require_once 'team_controller.inc.php';


        // ERROR HANDLERS
        $errors = [];

        if (isInputEmpty($name, $year, $country)) {
            $errors[] = "Fill in all fields";
        }

        if (isTeamTaken($pdo, $name, "")) {
            $errors[] = "Team already exists";
        }

        if ($year > "2099" || $year < "1800") {
            $errors[] = "Invalid Year";
        }

        if ($errors) {
            echo json_encode(['status' => 'error', 'message' => $errors]);
            die();
        }

        insertTeamData($pdo, $name, $year, $country);

        header('Content-Type: application/json');
        // Send a success response
        echo json_encode(['status' => 'success', 'message' => 'Team inserted successfully']);
        die();
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error inserting team: ' . $e->getMessage()]);
        die("Query Failed: " . $e->getMessage());
    }
} else {
    $errors = ["Fill in All fields"];
    echo json_encode(['status' => 'error', 'message' => $errors]);
    die();
}
