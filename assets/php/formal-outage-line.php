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
        $sql = 'SELECT event_date, line, time_from, time_to, timeocb, t_cause, t_component, IFNULL(relay_show, "-") as relay_show, IFNULL(pole, "-") as pole, IFNULL(road, "-") as road, IFNULL(lateral, "-") as lateral, affected_fdrs, fdr_minutes 
            FROM lineoutage 
            WHERE line LIKE "'.trim($_GET[line]).'%" AND event_date BETWEEN "'.date_format($date_from, "Y-m-d").'" AND "';
        if (intval(substr($_GET[dateTo], -4)) < $year_threshold) {
            $sql .= date_format($date_to, "Y-m-d").'"';

            try {
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Something wrong!!! '.$e->getMessage();
            }

            $row = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetchAll for convertint from PDO data object to array

        } else {// intval(substr($_GET[dateTo], -4)) >= $year_threshold
            $sql .= date_format($date_to_old, "Y-m-d").'"';

            try {
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Something wrong!!! '.$e->getMessage();
            }

            $row = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetchAll for convertint from PDO data object to array

            $sql2 = 'SELECT a.date AS event_date, a.line, a.time_from, MIN(a.time_to) AS time_to, MIN(a.timeocb) AS timeocb, c.t_cause, IFNULL(d.t_componen, "-") AS t_component, IFNULL(a.relay, "-") AS relay_show, IFNULL(a.pole, "-") AS pole, IFNULL(a.road, "-") AS road, IFNULL(a.lateral, "-") AS lateral, SUM(IF(b.event<>"S", 1, 0)) AS affected_fdrs, SUM(IF(b.event<>"S", b.time_eq, 0)) AS fdr_minutes
                FROM outage_event_db a
                    LEFT JOIN outage_event_db b
                        ON a.date = b.date AND a.time_from = b.time_from AND a.line = b.line AND a.cb = b.cb
                    LEFT JOIN nw_cause c
                        ON a.new_code = c.sub_code
                    LEFT JOIN component d
                        ON a.component = d.code
                WHERE a.group_type = "L" and b.group_type = "L" and a.event = "H" AND b.event in("I", "O", "S") AND a.line LIKE "'.trim($_GET[line]).'%" AND a.date BETWEEN "'.date_format($date_from_new, "Y-m-d").'" AND "'.date_format($date_to, "Y-m-d").'" AND b.date BETWEEN "'.date_format($date_from_new, "Y-m-d").'" AND "'.date_format($date_to, "Y-m-d").'" 
                GROUP BY event_date, time_from, line
                ORDER BY event_date, time_from, line';

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
        
        
    } else { // intval(substr($_GET[dateFrom], -4)) >= $year_threshold
        $sql = 'SELECT a.date AS event_date, a.line, a.time_from, MIN(a.time_to) AS time_to, MIN(a.timeocb) AS timeocb, c.t_cause, IFNULL(d.t_componen, "-") AS t_component, IFNULL(a.relay, "-") AS relay_show, IFNULL(a.pole, "-") AS pole, IFNULL(a.road, "-") AS road, IFNULL(a.lateral, "-") AS lateral, SUM(IF(b.event<>"S", 1, 0)) AS affected_fdrs, SUM(IF(b.event<>"S", b.time_eq, 0)) AS fdr_minutes
            FROM outage_event_db a
                LEFT JOIN outage_event_db b
                    ON a.date = b.date AND a.time_from = b.time_from AND a.line = b.line AND a.cb = b.cb
                LEFT JOIN nw_cause c
                    ON a.new_code = c.sub_code
                LEFT JOIN component d
                    ON a.component = d.code
            WHERE a.group_type = "L" and b.group_type = "L" and a.event = "H" AND b.event in("I", "O", "S") AND a.line LIKE "'.trim($_GET[line]).'%" AND a.date BETWEEN "'.date_format($date_from, "Y-m-d").'" AND "'.date_format($date_to, "Y-m-d").'" AND b.date BETWEEN "'.date_format($date_from, "Y-m-d").'" AND "'.date_format($date_to, "Y-m-d").'" 
            GROUP BY event_date, time_from, line
            ORDER BY event_date, time_from, line';

        try {
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetchAll for convertint from PDO data object to array
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