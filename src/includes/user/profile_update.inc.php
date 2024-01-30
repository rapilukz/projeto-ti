<?php

if (isset($_POST['id']) && isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["birthdate"])) {

    $id = $_POST["id"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $birthdate = $_POST["birthdate"];

    try {
        require_once '../dbconn.inc.php';
        require_once 'user_model.inc.php';
        require_once 'user_controller.inc.php';


        // ERROR HANDLERS
        $errors = [];
        session_start();

        if (isInputEmpty($username, $email, $birthdate, "user")) {
            $errors[] = "Fill in all the fields";
        }

        if (!isValidEmail($email)) {
            $errors[] = "Invalid email";
        }

        if (strtotime($birthdate) >= time()) {
            $errors[] = "Invalid Birthdate";
        }

        if (isUsernameTaken($pdo, $username) && $username !=  $_SESSION["user_username"]) {
            $errors[] = "Username already taken!";
        }

        if (isEmailRegistered($pdo, $email) && $email !=  $_SESSION["user_email"]) {
            $errors[] = "Email already registered!";
        }

        if ($errors) {
            echo json_encode(['status' => 'error', 'message' => $errors]);
            die();
        }

        updateProfileData($pdo, $id, $username, $email, $birthdate);


        $_SESSION["user_username"] = htmlspecialchars($username);
        $_SESSION["user_email"] = htmlspecialchars($email);
        $_SESSION["user_birthdate"] = htmlspecialchars($birthdate);

        header('Content-Type: application/json');
        // Send a success response
        echo json_encode(['status' => 'success', 'message' => 'User updated successfully']);
        die();
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error updating user: ' . $e->getMessage()]);
        die("Query Failed: " . $e->getMessage());
    }
} else {
    $errors = ["Fill in All fields"];
    echo json_encode(['status' => 'error', 'message' => $errors]);
    die();
}
