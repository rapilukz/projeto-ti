<?php

declare(strict_types=1);

function getAllUsers(object $pdo)
{
    $query = "SELECT user_id, username, email, birthdate FROM users";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function deleteUserById(object $pdo, string $id)
{
    $query = "DELETE from users where user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $id);
    $stmt->execute();
}
