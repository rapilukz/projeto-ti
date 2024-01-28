<?php

declare(strict_types=1);

function check_signup_erros()
{

    if (isset($_SESSION['errors_signup'])) {
        $errors = $_SESSION['errors_signup'];

        foreach ($errors as $error) {
            echo '<div class="form-error text-danger">' . $error . '</div>';
        }

        unset($_SESSION['errors_signup']);
    }
}
