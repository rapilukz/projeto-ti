<?php

declare(strict_types=1);


function getUsers(object $pdo)
{
    return getAllUsers($pdo);
}

function deleteUser(object $pdo, string $id)
{
    deleteUserById($pdo, $id);
}


function isInputEmpty(string $username, string $email, string $birthdate, string $role): bool
{
    return empty($username) || empty($email) || empty($birthdate) || empty($role);
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

function isUpdateUsernameTaken(object $pdo, string $username, $id): bool
{

    $result = getUsername($pdo, $username);

    if (is_array($result) && $result["user_id"] == $id && $result["username"] == $username) return false;

    if (getUsername($pdo, $username)) {
        return true;
    } else {
        return false;
    }
}

function isEmailRegistered(object $pdo, string $email): bool
{

    $result = getEmail($pdo, $email);

    if ($result) {
        return true;
    } else {
        return false;
    }
}

function isUpdateEmailRegistered(object $pdo, string $email, $id): bool
{
    $result = getEmail($pdo, $email);

    if (is_array($result) && $result["user_id"] == $id && $result["email"] == $email) return false;

    if ($result) {
        return true;
    } else {
        return false;
    }
}

function updateUserData(object $pdo, string $id, string $username, string $email, string $role, string $birthdate)
{
    updateUser($pdo, $id, $username, $email, $role, $birthdate);
}

function updateProfileData(object $pdo, string $id, string $username, string $email, string $birthdate)
{
    updateUserProfile($pdo, $id, $username, $email, $birthdate);
}

function getUserData(object $pdo, string $id)
{
    return getUserById($pdo, $id);
}
