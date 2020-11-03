<?php
    header('Content-Type: application/json');

    require_once 'db.php';
    $dbh = new PDO($dsn, $username, $password, $options);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // $sql = 'SELECT event_date, feeder, time_from, time_to, timeocb, t_cause, t_component, group_type, IFNULL(relay_show,0) AS relay_show, IFNULL(pole,0) AS pole, IFNULL(road,0) AS road, IFNULL(lateral,0) AS lateral 
    //         FROM fdr_outage 
    //         WHERE fdr_outage_id is not null';

    // // check date range
    // $date = DateTime::createFromFormat('m/d/Y', "08/01/2018");
    // echo $date->format('Y-m-d');
    $date_from = date_create_from_format("m/d/Y",$_GET[dateFrom]);
    $date_to = date_create_from_format("m/d/Y",$_GET[dateTo]);

    if ($_GET[rankFeeder] == 'false') {// rankCause
        //no code here
        
    } else { //$_GET[rankFeeder == 'true'] // rankFeeder
        //check selected district    
        if ($_GET[district] > 0) {// select district
            
            $district = $_GET[district];
            
            // check interruption type
            if ($_GET[typeInterruption] === '0') {
                $int_type = ' AND timeocb <= 1 ';
            } elseif ($_GET[typeInterruption] === '1') {
                $int_type = ' AND timeocb > 1 ';
            }

            $sql = 'SELECT feederA AS feeder, outageCount, outageAndAffectedCount, outageAndAffectedCustnum, outageAndAffectedCustmin, affectedCount, affectedCustnum, affectedCustmin
                    FROM (
                        SELECT IFNULL(a.feeder, b.feeder) AS feederA, IFNULL(outageCount, 0) AS outageCount, IFNULL(b.feeder,a.feeder) AS feederB, IFNULL(outageAndAffectedCount, 0) AS outageAndAffectedCount, IFNULL(outageAndAffectedCustnum, 0) AS outageAndAffectedCustnum, IFNULL(outageAndAffectedCustmin, 0) AS outageAndAffectedCustmin, IFNULL(affectedCount, 0) AS affectedCount, IFNULL(affectedCustnum, 0) AS affectedCustnum, IFNULL(affectedCustmin, 0) AS affectedCustmin
                            FROM (
                                    SELECT feeder, COUNT(feeder) AS outageCount 
                                    FROM outage_event_db 
                                    WHERE date BETWEEN "'.date_format($date_from, "Y-m-d").'" AND "'.date_format($date_to, "Y-m-d").'" AND district = '.$district.' AND group_type = "F" AND event in("I", "O")'.$int_type.'
                                    GROUP BY feeder
                                 ) AS a
                                LEFT JOIN (
                                    SELECT feeder, SUM(IF(outgdist=custdist, 1, 0)) AS outageAndAffectedCount, ROUND(SUM(IF(outgdist=custdist, cust_num, 0))) AS outageAndAffectedCustnum, SUM(IF(outgdist=custdist, cust_min, 0)) AS outageAndAffectedCustmin, SUM(IF(outgdist<>custdist, 1, 0)) AS affectedCount, SUM(IF(outgdist<>custdist, cust_num, 0)) AS affectedCustnum, SUM(IF(outgdist<>custdist, cust_min, 0)) AS affectedCustmin
                                        FROM statistics_database.indices_db
                                        WHERE date BETWEEN "'.date_format($date_from, "Y-m-d").'" AND "'.date_format($date_to, "Y-m-d").'" AND custdist = '.$district.' AND group_type = "F" AND event in("I", "O")'.$int_type.'
                                        GROUP BY feeder
                                    ) AS b
                                ON a.feeder = b.feeder
                            UNION
                        SELECT IFNULL(a.feeder, b.feeder) AS feederA, IFNULL(outageCount, 0) AS outageCount, IFNULL(b.feeder,a.feeder) AS feederB, IFNULL(outageAndAffectedCount, 0) AS outageAndAffectedCount, IFNULL(outageAndAffectedCustnum, 0) AS outageAndAffectedCustnum, IFNULL(outageAndAffectedCustmin, 0) AS outageAndAffectedCustmin, IFNULL(affectedCount, 0) AS affectedCount, IFNULL(affectedCustnum, 0) AS affectedCustnum, IFNULL(affectedCustmin, 0) AS affectedCustmin
                            FROM (
                                    SELECT feeder, COUNT(feeder) AS outageCount 
                                    FROM outage_event_db 
                                    WHERE date BETWEEN "'.date_format($date_from, "Y-m-d").'" AND "'.date_format($date_to, "Y-m-d").'" AND district = '.$district.' AND group_type = "F" AND event in("I", "O")'.$int_type.'
                                    GROUP BY feeder
                                ) AS a
                                RIGHT JOIN (
                                    SELECT feeder, SUM(IF(outgdist=custdist, 1, 0)) AS outageAndAffectedCount, ROUND(SUM(IF(outgdist=custdist, cust_num, 0))) AS outageAndAffectedCustnum, SUM(IF(outgdist=custdist, cust_min, 0)) AS outageAndAffectedCustmin, SUM(IF(outgdist<>custdist, 1, 0)) AS affectedCount, SUM(IF(outgdist<>custdist, cust_num, 0)) AS affectedCustnum, SUM(IF(outgdist<>custdist, cust_min, 0)) AS affectedCustmin
                                        FROM statistics_database.indices_db
                                        WHERE date BETWEEN "'.date_format($date_from, "Y-m-d").'" AND "'.date_format($date_to, "Y-m-d").'" AND custdist = '.$district.' AND group_type = "F" AND event in("I", "O")'.$int_type.'
                                        GROUP BY feeder
                                    ) AS b
                                ON a.feeder = b.feeder
                            ) AS c
                    ORDER BY outageCount DESC';

        } else { // select all district
            
            // check interruption type
            if ($_GET[typeInterruption] === '0') {
                $int_type = ' AND timeocb <= 1 ';
            } elseif ($_GET[typeInterruption] === '1') {
                $int_type = ' AND timeocb > 1 ';
            }

            $sql = 'SELECT feederA AS feeder, outageCount, outageCustnum, outageCustmin
                    FROM (
                        SELECT IFNULL(a.feeder, b.feeder) AS feederA, IFNULL(outageCount, 0) AS outageCount, IFNULL(b.feeder,a.feeder) AS feederB, IFNULL(outageCustnum, 0) AS outageCustnum, IFNULL(outageCustmin, 0) AS outageCustmin
                        FROM (
                                SELECT feeder, COUNT(feeder) AS outageCount 
                                FROM statistics_database.outage_event_db 
                                WHERE date BETWEEN "'.date_format($date_from, "Y-m-d").'" AND "'.date_format($date_to, "Y-m-d").'" AND group_type = "F" AND event in("I", "O")'.$int_type.'
                                GROUP BY feeder
                            ) AS a
                            LEFT JOIN (
                                    SELECT feeder, ROUND(SUM(cust_num)) AS outageCustnum, SUM(cust_min) AS outageCustmin
                                    FROM statistics_database.indices_db
                                    WHERE date BETWEEN "'.date_format($date_from, "Y-m-d").'" AND "'.date_format($date_to, "Y-m-d").'" AND group_type = "F" AND event in("I", "O")'.$int_type.'
                                    GROUP BY feeder
                                ) AS b
                            ON a.feeder = b.feeder
                        UNION
                        SELECT IFNULL(a.feeder, b.feeder) AS feederA, IFNULL(outageCount, 0) AS outageCount, IFNULL(b.feeder,a.feeder) AS feederB, IFNULL(outageCustnum, 0) AS outageCustnum, IFNULL(outageCustmin, 0) AS outageCustmin
                        FROM (
                                SELECT feeder, COUNT(feeder) AS outageCount 
                                FROM statistics_database.outage_event_db 
                                WHERE date BETWEEN "'.date_format($date_from, "Y-m-d").'" AND "'.date_format($date_to, "Y-m-d").'" AND group_type = "F" AND event in("I", "O")'.$int_type.'
                                GROUP BY feeder
                            ) AS a
                            RIGHT JOIN (
                                    SELECT feeder, ROUND(SUM(cust_num)) AS outageCustnum, SUM(cust_min) AS outageCustmin
                                    FROM statistics_database.indices_db
                                    WHERE date BETWEEN "'.date_format($date_from, "Y-m-d").'" AND "'.date_format($date_to, "Y-m-d").'" AND group_type = "F" AND event in("I", "O")'.$int_type.'
                                    GROUP BY feeder
                                ) AS b
                            ON a.feeder = b.feeder
                        ) AS c
                    ORDER BY outageCount DESC;';

        }
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