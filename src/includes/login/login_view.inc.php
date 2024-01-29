<?php

declare(strict_types=1);

function check_login_errors()
{

    if (isset($_SESSION['errors_login'])) {
        $errors = $_SESSION['errors_login'];

        foreach ($errors as $error) {
            echo '<div class="form-error text-danger">' . $error . '</div>';
        }

        unset($_SESSION['errors_login']);
    }
}


function output_user()
{
    if (isset($_SESSION["user_id"])) {
        echo '<ul class="links d-flex">
            <li><a href="#" class="link">User List</a></li>
            <div class="dropdown">
                <button class="btn dropdown-toggle dropdown-btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-user"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li class="username-container"><a href="./auth/profile.php" class="dropdown-item username">' . $_SESSION["user_username"] . '</a></li>
                    <li><a class="dropdown-item second-item" href="./auth/profile.php"><i class="fa-solid fa-user"></i>Profile</a></li>
                    <form action="./includes/login/logout.inc.php" method="POST">
                        <li><a class="dropdown-item"><i class="fa-solid fa-right-from-bracket"></i> <button type="submit" class="logout-btn dropdown-item">Logout</button></a></li>
                    </form>
                </ul>
            </div>
           ';
    } else {
        echo '<div class="buttons-container d-flex">
                <a href="auth/login.php"><button type="button" class="login-btn">Login</button></a>
                <a href="auth/register.php"><button type="button" class="signup-btn">Sign Up</button></a>
            </div>';
    }
}
