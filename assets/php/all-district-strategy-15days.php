<?php
    header('Content-Type: application/json');

    require_once 'db.php';
    $dbh = new PDO($dsn, $username, $password, $options);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $selectedYear = $_GET[selectedYear];
    $selectedDistrictValue = $_GET[selectedDistrictValue];
    $target = (int) $_GET[checkTarget]; // 1 has target for that year.

    // district code
    {
        $sql = 'SELECT tabb FROM district WHERE code BETWEEN 1 AND 18';
        try {
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tabb[] = $row[tabb];
        }
        // print_r($tabb);
    }
    // /district code

    if ($target == 1) { // 1 has target for that year.
        // Target
        $sql = 'SELECT month(yearmonthnumbertarget) AS data_month, districtCode, 
        saifi_target_5 AS saifi_5, saidi_target_5 AS saidi_5 
        FROM eachdisttarget 
        WHERE yearmonthnumbertarget BETWEEN "'.$selectedYear.'-01-01" AND "'.$selectedYear.'-12-01"';

        try {
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        } catch (PDOException $e) {
        echo 'Something wrong!!! '.$e->getMessage();
        }

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // saifi_target and saidi_target [รหัสเขต][เกณฑ์คะแนน5][ค่าเกณฑ์แต่ละเดือน]
        $saifi_target[$row[districtCode]][saifi_5][] = $row[saifi_5];
        $saidi_target[$row[districtCode]][saidi_5][] = $row[saidi_5];
        }
        // print_r($saifi_target);
        // print_r($saidi_target);
        // /Target
    }

    // check lasted month of indices_db_15days table
    {
        $sql = 'SELECT max(month(date)) AS lasted_month 
                    FROM indices_db_15days 
                    WHERE year(date) = "'.$selectedYear.'"';

        try {
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $lasted_month = $row[0][lasted_month];
        // echo($lasted_month);
    }
    // /check lasted month of indices_db_15days table

    // check lasted day of lasted month of indices_db_15,30days table
    {
        $sql = 'SELECT max(day(date)) AS lasted_day 
                    FROM indices_db_15days 
                    WHERE year(date) = "'.$selectedYear.'" and month(date) = "'.$lasted_month.'"';

        try {
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $lasted_day = $row[0][lasted_day];
        settype($lasted_day, "float");
        // echo(type($lasted_day);
        // echo(gettype($lasted_day));
    }
    // /check lasted day of lasted month of indices_db_15,30days table

    if ($lasted_day >= 28) {
        // accuDistCust and eachDistCust customer
        {
            $sql = 'SELECT district, month AS data_month, nocus AS dist_cust_month FROM discust WHERE district != 99 and year = '.$selectedYear.' and month <= '.$lasted_month;
            try {
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Something wrong!!! '.$e->getMessage();
            }

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($row[data_month] == "1") {
                    $eachDistCust[$row[district]][$row[data_month]-1] = $row[dist_cust_month];
                    $accuDistCust[$row[district]][$row[data_month]-1] = $row[dist_cust_month];
                } else {
                    $eachDistCust[$row[district]][$row[data_month]-1] = $row[dist_cust_month];
                    $accuDistCust[$row[district]][$row[data_month]-1] = $accuDistCust[$row[district]][$row[data_month]-2]+$row[dist_cust_month];
                }
            }
            // print_r($eachDistCust);
            // print_r($accuDistCust);
        }
        // /accuDistCust customer
    } else { //$lasted_day <= 15
        // accuDistCust and eachDistCust customer
        {
            if ($lasted_month == 1) {
                $sql = 'SELECT district, month AS data_month, nocus AS dist_cust_month FROM discust WHERE district != 99 and year = '.($selectedYear-1).' and month = 12';
            } else {
                $sql = 'SELECT district, month AS data_month, nocus AS dist_cust_month FROM discust WHERE district != 99 and year = '.$selectedYear.' and month < '.$lasted_month;
            }

            try {
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Something wrong!!! '.$e->getMessage();
            }

            if ($lasted_month == 1) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $eachDistCust[$row[district]][0] = $row[dist_cust_month];
                    $accuDistCust[$row[district]][0] = $row[dist_cust_month];
                }
            } else {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    if ($row[data_month] == "1") {
                        $eachDistCust[$row[district]][$row[data_month]-1] = $row[dist_cust_month];
                        $accuDistCust[$row[district]][$row[data_month]-1] = $row[dist_cust_month];
                    } else {
                        $eachDistCust[$row[district]][$row[data_month]-1] = $row[dist_cust_month];
                        $accuDistCust[$row[district]][$row[data_month]-1] = $accuDistCust[$row[district]][$row[data_month]-2]+$row[dist_cust_month];
                    }
                }
            }

            // print_r($eachDistCust);
            // print_r($accuDistCust);

            if ($lasted_month > 1) {
                for ($i=1; $i<=18 ; $i++) { 
                    $eachDistCust[$i][$lasted_month-1] = $eachDistCust[$i][$lasted_month-2];
                    $accuDistCust[$i][$lasted_month-1] = $accuDistCust[$i][$lasted_month-2]+$eachDistCust[$i][$lasted_month-1];
                }
            }
            
            // print_r($eachDistCust);
            // print_r($accuDistCust);
        }
        // /accuDistCust customer
    }

    // sum_cust_num and sum_cust_min
    {
        // official indices of previous month
        $sql = 'SELECT custdist, month(date) AS data_month, sum(cust_num) AS sum_cust_num, sum(cust_min) AS sum_cust_min
                FROM indices_db 
                WHERE timeocb > 1 
                    AND event in("i", "o") 
                    AND group_type = "f" 
                    AND major is null 
                    AND year(date) = "'.$selectedYear.'" 
                    AND month(date) < "'.$lasted_month.'" 
                    GROUP BY custdist, month(date)';

        try {
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // print_r($row);

        $no_district = 18;
        $no_month = count($eachDistCust[1])-1;
        $count_row = 0;
        for ($i = 1; $i <= $no_district; $i++) { 
            for ($q = 1; $q <= $no_month; $q++) { 
                if ($row[$count_row][custdist] == $i && $row[$count_row][data_month] == $q) {
                    if ($row[$count_row][data_month] == 1) {
                        $eachCustNum[$i][$q-1] = $row[$count_row][sum_cust_num];
                        $accuCustNum[$i][$q-1] = $row[$count_row][sum_cust_num];

                        $eachCustMin[$i][$q-1] = $row[$count_row][sum_cust_min];
                        $accuCustMin[$i][$q-1] = $row[$count_row][sum_cust_min];
                    } else {
                        $eachCustNum[$i][$q-1] = $row[$count_row][sum_cust_num];
                        $accuCustNum[$i][$q-1] = $accuCustNum[$i][$q-2]+$row[$count_row][sum_cust_num];
                        
                        $eachCustMin[$i][$q-1] = $row[$count_row][sum_cust_min];
                        $accuCustMin[$i][$q-1] = $accuCustMin[$i][$q-2]+$row[$count_row][sum_cust_min];
                    }
                    $count_row++;
                } else {
                        $eachCustNum[$i][$q-1] = 0;
                        $accuCustNum[$i][$q-1] = $accuCustNum[$i][$q-2]+0;

                        $eachCustMin[$i][$q-1] = 0;
                        $accuCustMin[$i][$q-1] = $accuCustMin[$i][$q-2]+0;
                }
            }
        }
        // print_r($eachCustNum);
        // print_r($accuCustNum);
        
        // unoffcial indices 15 days of current month
        $sql = 'SELECT custdist, month(date) AS data_month, sum(cust_num) AS sum_cust_num, sum(cust_min) AS sum_cust_min
                FROM indices_db_15days 
                WHERE timeocb > 1 
                    AND event in("i", "o") 
                    AND group_type = "f" 
                    AND major is null 
                    AND year(date) = "'.$selectedYear.'" 
                    AND month(date) = "'.$lasted_month.'" 
                    GROUP BY custdist, month(date)';

        try {
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // print_r($row2);
        // foreach ($row2 as $key => $value) {
        //     $row[] = $value;
        // }
        // print_r($row);

        $no_district = 18;
        $no_month = count($eachDistCust[1]);
        $count_row = 0;        
        for ($i = 1; $i <= $no_district; $i++) { 
            if ($row[$count_row][custdist] == $i && $row[$count_row][data_month] == $no_month) {
                if ($row[$count_row][data_month] == 1) {
                    $eachCustNum[$i][$no_month-1] = $row[$count_row][sum_cust_num];
                    $accuCustNum[$i][$no_month-1] = $row[$count_row][sum_cust_num];

                    $eachCustMin[$i][$no_month-1] = $row[$count_row][sum_cust_min];
                    $accuCustMin[$i][$no_month-1] = $row[$count_row][sum_cust_min];
                } else {
                    $eachCustNum[$i][$no_month-1] = $row[$count_row][sum_cust_num];
                    $accuCustNum[$i][$no_month-1] = $accuCustNum[$i][$no_month-2]+$row[$count_row][sum_cust_num];
                    
                    $eachCustMin[$i][$no_month-1] = $row[$count_row][sum_cust_min];
                    $accuCustMin[$i][$no_month-1] = $accuCustMin[$i][$no_month-2]+$row[$count_row][sum_cust_min];
                }
                $count_row++;
            } else {
                    $eachCustNum[$i][$no_month-1] = 0;
                    $accuCustNum[$i][$no_month-1] = $accuCustNum[$i][$no_month-2]+0;

                    $eachCustMin[$i][$no_month-1] = 0;
                    $accuCustMin[$i][$no_month-1] = $accuCustMin[$i][$no_month-2]+0;
            }
        }
        

        // print_r($eachCustNum);
        // print_r($accuCustNum);
    }
    // /sum_cust_num and sum_cust_min

    // calculate MEA saifi saidi
    {
        $indices = calculateIndices($accuCustNum, $accuCustMin, $eachCustNum, $eachCustMin, $accuDistCust, $eachDistCust, $no_month);
        $saifi = $indices[0];
        $saidi = $indices[1];
        $saifi_month = $indices[2];
        $saidi_month = $indices[3];
        // print_r($saifi);
        // print_r($saidi);
        // print_r($saifi_month);
        // print_r($saidi_month);
        // echo count($saifi);
        // /calculate MEA saifi saidi
        // calculate MEA KPI
        // print_r($kpi);
    }
    // /calculate MEA KPI

    if ($target == 1) { // mean that has target
        echo json_encode([  
            data_year => $selectedYear,
            tabb => $tabb,
            saifi => $saifi, 
            saidi => $saidi,
            saifi_month => $saifi_month,
            saidi_month => $saidi_month,
            saifi_target => $saifi_target,
            saidi_target => $saidi_target,
            no_month => $no_month,
            lasted_day => $lasted_day,
        ]);
    } else { // $target == 0, mean that hasn't target
        echo json_encode([  
            data_year => $selectedYear,
            tabb => $tabb,
            saifi => $saifi, 
            saidi => $saidi,
            saifi_month => $saifi_month,
            saidi_month => $saidi_month,
            // saifi_target => $saifi_target,
            // saidi_target => $saidi_target,
            no_month => $no_month,
            lasted_day => $lasted_day,
        ]);
    }
    
    // $jsonData = json_encode($row);
    // echo $jsonData;

    // close connection
    $dbh = null;

    // calculate indices
    function calculateIndices($accuCustNum, $accuCustMin, $eachCustNum, $eachCustMin, $accuDistCust, $eachDistCust, $no_month) {
        // $saifi = array();
        // $saidi = array();
        foreach ($accuCustNum as $key_district => $value_district) {
            foreach ($value_district as $key_month => $value_month) {
                $saifi[$key_district][$key_month] = number_format($value_month/$accuDistCust[$key_district][$key_month]*($key_month+1), 3, '.', '');
                $saidi[$key_district][$key_month] = number_format($accuCustMin[$key_district][$key_month]/$accuDistCust[$key_district][$key_month]*($key_month+1), 3, '.', '');
                
                $saifi_month[$key_district][$key_month] = number_format($eachCustNum[$key_district][$key_month]/$eachDistCust[$key_district][$key_month], 3, '.', '');
                $saidi_month[$key_district][$key_month] = number_format($eachCustMin[$key_district][$key_month]/$eachDistCust[$key_district][$key_month], 3, '.', '');
            }
        }
        
        // print_r($saifi);
        // print_r($saidi);
        // print_r($saifi_month);
        // print_r($saidi_month);
        return [$saifi, $saidi, $saifi_month, $saidi_month];
    }

    // calculate KPI
    // function calculateKPI($saifi, $saidi, $saifi_target, $saidi_target, $system) {
    //     // $no_month = count($saifi);
    //     if ($system != 'e') { // for mea, line&station, feeder
    //         foreach ($saifi as $key => $value) {
    //             switch ($value) {
    //                 case ($value <= $saifi_target[$system."5"][$key]):
    //                     $saifi_kpi[] = 5;
    //                     break;
                    
    //                 case ($value <= $saifi_target[$system."4"][$key]):
    //                     $saifi_kpi[] = round( ($value - $saifi_target[$system."4"][$key]) / ($saifi_target[$system."5"][$key] - $saifi_target[$system."4"][$key]) + 4, 2);
    //                     break;
    
    //                 case ($value <= $saifi_target[$system."3"][$key]):
    //                     $saifi_kpi[] = round( ($value - $saifi_target[$system."3"][$key]) / ($saifi_target[$system."4"][$key] - $saifi_target[$system."3"][$key]) + 3, 2);
    //                     break;
    
    //                 case ($value <= $saifi_target[$system."2"][$key]):
    //                     $saifi_kpi[] = round( ($value - $saifi_target[$system."2"][$key]) / ($saifi_target[$system."3"][$key] - $saifi_target[$system."2"][$key]) + 2, 2);
    //                     break;
    
    //                 case ($value <= $saifi_target[$system."1"][$key]):
    //                     $saifi_kpi[] = round( ($value - $saifi_target[$system."2"][$key]) / ($saifi_target[$system."3"][$key] - $saifi_target[$system."2"][$key]) + 2, 2);
    //                     break;
                    
    //                 case ($value > $saifi_target[$system."1"][$key]):
    //                     $saifi_kpi[] = 1;
    //                     break;
    //                 // default:
    //                 //     # code...
    //                 //     break;
    //             }
                
    //             switch ($saidi[$key]) {
    //                 case ($saidi[$key] <= $saidi_target[$system."5"][$key]):
    //                     $saidi_kpi[] = 5;
    //                     break;
                    
    //                 case ($saidi[$key] <= $saidi_target[$system."4"][$key]):
    //                     $saidi_kpi[] = round( ($saidi[$key] - $saidi_target[$system."4"][$key]) / ($saidi_target[$system."5"][$key] - $saidi_target[$system."4"][$key]) + 4, 2);
    //                     break;
    
    //                 case ($saidi[$key] <= $saidi_target[$system."3"][$key]):
    //                     $saidi_kpi[] = round( ($saidi[$key] - $saidi_target[$system."3"][$key]) / ($saidi_target[$system."4"][$key] - $saidi_target[$system."3"][$key]) + 3, 2);
    //                     break;
    
    //                 case ($saidi[$key] <= $saidi_target[$system."2"][$key]):
    //                     $saidi_kpi[] = round( ($saidi[$key] - $saidi_target[$system."2"][$key]) / ($saidi_target[$system."3"][$key] - $saidi_target[$system."2"][$key]) + 2, 2);
    //                     break;
    
    //                 case ($saidi[$key] <= $saidi_target[$system."1"][$key]):
    //                     $saidi_kpi[] = round( ($saidi[$key] - $saidi_target[$system."2"][$key]) / ($saidi_target[$system."3"][$key] - $saidi_target[$system."2"][$key]) + 2, 2);
    //                     break;
                    
    //                 case ($saidi[$key] > $saidi_target[$system."1"][$key]):
    //                     $saidi_kpi[] = 1;
    //                     break;
    //                 // default:
    //                 //     # code...
    //                 //     break;
    //             }
    //         }            
    //     } else { // for egat
            
    //         // print_r($saifi);
    //         // print($system);
    //         foreach ($saifi as $key => $value) {
    //             switch (settype($value, "float")) {
    //                 case ($value <= $saifi_target[$system."5"][$key]):
    //                     $saifi_kpi[] = "good";
    //                     break;
                    
    //                 case ($value > $saifi_target[$system."5"][$key]):
    //                     $saifi_kpi[] = "bad";
    //                     break;
    //             }
    //             switch (settype($saidi[$key], "float")) {
    //                 case ($saidi[$key] <= $saidi_target[$system."5"][$key]):
    //                     $saidi_kpi[] = "good";
    //                     break;
                    
    //                 case ($saidi[$key] > $saidi_target[$system."5"][$key]):
    //                     $saidi_kpi[] = "bad";
    //                     break;
    //             }
    //         }      
    //     }

    //     return [$saifi_kpi, $saidi_kpi];
    // }
    // /calculate KPI
?>