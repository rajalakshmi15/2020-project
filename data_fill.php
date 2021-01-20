<?php
/* $m = new MongoDB\Driver\Manager("mongodb://localhost:27017/");
$stats = new MongoDB\Driver\Command(["dbstats" => 1]);
$res = $m->executeCommand("testdb", $stats);
$query = new MongoDB\Driver\Query([]);
$rows = $m->executeQuery("use testdb", $query);
var_dump($res); */
//phpinfo();
date_default_timezone_set('Asia/Kolkata');
if(session_id() == '' || !($_SESSION)) {session_start();}
require_once ("mysqldb.php");
$_SESSION["data_fill"]="Data";
ob_implicit_flush(true);
ob_end_flush();
?>
<script>
var i='0';
function progress(i)
{
//i++;	
document.getElementById("test").innerHTML = i;	
}
//myVar = setInterval(progress, 1000);
</script>
<div id="test">Hello</div>
<?php
//ob_flush();
//flush();
//sleep(1);
$a["P"]="Pressure";
$a["T"]="Temperature";
$a["F"]="Flow";
$a["L"]="Level";
$vals1=array ("Very Low","Low","High", "Very High");
$vals2=array ("P","T","F","L");
$vals3=array ("VL","L","H","VH");
$b["P"]="10000";
$b["T"]="20000";
$b["F"]="30000";
$b["L"]="40000";

/**************************** AL Master **************************/
function fill_al_master($conn)
{
try
{
$vals2=$GLOBALS['vals2'];
$vals1=$GLOBALS['vals1'];
$vals3=$GLOBALS['vals3'];
$a=$GLOBALS['a'];
$stmt=execute_query($conn,"DELETE FROM Gail_Alarm.gail_al_master");
$j=0;
$arr1=array();
//$stmt=execute_query($conn,"DELETE FROM Gail_Alarm.gail_al_master");
foreach($a as $k1 => $v1)
{
for($i=1;$i<=50;$i++)
{
	$k=0;
	foreach($vals1 as $k2 => $v2)
	{
	$e_id=str_pad(100000+$i, 6, "0", STR_PAD_LEFT);
	$e_no=str_pad($i, 4, "0", STR_PAD_LEFT);
	array_push($arr1,"('$k1$e_id-{$vals3[$k2]}','$k1$e_no $v1 $v2')");
	$k++;
	}
}
	$j++;
}
//echo implode(",",$arr1);
$qry="INSERT INTO Gail_Alarm.gail_al_master (m_al_id, m_al_desc) VALUES ".implode(",",$arr1);
$stmt=execute_query($conn,$qry);
$stmt=execute_query($conn,"commit");
echo "Alarm master updated.<br>";
}
catch(Exception $e) {
  echo 'fill al master Exception: ' .$e->getMessage();
}
}
/**************************** EV ST Master **************************/
function fill_ev_st_master($conn)
{
try
{
$stmt=execute_query($conn,"DELETE FROM Gail_Alarm.gail_ev_master");
$stmt=execute_query($conn,"DELETE FROM Gail_Alarm.gail_st_master");
$stmt=execute_query($conn,"DELETE FROM Gail_Alarm.gail_al_master where m_al_id like 'M%'");
$b=array("Open Command", "Close Command");
$c=array("On Command", "Off Command");
$d=array("Opened", "Closed");
$e=array("Running", "Stopped");
$f=array("OP","CL");
$g=array("ON","OFF");
$h=array("OPD","CLD");
$x=array("R","S");

$arr1=array();
$arr2=array();
$arr3=array();
for ($j=1;$j<=30;$j++)	
{
	for ($i=0;$i<2;$i++)
	{
	$e_id=str_pad(200000+$j, 6, "0", STR_PAD_LEFT);
	$e_id1=str_pad(300000+$j, 6, "0", STR_PAD_LEFT);
	$e_no=str_pad($j, 4, "0", STR_PAD_LEFT);
	//echo "('V$e_id','Valve V$e_no {$b[$i]}')";
	array_push($arr1,"('V$e_id-{$f[$i]}','Valve V$e_no {$b[$i]}')");
	array_push($arr2,"('V$e_id1-{$h[$i]}','Valve V$e_no {$d[$i]}')");
	}
}
for ($j=1;$j<=20;$j++)	
{
	for ($i=0;$i<2;$i++)
	{
	$e_id=str_pad(200000+$j, 6, "0", STR_PAD_LEFT);
	$e_id1=str_pad(300000+$j, 6, "0", STR_PAD_LEFT);
	$e_id2=str_pad(100000+$j, 6, "0", STR_PAD_LEFT);
	$e_no=str_pad($j, 4, "0", STR_PAD_LEFT);
	//echo "('M$e_id','Valve M$e_no {$c[$i]}')";
	array_push($arr1,"('M$e_id-{$g[$i]}','Motor M$e_no {$c[$i]}')");
	array_push($arr2,"('M$e_id1-{$x[$i]}','Motor M$e_no {$e[$i]}')");
	if($i==0) array_push($arr3,"('M$e_id2-TR','Motor M$e_no Tripped')");
	}
}

//echo implode(",",$arr1);
$qry="INSERT INTO Gail_Alarm.gail_ev_master (m_ev_id, m_ev_desc) VALUES ".implode(",",$arr1);
$stmt=execute_query($conn,$qry);
$qry="INSERT INTO Gail_Alarm.gail_st_master (m_st_id, m_st_desc) VALUES ".implode(",",$arr2);
$stmt=execute_query($conn,$qry);
$qry="INSERT INTO Gail_Alarm.gail_al_master (m_al_id, m_al_desc) VALUES ".implode(",",$arr3);
$stmt=execute_query($conn,$qry);
$stmt=execute_query($conn,"commit");
echo "Event & Status master updated.<br>";
}
catch(Exception $e) {
  echo 'fill al master Exception: ' .$e->getMessage();
}
}


function db_upd($conn,$table,$arr)
{

$qry="INSERT INTO $table  VALUES ".implode(",",$arr);
//echo "<br>$qry";
$stmt=execute_query($conn,"DELETE FROM $table");
$stmt=execute_query($conn,$qry);
$stmt=execute_query($conn,"commit");
$m=count($arr);
echo "<br>gail alarms Updated.: $m";
unset ($arr);
}

function get_db_str($date,$t_val,$str1,$id,$id_stat,$type)
{
$str=" $t_val $str1 ";
if ($type==1) 
{
$dt1=clone $date;
date_add($dt1,date_interval_create_from_date_string($str));
$date_str=date_format($dt1,"Y-m-d H:i:s").".".mt_rand(0,999);
}
else
{
date_add($date,date_interval_create_from_date_string($str));
$date_str=date_format($date,"Y-m-d H:i:s").".".mt_rand(0,999);
}
//echo "<br>('$id','$date_str','$id_stat')  : $str $type ";
return "('$id','$date_str','$id_stat')";
}

function gen_al_ev_st($conn)
{
try
{
$grp_in[]=array('P100005-H','T100005-H');
$grp_out[]=array('V200003-OP');
$grp_in[]=array('L100010-L','P100007-H');
$grp_out[]=array('V200005-CL');
$grp_in[]=array('T100003-V','P100008-H','P100009-L');
$grp_out[]=array('M200008-ON','V200012-OP');
$grp_in[]=array('P100011-L','P100012-H','P100006-L');
$grp_out[]=array('V200010-OP','V200004-OP');
$grp_in[]=array('T100015-H','L100018-H','P100040-L');
$grp_out[]=array('V200020-OP','V200015-OP');

$st_dt="2020-01-01";
$end_dt="2020-02-01";

$y1="('";
foreach($grp_in as $k1 => $x1)
$y1.=implode("','",$x1)."','";
$y1.=" ')";
$qry="select m_al_id from gail_al_master where m_al_id not in $y1 ORDER BY RAND()";
$sth=execute_query($conn,$qry);
while($row = $sth->fetch()) {
	$rnd_in_vals[]=$row[0];
	}
	echo count($rnd_in_vals);
$arr1=array();
$arr2=array();
$arr3=array();
$date2 = date_create($st_dt);
$aaa=0;
$st_ev['OP']=array('-OPD','-CLD');
$st_ev['CL']=array('-CLD','-OPD');
$st_ev['ON']=array('-S','-R');
$st_ev['OFF']=array('-R','-S');
$ev_1['OP']='-CL';
$ev_1['CL']='-OP';
$ev_1['ON']='-OFF';
$ev_1['OFF']='ON';
for ($date1=date_create($st_dt);$date1<=date_create($end_dt);/*date_add_from_str($date1," 1 day ")*/)
{
//$rnd_al_id =get_rnd_db_id($conn,"gail_al_master");
$min=mt_rand(25,40);
date_add_from_str($date1," $min mins ");
$rnd_grp=mt_rand(0,4);

foreach($grp_in[$rnd_grp] as $k2 => $v2)
{
$rnd_al_id=$v2;
array_push($arr1,get_db_str($date1,mt_rand(0,59),"secs",$rnd_al_id,'1',0));
array_push($arr1,get_db_str($date1,mt_rand(10,15),"mins",$rnd_al_id,'0',1));
}

foreach($grp_out[$rnd_grp] as $k2 => $v2)
{
$v3=explode("-",$v2);
//$rnd_al_id=$v2;
$rnd_al_id=$v3[0].$ev_1[$v3[1]];
array_push($arr2,get_db_str($date1,mt_rand(0,300),"secs",$rnd_al_id,'0',0));
//$rnd_al_id=$v3[0].$ev_1[$v3[1]];
$rnd_al_id=$v2;
array_push($arr2,get_db_str($date1,mt_rand(3,5),"secs",$rnd_al_id,'1',1));
$rnd_al_id=$v3[0].$st_ev[$v3[1]][1];
$rnd_al_id[1]=3;
array_push($arr3,get_db_str($date1,mt_rand(3,5),"secs",$rnd_al_id,'0',1));
$rnd_al_id=$v3[0].$st_ev[$v3[1]][0];
$rnd_al_id[1]=3;
array_push($arr3,get_db_str($date1,mt_rand(10,20),"secs",$rnd_al_id,'1',1));
}
/*
for ($i=0;$i<mt_rand(0,3);$i++)
{
if ($aaa<count($rnd_in_vals))
{
$rnd_al_id=$rnd_in_vals[$aaa];
array_push($arr1,get_db_str($date1,mt_rand(1,3),"mins",$rnd_al_id,'1',0));
array_push($arr1,get_db_str($date1,mt_rand(1,100),"mins",$rnd_al_id,'0',1));
$aaa++;
}
else
	$aaa=0;
}
*/
$diff_secs = $date1->format('U') - $date2->format('U');
$t_diff=gmdate("H:i:s", $diff_secs);
$date2=clone $date1;
//echo "<br>$t_diff--------------------------------------------------------------------";
}
//echo implode(",",$arr1);
db_upd($conn,"gail_alarms",$arr1);
db_upd($conn,"gail_events",$arr2);
db_upd($conn,"gail_stat",$arr3);
unset($arr1);
unset($arr2);
unset($arr3);
}
catch(Exception $e) {
  echo 'fill al master Exception: ' .$e->getMessage();
}
}

/**************************** GEN ALARMS **************************/
function gen_alarms($conn)
{
try
{
$stmt=execute_query($conn,"DELETE FROM Gail_Alarm.gail_alarms");
//$stmt=execute_query($conn,"DELETE FROM Gail_Alarm.gail_events");
//$stmt=execute_query($conn,"DELETE FROM Gail_Alarm.gail_stat");
$m=0;
$arr1=array();
$arr2=array();
$arr3=array();
for ($date1=date_create("2020-01-01");$date1<=date_create("2020-01-31");/*date_add_from_str($date1," 1 day ")*/)
{
$m++;
//$equip_no=str_pad($i, 6, "0", STR_PAD_LEFT);
//echo "<script>progress('No. of Alarms=$m');</script>";
$min=mt_rand(0,59);
$sec=mt_rand(0,59);
date_add_from_str($date1," $min mins $sec secs ");
$date_str=date_format($date1,"Y-m-d H:i:s").".".mt_rand(0,999);
$rnd_al_id =get_rnd_db_id($conn,"gail_al_master");
array_push($arr1, "('$rnd_al_id','$date_str')");
}
//echo implode(",",$arr1);
$qry="INSERT INTO Gail_Alarm.gail_alarms (al_id, al_date) VALUES ".implode(",",$arr1);
$stmt=execute_query($conn,$qry);
$stmt=execute_query($conn,"commit");
echo "gail alarms Updated.: $m<br>";
}
catch(Exception $e) {
  echo 'fill al master Exception: ' .$e->getMessage();
}
}

/**************************** GEN Events and Status **************************/
function gen_ev_st($conn)
{
try
{
//$stmt=execute_query($conn,"DELETE FROM Gail_Alarm.gail_alarms");
$stmt=execute_query($conn,"DELETE FROM Gail_Alarm.gail_events");
$stmt=execute_query($conn,"DELETE FROM Gail_Alarm.gail_stat");
$m=0;
$arr1=array();
$arr2=array();
$arr3=array();
for ($date1=date_create("2020-01-01");$date1<=date_create("2020-01-31");/*date_add_from_str($date1," 1 day ")*/)
{
$m++;
//$equip_no=str_pad($i, 6, "0", STR_PAD_LEFT);
//echo "<script>progress('No. of Events=$m');</script>";
$min=mt_rand(0,59);
$sec=mt_rand(0,59);
date_add_from_str($date1," $min mins $sec secs ");
$date_str=date_format($date1,"Y-m-d H:i:s").".".mt_rand(0,999);
$rnd_ev_id =get_rnd_db_id($conn,"gail_ev_master");
array_push($arr1,"('$rnd_ev_id','$date_str')");
//$qry="INSERT INTO gail_alarm.gail_events (ev_id, ev_date) VALUES('$rnd_id', '$date_str')";
//$stmt=execute_query($conn,$qry);
$sec=mt_rand(10,20);
$date2=$date1;
date_add_from_str($date2," $sec secs ");
$rnd_ev_id[1]='3';
$rnd_st_id = str_replace('-OP', '-OPD',$rnd_ev_id); 
$rnd_st_id = str_replace('-CL', '-CLD',$rnd_st_id);
$rnd_st_id = str_replace('-ON', '-R',$rnd_st_id);
$rnd_st_id = str_replace('-OFF', '-S',$rnd_st_id);
$date_str=date_format($date2,"Y-m-d H:i:s").".".mt_rand(0,999);
array_push ($arr2,"('$rnd_st_id','$date_str')");
//$qry="INSERT INTO gail_alarm.gail_stat (st_id, st_date) VALUES('$rnd_id', '$date_str')";
//$stmt=execute_query($conn,$qry);

//echo "<br>$qry";
}
$qry="INSERT INTO Gail_Alarm.gail_events (ev_id, ev_date) VALUES ".implode(",",$arr1);
$stmt=execute_query($conn,$qry);
$qry="INSERT INTO Gail_Alarm.gail_stat (st_id, st_date) VALUES ".implode(",",$arr2);
$stmt=execute_query($conn,$qry);
$stmt=execute_query($conn,"commit");
echo "gail Events & Status Updated.: $m<br>";
}
catch(Exception $e) {
  echo 'fill al master Exception: ' .$e->getMessage();
}
}
/**************************** date add **************************/
function date_add_from_str($date,$str)
{
date_add($date,date_interval_create_from_date_string($str));	
/* Examples
1 year + 10 mins + 23 secs
10 days
*/
}
/**************************** GET Random  DB id **************************/
function get_rnd_db_id($conn,$table)
{
	$ret_val="";
	$qry="SELECT * FROM Gail_Alarm.$table ORDER BY RAND() LIMIT 1";
	//echo $qry."<br>";
	$sth=execute_query($conn,$qry);
	while($row = $sth->fetch()) {
	$ret_val= $row[0];	
	}
	return $ret_val;
}
/**************************** Functions End **************************/
//fill_al_master($conn);
//fill_ev_st_master($conn);
//fill_st_master($conn);
//gen_alarms($conn);
//gen_ev_st($conn);
gen_al_ev_st($conn);

//$_SESSION["data_fill"]="complete";
try
{
//echo date_format($date1,"Y/m/d H:i:s:u");
//echo date_interval_create_from_date_string("1 year + 10 mins + 23 secs")."<br>";

/*	
//Generate a timestamp using mt_rand.
$timestamp = mt_rand(1, time());
echo time();
//Format that timestamp into a readable date string.
$randomDate = date("d m Y", 0);
//Print it out.
echo $randomDate."<br>";
echo mt_rand(10,100);
//$stmt=execute_query($conn,"");
//execute_query($conn,"commit;");
*/
}
catch(Exception $e) {
  echo 'Main Exception: ' .$e->getMessage();
}
?>