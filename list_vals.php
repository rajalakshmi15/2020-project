<?php
header( 'Content-type: text/html; charset=utf-8' );
require_once __DIR__ . '/php-ml/vendor/autoload.php';
use Phpml\Association\Apriori;
use Phpml\ModelManager;
?>
<?php
$clr_al=array("VH"=>"red","H"=>"orange","L"=>"orange","VL"=>"red","TR"=>"RED","OP"=>"red","CL"=>"GREEN","OPD"=>"red","CLD"=>"red","ON"=>"red","OFF"=>"Green","R"=>"RED","S"=>"GREEN");
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
function get_db_val($conn,$qry)
{
$val="";
$stmt=execute_query($conn,$qry);
while ($row = $stmt->fetch(PDO::FETCH_NUM))
{
$val=$row[0];
}	
return $val;
}
?>
<?php
function tbl_data($id,$header,$footer,$stmt)
{
echo "<table id='tbl_$id' border='1' class='table table-bordered table-striped'  style='margin-left: auto; margin-right: auto;'>";
echo "<thead style='padding:10px 10px;'><tr>";
foreach($header as $key => $val) echo "<th>$val</th>";
echo "</tr></thead>";
echo "<tbody style='padding: 0px 0px; height:10px;'>";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
	//if($row['al_id']!=NULL) echo "<br>".$row['al_id']; else echo "<br>x";
	$val1=explode("-",$row['al_id']);
	//echo "<br>".($val1[1]);
	$clr_1="GRAY";
	if($row['al_stat']=='1')
	{
	$clr_2=$GLOBALS["clr_al"];
	$clr_1=$clr_2[$val1[1]];
	}
	//if (isset($val1[1])) if (count($val1[1])>0) $clr_1=$clr_al[$val1[1]];
	//echo $clr_1;
	//echo "<tr>";
	foreach($row as $key => $val) 
	{
	echo "<td style='color:$clr_1; height:10px; padding:2px 8px;'>$val</td>";
	}
	//echo "{$row['al_id']}, {$row['m_al_desc']}, {$row['al_date']} <br>";
	echo "</tr>";
}
echo "</tbody>";
echo "<tfoot><tr>";
foreach($header as $key => $val) echo "<th>$val</th>";
echo "</tr></tfoot>";
echo "</table>";
}
?>
<?php
function tbl_master_data($id,$header,$footer,$stmt)
{
echo "<table id='tbl_$id' border='1' class='table table-bordered table-striped' style='margin-left: auto; margin-right: auto;'>";
echo "<thead><tr>";
foreach($header as $key => $val) echo "<th>$val</th>";
echo "</tr></thead>";
echo "<tbody>";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
	echo "<tr>";
	foreach($row as $key => $val)
	{	
	echo "<td style='height:10px; padding:2px 8px;'>$val</td>";
	}
	/*
	echo "<td style='height:10px; padding:2px 8px;'>";
	echo "<button style='height:30px;'><i class='fa fa-plus fa-xs' ></i></button>";
	echo "<button style='height:30px;margin-left:5px;' onclick='tbl_edit(this);' id='edit_$id'><i class='fa fa-edit fa-xs'   ></i></button>";
	echo "<button style='height:30px;margin-left:5px;' id='del_$id' onclick='tbl_edit(this);' ><i class='fa fa-trash fa-xs'></i></button>";
	echo "</td>";
	*/
	echo "</tr>";
}
echo "</tbody>";
/*
echo "<tfoot><tr>";
foreach($header as $key => $val) echo "<th>$val</th>";
echo "</tr></tfoot>";
*/
echo "</table>";

}
?>
<?php
function tbl_grp_data($id,$conn,$st_dt)
{
	//echo $st_dt;
	$date=date_create($st_dt);
$st_dt=date_format($date,"Y-m-d 00:00:00");
echo $st_dt;
$qry = "select clu_data from cluster_aut where clu_st_dt='$st_dt' limit 1";
$stmt=execute_query($conn,$qry);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
	foreach($row as $key => $val) 
	{
	$vals=json_decode($val,true);
	}
	}
/* get_db_val($conn,"select set_al_min_dt()");
$qry = "SELECT * from grp_aut_json";
$stmt=execute_query($conn,$qry); */
$header=array("Cluster from","Cluster to","Alarms Cluster","Events Cluster","Status Cluster");
$footer =$header;
echo "<table id='tbl_$id' border='1' class='table table-bordered table-striped' style='margin-left: auto; margin-right: auto;'>";
echo "<thead>";
//echo "<tr ><th colspan='4' ><button onclick='add_group(this);'>Add selected to group</button></th></tr>";
echo "<tr>";
foreach($header as $key => $val) echo "<th>$val</th>";
echo "</tr></thead>";
echo "<tbody>";
foreach($vals as $key => $val) 
	{
	echo "<tr>";
	$key10=explode("_",$key);
	//$dt1=gmdate("Y-m-d H:i:s ", $key10[1]+86400);
	//$dt2=gmdate("Y-m-d H:i:s ", $key10[2]+86400);
	date_default_timezone_set("Asia/Kolkata");
	$dt1=date("Y-m-d H:i:s ", $key10[1]);
	$dt2=date("Y-m-d H:i:s ", $key10[2]);
	//$dt1=$key10[1];
	//$dt2=$key10[1];
	echo "<td style='height:10px; padding:2px 8px;'>$dt1</td>";
	echo "<td style='height:10px; padding:2px 8px;'>$dt2</td>";
	foreach ($val as $key1 => $val1)
	{
	//foreach ($val1 as $key2 => $val2)
	//echo "td"
	//$val2=implode("<br>",$val1[$key1]);
	
	$val2=implode("<br>",$val1);
	echo "<td style='height:10px; padding:2px 8px;'>$val2</td>";
	}
	echo "</tr>";
	}
/* while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
	echo "<tr>";
	//echo "<td>{$row['dt1']}</td>";

	foreach($row as $key => $val)
	{
	echo "<td  style='height:10px; padding:0px 0px;'><small><b><pre>";	
	if ($key!="grp_num") 
	{
		$grp_id=json_decode($val,true);
		//var_dump($grp_id);
		foreach($grp_id as $key1 => $val1) echo "<label><input type='checkbox' style='vertical-align: middle; position: relative; bottom: 1px;' > $val1</label>\n";
	}
	else
	echo "$val";
	echo "</pre></b></small></td>";
	}


	echo "</tr>";
} */
echo "</tbody>";
echo "<tfoot><tr>";
foreach($header as $key => $val) echo "<th>$val</th>";
echo "</tr></tfoot>";
echo "</table>";
}
?>

<?php
function tbl_grp_data_1($id,$conn)
{
/*
echo "<br>".get_db_val($conn,"select from_dt()")."<br>";
echo get_db_val($conn,"select to_dt()")."<br>";
echo get_db_val($conn,"select get_grp_int()")."<br>";
echo get_db_val($conn,"select set_al_min_dt()")." al_min dt<br>";
echo get_db_val($conn,"select get_al_min_dt()")." al_min dt<br>";
*/
//$test1=array("1;2","2;3","3;4");
//echo json_encode($test1);
get_db_val($conn,"select set_al_min_dt()");

$qry = "SELECT * from grp_aut_json";
$stmt=execute_query($conn,$qry);
$header=array("0","al_grp_id","1","2");
$footer =$header;
echo "<table id='tbl_$id' border='1' class='table table-bordered table-striped'>";
echo "<thead><tr ><th colspan='4' ><button onclick='add_group(this);'>Add selected to group</button></th></tr><tr>";
foreach($header as $key => $val) echo "<th>$val</th>";
echo "</tr></thead>";
echo "<tbody>";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
	echo "<tr>";
	//echo "<td>{$row['dt1']}</td>";

	foreach($row as $key => $val)
	{
	echo "<td  style='height:10px; padding:0px 0px;'><small><b><pre>";	
	if ($key!="grp_num") 
	{
		$grp_id=json_decode($val,true);
		//var_dump($grp_id);
		foreach($grp_id as $key1 => $val1) echo "<label><input type='checkbox' style='vertical-align: middle; position: relative; bottom: 1px;' > $val1</label>\n";
	}
	else
	echo "$val";
	echo "</pre></b></small></td>";
	}


	echo "</tr>";
}
echo "</tbody>";
echo "<tfoot><tr>";
foreach($header as $key => $val) echo "<th>$val</th>";
echo "</tr></tfoot>";
echo "</table>";
}
?>


<?php
function active_vals($id,$conn)
{
//$qry="sselect al_id,dt_grp,m_al_plant,m_al_desc,m_al_pri from active_vals where substr(al_id,2,1)='1' order by dt_grp desc  ";
$qry="select al_id id,dt_grp dt1,m_al_plant, m_al_desc desc1,m_al_pri from active_vals where substr(al_id,2,1)='1'";
$stmt=execute_query($conn,$qry);
$td_style="style='height:10px; padding:2px 8px;'";	
$header=array("Alarm Date","Alarm id","Plant Area","Description","Priority");
echo "<table id='tbl_$id' border='1' class='table table-bordered table-striped' style='width:100%;'>";
echo "<thead><tr>";
foreach($header as $key => $val) echo "<th>$val</th>";
echo "</tr></thead>";
echo "<tbody>"; 
while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
	$val1=explode("-",$row['id']);
	//echo "<br>".($val1[1]);
	$clr_1="GRAY";
	//if($row['al_stat']=='1')
	{
	$clr_2=$GLOBALS["clr_al"];
	$clr_1=$clr_2[$val1[1]];
	}
echo "<tr style='color:$clr_1'>";
echo "<td $td_style>".$row['dt1']."</td>";
echo "<td $td_style>".$row['id']."</td>";
echo "<td $td_style>".$row['m_al_plant']."</td>";
echo "<td $td_style>".$row['desc1']."</td>";
echo "<td $td_style>".$row['m_al_pri']."</td>";
//echo $row['id'].$row['desc1'].$row['dt1']."<br>";
//$val1=str_replace("-","_",$row['al_id'])."_1";
//array_push($al_id,$val1);
echo "</tr>";
}
echo "</tbody>";
echo "<tfoot><tr>";
foreach($header as $key => $val) echo "<th>$val</th>";
echo "</tr></tfoot>";
echo "</table>";
}
?>
<?php
require_once ("mysqldb.php");
$st_dt=get_post_val("start_date","");
$end_dt=get_post_val("end_date","");
$duration=get_post_val("duration","");
$apri_id=get_post_val("apri_id","");
$id=get_post_val('id','');
//$end_dt=$_POST['end_date'];
//$id=$_POST['id'];

$qry = "SET SESSION group_concat_max_len = 10000000";
$stmt=execute_query($conn,$qry);
echo "$st_dt : $end_dt : $duration, $id";
if ($st_dt!="")
{
$qry = "SELECT set_dt_from_to('$st_dt','$end_dt')";
$stmt=execute_query($conn,$qry);
}
if($duration!="")
{
$qry = "SELECT set_grp_int($duration) ";
$stmt=execute_query($conn,$qry);
}
if($id=="alarm_list")
{
$qry = "SELECT al_id,m_al_plant ,m_al_desc,al_date,al_stat,m_al_pri from  all_bet_dt where substr(al_id,2,1)=1 order by al_date desc ";
$stmt=execute_query($conn,$qry);
$header=array("Alarm ID","Plant Area","Alarm Description","Alarm Date Time", "Alarm Status","Priority");
$footer =$header;
tbl_data($id,$header,$footer,$stmt);
}
if($id=="event_list")
{
$qry = "SELECT al_id,m_al_plant ,m_al_desc,al_date,al_stat,m_al_pri from  all_bet_dt where substr(al_id,2,1)=2 order by al_date desc ";
$stmt=execute_query($conn,$qry);
$header=array("Event ID","Plant Area","Event Description","Event Date Time","Event Status","Priority");
$footer =$header;
tbl_data($id,$header,$footer,$stmt);
}
if($id=="status_list")
{
$qry = "SELECT al_id,m_al_plant ,m_al_desc,al_date,al_stat,m_al_pri from  all_bet_dt where substr(al_id,2,1)=2 order by al_date desc ";
$stmt=execute_query($conn,$qry);
$header=array("Status ID","Plant Area","Status Description","Status Date Time","Status","Priority");
$footer =$header;
tbl_data($id,$header,$footer,$stmt);
}
if($id=="alarm_master")
{
$qry = "SELECT m_al_id,m_al_desc,m_al_pri,m_al_plant from gail_al_master order by m_al_id";
$stmt=execute_query($conn,$qry);
$header=array("Alarm ID","Alarm Description","Priority","Plant Area");
$footer =$header;
tbl_master_data($id,$header,$footer,$stmt);
}
if($id=="event_master")
{
$qry = "SELECT m_ev_id,m_ev_desc,m_ev_pri,m_ev_plant from gail_ev_master order by m_ev_id";
$stmt=execute_query($conn,$qry);
$header=array("Event ID","Event Description","Priority","Plant Area");
$footer =$header;
tbl_master_data($id,$header,$footer,$stmt);
}
if($id=="status_master")
{
$qry = "SELECT m_st_id,m_st_desc,,m_st_pri,m_st_plant from gail_st_master order by m_st_id ";
$stmt=execute_query($conn,$qry);
$header=array("Status ID","Status Description","Priority","Plant Area");
$footer =$header;
tbl_master_data($id,$header,$footer,$stmt);
}
if($id=="group_aut")
{
tbl_grp_data($id,$conn,$st_dt);
}

if($id=="active")
{
active_vals($id,$conn);
}
/* echo "<div style='width:100%;text-align:right;' onclick=\"report_call('$id','$st_dt','$end_dt','$duration');\"><button style='cursor:pointer;' class='btn btn-outline-dark'> <i class='fas fa-file-pdf fa-lg ml-0 mr-0'></i>
</button></div>"; */
?>