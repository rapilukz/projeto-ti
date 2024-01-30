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

function getTeam(object $pdo, string $name)
{
    $query = "SELECT team_id, team_name FROM teams WHERE team_name = :team_name;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":team_name", $name);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function updateTeam(object $pdo, string $id, string $name, string $year, string $country)
{
    $query = "UPDATE teams SET team_name = :team_name, foundation_year = :foundation_year, country = :country WHERE team_id = :team_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':team_name', $name);
    $stmt->bindParam(':foundation_year', $year);
    $stmt->bindParam(':country', $country);
    $stmt->bindParam(':team_id', $id);
    $stmt->execute();
}
