<?php

declare(strict_types=1);


function deleteTrainerById(object $pdo, string $id)
{
    $query = "DELETE from trainers where trainer_id = :trainer_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":trainer_id", $id);
    $stmt->execute();
}
