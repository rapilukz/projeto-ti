<?php

try {
    require_once '../dbconn.inc.php';
    require_once 'user_model.inc.php';
    require_once 'user_controller.inc.php';

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
               user_id LIKE :user_id OR 
               username LIKE :username OR
               email LIKE :email OR 
               role LIKE :role OR 
               birthdate LIKE :birthdate) ";



        $searchArray = array(
            'user_id' => "%$searchValue%",
            'username' => "%$searchValue%",
            'email' => "%$searchValue%",
            'role' => "%$searchValue%",
            'birthdate' => "%$searchValue%",
        );
    }

    // Total number of records without filtering
    $stmt = $pdo->prepare("SELECT COUNT(*) AS allcount FROM users ");
    $stmt->execute();
    $records = $stmt->fetch();
    $totalRecords = $records['allcount'];

    // Total number of records with filtering
    $stmt = $pdo->prepare("SELECT COUNT(*) AS allcount FROM users WHERE 1 " . $searchQuery);
    $stmt->execute($searchArray);
    $records = $stmt->fetch();
    $totalRecordwithFilter = $records['allcount'];

    // Fetch records
    $stmt = $pdo->prepare("SELECT * FROM users WHERE 1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset");

    // Bind values
    foreach ($searchArray as $key => $search) {
        $stmt->bindValue(':' . $key, $search, PDO::PARAM_STR);
    }

    $stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
    $stmt->execute();
    $empRecords = $stmt->fetchAll();

    $data = array();

    // Check if $_SESSION["user_id"] is in the list of users
    session_start();
    $loggedInUserId = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;

    foreach ($empRecords as $row) {
        $data[] = array(
            "user_id" => $row['user_id'],
            "username" => $row['username'],
            "email" => $row['email'],
            "birthdate" => $row['birthdate'],
            "role" => $row['role'],
            "same_user" => $loggedInUserId == $row['user_id'] ? true : false
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
