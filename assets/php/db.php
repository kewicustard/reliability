<?php
    $dsn = 'mysql:host=localhost; dbname=statistics_database';
    $username = 'root';
    $password = 'pcd_db';
    $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    );
?>