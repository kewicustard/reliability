<?php
    header('Content-Type: application/json');

    require_once 'db.php';
    $dbh = new PDO($dsn, $username, $password, $options);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $year = $_GET['year'];
    $strategy_target = $_GET['strategy_target'];

    // check lasted month of indices_db table
    {
        $sql = 'SELECT max(month(date)) AS lasted_month 
                    FROM indices_db 
                    WHERE year(date) = "'.$year.'"';

        try {
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $lasted_month = $row[0]['lasted_month'];
        // echo($lasted_month);
    }
    // /check lasted month of indices_db table

    // MEA-customer
    $sql = 'SELECT max(month) AS no_month, sum(nocus) AS mea_cust FROM discust WHERE district = 99 AND year = "'.$year.'" and month <= '.$lasted_month;
    
    try {
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Something wrong!!! '.$e->getMessage();
    }
    
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['no_month'] = $row[0]['no_month'];
    $data['mea_cust'] = $row[0]['mea_cust'];
    // echo $no_month;
    // print_r($data);
    // /MEA-customer

    // MEA-Strategy
    $sql = 'SELECT max(month(date)) AS no_month, sum(cust_num) AS cust_num_all, sum(cust_min) AS cust_min_all FROM indices_db WHERE timeocb > 1 AND event in("i", "o") AND major is null AND year(date) = "'.$year.'"';
    
    try {
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Something wrong!!! '.$e->getMessage();
    }
    
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['cust_num_all'] = $row[0]['cust_num_all'];
    $data['cust_min_all'] = $row[0]['cust_min_all'];
    // print_r($data);
    // print_r($row);
    // /MEA-Strategy

    // MEA-Strategy Target
    if ($strategy_target == 'yes') {

        $sql = 'SELECT month(YearMonthnumberTarget) AS no_month, SAIFI_MEATarget_5, SAIFI_MEATarget_4, SAIFI_MEATarget_3, SAIFI_MEATarget_2, SAIFI_MEATarget_1, SAIDI_MEATarget_5, SAIDI_MEATarget_4, SAIDI_MEATarget_3, SAIDI_MEATarget_2, SAIDI_MEATarget_1 FROM target WHERE month(yearmonthnumbertarget) = '.$data['no_month'].' and year(yearmonthnumbertarget) = '.$year;
    
        try {
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }
        
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data['SAIFI_MEATarget'] = [$row[0]['SAIFI_MEATarget_5'], $row[0]['SAIFI_MEATarget_4'], $row[0]['SAIFI_MEATarget_3'], $row[0]['SAIFI_MEATarget_2'], $row[0]['SAIFI_MEATarget_1']];
        $data['SAIDI_MEATarget'] = [$row[0]['SAIDI_MEATarget_5'], $row[0]['SAIDI_MEATarget_4'], $row[0]['SAIDI_MEATarget_3'], $row[0]['SAIDI_MEATarget_2'], $row[0]['SAIDI_MEATarget_1']];
        // print_r($data);

    } else {// $strategy_target == 'no'
        // echo gettype($year);
        $previous_year = $year-1;
        // echo $previous_year;
        // echo gettype($previous_year);
        
        // MEA-customer previous year
        $sql = 'SELECT year, max(month) AS no_month, sum(nocus) AS mea_cust FROM discust WHERE district = 99 AND month <= "'.$data['no_month'].'" AND year = "'.$previous_year.'" and month <= '.$lasted_month;
        try {
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }
        
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data['mea_cust_previous_year'] = $row[0]['mea_cust'];
        //print_r($row);
        // /MEA-customer previous year
        
        // MEA-Strategy previous year
        $sql = 'SELECT max(year(date)) AS year, max(month(date)) AS no_month, sum(cust_num) AS cust_num_all, sum(cust_min) AS cust_min_all FROM indices_db WHERE timeocb > 1 AND event in("i", "o") AND major is null AND month(date) <= "'.$data['no_month'].'" AND year(date) = "'.$previous_year.'"';
        try {
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }
        
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data['cust_num_all_previous_year'] = $row[0]['cust_num_all'];
        $data['cust_min_all_previous_year'] = $row[0]['cust_min_all'];
        // print_r($row);
        /// MEA-Strategy previous year
    }
    // /MEA-Strategy Target

    // MEA-SEPA MEA
    $sql = 'SELECT max(month(date)) AS no_month, sum(cust_num) AS cust_num_all, sum(cust_min) AS cust_min_all from indices_db WHERE timeocb > 1 AND event in("i", "o") AND major is null AND year(date) = "'.$year.'" AND control = "c"';
    
    try {
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Something wrong!!! '.$e->getMessage();
    }
    
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['cust_num_all_sepa'] = $row[0]['cust_num_all'];
    $data['cust_min_all_sepa'] = $row[0]['cust_min_all'];
    // print_r($data);
    // /MEA-SEPA MEA

    // MEA-SEPA MEA Target
    $sql = 'SELECT month(YearMonthnumberTarget) AS no_month, SAIFI_MEATarget_5, SAIFI_MEATarget_4, SAIFI_MEATarget_3, SAIFI_MEATarget_2, SAIFI_MEATarget_1, SAIDI_MEATarget_5, SAIDI_MEATarget_4, SAIDI_MEATarget_3, SAIDI_MEATarget_2, SAIDI_MEATarget_1 FROM target_mea_sepa WHERE month(yearmonthnumbertarget) = '.$data['no_month'].' and year(yearmonthnumbertarget) = '.$year;

    try {
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Something wrong!!! '.$e->getMessage();
    }
    
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['SAIFI_MEATarget_sepa'] = [$row[0]['SAIFI_MEATarget_5'], $row[0]['SAIFI_MEATarget_4'], $row[0]['SAIFI_MEATarget_3'], $row[0]['SAIFI_MEATarget_2'], $row[0]['SAIFI_MEATarget_1']];
    $data['SAIDI_MEATarget_sepa'] = [$row[0]['SAIDI_MEATarget_5'], $row[0]['SAIDI_MEATarget_4'], $row[0]['SAIDI_MEATarget_3'], $row[0]['SAIDI_MEATarget_2'], $row[0]['SAIDI_MEATarget_1']];
    // print_r($data);
    // /MEA-SEPA MEA Target

    // MEA-Focus Group 8 districts customer
    $sql = 'SELECT max(month) AS no_month, sum(nocus) AS focus_cust FROM discust WHERE year = "'.$year.'" and month <= '.$lasted_month.' AND district in (SELECT code FROM focusdist WHERE year = "'.$year.'")';
    
    try {
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Something wrong!!! '.$e->getMessage();
    }
    
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['focus_cust'] = $row[0]['focus_cust'];
    // echo $no_month;
    // print_r($data);
    // /MEA-Focus Group 8 districts customer

    // MEA-Focus Group 8 districts
    $sql = 'SELECT max(month(date)) AS no_month, sum(cust_num) AS cust_num_all, sum(cust_min) AS cust_min_all from indices_db WHERE timeocb > 1 AND event in("i", "o") AND major is null AND year(date) = "'.$year.'" AND control = "c" AND custdist in (SELECT code FROM focusdist WHERE year = "'.$year.'")';
    
    try {
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Something wrong!!! '.$e->getMessage();
    }
    
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['cust_num_all_focus'] = $row[0]['cust_num_all'];
    $data['cust_min_all_focus'] = $row[0]['cust_min_all'];
    // print_r($data);
    // /MEA-Focus Group 8 districts

    // MEA-Focus Group 8 districts Target
    $sql = 'SELECT month(YearMonthnumberTarget) AS no_month, SAIFI_MEATarget_5, SAIFI_MEATarget_4, SAIFI_MEATarget_3, SAIFI_MEATarget_2, SAIFI_MEATarget_1, SAIDI_MEATarget_5, SAIDI_MEATarget_4, SAIDI_MEATarget_3, SAIDI_MEATarget_2, SAIDI_MEATarget_1 FROM target_mea_sepa_focus_group WHERE month(yearmonthnumbertarget) = '.$data['no_month'].' and year(yearmonthnumbertarget) = '.$year;

    try {
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Something wrong!!! '.$e->getMessage();
    }
    
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['SAIFI_MEATarget_focus'] = [$row[0]['SAIFI_MEATarget_5'], $row[0]['SAIFI_MEATarget_4'], $row[0]['SAIFI_MEATarget_3'], $row[0]['SAIFI_MEATarget_2'], $row[0]['SAIFI_MEATarget_1']];
    $data['SAIDI_MEATarget_focus'] = [$row[0]['SAIDI_MEATarget_5'], $row[0]['SAIDI_MEATarget_4'], $row[0]['SAIDI_MEATarget_3'], $row[0]['SAIDI_MEATarget_2'], $row[0]['SAIDI_MEATarget_1']];
    // print_r($data);
    // /MEA-Focus Group 8 districts Target

    // Industrial customer
    $sql = 'SELECT max(month) AS no_month, sum(indust_cus) AS all_indust_cust FROM area_cust WHERE year = '.$year;
    try {
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Something wrong!!! '.$e->getMessage();
    }
    
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['no_month_nikom'] = $row[0]['no_month'];
    $data['all_indust_cust'] = $row[0]['all_indust_cust'];
    // /Industrial customer

    // Industrial
    $sql = 'SELECT max(new_month) AS no_month, sum(cust_num) AS cust_num_all, sum(cust_min) AS cust_min_all FROM int_nikom WHERE timeocb > 1 AND year(date) = '.$year.' AND major is null';

    try {
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Something wrong!!! '.$e->getMessage();
    }
    
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['cust_num_all_nikom'] = $row[0]['cust_num_all'];
    $data['cust_min_all_nikom'] = $row[0]['cust_min_all'];
    // /Industrial

    // Industrial Target
    $sql = 'SELECT saifi_industrial, saidi_industrial FROM service_standard ORDER BY year_standard DESC';

    try {
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Something wrong!!! '.$e->getMessage();
    }
    
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['SAIFI_Target_nikom'] = $row[0]['saifi_industrial'];
    $data['SAIDI_Target_nikom'] = $row[0]['saidi_industrial'];
    // print_r($data);
    // /Industrial Target

    $res['no_month'] = $data['no_month'];
    
    // MEA-Strategy
    if ($strategy_target == 'yes') {
        $index_kpi = calculateIndexAndKpi($data['no_month'], $data['mea_cust'], $data['cust_num_all'], $data['cust_min_all'], $data['SAIFI_MEATarget'], $data['SAIDI_MEATarget']);
        $res['saifi'] = $index_kpi[0];
        $res['saidi'] = $index_kpi[1];
        $res['saifi_kpi'] = $index_kpi[2];
        $res['saidi_kpi'] = $index_kpi[3];
    } else { //$strategy_target == 'no'
        $index_kpi = calculateIndexAndcomparePreviousYear($data['no_month'], $data['mea_cust'], $data['cust_num_all'], $data['cust_min_all'], $data['mea_cust_previous_year'], $data['cust_num_all_previous_year'], $data['cust_min_all_previous_year']);
        $res['saifi'] = $index_kpi[0];
        $res['saidi'] = $index_kpi[1];
        $res['saifi_kpi'] = $index_kpi[2];
        $res['saidi_kpi'] = $index_kpi[3];
    }
    
    // MEA-SEPA
    $index_kpi = calculateIndexAndKpi($data['no_month'], $data['mea_cust'], $data['cust_num_all_sepa'], $data['cust_min_all_sepa'], $data['SAIFI_MEATarget_sepa'], $data['SAIDI_MEATarget_sepa']);
    $res['saifi_sepa'] = $index_kpi[0];
    $res['saidi_sepa'] = $index_kpi[1];
    $res['saifi_kpi_sepa'] = $index_kpi[2];
    $res['saidi_kpi_sepa'] = $index_kpi[3];

    // MEA-Focus Group 8 districts
    $index_kpi = calculateIndexAndKpi($data['no_month'], $data['focus_cust'], $data['cust_num_all_focus'], $data['cust_min_all_focus'], $data['SAIFI_MEATarget_focus'], $data['SAIDI_MEATarget_focus']);
    $res['saifi_focus'] = $index_kpi[0];
    $res['saidi_focus'] = $index_kpi[1];
    $res['saifi_kpi_focus'] = $index_kpi[2];
    $res['saidi_kpi_focus'] = $index_kpi[3];

    // Industrial
    $index_kpi = calculateIndustrial($data['no_month_nikom'], $data['all_indust_cust'], $data['cust_num_all_nikom'], $data['cust_min_all_nikom'], $data['SAIFI_Target_nikom'], $data['SAIDI_Target_nikom']);
    $res['saifi_nikom'] = $index_kpi[0];
    $res['saidi_nikom'] = $index_kpi[1];
    $res['saifi_kpi_nikom'] = $index_kpi[2];
    $res['saidi_kpi_nikom'] = $index_kpi[3];

    $jsonData = json_encode($res);
    echo $jsonData;

    $dbh = null;

    function calculateIndexAndKpi($no_month, $mea_cust, $cust_num, $cust_min, $saifi_target, $saidi_target) {
        // Index
        $saifi = number_format($cust_num/$mea_cust*$no_month, 3, '.', '');
        $saidi = number_format($cust_min/$mea_cust*$no_month, 3, '.', '');

        // echo $saifi;
        // print_r($saifi_target);

        // KPI
            // SAIFI
        switch ($saifi) {
            case ($saifi <= number_format($saifi_target[0], 3, '.', '')):
                $saifi_kpi= '5.00';
                break;
            
            case ($saifi <= number_format($saifi_target[1], 3, '.', '')):
                $saifi_kpi= number_format( ($saifi - $saifi_target[1]) / ($saifi_target[0] - $saifi_target[1]) + 4, 2, '.', '');
                break;

            case ($saifi <= number_format($saifi_target[2], 3, '.', '')):
                $saifi_kpi= number_format( ($saifi - $saifi_target[2]) / ($saifi_target[1] - $saifi_target[2]) + 3, 2, '.', '');
                break;

            case ($saifi <= number_format($saifi_target[3], 3, '.', '')):
                $saifi_kpi= number_format( ($saifi - $saifi_target[3]) / ($saifi_target[2] - $saifi_target[3]) + 2, 2, '.', '');
                break;

            case ($saifi <= number_format($saifi_target[4], 3, '.', '')):
                $saifi_kpi= number_format( ($saifi - $saifi_target[4]) / ($saifi_target[3] - $saifi_target[4]) + 1, 2, '.', '');
                break;
            
            case ($saifi > number_format($saifi_target[4], 3, '.', '')):
                $saifi_kpi= '1.00';
                break;
            // default:
            //     # code...
            //     break;
        }
            // SAIDI
        switch ($saidi) {
            case ($saidi <= number_format($saidi_target[0], 3, '.', '')):
                $saidi_kpi= '5.00';
                break;
            
            case ($saidi <= number_format($saidi_target[1], 3, '.', '')):
                $saidi_kpi= number_format( ($saidi - $saidi_target[1]) / ($saidi_target[0] - $saidi_target[1]) + 4, 2, '.', '');
                break;

            case ($saidi <= number_format($saidi_target[2], 3, '.', '')):
                $saidi_kpi= number_format( ($saidi - $saidi_target[2]) / ($saidi_target[1] - $saidi_target[2]) + 3, 2, '.', '');
                break;

            case ($saidi <= number_format($saidi_target[3], 3, '.', '')):
                $saidi_kpi= number_format( ($saidi - $saidi_target[3]) / ($saidi_target[2] - $saidi_target[3]) + 2, 2, '.', '');
                break;

            case ($saidi <= number_format($saidi_target[4], 3, '.', '')):
                $saidi_kpi= number_format( ($saidi - $saidi_target[4]) / ($saidi_target[3] - $saidi_target[4]) + 1, 2, '.', '');
                break;
            
            case ($saidi > number_format($saidi_target[4], 3, '.', '')):
                $saidi_kpi= '1.00';
                break;
            // default:
            //     # code...
            //     break;
        }        

        return [$saifi, $saidi, $saifi_kpi, $saidi_kpi];
    }

    function calculateIndexAndcomparePreviousYear($no_month, $mea_cust, $cust_num, $cust_min, $mea_cust_previous_year, $cust_num_previous_year, $cust_min_previous_year) {
        // Index this year
        $saifi = number_format($cust_num/$mea_cust*$no_month, 3, '.', '');
        $saidi = number_format($cust_min/$mea_cust*$no_month, 3, '.', '');

        // Index this previous year
        $saifi_previous_year = number_format($cust_num_previous_year/$mea_cust_previous_year*$no_month, 3, '.', '');
        $saidi_previous_year = number_format($cust_min_previous_year/$mea_cust_previous_year*$no_month, 3, '.', '');

        // KPI
            // SAIFI
            if ($saifi <= $saifi_previous_year) {
                $saifi_kpi = '5'; //5 is better than previous year
            } else {
                $saifi_kpi = '1'; //1 is worse than previous year
            }

            // SAIDI
            if ($saidi <= $saidi_previous_year) {
                $saidi_kpi = '5'; //5 is better than previous year
            } else {
                $saidi_kpi = '1'; //1 is worse than previous year
            }
        // $saifi_kpi = '1';
        // $saidi_kpi = '1';
        // echo $saifi_kpi;
        // echo $saidi_kpi;
        return [$saifi, $saidi, $saifi_kpi, $saidi_kpi];
    }

    function calculateIndustrial($no_month, $mea_cust, $cust_num, $cust_min, $saifi_target, $saidi_target) {
        // Index
        $saifi = number_format($cust_num/$mea_cust*$no_month, 2, '.', '');
        $saidi = number_format($cust_min/$mea_cust*$no_month, 2, '.', '');

        // KPI
            // SAIFI
        if ($saifi <= $saifi_target) {
            $saifi_kpi = 'Good';
        } else {
            $saifi_kpi = 'Bad';
        }
        
            // SAIDI
        $saidi_kpi = ($saidi <= $saidi_target) ? 'Good' : 'Bad' ;
        
        return [$saifi, $saidi, $saifi_kpi, $saidi_kpi];
    }
?>