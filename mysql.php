<?php

//CREDENTIALS FOR DB
$servername = "localhost";
$username = "root";
$password = "";

    try {
            $conn = new PDO("mysql:host=$servername;dbname=rex;charset=utf-8", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }

     //creating table if it doesnt exist   
    $stat2 = $conn->prepare("CREATE TABLE IF NOT EXISTS `DE_Table` (
    `Locid` INT AUTO_INCREMENT NOT NULL,
    `name` varchar(200),
    `lat` varchar(100),
    `lon` varchar(100),
    PRIMARY KEY (`Locid`)) DEFAULT CHARSET=utf8") ; 
    $stat2->execute();


    //inserting data in the table from DE.tab file
    $result = array();
    $fp = fopen('DE.tab','r') or die("Unable to open file!");
    if (($headers = fgetcsv($fp, 0, "\t")) !== FALSE)
        if ($headers)
            while (($line = fgetcsv($fp, 0, "\t")) !== FALSE) 
                if ($line)
                    if (sizeof($line)==sizeof($headers))
                        $result[] = array_combine($headers,$line);    
    fclose($fp);
    for($j=0; $j<sizeof($result);$j++){
        $sql = "INSERT IGNORE INTO DE_Table (locid, name,lat,lon)
                VALUES (:locid, :name, :lat, :lon)";
        $statement =$conn->prepare($sql);
        $statement->bindValue(':locid', $result[$j]['#loc_id']);
        $statement->bindValue(':name', $result[$j]['name']);
        $statement->bindValue(':lat', $result[$j]['lat']);
        $statement->bindValue(':lon', $result[$j]['lon']);
        $inserted = $statement->execute();
    }
?> 