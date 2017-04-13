<?php

//CREDENTIALS FOR DB
define ('DBSERVER', 'localhost');
define ('DBUSER', 'user');
define ('DBPASS','password');
define ('DBNAME','rex');

$servername = "localhost";
$username = "root";
$password = "";

    try {
            $conn = new PDO("mysql:host=$servername;dbname=rex", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //  echo "Connected successfully"
            $stmt = $conn->prepare("SELECT * FROM address"); 
            $stmt->execute();

            // set the resulting array to associative
           // $result = $stmt->fetchAll();
            //print_r($result);

        }
    catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }



    $stat2 = $conn->prepare("CREATE TABLE IF NOT EXISTS `add5` (
    `Locid` INT AUTO_INCREMENT NOT NULL,
    `name` varchar(200),
    `lat` varchar(100),
    `lon` varchar(100),
    PRIMARY KEY (`Locid`))"); 
    $stat2->execute();



    $result = array();
    $fp = fopen('DE.tab','r') or die("Unable to open file!");
    if (($headers = fgetcsv($fp, 0, "\t")) !== FALSE)
        if ($headers)
            while (($line = fgetcsv($fp, 0, "\t")) !== FALSE) 
                if ($line)
                    if (sizeof($line)==sizeof($headers))
                        $result[] = array_combine($headers,$line);
    
    fclose($fp);
    //print_r($result);
    //echo sizeof($result);

    for($j=0; $j<sizeof($result);$j++){

        //echo $result[$j]['name'];
        $sql = "INSERT IGNORE INTO add5 (locid, name,lat,lon)
                VALUES (:locid, :name, :lat, :lon)";
        //echo $sql;
        $statement =$conn->prepare($sql);

        $statement->bindValue(':locid', $result[$j]['#loc_id']);
        $statement->bindValue(':name', $result[$j]['name']);
        $statement->bindValue(':lat', $result[$j]['lat']);
        $statement->bindValue(':lon', $result[$j]['lon']);
        //echo $result[$j]['lat'];
        $inserted = $statement->execute();
    }

    echo "inserted";

    //fclose($fp);

   /* $mySearch = $_POST['mySearchHTMLVariable'];

    $query="SELECT * FROM add2 WHERE CONCAT(locid, ' ', name,' ') like '%$mySearch%'"; */

    //CREATE QUERY TO DB AND PUT RECEIVED DATA INTO ASSOCIATIVE ARRAY
    if (isset($_REQUEST['query'])) {
        echo "inside if";
        $query = $_REQUEST['query'];
        $sql = mysql_query ("SELECT locid, name FROM add3 WHERE locid LIKE '%{$query}%' OR name LIKE '%{$query}%'");
        echo $sql;
    	$array = array();
        while ($row = mysql_fetch_array($sql)) {
            $array[] = array (
                'label' => $row['name'].', '.$row['locid'],
                'value' => $row['name'],
            );
        }
        //RETURN JSON ARRAY
        echo json_encode ($array);
    }

?>