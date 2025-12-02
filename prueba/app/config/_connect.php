<?php
    $host = 'localhost';
    $db = 'bdpdo';
    $user = 'userpdo';
    $password = 'passodo123';
    $port = '3306';
    $charset = 'utf8';

    try {
        $dsn = "mysql:host=".$host.";dbname=".$db.";charset=".$charset;
        $dbh = new PDO($dsn, $user, $password);
        echo 'Conexiòn Èxitosa';
    }//end try 
    catch (PDOException $e){
        echo "Error: ".$e->getMessage();
    }//end catch