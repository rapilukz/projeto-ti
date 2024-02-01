<?php

declare(strict_types=1);


function deletePlayerById(object $pdo, string $id)
{
    $query = "DELETE from players where player_id = :player_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":player_id", $id);
    $stmt->execute();
}
