<?php

declare(strict_types=1);

function check_signup_errors()
{

    if (isset($_SESSION['errors_signup'])) {
        $errors = $_SESSION['errors_signup'];

        foreach ($errors as $error) {
            echo '<div class="form-error text-danger">' . $error . '</div>';
        }

        unset($_SESSION['errors_signup']);
    }
}

function signupInputs()
{
    if (isset($_SESSION["signup_data"]["username"]) && !isset($_SESSION["errors_signup"]["username_taken"])) {
        echo '<div class="mb-3 mt-3">
        <label class="form-label">Username</label>
        <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="' . $_SESSION["signup_data"]["username"]  . '">
        </div>';
    } else {
        echo '<div class="mb-3 mt-3">
        <label class="form-label">Username</label>
        <input type="text" class="form-control" name="username" id="username" placeholder="Username">
        </div>';
    }

    if (isset($_SESSION["signup_data"]["email"]) && !isset($_SESSION["errors_signup"]["email_used"]) && !isset($_SESSION["errors_signup"]["invalid_email"])) {
        echo '<div class="mb-3">
        <label class="form-label">Email</label>
        <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="' . $_SESSION["signup_data"]["email"] . '">
        </div>
        ';
    } else {
        echo '<div class="mb-3">
        <label class="form-label">Email</label>
        <input type="text" class="form-control" name="email" id="email" placeholder="Email">
        </div>
        ';
    }

    if (isset($_SESSION["signup_data"]["birthdate"]) && !isset($_SESSION["errors_signup"]["invalid_birthdate"])) {
        echo '<div class="mb-3">
        <label class="form-label">Birthdate</label>
        <input type="date" class="form-control" name="birthdate" id="birthdate" placeholder="Birthdate" value="' . $_SESSION["signup_data"]["birthdate"] . '">
        </div>';
    } else {
        echo '<div class="mb-3">
        <label class="form-label">Birthdate</label>
        <input type="date" class="form-control" name="birthdate" id="birthdate" placeholder="Birthdate">
        </div>';
    }

    echo '<div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
        </div>


        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" class="form-control" name="confirm-password" id="confirm-password" placeholder="Confirm Password">
            <div class="mt-3 d-flex">
                <span class="sign-in ms-auto">Already have an account?<a href="login.php" class="ms-1">Sign Up</a></span>
            </div>
        </div>';
}
