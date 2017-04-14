<?php

//CREDENTIALS FOR DB
$servername = "localhost";
$username = "root";
$password = "";

    try {
            $conn = new PDO("mysql:host=$servername;dbname=rex;charset=utf-8", $username, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }
    

    //CREATE QUERY TO DB AND PUT RECEIVED DATA INTO ASSOCIATIVE ARRAY
    if (isset($_REQUEST['query'])) {
        echo $_REQUEST['query'];
        $query = $_REQUEST['query'];
        echo $query;
        $sql = "SELECT locid, name, lat, lon FROM DE_Table WHERE locid  LIKE '%{$query}%' COLLATE utf8_bin OR  name LIKE '%{$query}%' COLLATE utf8_bin LIMIT 20";
        $result = $conn->query($sql);
        $array = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $array[] = array (
                'label' => utf8_decode($row['name'].', '.$row['locid'].','.$row['lat'].','.$row['lon']),
                'value' => utf8_decode($row['name']),
            );
        }
        //RETURN JSON ARRAY
        echo json_encode($array);
    }
?>