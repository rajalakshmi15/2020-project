<?php
require_once ("mysqldb.php");
?>
<?php
function get_post_val($key,$def_val)
{
	$val="";
	//isset($_POST[$key]) ? $val=$_POST[$key] : $val=$def_val;
	if (isset($_POST[$key]))
		$val=$_POST[$key]; 
	else
		if (isset($_GET[$key]))
		$val=$_GET[$key];
	else
	$val=$def_val;
	return $val;
}
?>
<?php
$table_name=get_post_val("table_name","");
$vals=get_post_val("values","");
//echo $table_name;
//echo $vals;
$vals1=json_decode($vals,true);
$cn=[];
$vals2=[];
foreach($vals1 as $k1 => $v1)
$cn[]=$k1;
foreach($vals1 as $k1 => $v1)
{
if($v1=='') $vals2[]="null";
else
$vals2[]="'$v1'";
}
$qry="INSERT INTO $table_name (".implode(",",$cn).") values(".implode(",",$vals2).")";
//echo $qry;
try
{
	$stmt=execute_query($conn,$qry);
	$stmt=execute_query($conn,"commit");
	echo "Added:Table($table_name), Values($vals)";
}
catch (Exception $e)
{
	echo $e;
}
//var_dump($cn);

/* INSERT INTO Customers (CustomerName, City, Country)
VALUES ('Cardinal', 'Stavanger', 'Norway'); */
?>