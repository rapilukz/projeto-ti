<?php

declare(strict_types=1);

function isInputEmpty(string $email, string $password): bool
{
    return empty($email) || empty($password);
}

function isEmailValid(bool | array $result)
{
    if ($result) {
        return true;
    } else {
        return false;
    }
}

function isPasswordValid(string $password, string $hashedPassword)
{
    return password_verify($password, $hashedPassword);
}
