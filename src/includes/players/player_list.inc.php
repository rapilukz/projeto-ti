<?php

try {
    require_once '../dbconn.inc.php';
    require_once 'player_model.inc.php';
    require_once 'player_controller.inc.php';

    // Reading value
    $draw = $_POST['draw'];
    $row = $_POST['start'];
    $rowperpage = $_POST['length']; // Rows display per page
    $columnIndex = $_POST['order'][0]['column']; // Column index
    $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
    $searchValue = $_POST['search']['value']; // Search value
    $searchArray = array();

    // Search
    $searchQuery = " ";
    if ($searchValue != '') {
        $searchQuery = " AND (
               player_id LIKE :player_id OR 
               player_name LIKE :player_name OR
               position LIKE :position OR 
               birthdate LIKE :birthdate OR 
               team_name  LIKE :team_name ) ";



        $searchArray = array(
            'player_id' => "%$searchValue%",
            'player_name' => "%$searchValue%",
            'position' => "%$searchValue%",
            'birthdate' => "%$searchValue%",
            'team_name' => "%$searchValue%",
        );
    }

    // Total number of records without filtering
    $stmt = $pdo->prepare("SELECT COUNT(*) AS allcount FROM players ");
    $stmt->execute();
    $records = $stmt->fetch();
    $totalRecords = $records['allcount'];

    // Total number of records with filtering
    $stmt = $pdo->prepare("SELECT COUNT(*) AS allcount FROM players LEFT JOIN teams ON players.team_id = teams.team_id WHERE 1 " . $searchQuery);
    $stmt->execute($searchArray);
    $records = $stmt->fetch();
    $totalRecordwithFilter = $records['allcount'];

    // Fetch records
    $stmt = $pdo->prepare("SELECT *, teams.team_name 
                    FROM players 
                    LEFT JOIN teams ON players.team_id = teams.team_id
                    WHERE 1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset");

    // Bind values
    foreach ($searchArray as $key => $search) {
        $stmt->bindValue(':' . $key, $search, PDO::PARAM_STR);
    }

    $stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
    $stmt->execute();
    $empRecords = $stmt->fetchAll();

    $data = array();

    foreach ($empRecords as $row) {
        $data[] = array(
            "player_id" => $row['player_id'],
            "player_name" => $row['player_name'],
            "position" => $row['position'],
            "birthdate" => $row['birthdate'],
            "team_id" => $row['team_id'],
            "team_name" => $row['team_name'],
        );
    }


    // Response
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
    );

    header('Content-Type: application/json');
    echo json_encode($response);
} catch (PDOException $e) {
    die("Query Failed: " . $e->getMessage());
}
