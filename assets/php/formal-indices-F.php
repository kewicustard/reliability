<?php
    header('Content-Type: application/json');

    require_once 'db.php';
    $dbh = new PDO($dsn, $username, $password, $options);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // $sql = 'SELECT event_date, feeder, time_from, time_to, timeocb, t_cause, t_component, group_type, IFNULL(relay_show,"-") AS relay_show, IFNULL(pole,"-") AS pole, IFNULL(road,"-") AS road, IFNULL(lateral,"-") AS lateral 
    //         FROM fdr_outage 
    //         WHERE fdr_outage_id is not null';

    if ($_GET[unofficialData] == 'false') {
        $sql = 'SELECT table1.date, table1.new_month, table1.feeder, table1.time_from, table1.time_to, table1.timeocb, table1.time_eq, IFNULL(table2.to1,"-") AS to1, IFNULL(table2.to2,"-") AS to2, IFNULL(table2.to3,"-") AS to3, IFNULL(table2.to4,"-") AS to4, table4.tabb AS outgdist, table5.tabb AS custdist, table1.cust_num, table1.cust_min, table3.t_main, table3.t_cause, table6.t_componen, IFNULL(table1.lateral,"-") AS lateral, IFNULL(table1.relay,"-") AS relay, table1.control  
        FROM statistics_database.indices_db AS table1
            INNER JOIN statistics_database.outage_event_db AS table2 ON table1.date = table2.date AND table1.time_from = table2.time_from AND table1.feeder = table2.feeder 
            INNER JOIN statistics_database.nw_cause AS table3 ON table1.new_code = table3.sub_code 
            INNER JOIN statistics_database.district AS table4 ON table1.outgdist = table4.code 
            INNER JOIN statistics_database.district AS table5 ON table1.custdist = table5.code 
            LEFT JOIN statistics_database.component AS table6 ON table1.component <=> table6.code 
            WHERE table1.group_type = "F" AND table1.major is null';
    } else { //$_GET[unoffcialData == 'true']
        $sql = 'SELECT table1.date, table1.new_month, table1.feeder, table1.time_from, table1.time_to, table1.timeocb, table1.time_eq, IFNULL(table2.to1,"-") AS to1, IFNULL(table2.to2,"-") AS to2, IFNULL(table2.to3,"-") AS to3, IFNULL(table2.to4,"-") AS to4, table4.tabb AS outgdist, table5.tabb AS custdist, table1.cust_num, table1.cust_min, table3.t_main, table3.t_cause, table6.t_componen, IFNULL(table1.lateral,"-") AS lateral, IFNULL(table1.relay,"-") AS relay, table1.control  
        FROM statistics_database.indices_db_15days AS table1
            INNER JOIN statistics_database.outage_event_db_15days AS table2 ON table1.date = table2.date AND table1.time_from = table2.time_from AND table1.feeder = table2.feeder 
            INNER JOIN statistics_database.nw_cause AS table3 ON table1.new_code = table3.sub_code 
            INNER JOIN statistics_database.district AS table4 ON table1.outgdist = table4.code 
            INNER JOIN statistics_database.district AS table5 ON table1.custdist = table5.code 
            LEFT JOIN statistics_database.component AS table6 ON table1.component <=> table6.code 
            WHERE table1.group_type = "F" AND table1.major is null';
    }
    
    // // check selectd feeder search or district search        
    // if (empty($_GET[selectedForD])) { // feeder search
    //     $sql .= ' AND feeder LIKE "'.$_GET[feeder].'%"';
    // } // district search hasn't code.
    
    //check selected district    
    if ($_GET[district] > 0) {
        $sql .= ' AND table1.custdist = '.$_GET[district];
    }

    // check outage system
    // if ($_GET[outageSystem] === 'LS') {
    //     $sql .= ' AND group_type in("L", "S")';
    // } elseif ($_GET[outageSystem] === 'F') {
    //     $sql .= ' AND group_type = "F"';
    // }

    // check interruption type
    if ($_GET[typeInterruption] === '0') {
        $sql .= ' AND table1.timeocb <= 1';
    } elseif ($_GET[typeInterruption] === '1') {
        $sql .= ' AND table1.timeocb > 1';
    }

    // // check date range
    // $date = DateTime::createFromFormat('m/d/Y', "08/01/2018");
    // echo $date->format('Y-m-d');
    $date_from = date_create_from_format("m/d/Y",$_GET[dateFrom]);
    $date_to = date_create_from_format("m/d/Y",$_GET[dateTo]);
    $sql .= ' AND table1.date BETWEEN "'.date_format($date_from, "Y-m-d").'" AND "'.date_format($date_to, "Y-m-d").'"';

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