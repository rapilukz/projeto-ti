<?php

declare(strict_types=1);


function deletePlayerById(object $pdo, string $id)
{
    $query = "DELETE from players where player_id = :player_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":player_id", $id);
    $stmt->execute();
}

function getName(object $pdo, string $name)
{
    $query = "SELECT player_name, player_id FROM players WHERE player_name = :player_name;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":player_name", $name);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function getAllTeams(object $pdo)
{
    $query = "SELECT team_name from teams";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function getTeam(object $pdo, string $team)
{
    $query = "SELECT team_id from teams WHERE team_name = :team_name";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":team_name", $team);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function insertPlayer(object $pdo, string $name, string $position, string $birthdate, string $teamId)
{
    try {
        $query = "INSERT INTO players (player_name, position, birthdate, team_id) VALUES (:player_name, :position, :birthdate, :team_id)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':player_name', $name);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':birthdate', $birthdate);
        $stmt->bindParam(':team_id', $teamId);
        $stmt->execute();

        // Assuming you want to return the inserted player's data
        $playerId = $pdo->lastInsertId();
        $selectQuery = "SELECT players.*, teams.team_name 
                        FROM players 
                        LEFT JOIN teams ON players.team_id = teams.team_id
                        WHERE player_id = :player_id";
        $selectStmt = $pdo->prepare($selectQuery);
        $selectStmt->bindParam(':player_id', $playerId);
        $selectStmt->execute();
        $insertedPlayer = $selectStmt->fetch(PDO::FETCH_ASSOC);

        return $insertedPlayer;
    } catch (PDOException $e) {
        // Handle the exception as needed
        die("Query Failed: " . $e->getMessage());
    }
}

function updatePlayer(object $pdo, string $id, string $name, string $position, string $birthdate, $teamId)
{

    $query = "UPDATE players 
                  SET player_name = :player_name, position = :position, birthdate = :birthdate, team_id = :team_id
                  WHERE player_id = :player_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':player_name', $name);
    $stmt->bindParam(':position', $position);
    $stmt->bindParam(':birthdate', $birthdate);
    $stmt->bindParam(':team_id', $teamId);
    $stmt->bindParam(':player_id', $id);
    $stmt->execute();
}
