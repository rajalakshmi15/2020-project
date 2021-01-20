<?php
require_once("../mysqldb.php");

class MySQLTableEdit {
public $table_name="";
public $row_count=0;
public $col_count=0;
public $col_names=[];

function __construct($conn,$table)
{
$qry="select * from $table";
$stmt=execute_query($conn,$qry);
$row_count = $stmt->rowCount();
$col_count=$stmt->columnCount();
for($i=0;$i<$col_count;$i++)
{
	$x=$stmt->getColumnMeta($i);
	$this->col_names[]=$x['name'];
}
$this->create_table($stmt);
} // function _construct ends here	
function create_table($stmt)
{
echo "<table border=1 style='width:100%;'>";
echo "<thead><tr>";
//echo "<pre>".print_r($this->col_names[0])."</pre>";
foreach($this->col_names as $key => $val) echo "<th>$val</th>";
echo "</tr></thead>";
echo "<tbody>";	
while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
	echo "<tr>";
foreach($row as $k1 => $v1)
echo "<td>$v1</td>";
echo "</tr>";
}
echo "</tbody>";
echo "<tfoot><tr>";
foreach($this->col_names as $key => $val) echo "<th>$val</th>";
echo "</tr></tfoot>";
echo "</table>";
}  // create table ends here
} // class ends here

$a = new MySQLTableEdit($conn,"gail_alarms");	
//$a->x($conn);
?>