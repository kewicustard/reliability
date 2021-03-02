<?php
    header('Content-Type: application/json');

    require_once 'db.php';
    $dbh = new PDO($dsn, $username, $password, $options);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $selectedYear = $_GET[selectedYear];
    $target = (int) $_GET[checkTarget]; // 1 has target for that year.
    if($target == 0){ // hasn't target
        $previous_year = $selectedYear - 1;
        // echo $previous_year;
        // echo gettype($previous_year);
    }

    // Target or Previous year
    if ($target != 0) {
        // Target
        $sql = 'SELECT month(yearmonthnumbertarget) AS data_month, 
                saifi_meatarget_1 AS saifi_1, saifi_meatarget_2 as saifi_2, saifi_meatarget_3 AS saifi_3, saifi_meatarget_4 as saifi_4, saifi_meatarget_5 AS saifi_5, 
                saidi_meatarget_1 AS saidi_1, saidi_meatarget_2 as saidi_2, saidi_meatarget_3 AS saidi_3, saidi_meatarget_4 as saidi_4, saidi_meatarget_5 AS saidi_5, 
                saifi_lstarget_1 AS saifi_ls_1, saifi_lstarget_2 as saifi_ls_2, saifi_lstarget_3 AS saifi_ls_3, saifi_lstarget_4 as saifi_ls_4, saifi_lstarget_5 AS saifi_ls_5, 
                saidi_lstarget_1 AS saidi_ls_1, saidi_lstarget_2 as saidi_ls_2, saidi_lstarget_3 AS saidi_ls_3, saidi_lstarget_4 as saidi_ls_4, saidi_lstarget_5 AS saidi_ls_5, 
                saifi_disttarget_1 AS saifi_f_1, saifi_disttarget_2 as saifi_f_2, saifi_disttarget_3 AS saifi_f_3, saifi_disttarget_4 as saifi_f_4, saifi_disttarget_5 AS saifi_f_5, 
                saidi_disttarget_1 AS saidi_f_1, saidi_disttarget_2 as saidi_f_2, saidi_disttarget_3 AS saidi_f_3, saidi_disttarget_4 as saidi_f_4, saidi_disttarget_5 AS saidi_f_5
                FROM target_mea_sepa_focus_group WHERE yearmonthnumbertarget BETWEEN "'.$selectedYear.'-01-01" AND "'.$selectedYear.'-12-01"';

        try {
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // saifi_target
            $saifi_target[m1][] = $row[saifi_1];
            $saifi_target[m2][] = $row[saifi_2];
            $saifi_target[m3][] = $row[saifi_3];
            $saifi_target[m4][] = $row[saifi_4];
            $saifi_target[m5][] = $row[saifi_5];
            $saifi_target[ls1][] = $row[saifi_ls_1];
            $saifi_target[ls2][] = $row[saifi_ls_2];
            $saifi_target[ls3][] = $row[saifi_ls_3];
            $saifi_target[ls4][] = $row[saifi_ls_4];
            $saifi_target[ls5][] = $row[saifi_ls_5];
            $saifi_target[f1][] = $row[saifi_f_1];
            $saifi_target[f2][] = $row[saifi_f_2];
            $saifi_target[f3][] = $row[saifi_f_3];
            $saifi_target[f4][] = $row[saifi_f_4];
            $saifi_target[f5][] = $row[saifi_f_5];

            // saidi_target
            $saidi_target[m1][] = $row[saidi_1];
            $saidi_target[m2][] = $row[saidi_2];
            $saidi_target[m3][] = $row[saidi_3];
            $saidi_target[m4][] = $row[saidi_4];
            $saidi_target[m5][] = $row[saidi_5];
            $saidi_target[ls1][] = $row[saidi_ls_1];
            $saidi_target[ls2][] = $row[saidi_ls_2];
            $saidi_target[ls3][] = $row[saidi_ls_3];
            $saidi_target[ls4][] = $row[saidi_ls_4];
            $saidi_target[ls5][] = $row[saidi_ls_5];
            $saidi_target[f1][] = $row[saidi_f_1];
            $saidi_target[f2][] = $row[saidi_f_2];
            $saidi_target[f3][] = $row[saidi_f_3];
            $saidi_target[f4][] = $row[saidi_f_4];
            $saidi_target[f5][] = $row[saidi_f_5];
        }
    } else { //no target, use previous year
        // Previous year

        // MEA focus group customer
        {
            $sql = 'SELECT month AS data_month, sum(nocus) AS mea_cust_month FROM discust WHERE year = '.$previous_year.' AND district in (SELECT code FROM focusdist WHERE year = "'.$selectedYear.'") GROUP BY data_month';
            try {
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Something wrong!!! '.$e->getMessage();
            }

            $no_month = $stmt->rowCount();
            $i = 0;
            $accuMeaCust = array();
            $eachMeaCust = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($i == 0) {
                    $accuMeaCust[$i] = [
                                                data_month => $row[data_month], 
                                                mea_cust_month => $row[mea_cust_month]
                                            ];
                } else {
                    $accuMeaCust[$i] = [
                                                data_month => $row[data_month], 
                                                mea_cust_month => $accuMeaCust[$i-1][mea_cust_month]+$row[mea_cust_month]
                                            ];
                }
                $eachMeaCust[] = $row;
                $i++;
            }
            // print_r($accuMeaCust);
            // print_r($eachMeaCust);
        }
        // /MEA focus group customer

        // MEA
        {
            $sql = 'SELECT month(date) AS data_month, sum(cust_num) AS cust_num_month, sum(cust_min) AS cust_min_month
                        FROM indices_db 
                        WHERE timeocb > 1 
                            AND event in("i", "o") 
                            AND major is null 
                            AND year(date) = "'.$previous_year.'" 
                            AND control = "c" 
                            AND custdist in (SELECT code FROM focusdist WHERE year = "'.$selectedYear.'") 
                            group by month(date)';

            try {
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Something wrong!!! '.$e->getMessage();
            }

            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $custNumMin = fetchCustNumMin($row, $no_month);
            $accuCustNumMin = $custNumMin[0];
            $eachCustNumMin = $custNumMin[1];
            // /MEA
            // calculate MEA saifi saidi for previous year
            $indices = calculateAccuIndices($accuCustNumMin, $accuMeaCust);
            $saifi_m_previous_year = $indices[0];
            $saidi_m_previous_year = $indices[1];
            $indices = calculateEachIndices($eachCustNumMin, $eachMeaCust);
            $saifi_m_month_previous_year = $indices[0];
            $saidi_m_month_previous_year = $indices[1];
            // print_r($saifi_previous_year);
            // print_r($saidi_previous_year);
            // print_r($saifi_month_previous_year);
            // print_r($saidi_month_previous_year);
            // echo count($saifi_previous_year);
            // /calculate MEA saifi saidi for previous year
        }

        // Transmission Line and Station
        {
            $sql = 'SELECT month(date) AS data_month, sum(cust_num) AS cust_num_month, sum(cust_min) AS cust_min_month
                    FROM indices_db 
                    WHERE timeocb > 1 
                        and event in("i", "o") 
                        and major is null 
                        and year(date) = "'.$previous_year.'" 
                        and group_type in("l", "s") 
                        and control = "c" 
                        AND custdist in (SELECT code FROM focusdist WHERE year = "'.$selectedYear.'") 
                        group by month(date)';

            try {
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Something wrong!!! '.$e->getMessage();
            }

            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $custNumMin = fetchCustNumMin($row, $no_month);
            $accuCustNumMin = $custNumMin[0];
            $eachCustNumMin = $custNumMin[1];
            // /Transmission Line and Station
            // calculate Transmission Line and Station saifi saidi
            $indices = calculateAccuIndices($accuCustNumMin, $accuMeaCust);
            $saifi_ls_previous_year = $indices[0];
            $saidi_ls_previous_year = $indices[1];
            $indices = calculateEachIndices($eachCustNumMin, $eachMeaCust);
            $saifi_ls_month_previous_year = $indices[0];
            $saidi_ls_month_previous_year = $indices[1];
            // print_r($saifi_ls_previous_year);
            // /calculate Transmission Line and Station saifi saidi
        }

        // Feeder
        {
            $sql = 'SELECT month(date) AS data_month, sum(cust_num) AS cust_num_month, sum(cust_min) AS cust_min_month
                    FROM indices_db 
                    WHERE timeocb > 1 
                        and event in("i", "o") 
                        and major is null 
                        and year(date) = "'.$previous_year.'" 
                        and group_type = "f" 
                        and control = "c" 
                        AND custdist in (SELECT code FROM focusdist WHERE year = "'.$selectedYear.'") 
                        group by month(date)';

            try {
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Something wrong!!! '.$e->getMessage();
            }

            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $custNumMin = fetchCustNumMin($row, $no_month);
            $accuCustNumMin = $custNumMin[0];
            $eachCustNumMin = $custNumMin[1];
            // /Feeder
            // calculate Feeder saifi saidi
            $indices = calculateAccuIndices($accuCustNumMin, $accuMeaCust);
            $saifi_f_previous_year = $indices[0];
            $saidi_f_previous_year = $indices[1];
            $indices = calculateEachIndices($eachCustNumMin, $eachMeaCust);
            $saifi_f_month_previous_year = $indices[0];
            $saidi_f_month_previous_year = $indices[1];
            // print_r($saifi_f_previous_year);
            // /calculate Feeder saifi saidi
        }

        $saifi_previous_year[m] = $saifi_m_previous_year;
        $saifi_previous_year[m_month] = $saifi_m_month_previous_year;
        $saifi_previous_year[ls] = $saifi_ls_previous_year;
        $saifi_previous_year[ls_month] = $saifi_ls_month_previous_year;
        $saifi_previous_year[f] = $saifi_f_previous_year;
        $saifi_previous_year[f_month] = $saifi_f_month_previous_year;
        
        $saidi_previous_year[m] = $saidi_m_previous_year;
        $saidi_previous_year[m_month] = $saidi_m_month_previous_year;
        $saidi_previous_year[ls] = $saidi_ls_previous_year;
        $saidi_previous_year[ls_month] = $saidi_ls_month_previous_year;
        $saidi_previous_year[f] = $saidi_f_previous_year;
        $saidi_previous_year[f_month] = $saidi_f_month_previous_year;
        // print_r($saifi_previous_year);
        // print_r($saidi_previous_year);
        // /Previous year
    }
    // /Target or Previous year
    
    // check lasted month of indices_db table
    {
        $sql = 'SELECT max(month(date)) AS lasted_month 
                    FROM indices_db 
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
    // /check lasted month of indices_db table

    // check lasted day of lasted month of indices_db_15,30days table
    {
        $sql = 'SELECT max(day(date)) AS lasted_day 
                    FROM indices_db 
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

    // Calculate This year

        if ($lasted_day >= 28) {
            // MEA focus group customer
            {
                $sql = 'SELECT month AS data_month, sum(nocus) AS mea_cust_month FROM discust WHERE year = '.$selectedYear.' AND month <= '.$lasted_month.' AND district in (SELECT code FROM focusdist WHERE year = "'.$selectedYear.'") GROUP BY data_month';
                try {
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute();
                } catch (PDOException $e) {
                    echo 'Something wrong!!! '.$e->getMessage();
                }
        
                $no_month = $stmt->rowCount();
                $i = 0;
                $accuMeaCust = array();
                $eachMeaCust = array();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    if ($i == 0) {
                        $accuMeaCust[$i] = [
                                                    data_month => $row[data_month], 
                                                    mea_cust_month => $row[mea_cust_month]
                                                ];
                    } else {
                        $accuMeaCust[$i] = [
                                                    data_month => $row[data_month], 
                                                    mea_cust_month => $accuMeaCust[$i-1][mea_cust_month]+$row[mea_cust_month]
                                                ];
                    }
                    $eachMeaCust[] = $row;
                    $i++;
                }
            }
            // /MEA focus group customer
        } else { //$lasted_day <= 15
            // MEA focus group customer
            {
                if ($lasted_month == 1) {
                    $sql = 'SELECT month AS data_month, sum(nocus) AS mea_cust_month FROM discust WHERE year = '.($selectedYear-1).' AND district in (SELECT code FROM focusdist WHERE year = "'.$selectedYear.'") AND month = 12 GROUP BY data_month';
                } else {
                    $sql = 'SELECT month AS data_month, sum(nocus) AS mea_cust_month FROM discust WHERE year = '.$selectedYear.' AND district in (SELECT code FROM focusdist WHERE year = "'.$selectedYear.'") AND month < '.$lasted_month.' GROUP BY data_month';
                }
                
                try {
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute();
                } catch (PDOException $e) {
                    echo 'Something wrong!!! '.$e->getMessage();
                }

                $no_month = $stmt->rowCount();
                $i = 0;
                $accuMeaCust = array();
                $eachMeaCust = array();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    if ($i == 0) {
                        $accuMeaCust[$i] = [
                                                    data_month => $row[data_month], 
                                                    mea_cust_month => $row[mea_cust_month]
                                                ];
                    } else {
                        $accuMeaCust[$i] = [
                                                    data_month => $row[data_month], 
                                                    mea_cust_month => $accuMeaCust[$i-1][mea_cust_month]+$row[mea_cust_month]
                                                ];
                    }
                    $eachMeaCust[] = $row;
                    $i++;
                }

                if ($lasted_month > 1) {
                    $eachMeaCust[] = [
                                        data_month => $i+1,
                                        mea_cust_month => $eachMeaCust[$i-1][mea_cust_month]
                                    ];
                    $accuMeaCust[] = [
                                        data_month => $i+1,
                                        mea_cust_month => $accuMeaCust[$i-1][mea_cust_month]+$eachMeaCust[$i][mea_cust_month]
                                    ];
                } else { // lasted_month = 1
                    $eachMeaCust[0][data_month] = 1;
                    $accuMeaCust[0][data_month] = 1;
                }
            }
            // /MEA focus group customer
        }

        // MEA
        {
            // official indices of previous month
            $sql = 'SELECT month(date) AS data_month, sum(cust_num) AS cust_num_month, sum(cust_min) AS cust_min_month
                    FROM indices_db 
                    WHERE timeocb > 1 
                        AND event in("i", "o") 
                        AND major is null 
                        AND year(date) = "'.$selectedYear.'" 
                        AND control = "c" 
                        AND custdist in (SELECT code FROM focusdist WHERE year = "'.$selectedYear.'") 
                        AND month(date) < "'.$lasted_month.'" 
                        group by month(date)';

            try {
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Something wrong!!! '.$e->getMessage();
            }

            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // unofficial indices 15 days of current month
            $sql = 'SELECT month(date) AS data_month, sum(cust_num) AS cust_num_month, sum(cust_min) AS cust_min_month
                    FROM indices_db 
                    WHERE timeocb > 1 
                        AND event in("i", "o") 
                        AND major is null 
                        AND year(date) = "'.$selectedYear.'" 
                        AND control = "c" 
                        AND custdist in (SELECT code FROM focusdist WHERE year = "'.$selectedYear.'") 
                        AND month(date) = "'.$lasted_month.'" 
                        group by month(date)';

            try {
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Something wrong!!! '.$e->getMessage();
            }

            $row2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $row[] = $row2[0];

            $custNumMin = fetchCustNumMin($row, $lasted_month);
            $accuCustNumMin = $custNumMin[0];
            $eachCustNumMin = $custNumMin[1];
        }
        // /MEA
        // calculate MEA saifi saidi
        {
            $indices = calculateAccuIndices($accuCustNumMin, $accuMeaCust);
            $saifi = $indices[0];
            $saidi = $indices[1];
            $indices = calculateEachIndices($eachCustNumMin, $eachMeaCust);
            $saifi_month = $indices[0];
            $saidi_month = $indices[1];
            // print_r($saifi);
            // print_r($saidi);
            // print_r($saifi_month);
            // print_r($saidi_month);
            // echo count($saifi);
        }
        // /calculate MEA saifi saidi
        // calculate MEA KPI
        {
            if ($target != 0) {
                // Target
                $kpi = calculateKPI($saifi, $saidi, $saifi_target, $saidi_target, 'm');
                $saifi_kpi = $kpi[0];
                $saidi_kpi = $kpi[1];
                // print_r($kpi);
            } else { //hasn't target then compare with previous year
                $compare_previous_year = calculateComparePreviousyear($saifi, $saidi, $saifi_previous_year, $saidi_previous_year, 'm');
                $saifi_compare_previous_year = $compare_previous_year[0];
                $saidi_compare_previous_year = $compare_previous_year[1];
                // print_r($saifi_compare_previous_year);
                // print_r($saidi_compare_previous_year);
            }
        }
        // /calculate MEA KPI
        
        // Transmission Line and Station
        {
            // official indices of previous month
            $sql = 'SELECT month(date) AS data_month, sum(cust_num) AS cust_num_month, sum(cust_min) AS cust_min_month
                    FROM indices_db 
                    WHERE timeocb > 1 
                        AND event in("i", "o") 
                        AND major is null 
                        AND year(date) = "'.$selectedYear.'" 
                        AND group_type in("l", "s") 
                        AND control = "c" 
                        AND custdist in (SELECT code FROM focusdist WHERE year = "'.$selectedYear.'") 
                        AND month(date) < "'.($lasted_month).'" 
                        group by month(date)';

            try {
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Something wrong!!! '.$e->getMessage();
            }

            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // unoffcial indices 15 days of current month
            $sql = 'SELECT month(date) AS data_month, sum(cust_num) AS cust_num_month, sum(cust_min) AS cust_min_month
                    FROM indices_db 
                    WHERE timeocb > 1 
                        AND event in("i", "o") 
                        AND major is null 
                        AND year(date) = "'.$selectedYear.'" 
                        AND group_type in("l", "s") 
                        AND control = "c" 
                        AND custdist in (SELECT code FROM focusdist WHERE year = "'.$selectedYear.'") 
                        AND month(date) = "'.($lasted_month).'" 
                        group by month(date)';

            try {
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Something wrong!!! '.$e->getMessage();
            }

            $row2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $row[] = $row2[0];

            $custNumMin = fetchCustNumMin($row, $lasted_month);
            $accuCustNumMin = $custNumMin[0];
            $eachCustNumMin = $custNumMin[1];
        }
        // /Transmission Line and Station
        // calculate Transmission Line and Station saifi saidi
        {
            $indices = calculateAccuIndices($accuCustNumMin, $accuMeaCust);
            $saifi_ls = $indices[0];
            $saidi_ls = $indices[1];
            $indices = calculateEachIndices($eachCustNumMin, $eachMeaCust);
            $saifi_ls_month = $indices[0];
            $saidi_ls_month = $indices[1];
        }
        // /calculate Transmission Line and Station saifi saidi
        // calculate Transmission Line and Station KPI
        {
            if ($target != 0) {
                // Target
                $kpi = calculateKPI($saifi_ls, $saidi_ls, $saifi_target, $saidi_target, "ls");
                $saifi_ls_kpi = $kpi[0];
                $saidi_ls_kpi = $kpi[1];
                // print_r($kpi);
            } else { //hasn't target then compare with previous year
                $compare_previous_year = calculateComparePreviousyear($saifi_ls, $saidi_ls, $saifi_previous_year, $saidi_previous_year, 'ls');
                $saifi_ls_compare_previous_year = $compare_previous_year[0];
                $saidi_ls_compare_previous_year = $compare_previous_year[1];
                // print_r($saifi_ls_compare_previous_year);
                // print_r($saidi_ls_compare_previous_year);
            }
        }
        // /calculate Transmission Line and Station KPI

        // Feeder
        {
            // official indices of previous month
            $sql = 'SELECT month(date) AS data_month, sum(cust_num) AS cust_num_month, sum(cust_min) AS cust_min_month
                    FROM indices_db 
                    WHERE timeocb > 1 
                        AND event in("i", "o") 
                        AND major is null 
                        AND year(date) = "'.$selectedYear.'" 
                        AND group_type = "f" 
                        AND control = "c" 
                        AND custdist in (SELECT code FROM focusdist WHERE year = "'.$selectedYear.'") 
                        AND month(date) < "'.($lasted_month).'" 
                        group by month(date)';

            try {
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Something wrong!!! '.$e->getMessage();
            }

            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // unoffcial indices 15 days of current month
            $sql = 'SELECT month(date) AS data_month, sum(cust_num) AS cust_num_month, sum(cust_min) AS cust_min_month
                    FROM indices_db 
                    WHERE timeocb > 1 
                        AND event in("i", "o") 
                        AND major is null 
                        AND year(date) = "'.$selectedYear.'" 
                        AND group_type = "f" 
                        AND control = "c" 
                        AND custdist in (SELECT code FROM focusdist WHERE year = "'.$selectedYear.'") 
                        AND month(date) = "'.($lasted_month).'" 
                        group by month(date)';

            try {
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Something wrong!!! '.$e->getMessage();
            }

            $row2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $row[] = $row2[0];

            $custNumMin = fetchCustNumMin($row, $lasted_month);
            $accuCustNumMin = $custNumMin[0];
            $eachCustNumMin = $custNumMin[1];
        }
        // /Feeder
        // calculate Feeder saifi saidi
        {
            $indices = calculateAccuIndices($accuCustNumMin, $accuMeaCust);
            $saifi_f = $indices[0];
            $saidi_f = $indices[1];
            $indices = calculateEachIndices($eachCustNumMin, $eachMeaCust);
            $saifi_f_month = $indices[0];
            $saidi_f_month = $indices[1];
        }    
        // /calculate Feeder saifi saidi
        // calculate Feeder KPI
        {
            if ($target != 0) {
                // Target
                $kpi = calculateKPI($saifi_f, $saidi_f, $saifi_target, $saidi_target, "f");
                $saifi_f_kpi = $kpi[0];
                $saidi_f_kpi = $kpi[1];
            // print_r($kpi);
            } else { //hasn't target then compare with previous year
                $compare_previous_year = calculateComparePreviousyear($saifi_f, $saidi_f, $saifi_previous_year, $saidi_previous_year, 'f');
                $saifi_f_compare_previous_year = $compare_previous_year[0];
                $saidi_f_compare_previous_year = $compare_previous_year[1];
                // print_r($saifi_f_compare_previous_year);
                // print_r($saidi_f_compare_previous_year);
            }
        }
        // /calculate Feeder KPI

    // Calculate This year

    if ($target != 0) { //has target, use target
        
        echo json_encode([  
                            saifi => $saifi, 
                            saidi => $saidi,
                            saifi_month => $saifi_month, 
                            saidi_month => $saidi_month,
                            saifi_ls => $saifi_ls,
                            saidi_ls => $saidi_ls,
                            saifi_ls_month => $saifi_ls_month,
                            saidi_ls_month => $saidi_ls_month,
                            saifi_f => $saifi_f,
                            saidi_f => $saidi_f,
                            saifi_f_month => $saifi_f_month,
                            saidi_f_month => $saidi_f_month,
                            saifi_target => $saifi_target,
                            saidi_target => $saidi_target,
                            saifi_kpi => $saifi_kpi,
                            saidi_kpi => $saidi_kpi,
                            saifi_ls_kpi => $saifi_ls_kpi,
                            saidi_ls_kpi => $saidi_ls_kpi,
                            saifi_f_kpi => $saifi_f_kpi,
                            saidi_f_kpi => $saidi_f_kpi,
                            lasted_day => $lasted_day,
                            lasted_month => $lasted_month,
                        ]);
        // $jsonData = json_encode($row);
        // echo $jsonData;
    } else { //no target, use previous year
        
        echo json_encode([  
            saifi => $saifi, 
            saidi => $saidi,
            saifi_month => $saifi_month, 
            saidi_month => $saidi_month,
            saifi_ls => $saifi_ls,
            saidi_ls => $saidi_ls,
            saifi_ls_month => $saifi_ls_month,
            saidi_ls_month => $saidi_ls_month,
            saifi_f => $saifi_f,
            saidi_f => $saidi_f,
            saifi_f_month => $saifi_f_month,
            saidi_f_month => $saidi_f_month,
            saifi_previous_year => $saifi_previous_year,
            saidi_previous_year => $saidi_previous_year,
            saifi_comparePY => $saifi_compare_previous_year,
            saidi_comparePY => $saidi_compare_previous_year,
            saifi_ls_comparePY => $saifi_ls_compare_previous_year,
            saidi_ls_comparePY => $saidi_ls_compare_previous_year,
            saifi_f_comparePY => $saifi_f_compare_previous_year,
            saidi_f_comparePY => $saidi_f_compare_previous_year,
            lasted_day => $lasted_day,
            lasted_month => $lasted_month,
        ]);

    }
        

    // close connection
    $dbh = null;

    // fectch PDO object to variable
    function fetchCustNumMin($row, $no_month) {
        $x = 0; // count for index $row
        $accuCustNumMin = array();
        $eachCustNumMin = array();
        for ($i = 0; $i < $no_month; $i++) {
            if ($i == 0) {
                if ($row[$x][data_month] == $i+1) {
                    $accuCustNumMin[$i] = [
                                            data_month => $row[$x][data_month], 
                                            cust_num_month => $row[$x][cust_num_month], 
                                            cust_min_month => $row[$x][cust_min_month]
                                          ];
                    $eachCustNumMin[$i] = $accuCustNumMin[$i];
                    $x++;
                } else {
                    $accuCustNumMin[$i] = [
                                            data_month => $i+1, 
                                            cust_num_month => 0, 
                                            cust_min_month => 0
                                          ];
                    $eachCustNumMin[$i] = $accuCustNumMin[$i];
                }            
            } else {
                if ($row[$x][data_month] == $i+1) {
                    $accuCustNumMin[$i] = [
                                            data_month => $row[$x][data_month], 
                                            cust_num_month => $accuCustNumMin[$i-1][cust_num_month]+$row[$x][cust_num_month], 
                                            cust_min_month => $accuCustNumMin[$i-1][cust_min_month]+$row[$x][cust_min_month]
                                          ];
                    $eachCustNumMin[$i] = [
                                            data_month => $row[$x][data_month], 
                                            cust_num_month => $row[$x][cust_num_month], 
                                            cust_min_month => $row[$x][cust_min_month]
                                          ];
                    $x++;                                                            
                } else {
                    $accuCustNumMin[$i] = [
                                            data_month => $i+1, 
                                            cust_num_month => $accuCustNumMin[$i-1][cust_num_month], 
                                            cust_min_month => $accuCustNumMin[$i-1][cust_min_month]
                                          ];
                    $eachCustNumMin[$i] = [
                                            data_month => $i+1, 
                                            cust_num_month => 0, 
                                            cust_min_month => 0
                                          ];
                }  
            }        
        }
    
        return array($accuCustNumMin, $eachCustNumMin);
    }
    // /fectch PDO object to variable

    // calculate indices
    function calculateAccuIndices($CustNumMin, $MeaCust) {
        // $saifi = array();
        // $saidi = array();
        foreach ($CustNumMin as $key => $value) {
            $saifi[] = number_format($value[cust_num_month]/$MeaCust[$key][mea_cust_month]*$value[data_month], 3, '.', '');
            $saidi[] = number_format($value[cust_min_month]/$MeaCust[$key][mea_cust_month]*$value[data_month], 3, '.', '');
        }
        
        return [$saifi, $saidi];
    }

    function calculateEachIndices($CustNumMin, $MeaCust) {
        // $saifi = array();
        // $saidi = array();
        foreach ($CustNumMin as $key => $value) {
            $saifi[] = number_format($value[cust_num_month]/$MeaCust[$key][mea_cust_month], 3, '.', '');
            $saidi[] = number_format($value[cust_min_month]/$MeaCust[$key][mea_cust_month], 3, '.', '');
        }
        
        return [$saifi, $saidi];
    }
    // /calculate indices

    // calculate KPI
    function calculateKPI($saifi, $saidi, $saifi_target, $saidi_target, $system) {
        // $no_month = count($saifi);
            // for mea, line&station, feeder
            foreach ($saifi as $key => $value) {
                switch ($value) {
                    case ($value <= $saifi_target[$system."5"][$key]):
                        $saifi_kpi[] = '5.00';
                        break;
                    
                    case ($value <= $saifi_target[$system."4"][$key]):
                        $saifi_kpi[] = number_format( ($value - $saifi_target[$system."4"][$key]) / ($saifi_target[$system."5"][$key] - $saifi_target[$system."4"][$key]) + 4, 2, '.', '');
                        break;
    
                    case ($value <= $saifi_target[$system."3"][$key]):
                        $saifi_kpi[] = number_format( ($value - $saifi_target[$system."3"][$key]) / ($saifi_target[$system."4"][$key] - $saifi_target[$system."3"][$key]) + 3, 2, '.', '');
                        break;
    
                    case ($value <= $saifi_target[$system."2"][$key]):
                        $saifi_kpi[] = number_format( ($value - $saifi_target[$system."2"][$key]) / ($saifi_target[$system."3"][$key] - $saifi_target[$system."2"][$key]) + 2, 2, '.', '');
                        break;
    
                    case ($value <= $saifi_target[$system."1"][$key]):
                        $saifi_kpi[] = number_format( ($value - $saifi_target[$system."1"][$key]) / ($saifi_target[$system."2"][$key] - $saifi_target[$system."1"][$key]) + 1, 2, '.', '');
                        break;
                    
                    case ($value > $saifi_target[$system."1"][$key]):
                        $saifi_kpi[] = '1.00';
                        break;
                    // default:
                    //     # code...
                    //     break;
                }
                
                switch ($saidi[$key]) {
                    case ($saidi[$key] <= $saidi_target[$system."5"][$key]):
                        $saidi_kpi[] = '5.00';
                        break;
                    
                    case ($saidi[$key] <= $saidi_target[$system."4"][$key]):
                        $saidi_kpi[] = number_format( ($saidi[$key] - $saidi_target[$system."4"][$key]) / ($saidi_target[$system."5"][$key] - $saidi_target[$system."4"][$key]) + 4, 2, '.', '');
                        break;
    
                    case ($saidi[$key] <= $saidi_target[$system."3"][$key]):
                        $saidi_kpi[] = number_format( ($saidi[$key] - $saidi_target[$system."3"][$key]) / ($saidi_target[$system."4"][$key] - $saidi_target[$system."3"][$key]) + 3, 2, '.', '');
                        break;
    
                    case ($saidi[$key] <= $saidi_target[$system."2"][$key]):
                        $saidi_kpi[] = number_format( ($saidi[$key] - $saidi_target[$system."2"][$key]) / ($saidi_target[$system."3"][$key] - $saidi_target[$system."2"][$key]) + 2, 2, '.', '');
                        break;
    
                    case ($saidi[$key] <= $saidi_target[$system."1"][$key]):
                        $saidi_kpi[] = number_format( ($saidi[$key] - $saidi_target[$system."1"][$key]) / ($saidi_target[$system."2"][$key] - $saidi_target[$system."1"][$key]) + 1, 2, '.', '');
                        break;
                    
                    case ($saidi[$key] > $saidi_target[$system."1"][$key]):
                        $saidi_kpi[] = '1.00';
                        break;
                    // default:
                    //     # code...
                    //     break;
                }
            }            
        
        return [$saifi_kpi, $saidi_kpi];
    }
    // /calculate KPI

    // calculate compare with previous year
    function calculateComparePreviousYear($saifi, $saidi, $saifi_previous_year, $saidi_previous_year, $system) {
        // $no_month = count($saifi);
        // print_r($saifi);
        // print($system);
        foreach ($saifi as $key => $value) { // -(minus) is better than previous year, + is worse than previous year
            // echo gettype($value);
            // settype($value, "float");
            // echo gettype($value);            
            $saifi_comparePY[] = number_format( ($value - $saifi_previous_year[$system][$key]) / $saifi_previous_year[$system][$key] * 100, 2, '.', '');
            // echo ( ($saifi_comparePY[$key] == 'nan' || $saifi_comparePY[$key] == 'inf') ? '-' : 'a' );
            if ($saifi_comparePY[$key] == 'nan' || $saifi_comparePY[$key] == 'inf') {
                $saifi_comparePY[$key] = '-';
            }

            $saidi_comparePY[] = number_format( ($saidi[$key] - $saidi_previous_year[$system][$key]) / $saidi_previous_year[$system][$key] * 100, 2, '.', '');
            // echo gettype(($value - $saifi_previous_year[$system][$key]) / $saifi_previous_year[$system][$key] * 100);
            if ($saidi_comparePY[$key] == 'nan' || $saidi_comparePY[$key] == 'inf') {
                $saidi_comparePY[$key] = '-';
            }
            
        }

            // print_r($saifi_comparePY);
        return [$saifi_comparePY, $saidi_comparePY];
    }
    // /calculate KPI
?>