<?php

try {
    require_once '../dbconn.inc.php';
    require_once 'team_model.inc.php';
    require_once 'team_controller.inc.php';


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
           team_id LIKE :team_id OR 
           team_name LIKE :team_name OR
           foundation_year LIKE :foundation_year OR 
           country LIKE :country) ";



        $searchArray = array(
            'team_id' => "%$searchValue%",
            'team_name' => "%$searchValue%",
            'foundation_year' => "%$searchValue%",
            'country' => "%$searchValue%",
        );
    }

    // Total number of records without filtering
    $stmt = $pdo->prepare("SELECT COUNT(*) AS allcount FROM teams ");
    $stmt->execute();
    $records = $stmt->fetch();
    $totalRecords = $records['allcount'];

    // Total number of records with filtering
    $stmt = $pdo->prepare("SELECT COUNT(*) AS allcount FROM teams WHERE 1 " . $searchQuery);
    $stmt->execute($searchArray);
    $records = $stmt->fetch();
    $totalRecordwithFilter = $records['allcount'];

    // Fetch records
    $stmt = $pdo->prepare("SELECT * FROM teams WHERE 1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset");

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
            "team_id" => $row['team_id'],
            "team_name" => $row['team_name'],
            "foundation_year" => $row['foundation_year'],
            "country" => $row['country'],
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
