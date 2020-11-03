<?php
    header('Content-Type: application/json');

    require_once 'db.php';
    $dbh = new PDO($dsn, $username, $password, $options);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $monthFrom = substr($_GET[dateFrom], 0, 2);
    $monthTo = substr($_GET[dateTo], 0, 2);
    $yearFrom = substr($_GET[dateFrom], 6);
    $yearTo = substr($_GET[dateTo], 6);

    // echo $monthFrom;
    // echo $monthTo;
    // echo $yearFrom;
    // echo $yearTo;
    
    { // load data previous year
        if ($yearFrom < $yearTo) {
            if ($_GET[unofficialData] == 'false') {
                $sql = 'SELECT month, year, district, nocus FROM statistics_database.discust WHERE district <> 99 AND month >= '.$monthFrom.' AND year = '.$yearFrom;
            } else { //$_GET[unoffcialData == 'true']
                if ($monthTo != '01') {
                    $sql = 'SELECT month, year, district, nocus FROM statistics_database.discust WHERE district <> 99 AND month >= '.$monthFrom.' AND year = '.$yearFrom;
                } else{ // $monthTo == '01'
                    $sql = 'SELECT month, year, district, nocus FROM statistics_database.discust WHERE district <> 99 AND month BETWEEN '.$monthFrom.' AND 11 AND year = '.$yearFrom;
                }
            }

            //check selected district    
            if ($_GET[district] > 0) {
                $sql .= ' AND district = '.$_GET[district];
            }

            try {
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Something wrong!!! '.$e->getMessage();
            }
        
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetchAll for converting from PDO data object to array
        }  
    }
    
    { // load data last year
        if ($_GET[unofficialData] == 'false') {
            $sql = 'SELECT month, year, district, nocus FROM statistics_database.discust WHERE district <> 99 AND month <= '.$monthTo.' AND year = '.$yearTo;
        } else { //$_GET[unoffcialData == 'true']
            if ($monthTo == '01') {
                $sql = 'SELECT month, year, district, nocus FROM statistics_database.discust WHERE district <> 99 AND month = 12 AND year = '.($yearTo-1);
            } else {
                $sql = 'SELECT month, year, district, nocus FROM statistics_database.discust WHERE district <> 99 AND month <= '.($monthTo-1).' AND year = '.$yearTo;
            }
        }
        
        //check selected district    
        if ($_GET[district] > 0) {
            $sql .= ' AND district = '.$_GET[district];
        }

        try {
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }
    
        $row2 = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetchAll for converting from PDO data object to array    
    }
    // print_r($row);
    // print_r($row2);
    foreach ($row2 as $key => $value) {
        $row[] = $value;
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