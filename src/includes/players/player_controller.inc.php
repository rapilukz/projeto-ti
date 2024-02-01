<?php

declare(strict_types=1);


function deletePlayer(object $pdo, string $id)
{
    deletePlayerById($pdo, $id);
}

function getTeams(object $pdo)
{
    return getAllTeams($pdo);
}


function getTeamId(object $pdo, string $team)
{
    return getTeam($pdo, $team);
}

function insertPlayerData(object $pdo, string $name, string $position, string $birthdate, string $teamId)
{
    return insertPlayer($pdo, $name, $position, $birthdate, $teamId);
}

function isInputEmpty(string $name, string $position, string $birthdate, string $team): bool
{
    return empty($name) || empty($position) || empty($birthdate) || empty($team);
}

function nameIsTaken(object $pdo, string $name, $id)
{
    $result = getName($pdo, $name);

    if (is_array($result) && $result["player_id"] == $id && $result["player_name"] == $name) return false;

    if ($result) {
        return true;
    } else {
        return false;
    }
}


function updatePlayerData(object $pdo, string $id, string $name, string $position, string $birthdate, $teamId)
{
    updatePlayer($pdo, $id, $name, $position, $birthdate, $teamId);
}
