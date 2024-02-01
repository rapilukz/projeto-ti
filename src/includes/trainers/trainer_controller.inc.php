<?php

declare(strict_types=1);

function deleteTrainer(object $pdo, string $id)
{
    deleteTrainerById($pdo, $id);
}
