<?php

declare(strict_types=1);

function getAllUsers(object $pdo)
{
    $query = "SELECT * FROM teams";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function deleteTeamById(object $pdo, string $id)
{
    $query = "DELETE from teams where team_id = :team_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":team_id", $id);
    $stmt->execute();
}
