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
