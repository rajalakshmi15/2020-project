
<?php
require_once ("mysqldb.php");
?>

<?php
for ($i=0;$i<=5;$i++)
{

	$sec1=$i*3;

	$sec2=$sec1+3;
		if ($i==0) $sec2=3;
	echo "<br>$sec1,$sec2";
	$qry="INSERT INTO GAIL_ALARMS VALUES('P100019-H','2020-01-01 01:00:$sec1','1')";
	$stmt=execute_query($conn,$qry);
	$qry="INSERT INTO GAIL_ALARMS VALUES('P100019-H','2020-01-01 01:00:$sec2','0')";
	$stmt=execute_query($conn,$qry);
	$stmt=execute_query($conn,"commit");
}
?>