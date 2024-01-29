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
        echo '<ul class="links">
            <li><a href="#" class="link">User List</a></li>
            <li><a href="#" class="link">' . $_SESSION["user_username"] . '</a></li>
            </ul>
            <form action="./includes/login/logout.inc.php" method="POST">
                <button type="submit" class="login-btn">Logout</button></a>
            </form>
           ';
    } else {
        echo '<a href="auth/login.php"><button type="button" class="login-btn">Login</button></a>';
    }
}
