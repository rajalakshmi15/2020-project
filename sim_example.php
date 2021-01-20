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
$id=get_post_val("id","");
$dt=get_post_val("dt","");
$stat=get_post_val("val","");
echo "$id,$dt,$stat";
if($id[0]!='V')
{
$qry="insert into gail_alarms values('$id','$dt','$stat')";
$stmt=execute_query($conn,$qry);
$qry="commit";
$stmt=execute_query($conn,$qry);
}
if($id=='V200005- OPEN')
{
$v1=explode("-",$id);
$v2=$v1[0]."-OP";
$v3=$v1[0]."-CL";
$qry="insert into gail_alarms values('$v3','$dt','0')";
$stmt=execute_query($conn,$qry);
$qry="insert into gail_alarms values('$v2','$dt','1')";
$stmt=execute_query($conn,$qry);
$qry="commit";
$stmt=execute_query($conn,$qry);
}
if($id=='V200005- CLOSE')
{
$v1=explode("-",$id);
$v2=$v1[0]."-OP";
$v3=$v1[0]."-CL";
$qry="insert into gail_alarms values('$v2','$dt','0')";
$stmt=execute_query($conn,$qry);
$qry="insert into gail_alarms values('$v3','$dt','1')";
$stmt=execute_query($conn,$qry);
$qry="commit";
$stmt=execute_query($conn,$qry);
}
if($id=='V300005-OPENED')
{
$v1=explode("-",$id);
$v2=$v1[0]."-OPD";
//$v3=$v1[0]."-CL";
$qry="insert into gail_alarms values('$v2','$dt','$stat')";
$stmt=execute_query($conn,$qry);
/* $qry="insert into gail_alarms values('$v2','$dt','1')";
$stmt=execute_query($conn,$qry); */
$qry="commit";
$stmt=execute_query($conn,$qry);
}
if($id=='V300005-CLOSED')
{
$v1=explode("-",$id);
$v2=$v1[0]."-CLD";
//$v3=$v1[0]."-CL";
$qry="insert into gail_alarms values('$v2','$dt','$stat')";
$stmt=execute_query($conn,$qry);
/* $qry="insert into gail_alarms values('$v2','$dt','1')";
$stmt=execute_query($conn,$qry); */
$qry="commit";
$stmt=execute_query($conn,$qry);
}
/* if($id=='V200005- OPEN')
{
$qry="insert into gail_alarms values('$id','$dt','$stat')";
$stmt=execute_query($conn,$qry);
$qry="insert into gail_alarms values('$id','$dt','$stat')";
else
{
$qry="insert into gail_alarms values('$id','$dt','$stat')";
}
$stmt=execute_query($conn,$qry);
$qry="commit";
$stmt=execute_query($conn,$qry);
} */
/* $qry="select distinct id,desc1,max(dt) dt1 from active_vals where substr(id,2,1)='1' group by id,desc1 order by
 dt1 desc Limit 3";
$stmt=execute_query($conn,$qry);
echo "<pre><table>";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
	echo "<tr>";
	foreach($row as $key => $val) 
	{
		echo "<td style='height:10px; padding:1px 4px;color:red;'>$val</td>";
	}
	//echo "{$row['al_id']}, {$row['m_al_desc']}, {$row['al_date']} <br>";
	echo "</tr>";
}
echo "</table></pre>"; */
?>