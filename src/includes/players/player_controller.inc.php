<?php

declare(strict_types=1);


function deletePlayer(object $pdo, string $id)
{
    deletePlayerById($pdo, $id);
}
