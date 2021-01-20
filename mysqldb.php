<?php
/*
$inipath = php_ini_loaded_file();

if ($inipath) {
    echo 'Loaded php.ini: ' . $inipath;
} else {
    echo 'A php.ini file is not loaded';
}
*/
?>
<?php
function execute_query($conn,$query)
{
		$stmt = $conn->prepare($query);
		$stmt->execute();
		return $stmt;
}
function test_db_1($stmt)
{	
		//$sth=execute_query($conn,$query);
	echo "<pre><table border='1'>";
	echo "<tr>";
	for ($i = 0; $i < $stmt->columnCount(); $i++) {
		
    $col = $stmt->getColumnMeta($i);
	echo "<td>".$col['name']."</td>";
    //$columns[] = $col['name'];
}
echo "</tr>";
//print_r($columns);
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
   echo "<tr>";
   foreach($row as $value) {
      echo "<td>{$value}</td>";
   }
   echo "</tr>";
   
}
echo "</table></pre>";
echo "<br> Row Count = ".$stmt->rowCount();
}
function test_db($conn,$query)
{
	
		$sth=execute_query($conn,$query);
	echo "<table border=1>";
	while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
   echo "<tr>";
   foreach($row as $value) {
      echo "<td>{$value}</td>";
   }
   echo "</tr>";
   echo "</table>";
}
echo "<br> Row Count = ".$sth->rowCount();
}

try {
    
	$host= gethostname();
	$ip = gethostbyname($host);
	//echo $ip;
	/*
	$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
); 
*/
	//$mysqli = new mysqli("localhost","swarna","swarna","gail_alarm");
	$conn = new PDO("mysql:host=$ip:3306;dbname=gail_alarm", "swarna", "swarna");
    // set the PDO error mode to exception
	
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
    echo "<br>" . $e->getMessage();
    }
	
//test_db($conn,"select * from ann_net;");
?>
<?php
//phpinfo();
?>