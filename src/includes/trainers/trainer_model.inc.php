<?php

declare(strict_types=1);


function deleteTrainerById(object $pdo, string $id)
{
    $query = "DELETE from trainers where trainer_id = :trainer_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":trainer_id", $id);
    $stmt->execute();
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

function insertTrainer(object $pdo, string $name, string $license, string $teamId)
{
    try {
        $query = "INSERT INTO trainers (trainer_name, coaching_license, team_id) VALUES (:trainer_name, :coaching_license, :team_id)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':trainer_name', $name);
        $stmt->bindParam(':coaching_license', $license);
        $stmt->bindParam(':team_id', $teamId);
        $stmt->execute();

        // Assuming you want to return the inserted player's data
        $trainerId = $pdo->lastInsertId();
        $selectQuery = "SELECT trainers.*, teams.team_name 
                        FROM trainers 
                        LEFT JOIN teams ON trainers.team_id = teams.team_id
                        WHERE trainer_id = :trainer_id";
        $selectStmt = $pdo->prepare($selectQuery);
        $selectStmt->bindParam(':trainer_id', $trainerId);
        $selectStmt->execute();
        $insertedTrainer = $selectStmt->fetch(PDO::FETCH_ASSOC);

        return $insertedTrainer;
    } catch (PDOException $e) {
        // Handle the exception as needed
        die("Query Failed: " . $e->getMessage());
    }
}


function getName(object $pdo, string $name)
{
    $query = "SELECT trainer_name, trainer_id FROM trainers WHERE trainer_name = :trainer_name;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":trainer_name", $name);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}
