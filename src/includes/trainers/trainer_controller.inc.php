<?php

declare(strict_types=1);

function isInputEmpty(string $name, string $license, string $team): bool
{
    return empty($name) || empty($license) || empty($team);
}

function deleteTrainer(object $pdo, string $id)
{
    deleteTrainerById($pdo, $id);
}

function getTeamId(object $pdo, string $team)
{
    return getTeam($pdo, $team);
}

function insertTrainerData(object $pdo, string $name, string $license, string $teamId)
{
    return insertTrainer($pdo, $name, $license, $teamId);
}


function nameIsTaken(object $pdo, string $name, $id)
{
    $result = getName($pdo, $name);

    if (is_array($result) && $result["trainer_id"] == $id && $result["trainer_name"] == $name) return false;

    if ($result) {
        return true;
    } else {
        return false;
    }
}


function updateTrainerData(object $pdo, string $id, string $name, string $license, string $teamId)
{
    updateTrainer($pdo, $id, $name, $license, $teamId);
}
