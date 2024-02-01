<?php

try {
    require_once '../dbconn.inc.php';
    require_once 'trainer_model.inc.php';
    require_once 'trainer_controller.inc.php';

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
               trainer_id LIKE :trainer_id OR 
               trainer_name LIKE :trainer_name OR
               coaching_license LIKE :coaching_license OR 
               team_name  LIKE :team_name ) ";



        $searchArray = array(
            'trainer_id' => "%$searchValue%",
            'trainer_name' => "%$searchValue%",
            'coaching_license' => "%$searchValue%",
            'team_name' => "%$searchValue%",
        );
    }

    // Total number of records without filtering
    $stmt = $pdo->prepare("SELECT COUNT(*) AS allcount FROM trainers ");
    $stmt->execute();
    $records = $stmt->fetch();
    $totalRecords = $records['allcount'];

    // Total number of records with filtering
    $stmt = $pdo->prepare("SELECT COUNT(*) AS allcount FROM trainers LEFT JOIN teams ON trainers.team_id = teams.team_id WHERE 1 " . $searchQuery);
    $stmt->execute($searchArray);
    $records = $stmt->fetch();
    $totalRecordwithFilter = $records['allcount'];

    // Fetch records
    $stmt = $pdo->prepare("SELECT *, teams.team_name 
                    FROM trainers 
                    LEFT JOIN teams ON trainers.team_id = teams.team_id
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
            "trainer_id" => $row['trainer_id'],
            "trainer_name" => $row['trainer_name'],
            "coaching_license" => $row['coaching_license'],
            "team_id" => $row['team_id'],
            "team_name" => $row['team_name']
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
