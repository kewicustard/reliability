<?php
    header('Content-Type: application/json');

    require_once 'db.php';
    $dbh = new PDO($dsn, $username, $password, $options);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // $sql = 'SELECT event_date, feeder, time_from, time_to, timeocb, t_cause, t_component, group_type, IFNULL(relay_show,"-") AS relay_show, IFNULL(pole,"-") AS pole, IFNULL(road,"-") AS road, IFNULL(lateral,"-") AS lateral 
    //         FROM fdr_outage 
    //         WHERE fdr_outage_id is not null';

    // // check date range
    // $date = DateTime::createFromFormat('m/d/Y', "08/01/2018");
    // echo $date->format('Y-m-d');
    $date_from = date_create_from_format("m/d/Y",$_GET[dateFrom]);
    $date_to = date_create_from_format("m/d/Y",$_GET[dateTo]);

    if ($_GET[rankFeeder] == 'false') {// rankCause
        //check selected district    
        if ($_GET[district] > 0) {// select district
            $district = $_GET[district];
            $sql = 'SELECT a.t_main AS main_cause, 
                        SUM(IF(b.date=c.date AND b.time_from=c.time_from AND b.feeder=c.feeder AND b.district=c.outgdist AND b.district='.$district.', 1, 0)) AS outageCount, 
                        SUM(IF(b.date=c.date AND b.time_from=c.time_from AND b.feeder=c.feeder AND c.outgdist=c.custdist AND c.outgdist='.$district.', 1, 0)) AS outageAndAffectedCount, 
                        ROUND(SUM(IF(b.date=c.date AND b.time_from=c.time_from AND b.feeder=c.feeder AND c.outgdist=c.custdist AND c.outgdist='.$district.', c.cust_num, 0))) AS outageAndAffectedCustnum, 
                        SUM(IF(b.date=c.date AND b.time_from=c.time_from AND b.feeder=c.feeder AND c.outgdist=c.custdist AND c.outgdist='.$district.', c.cust_min, 0)) AS outageAndAffectedCustmin, 
                        SUM(IF(b.date=c.date AND b.time_from=c.time_from AND b.feeder=c.feeder AND c.outgdist<>c.custdist AND c.custdist='.$district.', 1, 0)) AS affectedCount,
                        ROUND(SUM(IF(b.date=c.date AND b.time_from=c.time_from AND b.feeder=c.feeder AND c.outgdist<>c.custdist AND c.custdist='.$district.', c.cust_num, 0))) AS affectedCustnum,
                        SUM(IF(b.date=c.date AND b.time_from=c.time_from AND b.feeder=c.feeder AND c.outgdist<>c.custdist AND c.custdist='.$district.', c.cust_min, 0)) AS affectedCustmin
                    FROM nw_cause a
                        LEFT JOIN outage_event_db b
                            ON a.sub_code = b.new_code
                        LEFT JOIN indices_db c
                            ON a.sub_code = c.new_code
                    WHERE b.date BETWEEN "'.date_format($date_from, "Y-m-d").'" AND "'.date_format($date_to, "Y-m-d").'" 
                        AND c.date BETWEEN "'.date_format($date_from, "Y-m-d").'" AND "'.date_format($date_to, "Y-m-d").'" 
                        AND b.group_type = "F" AND c.group_type = "F" 
                        AND b.event IN("I", "O") AND c.event IN("I", "O") 
                        AND (c.outgdist = '.$district.' OR c.custdist = '.$district.')';

            // check interruption type
            if ($_GET[typeInterruption] === '0') {
                $sql .= ' AND b.timeocb <= 1 AND c.timeocb <= 1';
            } elseif ($_GET[typeInterruption] === '1') {
                $sql .= ' AND b.timeocb > 1 AND c.timeocb > 1';
            }

            $sql .= ' GROUP BY main_cause 
                    HAVING outageCount > 0 OR outageAndAffectedCount > 0 OR AffectedCount > 0
                    ORDER BY outageCount DESC';

        } else { // select all district
            $sql1 = 'SELECT b.code, b.t_main AS main_cause, count(*) AS outageCount
                        FROM outage_event_db a 
                            LEFT JOIN nw_cause b
                                ON a.new_code = b.sub_code
                        WHERE a.date BETWEEN "'.date_format($date_from, "Y-m-d").'" AND "'.date_format($date_to, "Y-m-d").'" 
                            AND a.group_type = "F" AND a.event in("I", "O")';
            $sql2 = 'SELECT b.code, b.t_main AS main_cause, sum(cust_num) AS outageCustnum, sum(cust_min) AS outageCustmin
                        FROM indices_db a
                            LEFT JOIN nw_cause b
                                ON a.new_code = b.sub_code
                        WHERE a.date BETWEEN "'.date_format($date_from, "Y-m-d").'" AND "'.date_format($date_to, "Y-m-d").'" 
                            AND a.group_type = "F" AND a.event in("I", "O")';
            
            // check interruption type
            if ($_GET[typeInterruption] === '0') {
                $sql1 .= ' AND a.timeocb <= 1 GROUP BY main_cause';
                $sql2 .= ' AND a.timeocb <= 1 GROUP BY main_cause';
            } elseif ($_GET[typeInterruption] === '1') {
                $sql1 .= ' AND a.timeocb > 1 GROUP BY main_cause';
                $sql2 .= ' AND a.timeocb > 1 GROUP BY main_cause';
            }

            $sql = 'SELECT a.main_cause, a.outageCount, ROUND(b.outageCustnum) AS outageCustnum, b.outageCustmin
                    FROM (	
                            '.$sql1.'
                        ) AS a
                        JOIN (	
                            '.$sql2.'    
                            ) AS b
                            ON a.code = b.code';

            $sql .= ' ORDER BY outageCount DESC';

        }
        
    } else { //$_GET[unoffcialData == 'true']
        //no code here
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