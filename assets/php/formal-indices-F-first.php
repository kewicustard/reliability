<?php
    header('Content-Type: application/json');

    require_once 'db.php';
    $dbh = new PDO($dsn, $username, $password, $options);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // official data
    $sql = 'SELECT max(date) AS lasted_date, min(date) AS initial_date FROM outage_event_db';

    try {
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Something wrong!!! '.$e->getMessage();
    }
    
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // unofficial data
    $sql = 'SELECT max(date) AS lasted_date15, min(date) AS initial_date15 FROM indices_db_15days';

    try {
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Something wrong!!! '.$e->getMessage();
    }
    
    $row2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($row2 as $key => $value) {
        $row[] = $value;
    }
    // print_r($row);

    $jsonData = json_encode($row);
    echo $jsonData;

    $dbh = null;
?>