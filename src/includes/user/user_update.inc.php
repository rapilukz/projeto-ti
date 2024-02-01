<?php

if (isset($_POST['id']) && isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["birthdate"]) && isset($_POST["role"])) {
    $id = $_POST["id"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $role = $_POST["role"];
    $birthdate = $_POST["birthdate"];

    try {
        require_once '../dbconn.inc.php';
        require_once 'user_model.inc.php';
        require_once 'user_controller.inc.php';


        // ERROR HANDLERS
        $errors = [];

        if (!isValidEmail($email)) {
            $errors[] = "Invalid email";
        }

        if (strtotime($birthdate) >= time()) {
            $errors[] = "Invalid Birthdate";
        }

        if (isUpdateUsernameTaken($pdo, $username, $id)) {
            $errors[] = "Username already taken!";
        }

        if (isUpdateEmailRegistered($pdo, $email, $id)) {
            $errors[] = "Email already registered!";
        }

        if ($errors) {
            echo json_encode(['status' => 'error', 'message' => $errors]);
            die();
        }

        updateUserData($pdo, $id, $username, $email, $role, $birthdate);

        session_start();
        $_SESSION["user_username"] = htmlspecialchars($username);
        $_SESSION["user_email"] = htmlspecialchars($email);
        $_SESSION["user_birthdate"] = htmlspecialchars($birthdate);
        $_SESSION["user_role"] = htmlspecialchars($role);

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
