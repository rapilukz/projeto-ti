<?php

declare(strict_types=1);


function getUsers(object $pdo)
{
    return getAllUsers($pdo);
}

function deleteUser(object $pdo, string $id)
{
    deleteUserById($pdo, $id);
}
