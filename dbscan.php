<?php
header( 'Content-type: text/html; charset=utf-8' );
require_once __DIR__ . '/php-ml/vendor/autoload.php';
use Phpml\Clustering\DBSCAN;
use Phpml\Math\Distance\Minkowski;
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
require_once ("mysqldb.php");
?>
<?php
function prt_pre($arr)
{
echo "<textarea style='width:100%;height:30%;'>";
print_r($arr);
echo "</textarea>";	
}
?>
<?php /*** date add from str**************************/
function date_add_from_str($date,$str)
{
date_add($date,date_interval_create_from_date_string($str));	
/* Examples
1 year + 10 mins + 23 secs
10 days
*/
}
?>
<?php // Get post,Get,Session Values
function get_value($type, $name,$dflt_val)
{
$val1=$dflt_val;
$type=strtoupper($type);

if($type!="POST" && $type!="GET" && $type!="SESSION")
{
isset($_POST[$name]) ? $val1=$_POST[$name] : $x="";
isset($_GET[$name]) ? $val1=$_GET[$name] : $x="";
isset($_SESSION[$name]) ? $val1=$_SESSION[$name] : $x="";
}
if($type=="POST") isset($_POST[$name]) ? $val1=$_POST[$name] : $val1=$dflt_val;
if($type=="GET") isset($_GET[$name]) ? $val1=$_GET[$name] : $val1=$dflt_val;
if($type=="SESSION") isset($_SESSION[$name]) ? $val1=$_SESSION[$name] : $val1=$dflt_val;
return $val1;
}
?>
<?php /********** K-Means Sample **************/

function get_samples_dbscan($conn,$st_dt,$end_dt)
{
$samples=array();	
$i=0;
$ar1=array("P"=>1,"T"=>2,"F"=>3,"L"=>4);
$qry = "SELECT al_id, al_date, al_stat, UNIX_TIMESTAMP(al_date) u_al_dt from gail_alarms where al_date between '$st_dt' and '$end_dt'";
$stmt=execute_query($conn,$qry);
while($row = $stmt->fetch(PDO::FETCH_NUM)) {
	//if ($row[2]=='S') $stat=1; else $stat=0;
	$samples[$i]=array($row[3],$row[2],$row[0]);

	$i++;
}
$qry = "SELECT ev_id, ev_date, ev_stat, UNIX_TIMESTAMP(ev_date) u_ev_dt from gail_events where ev_date between '$st_dt' and '$end_dt'";
$stmt=execute_query($conn,$qry);
while($row = $stmt->fetch(PDO::FETCH_NUM)) {
	//if ($row[2]=='S') $stat=1; else $stat=0;
	$samples[$i]=array($row[3],$row[2],$row[0]);
	$i++;
}
$qry = "SELECT st_id, st_date, st_stat, UNIX_TIMESTAMP(st_date) u_st_dt from gail_stat where st_date between '$st_dt' and '$end_dt'";
$stmt=execute_query($conn,$qry);
while($row = $stmt->fetch(PDO::FETCH_NUM)) {
	//if ($row[2]=='S') $stat=1; else $stat=0;
	$samples[$i]=array($row[3],$row[2],$row[0]);
	$i++;
}
return $samples;
}
?>
<?php /********** km data **************/
function dbscan_dta($arr,$samples)
{
$arr1=array();
$arr2=array();
$i=0;
foreach ($arr as $k1=>$v1)	
{
$ab1=array_column( $v1, '0' );
$min_t = min($ab1);
$max_t = max($ab1);
$arr_name="clust_{$min_t}_{$max_t}";
//echo "<br>clust_{$min_t}_{$max_t}";	
foreach ($v1 as $k2=>$v2) 
{
foreach ($v2 as $k3=>$v3)
{		
if ($k3==1) $s1="_".$v3;
if ($k3==2) $arr1[$arr_name][]=$v3.$s1;
//if ($k3==2) $arr1[$arr_name][]=$v3.$s1;
}
//echo "<br>".implode(",",$v2);
}
$i++;
}
//prt_pre($arr1);
return $arr1;
}
?>
<?php 
$start_dt="";
$interval=get_value("","interval","1 day ");
$n_inter=get_value("","n_inter","1");
$epsilon=get_value("","epsilon","300");
$minSamples_val=get_value("","minSamples","3");
$qry="SELECT * FROM clu_aut_st_dt limit 1";
$stmt=execute_query($conn,$qry);
while($row = $stmt->fetch(PDO::FETCH_NUM)) {
	if ($row[0]) $start_dt=$row[0];
	}
if(count(start_dt)>0)
{
//$dbscan = new DBSCAN($epsilon = $epsilon, $minSamples = $minSamples_val);
$dbscan = new DBSCAN($epsilon = $epsilon, $minSamples = $minSamples_val,new Minkowski($lambda=0.1));
//$dbscan = new DBSCAN($epsilon = 5, $minSamples = 3, new Minkowski($lambda=4));
//$kmeans = new KMeans($n_group);
$st_dt = date_create($start_dt);
$end_dt=clone $st_dt;
date_add_from_str($end_dt,$interval);
$start_time = microtime(true); 
//$stmt=execute_query($conn,"DELETE FROM cluster_aut");

for($i=0;$i<$n_inter;$i++)
{	
$st_str=date_format($st_dt,"Y-m-d H:i:s");
$end_str=date_format($end_dt,"Y-m-d H:i:s");
$samples=get_samples_dbscan($conn,$st_str,$end_str);
echo "<br>No. of Samples=".count($samples);
if (count($samples)>0)
{
echo "<br>$st_str _ $end_str";
$dbs1=$dbscan->cluster($samples);
$dbs2=dbscan_dta($dbs1,$samples);
$val_arr=[];
$val_arr1=[];
$i=0;
foreach($dbs2 as $k1 =>$v1)
{
$in_arr=[];
$out_arr=[];
$stat_arr=[];
$in_arr1=[];
$out_arr1=[];
$stat_arr1=[];
	//$dt_str=explode("_",$v1);
	foreach($v1 as $k2 =>$v2)
	{
	$ex1=explode("_",$v2);
	$ex1[0]=str_replace("-","_",$ex1[0]);
	if ($v2[1]=='1') $in_arr[]=$v2;
	if ($v2[1]=='2') $out_arr[]=$v2;
	if ($v2[1]=='3') $stat_arr[]=$v2;
	if ($v2[1]=='1') $in_arr1[$ex1[0]]=$ex1[1];
	if ($v2[1]=='2' && count($in_arr1)>0) $out_arr1[$ex1[0]]=$ex1[1];
//	if ($v2[1]=='3') $stat_arr1[$ex1[0]]=$ex1[1];
	
	}
//prt_pre($in_arr1);	
$val_arr[$k1][]=$in_arr;
$val_arr[$k1][]=$out_arr;
$val_arr[$k1][]=$stat_arr;
if (count($out_arr1)>0)
{
$val_arr1[$i]["input"]=$in_arr1;
$val_arr1[$i]["output"]=$out_arr1;
$i++;
//$val_arr1[$k1]["status"]=$stat_arr1;
}

}
//prt_pre($val_arr1);
//unset ($dbs2);
echo "<br>No. of output=".count($dbs2);
echo "<br>No. of val=".count($val_arr);
$dbs3=json_encode($val_arr);
$dbs4=json_encode($val_arr1);
//prt_pre($dbs2);
//prt_pre($dbs4);
//prt_pre($val_arr);
//prt_pre($dbs2);
$qry="INSERT INTO cluster_aut  VALUES ('$st_str','$end_str','$dbs3','$dbs4','0','','')";
$stmt=execute_query($conn,$qry);
$stmt=execute_query($conn,"commit");  
date_add_from_str($st_dt,$interval);
$end_dt=clone $st_dt;
date_add_from_str($end_dt,$interval);
unset ($val_arr);
unset ($dbs3);
}
unset($samples);
}	
$end_time = microtime(true); 
$execution_time = ($end_time - $start_time); 
echo "<br> It takes ".$execution_time." seconds to execute the script";
}
?>
