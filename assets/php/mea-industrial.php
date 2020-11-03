<?php
    header('Content-Type: application/json');

    require_once 'db.php';
    $dbh = new PDO($dsn, $username, $password, $options);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $selectedYear = $_GET[selectedYear];
    
    // Industrial Target
    $sql = 'SELECT saifi_industrial, saidi_industrial FROM service_standard ORDER BY year_standard DESC';

    try {
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Something wrong!!! '.$e->getMessage();
    }
    
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    for ($i = 0; $i < 12; $i++) { 
        $saifi_target_nikom[] = $row[0]['saifi_industrial'];
        $saidi_target_nikom[] = $row[0]['saidi_industrial'];
    }
    // print_r($saifi_target_nikom);
    // print_r($saidi_target_nikom);
    // /Industrial Target

    if ($selectedYear >= 2019) { // over than 2019, Indieces have 5 industrials (H, L, P, U, A)
        
        // Industrial customer
        $sql = 'SELECT month AS data_month, bc_cus, lb_cus, bp_cus, bu_cus, as_cus, indust_cus FROM area_cust WHERE year = '.$selectedYear;
        try {
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }

        $i = -1;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $accu_cust[H][] = $row[bc_cus]+$accu_cust[H][$i];
            $accu_cust[L][] = $row[lb_cus]+$accu_cust[L][$i];
            $accu_cust[P][] = $row[bp_cus]+$accu_cust[P][$i];
            $accu_cust[U][] = $row[bu_cus]+$accu_cust[U][$i];
            $accu_cust[A][] = $row[as_cus]+$accu_cust[A][$i];
            $accu_cust[nikom][] = $row[indust_cus]+$accu_cust[nikom][$i];
            $each_cust[H][] = $row[bc_cus];
            $each_cust[L][] = $row[lb_cus];
            $each_cust[P][] = $row[bp_cus];
            $each_cust[U][] = $row[bu_cus];
            $each_cust[A][] = $row[as_cus];
            $each_cust[nikom][] = $row[indust_cus];
            $i++;
        }
        // print_r($accu_cust);
        // print_r($each_cust);
        // /Industrial customer

        // Industrial
        $sql = 'SELECT new_month AS no_month, nikom, sum(cust_num) AS cust_num, sum(cust_min) AS cust_min FROM int_nikom WHERE timeocb > 1 AND year(date) = '.$selectedYear.' AND major is null GROUP BY no_month, nikom';

        try {
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }
        
        $no_month = count($each_cust[nikom]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $eachCustNum[$row[nikom]][$row[no_month]-1] = $row[cust_num];
            $eachCustMin[$row[nikom]][$row[no_month]-1] = $row[cust_min];
        }
        // print_r($eachCustNum);
        // print_r($eachCustMin);

        for ($i = 0; $i < $no_month; $i++) { 
            // CustNum
            if (is_null($eachCustNum[H][$i])) {
                $eachCustNum[H][$i] = 0;
            }
            $accuCustNum[H][$i] = $accuCustNum[H][$i-1] + $eachCustNum[H][$i];
            if (is_null($eachCustNum[L][$i])) {
                $eachCustNum[L][$i] = 0;
            }
            $accuCustNum[L][$i] = $accuCustNum[L][$i-1] + $eachCustNum[L][$i];
            if (is_null($eachCustNum[P][$i])) {
                $eachCustNum[P][$i] = 0;
            }
            $accuCustNum[P][$i] = $accuCustNum[P][$i-1] + $eachCustNum[P][$i];
            if (is_null($eachCustNum[U][$i])) {
                $eachCustNum[U][$i] = 0;
            }
            $accuCustNum[U][$i] = $accuCustNum[U][$i-1] + $eachCustNum[U][$i];
            if (is_null($eachCustNum[A][$i])) {
                $eachCustNum[A][$i] = 0;
            }
            $accuCustNum[A][$i] = $accuCustNum[A][$i-1] + $eachCustNum[A][$i];

            $eachCustNum[nikom][$i] = $eachCustNum[H][$i] + $eachCustNum[L][$i] + $eachCustNum[P][$i] + $eachCustNum[U][$i] + $eachCustNum[A][$i];
            $accuCustNum[nikom][$i] = $accuCustNum[nikom][$i-1] + $eachCustNum[nikom][$i];

            // CustMin
            if (is_null($eachCustMin[H][$i])) {
                $eachCustMin[H][$i] = 0;
            }
            $accuCustMin[H][$i] = $accuCustMin[H][$i-1] + $eachCustMin[H][$i];
            if (is_null($eachCustMin[L][$i])) {
                $eachCustMin[L][$i] = 0;
            }
            $accuCustMin[L][$i] = $accuCustMin[L][$i-1] + $eachCustMin[L][$i];
            if (is_null($eachCustMin[P][$i])) {
                $eachCustMin[P][$i] = 0;
            }
            $accuCustMin[P][$i] = $accuCustMin[P][$i-1] + $eachCustMin[P][$i];
            if (is_null($eachCustMin[U][$i])) {
                $eachCustMin[U][$i] = 0;
            }
            $accuCustMin[U][$i] = $accuCustMin[U][$i-1] + $eachCustMin[U][$i];
            if (is_null($eachCustMin[A][$i])) {
                $eachCustMin[A][$i] = 0;
            }
            $accuCustMin[A][$i] = $accuCustMin[A][$i-1] + $eachCustMin[A][$i];

            $eachCustMin[nikom][$i] = $eachCustMin[H][$i] + $eachCustMin[L][$i] + $eachCustMin[P][$i] + $eachCustMin[U][$i] + $eachCustMin[A][$i];
            $accuCustMin[nikom][$i] = $accuCustMin[nikom][$i-1] + $eachCustMin[nikom][$i];
        }
        // print_r($eachCustNum);
        // print_r($accuCustNum);
        // print_r($eachCustMin);
        // print_r($accuCustMin);
        // /Industrial

        // calculate MEA saifi saidi
        $indices = calculateAccuIndices('H', $accuCustNum, $accuCustMin, $accu_cust);
        $saifi[H] = $indices[0];
        $saidi[H] = $indices[1];
        $indices = calculateAccuIndices('L', $accuCustNum, $accuCustMin, $accu_cust);
        $saifi[L] = $indices[0];
        $saidi[L] = $indices[1];
        $indices = calculateAccuIndices('P', $accuCustNum, $accuCustMin, $accu_cust);
        $saifi[P] = $indices[0];
        $saidi[P] = $indices[1];
        $indices = calculateAccuIndices('U', $accuCustNum, $accuCustMin, $accu_cust);
        $saifi[U] = $indices[0];
        $saidi[U] = $indices[1];
        $indices = calculateAccuIndices('A', $accuCustNum, $accuCustMin, $accu_cust);
        $saifi[A] = $indices[0];
        $saidi[A] = $indices[1];
        $indices = calculateAccuIndices('nikom', $accuCustNum, $accuCustMin, $accu_cust);
        $saifi[nikom] = $indices[0];
        $saidi[nikom] = $indices[1];
        $indices = calculateEachIndices('H', $eachCustNum, $eachCustMin, $each_cust);
        $saifi_month[H] = $indices[0];
        $saidi_month[H] = $indices[1];
        $indices = calculateEachIndices('L', $eachCustNum, $eachCustMin, $each_cust);
        $saifi_month[L] = $indices[0];
        $saidi_month[L] = $indices[1];
        $indices = calculateEachIndices('P', $eachCustNum, $eachCustMin, $each_cust);
        $saifi_month[P] = $indices[0];
        $saidi_month[P] = $indices[1];
        $indices = calculateEachIndices('U', $eachCustNum, $eachCustMin, $each_cust);
        $saifi_month[U] = $indices[0];
        $saidi_month[U] = $indices[1];
        $indices = calculateEachIndices('A', $eachCustNum, $eachCustMin, $each_cust);
        $saifi_month[A] = $indices[0];
        $saidi_month[A] = $indices[1];
        $indices = calculateEachIndices('nikom', $eachCustNum, $eachCustMin, $each_cust);
        $saifi_month[nikom] = $indices[0];
        $saidi_month[nikom] = $indices[1];
    } else { // less than 2018, Indices have 4 industrials (H, L, P, U)
        // Industrial customer
        $sql = 'SELECT month AS data_month, bc_cus, lb_cus, bp_cus, bu_cus, indust_cus FROM area_cust WHERE year = '.$selectedYear;
        try {
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }

        $i = -1;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $accu_cust[H][] = $row[bc_cus]+$accu_cust[H][$i];
            $accu_cust[L][] = $row[lb_cus]+$accu_cust[L][$i];
            $accu_cust[P][] = $row[bp_cus]+$accu_cust[P][$i];
            $accu_cust[U][] = $row[bu_cus]+$accu_cust[U][$i];
            $accu_cust[nikom][] = $row[indust_cus]+$accu_cust[nikom][$i];
            $each_cust[H][] = $row[bc_cus];
            $each_cust[L][] = $row[lb_cus];
            $each_cust[P][] = $row[bp_cus];
            $each_cust[U][] = $row[bu_cus];
            $each_cust[nikom][] = $row[indust_cus];
            $i++;
        }
        // print_r($accu_cust);
        // print_r($each_cust);
        // /Industrial customer

        // Industrial
        $sql = 'SELECT new_month AS no_month, nikom, sum(cust_num) AS cust_num, sum(cust_min) AS cust_min FROM int_nikom WHERE timeocb > 1 AND year(date) = '.$selectedYear.' AND major is null GROUP BY no_month, nikom';

        try {
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }
        
        $no_month = count($each_cust[nikom]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $eachCustNum[$row[nikom]][$row[no_month]-1] = $row[cust_num];
            $eachCustMin[$row[nikom]][$row[no_month]-1] = $row[cust_min];
        }
        // print_r($eachCustNum);
        // print_r($eachCustMin);

        for ($i = 0; $i < $no_month; $i++) { 
            // CustNum
            if (is_null($eachCustNum[H][$i])) {
                $eachCustNum[H][$i] = 0;
            }
            $accuCustNum[H][$i] = $accuCustNum[H][$i-1] + $eachCustNum[H][$i];
            if (is_null($eachCustNum[L][$i])) {
                $eachCustNum[L][$i] = 0;
            }
            $accuCustNum[L][$i] = $accuCustNum[L][$i-1] + $eachCustNum[L][$i];
            if (is_null($eachCustNum[P][$i])) {
                $eachCustNum[P][$i] = 0;
            }
            $accuCustNum[P][$i] = $accuCustNum[P][$i-1] + $eachCustNum[P][$i];
            if (is_null($eachCustNum[U][$i])) {
                $eachCustNum[U][$i] = 0;
            }
            $accuCustNum[U][$i] = $accuCustNum[U][$i-1] + $eachCustNum[U][$i];

            $eachCustNum[nikom][$i] = $eachCustNum[H][$i] + $eachCustNum[L][$i] + $eachCustNum[P][$i] + $eachCustNum[U][$i];
            $accuCustNum[nikom][$i] = $accuCustNum[nikom][$i-1] + $eachCustNum[nikom][$i];

            // CustMin
            if (is_null($eachCustMin[H][$i])) {
                $eachCustMin[H][$i] = 0;
            }
            $accuCustMin[H][$i] = $accuCustMin[H][$i-1] + $eachCustMin[H][$i];
            if (is_null($eachCustMin[L][$i])) {
                $eachCustMin[L][$i] = 0;
            }
            $accuCustMin[L][$i] = $accuCustMin[L][$i-1] + $eachCustMin[L][$i];
            if (is_null($eachCustMin[P][$i])) {
                $eachCustMin[P][$i] = 0;
            }
            $accuCustMin[P][$i] = $accuCustMin[P][$i-1] + $eachCustMin[P][$i];
            if (is_null($eachCustMin[U][$i])) {
                $eachCustMin[U][$i] = 0;
            }
            $accuCustMin[U][$i] = $accuCustMin[U][$i-1] + $eachCustMin[U][$i];

            $eachCustMin[nikom][$i] = $eachCustMin[H][$i] + $eachCustMin[L][$i] + $eachCustMin[P][$i] + $eachCustMin[U][$i];
            $accuCustMin[nikom][$i] = $accuCustMin[nikom][$i-1] + $eachCustMin[nikom][$i];
        }
        // print_r($eachCustNum);
        // print_r($accuCustNum);
        // print_r($eachCustMin);
        // print_r($accuCustMin);
        // /Industrial

        // calculate MEA saifi saidi
        $indices = calculateAccuIndices('H', $accuCustNum, $accuCustMin, $accu_cust);
        $saifi[H] = $indices[0];
        $saidi[H] = $indices[1];
        $indices = calculateAccuIndices('L', $accuCustNum, $accuCustMin, $accu_cust);
        $saifi[L] = $indices[0];
        $saidi[L] = $indices[1];
        $indices = calculateAccuIndices('P', $accuCustNum, $accuCustMin, $accu_cust);
        $saifi[P] = $indices[0];
        $saidi[P] = $indices[1];
        $indices = calculateAccuIndices('U', $accuCustNum, $accuCustMin, $accu_cust);
        $saifi[U] = $indices[0];
        $saidi[U] = $indices[1];
        $indices = calculateAccuIndices('nikom', $accuCustNum, $accuCustMin, $accu_cust);
        $saifi[nikom] = $indices[0];
        $saidi[nikom] = $indices[1];
        $indices = calculateEachIndices('H', $eachCustNum, $eachCustMin, $each_cust);
        $saifi_month[H] = $indices[0];
        $saidi_month[H] = $indices[1];
        $indices = calculateEachIndices('L', $eachCustNum, $eachCustMin, $each_cust);
        $saifi_month[L] = $indices[0];
        $saidi_month[L] = $indices[1];
        $indices = calculateEachIndices('P', $eachCustNum, $eachCustMin, $each_cust);
        $saifi_month[P] = $indices[0];
        $saidi_month[P] = $indices[1];
        $indices = calculateEachIndices('U', $eachCustNum, $eachCustMin, $each_cust);
        $saifi_month[U] = $indices[0];
        $saidi_month[U] = $indices[1];
        $indices = calculateEachIndices('nikom', $eachCustNum, $eachCustMin, $each_cust);
        $saifi_month[nikom] = $indices[0];
        $saidi_month[nikom] = $indices[1];
        
        // print_r($saifi);
        // print_r($saidi);
        // print_r($saifi_month);
        // print_r($saidi_month);
        // echo count($saifi);
        // /calculate MEA saifi saidi
        // calculate MEA KPI
        // $kpi = calculateKPI($saifi, $saidi, $saifi_target, $saidi_target, 'm');
        // $saifi_kpi = $kpi[0];
        // $saidi_kpi = $kpi[1];
        // print_r($kpi);
        // /calculate MEA KPI
    }
    
    echo json_encode([  
                        saifi => $saifi, 
                        saidi => $saidi,
                        saifi_month => $saifi_month, 
                        saidi_month => $saidi_month,
                        saifi_target_nikom => $saifi_target_nikom,
                        saidi_target_nikom => $saidi_target_nikom
                    ]);
    // $jsonData = json_encode($row);
    // echo $jsonData;

    // close connection
    $dbh = null;

    // calculate indices
    function calculateAccuIndices($nikom, $accuCustNum, $accuCustMin, $accu_cust) {
        $iteration = count($accuCustNum[$nikom]);
        for ($i = 0; $i < $iteration; $i++) {
            $saifi[] = number_format($accuCustNum[$nikom][$i]/$accu_cust[$nikom][$i]*($i+1), 3, '.', '');
            $saidi[] = number_format($accuCustMin[$nikom][$i]/$accu_cust[$nikom][$i]*($i+1), 3, '.', '');
        }
        // print_r($saifi);
        // print_r($saidi);
        return [$saifi, $saidi];
    }

    function calculateEachIndices($nikom, $eachCustNum, $eachCustMin, $each_cust) {
        $iteration = count($eachCustNum[$nikom]);
        for ($i = 0; $i < $iteration; $i++) {
            $saifi[] = number_format($eachCustNum[$nikom][$i]/$each_cust[$nikom][$i], 3, '.', '');
            $saidi[] = number_format($eachCustMin[$nikom][$i]/$each_cust[$nikom][$i], 3, '.', '');
        }
        
        return [$saifi, $saidi];
    }
    // /calculate indices

    // calculate KPI
    // function calculateKPI($saifi, $saidi, $saifi_target, $saidi_target, $system) {
        // $no_month = count($saifi);
        // if ($system != 'e') { // for mea, line&station, feeder
        //     foreach ($saifi as $key => $value) {
        //         switch ($value) {
        //             case ($value <= $saifi_target[$system."5"][$key]):
        //                 $saifi_kpi[] = 5.00;
        //                 break;
                    
        //             case ($value <= $saifi_target[$system."4"][$key]):
        //                 $saifi_kpi[] = number_format( ($value - $saifi_target[$system."4"][$key]) / ($saifi_target[$system."5"][$key] - $saifi_target[$system."4"][$key]) + 4, 2, '.', '');
        //                 break;
    
        //             case ($value <= $saifi_target[$system."3"][$key]):
        //                 $saifi_kpi[] = number_format( ($value - $saifi_target[$system."3"][$key]) / ($saifi_target[$system."4"][$key] - $saifi_target[$system."3"][$key]) + 3, 2, '.', '');
        //                 break;
    
        //             case ($value <= $saifi_target[$system."2"][$key]):
        //                 $saifi_kpi[] = number_format( ($value - $saifi_target[$system."2"][$key]) / ($saifi_target[$system."3"][$key] - $saifi_target[$system."2"][$key]) + 2, 2, '.', '');
        //                 break;
    
        //             case ($value <= $saifi_target[$system."1"][$key]):
        //                 $saifi_kpi[] = number_format( ($value - $saifi_target[$system."2"][$key]) / ($saifi_target[$system."3"][$key] - $saifi_target[$system."2"][$key]) + 2, 2, '.', '');
        //                 break;
                    
        //             case ($value > $saifi_target[$system."1"][$key]):
        //                 $saifi_kpi[] = 1.00;
        //                 break;
                    // default:
                    //     # code...
                    //     break;
                // }
                
                // switch ($saidi[$key]) {
                //     case ($saidi[$key] <= $saidi_target[$system."5"][$key]):
                //         $saidi_kpi[] = 5.00;
                //         break;
                    
                //     case ($saidi[$key] <= $saidi_target[$system."4"][$key]):
                //         $saidi_kpi[] = number_format( ($saidi[$key] - $saidi_target[$system."4"][$key]) / ($saidi_target[$system."5"][$key] - $saidi_target[$system."4"][$key]) + 4, 2, '.', '');
                //         break;
    
                //     case ($saidi[$key] <= $saidi_target[$system."3"][$key]):
                //         $saidi_kpi[] = number_format( ($saidi[$key] - $saidi_target[$system."3"][$key]) / ($saidi_target[$system."4"][$key] - $saidi_target[$system."3"][$key]) + 3, 2, '.', '');
                //         break;
    
                //     case ($saidi[$key] <= $saidi_target[$system."2"][$key]):
                //         $saidi_kpi[] = number_format( ($saidi[$key] - $saidi_target[$system."2"][$key]) / ($saidi_target[$system."3"][$key] - $saidi_target[$system."2"][$key]) + 2, 2, '.', '');
                //         break;
    
                //     case ($saidi[$key] <= $saidi_target[$system."1"][$key]):
                //         $saidi_kpi[] = number_format( ($saidi[$key] - $saidi_target[$system."2"][$key]) / ($saidi_target[$system."3"][$key] - $saidi_target[$system."2"][$key]) + 2, 2, '.', '');
                //         break;
                    
                //     case ($saidi[$key] > $saidi_target[$system."1"][$key]):
                //         $saidi_kpi[] = 1.00;
                //         break;
                    // default:
                    //     # code...
                    //     break;
        //         }
        //     }            
        // } else { // for egat
            
            // print_r($saifi);
            // print($system);
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