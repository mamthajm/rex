<?php

//CREDENTIALS FOR DB
define ('DBSERVER', 'localhost');
define ('DBUSER', 'user');
define ('DBPASS','password');
define ('DBNAME','dbname');

$servername = "localhost";
$username = "root";
$password = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=rex", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }

    //CREATE QUERY TO DB AND PUT RECEIVED DATA INTO ASSOCIATIVE ARRAY
    if (isset($_REQUEST['query'])) {
        $query = $_REQUEST['query'];
        $sql = mysql_query ("SELECT zip, city FROM zips WHERE city LIKE '%{$query}%' OR zip LIKE '%{$query}%'");
    	$array = array();
        while ($row = mysql_fetch_array($sql)) {
            $array[] = array (
                'label' => $row['city'].', '.$row['zip'],
                'value' => $row['city'],
            );
        }
        //RETURN JSON ARRAY
        echo json_encode ($array);
    }

?>