<?php
    header('Content-Type: application/json');

    require_once 'db.php';
    $dbh = new PDO($dsn, $username, $password, $options);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT table1.date, table1.new_month, table1.feeder, table1.time_from, table1.time_to, table1.timeocb, table1.time_eq, IFNULL(table2.to1,"-") AS to1, IFNULL(table2.to2,"-") AS to2, IFNULL(table2.to3,"-") AS to3, IFNULL(table2.to4,"-") AS to4, table4.tabb AS outgdist, table5.tabb AS custdist, table1.cust_num, table1.cust_min, table3.t_main, table3.t_cause 
            FROM statistics_database.indices_db AS table1
                INNER JOIN statistics_database.outage_event_db AS table2 ON table1.date = table2.date AND table1.time_from = table2.time_from AND table1.feeder = table2.feeder 
                INNER JOIN statistics_database.nw_cause AS table3 ON table1.new_code = table3.sub_code 
                INNER JOIN statistics_database.district AS table4 ON table1.outgdist = table4.code 
                INNER JOIN statistics_database.district AS table5 ON table1.custdist = table5.code 
            WHERE YEAR(table1.date) = ' .$_GET[selectedYear]. ' AND table1.group_type = "F" AND table1.timeocb > 1 AND table1.major is null';
    
    //check selected district    
    if ($_GET[selectedDistrict] > 0) {
        $sql .= ' AND table1.custdist = '.$_GET[selectedDistrict];
    }

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