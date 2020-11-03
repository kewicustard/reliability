<?php
    header('Content-Type: application/json');

    require_once 'db.php';
    $dbh = new PDO($dsn, $username, $password, $options);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT event_date, feeder, time_from, time_to, timeocb, t_cause, t_component, group_type, IFNULL(relay_show,"-") AS relay_show, IFNULL(pole,"-") AS pole, IFNULL(road,"-") AS road, IFNULL(lateral,"-") AS lateral 
            FROM fdr_outage 
            WHERE fdr_outage_id is not null';
    
    // check selectd feeder search or district search        
    if (empty($_GET[selectedForD])) { // feeder search
        $sql .= ' AND feeder LIKE "'.$_GET[feeder].'%"';
    } // district search hasn't code.
    
    //check selected district    
    if ($_GET[district] > 0) {
        $sql .= ' AND district = '.$_GET[district];
    }

    // check outage system
    if ($_GET[outageSystem] === 'LS') {
        $sql .= ' AND group_type in("L", "S")';
    } elseif ($_GET[outageSystem] === 'F') {
        $sql .= ' AND group_type = "F"';
    }

    // check interruption type
    if ($_GET[typeInterruption] === '0') {
        $sql .= ' AND timeocb <= 1';
    } elseif ($_GET[typeInterruption] === '1') {
        $sql .= ' AND timeocb > 1';
    }

    // // check date range
    // $date = DateTime::createFromFormat('m/d/Y', "08/01/2018");
    // echo $date->format('Y-m-d');
    $date_from = date_create_from_format("m/d/Y",$_GET[dateFrom]);
    $date_to = date_create_from_format("m/d/Y",$_GET[dateTo]);
    $sql .= ' AND event_date BETWEEN "'.date_format($date_from, "Y-m-d").'" AND "'.date_format($date_to, "Y-m-d").'"';

    try {
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Something wrong!!! '.$e->getMessage();
    }
  
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetchAll for convertint from PDO data object to array
    $jsonData = json_encode($row);
    echo $jsonData;
    // print_r($row);
    // echo '<br>';
    // print_r($jsonData);
    // echo '<br>';
    // print_r(json_decode($jsonData));
    // echo $jsonData;

    $dbh = null;
?>