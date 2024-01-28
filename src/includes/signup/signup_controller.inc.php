<?php

declare(strict_types=1);

function isInputEmpty(string $username, string $password, string $confirmPassword, string $email, string $birthdate): bool
{
    return empty($username) || empty($password) || empty($confirmPassword) || empty($email) || empty($birthdate);
}

function isValidEmail(string $email): bool
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

function isUsernameTaken(object $pdo, string $username): bool
{
    if (getUsername($pdo, $username)) {
        return true;
    } else {
        return false;
    }
}

function isEmailRegistered(object $pdo, string $email): bool
{
    if (getEmail($pdo, $email)) {
        return true;
    } else {
        return false;
    }
}

function createUser(object $pdo, string $username, string $email, string $password, string $birthdate)
{
    createNewUser($pdo, $username, $email, $password, $birthdate);
}
