<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    try {
        require_once '../dbconn.inc.php';
        require_once 'login_controller.inc.php';
        require_once 'login_model.inc.php';

        // ERROR HANDLERS
        $errors = [];

        $result = getEmail($pdo, $email);

        if (isInputEmpty($email, $password)) {
            $errors["empty_input"] = "Fill in all fields";
        }

        if (!isEmailValid($result)) {
            $errors["login_incorret"] = "Invalid Credentials";
        }

        if (isEmailValid($result) && !isPasswordValid($password, $result["password"])) {
            $errors["login_incorret"] = "Invalid Credentials";
        }

        require '../config-session.inc.php';

        if ($errors) {
            $_SESSION["errors_login"] = $errors;

            header("Location: ../../auth/login.php");
            die();
        }


        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $result["user_id"];
        session_id($sessionId);

        $_SESSION["user_id"] = $result["user_id"];
        $_SESSION["user_username"] = htmlspecialchars($result["username"]);
        $_SESSION["user_email"] = htmlspecialchars($result["email"]);
        $_SESSION["user_birthdate"] = htmlspecialchars($result["birthdate"]);
        $_SESSION["user_role"] = $result["role"];

        $_SESSION["last_regeneration"] = time();

        header("Location: ../../index.php?login=success");
        $pdo = null;
        $stml = null;
        die();
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
} else {
    header("Location: ../../index.php");
    die();
}
