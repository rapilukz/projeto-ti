<?php

try {
    require_once '../dbconn.inc.php';
    require_once 'team_model.inc.php';
    require_once 'team_controller.inc.php';

    $teams = getTeams($pdo);

    header('Content-Type: application/json');
    echo json_encode($teams);
} catch (PDOException $e) {
    die("Query Failed: " . $e->getMessage());
}
