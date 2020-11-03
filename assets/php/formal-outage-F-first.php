<?php
    header('Content-Type: application/json');

    require_once 'db.php';
    $dbh = new PDO($dsn, $username, $password, $options);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // $sql = 'SELECT event_date FROM fdr_outage ORDER BY event_date DESC LIMIT 1';
    $sql = 'SELECT date AS event_date FROM outage_event_db ORDER BY date DESC LIMIT 1';

    try {
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Something wrong!!! '.$e->getMessage();
    }
    
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $jsonData = json_encode($row);
    echo $jsonData;

    $dbh = null;
?>