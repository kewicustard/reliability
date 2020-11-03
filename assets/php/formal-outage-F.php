<?php
    header('Content-Type: application/json');

    require_once 'db.php';
    $dbh = new PDO($dsn, $username, $password, $options);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // // check date range
    // $date = DateTime::createFromFormat('m/d/Y', "08/01/2018");
    // echo $date->format('Y-m-d');
    $date_from = date_create_from_format("m/d/Y",$_GET[dateFrom]);
    $date_to = date_create_from_format("m/d/Y",$_GET[dateTo]);
    $year_threshold = 2020;
    $date_from_new = date_create($year_threshold."-01-01");
    $date_to_old = date_create(($year_threshold-1)."-12-31");

    if (intval(substr($_GET[dateFrom], -4)) < $year_threshold) {
        $sql = 'SELECT event_date, feeder, time_from, time_to, timeocb, t_cause, t_component, group_type, IFNULL(relay_show,"-") AS relay_show, IFNULL(pole,"-") AS pole, IFNULL(road,"-") AS road, IFNULL(lateral,"-") AS lateral 
            FROM fdr_outage 
            WHERE event_date BETWEEN "'.date_format($date_from, "Y-m-d").'" AND "';

        if (intval(substr($_GET[dateTo], -4)) < $year_threshold) {
            $sql .= date_format($date_to, "Y-m-d").'"';

        } else {// intval(substr($_GET[dateTo], -4)) >= $year_threshold
            $sql .= date_format($date_to_old, "Y-m-d").'"';

            $sql2 = 'SELECT a.date AS event_date, a.feeder, a.time_from, a.time_to, a.timeocb, b.t_cause, IFNULL(c.t_componen, "-") AS t_component, a.group_type, IFNULL(a.relay,"-") AS relay_show, IFNULL(a.pole,"-") AS pole, IFNULL(a.road,"-") AS road, IFNULL(a.lateral,"-") AS lateral 
                FROM outage_event_db a
                    LEFT JOIN nw_cause b
                        ON a.new_code = b.sub_code
                    LEFT JOIN component c
                        ON a.component = c.code
                WHERE a.date BETWEEN "'.date_format($date_from_new, "Y-m-d").'" AND "'.date_format($date_to, "Y-m-d").'"';
        }
        
    } else { // intval(substr($_GET[dateTo], -4)) >= $year_threshold
        $sql = 'SELECT a.date AS event_date, a.feeder, a.time_from, a.time_to, a.timeocb, b.t_cause, IFNULL(c.t_componen, "-") AS t_component, a.group_type, IFNULL(a.relay,"-") AS relay_show, IFNULL(a.pole,"-") AS pole, IFNULL(a.road,"-") AS road, IFNULL(a.lateral,"-") AS lateral 
            FROM outage_event_db a
                LEFT JOIN nw_cause b
                    ON a.new_code = b.sub_code
                LEFT JOIN component c
                    ON a.component = c.code
            WHERE a.date BETWEEN "'.date_format($date_from, "Y-m-d").'" AND "'.date_format($date_to, "Y-m-d").'"';
    }
    
    // check selectd feeder search or district search        
    if (empty($_GET[selectedForD])) { // feeder search
        $sql .= ' AND feeder LIKE "'.trim($_GET[feeder]).'%"';
        if (isset($sql2)) {
            $sql2 .= ' AND feeder LIKE "'.trim($_GET[feeder]).'%"';
        }
    } // district search hasn't code.
    
    //check selected district    
    if ($_GET[district] > 0) {
        $sql .= ' AND district = '.$_GET[district];
        if (isset($sql2)) {
            $sql2 .= ' AND district = '.$_GET[district];
        }
    }

    // check outage system
    if ($_GET[outageSystem] === 'LS') {
        $sql .= ' AND group_type in("L", "S") AND event IN("I", "O")';
        if (isset($sql2)) {
            $sql2 .= ' AND group_type in("L", "S")';
        }
    } elseif ($_GET[outageSystem] === 'F') {
        $sql .= ' AND group_type = "F"';
        if (isset($sql2)) {
            $sql2 .= ' AND group_type = "F"';
        }
    }
    

    // check interruption type
    if ($_GET[typeInterruption] === '0') {
        $sql .= ' AND timeocb <= 1';
        if (isset($sql2)) {
            $sql2 .= ' AND timeocb <= 1';
        }
    } elseif ($_GET[typeInterruption] === '1') {
        $sql .= ' AND timeocb > 1';
        if (isset($sql2)) {
            $sql2 .= ' AND timeocb > 1';
        }
    }

    try {
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Something wrong!!! '.$e->getMessage();
    }
  
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetchAll for convertint from PDO data object to array

    if (isset($sql2)) {
        try {
            $stmt = $dbh->prepare($sql2);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }

        $row2 = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetchAll for convertint from PDO data object to array
        
        foreach ($row2 as $key => $value) {
            $row[] = $value;
        }
    }

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