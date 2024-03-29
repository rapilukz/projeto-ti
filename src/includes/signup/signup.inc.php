<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm-password"];
    $birthdate = $_POST["birthdate"];

    try {
        require_once '../dbconn.inc.php';
        require_once 'signup_model.inc.php';
        require_once 'signup_controller.inc.php';


        // ERROR HANDLERS
        $errors = [];

        if (isInputEmpty($username, $password, $confirm_password, $email, $birthdate)) {
            $errors["empty_input"] = "Fill in all fields";
        }

        if (!isValidEmail($email)) {
            $errors["invalid_email"] = "Invalid email!";
        }

        if (isUsernameTaken($pdo, $username)) {
            $errors["username_taken"] = "Username already taken!";
        }

        if (isEmailRegistered($pdo, $email)) {
            $errors["email_used"] = "Email already registered!";
        }

        if ($confirm_password != $password) {
            $errors["invalid_password"] = "Passwords do not match";
        }

        if (strlen($password) < 6) {
            $errors["short_password"] = "Password must be at least 6 characters long";
        }

        if (strtotime($birthdate) >= time()) {
            $errors["invalid_birthdate"] = "Invalid Birthdate";
        }

        require '../config-session.inc.php';

        if ($errors) {
            $_SESSION["errors_signup"] = $errors;

            $signupData = [
                "username" => $username,
                "email" => $email,
                "birthdate" => $birthdate
            ];

            $_SESSION["signup_data"] = $signupData;

            header("Location: ../../auth/register.php");
            die();
        }

        createUser($pdo, $username, $email, $password, $birthdate);
        header("Location: ../../auth/login.php?signup=success");
        $pdo = null;
        $stm = null;
        die();
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
} else {
    header("Location: ../../index.php");
    die();
}
