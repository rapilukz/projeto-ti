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
