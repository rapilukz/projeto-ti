<?php

declare(strict_types=1);

function getAllUsers(object $pdo)
{
    $query = "SELECT user_id, username, email, birthdate, role FROM users";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function getUserById(object $pdo, string $id)
{
    $query = "SELECT username, email, birthdate FROM users where user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $id);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function deleteUserById(object $pdo, string $id)
{
    $query = "DELETE from users where user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $id);
    $stmt->execute();
}

function getUsername(object $pdo, string $username)
{
    $query = "SELECT username FROM users WHERE username = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}


function getEmail(object $pdo, string $email)
{
    $query = "SELECT email FROM users WHERE email = :email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function updateUser(object $pdo, string $id, string $username, string $email, string $role, string $birthdate)
{

    $query = "UPDATE users SET username = :username, email = :email, birthdate = :birthdate, role = :role WHERE user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $id);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':birthdate', $birthdate);
    $stmt->bindParam(':role', $role);
    $stmt->execute();
}

function updateUserProfile(object $pdo, string $id, string $username, string $email, string $birthdate)
{

    $query = "UPDATE users SET username = :username, email = :email, birthdate = :birthdate WHERE user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $id);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':birthdate', $birthdate);
    $stmt->execute();
}
