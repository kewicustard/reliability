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

    $sql = 'SELECT a.date AS event_date, REPLACE(a.cb, " ", "") AS cb, a.time_from, c.t_cause, IFNULL(d.t_componen, "-") as t_component, IFNULL(a.relay, "-") AS relay_show, IFNULL(a.lateral, "-") AS lateral, SUM(IF(b.event<>"S", 1, 0)) AS affected_fdrs, SUM(IF(b.event<>"S", b.time_eq, 0)) AS fdr_minutes
            FROM statistics_database.outage_event_db a
                LEFT JOIN statistics_database.outage_event_db b
                    ON a.date = b.date AND a.time_from = b.time_from AND a.cb = b.cb
                LEFT JOIN statistics_database.nw_cause c
                    ON a.new_code = c.sub_code
                LEFT JOIN statistics_database.component d
                    ON a.component = d.code        
            WHERE a.group_type = "S" AND b.group_type = "S" AND a.event = "H" AND b.event in("I", "O", "S") AND a.cb LIKE "'.trim($_GET[station]).'%" AND a.date BETWEEN "'.date_format($date_from, "Y-m-d").'" AND "'.date_format($date_to, "Y-m-d").'" AND b.date BETWEEN "'.date_format($date_from, "Y-m-d").'" AND "'.date_format($date_to, "Y-m-d").'"
            GROUP BY event_date, time_from, cb
            ORDER BY event_date, time_from, cb';

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