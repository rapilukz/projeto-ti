<?php

declare(strict_types=1);

function isInputEmpty(string $name, string $year, string $country): bool
{
    return empty($name) || empty($year) || empty($country);
}


function getTeams(object $pdo)
{
    return getAllUsers($pdo);
}

function deleteTeam(object $pdo, string $id)
{
    deleteTeamById($pdo, $id);
}

function isTeamTaken(object $pdo, string $name, string $id)
{
    $result = getTeam($pdo, $name);

    if (is_array($result) && $result["team_id"] == $id && $result["team_name"] == $name) return false;

    if ($result) {
        return true;
    } else {
        return false;
    }
}

function updateTeamData(object $pdo, string $id, string $name, string $year, string $country)
{
    updateTeam($pdo, $id, $name, $year, $country);
}

function insertTeamData(object $pdo, string $name, string $year,  string $country)
{
    return insertTeam($pdo, $name, $year, $country);
}
