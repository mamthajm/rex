    <?php

    include "mysql.php";

try{
    $stmt = $conn->prepare("SELECT * FROM addressdetails WHERE 1"); 
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
        echo $v;
    }
}
catch(PDOException $e) {
     echo "Error: " . $e->getMessage();
}
	$conn = null;
	echo "</table>";

    ?>