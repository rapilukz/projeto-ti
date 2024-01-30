<?php

declare(strict_types=1);

function getTeams(object $pdo)
{
    return getAllUsers($pdo);
}

function deleteTeam(object $pdo, string $id)
{
    deleteTeamById($pdo, $id);
}
