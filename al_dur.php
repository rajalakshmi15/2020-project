
<head>
<meta http-equiv="refresh" content="100" />
</head>

 <script src="script/scripts/Chart.min.js"></script>
<script>
function chart_1(label,hr,canvas,clr,head)
{
	hr1=JSON.parse(hr)
	label1=JSON.parse(label)
var ctx = document.getElementById(canvas);
var canvas = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: label1,
    datasets: [{
      label: head,
      data: hr1,
      backgroundColor: clr,
      borderColor: clr,
      borderWidth: 1
    }]
  },
  options: {
    responsive: false,
    scales: {
      xAxes: [{
        ticks: {
          maxRotation: 90,
          minRotation: 80
        }
      }],
      yAxes:
       [{
        ticks: {
          beginAtZero: true
        }
      }]
	  
    }
  }
});
}
</script>
<?php///////////////////////////////////////////////////////////////////////////////////////////////////?>
<?php
require_once ("mysqldb.php");
?>
<?php
function prt_pre($arr)
{
echo "<pre>";
print_r($arr);
echo "</pre>";	
}
?>
<?php
function long_lasting($conn)
{
	$qry = "select al_id id,UNIX_TIMESTAMP(al_date) dt1,al_date dt,m_al_desc desc1,al_stat stat from all_view av  order by al_id, al_date";
//$a1=[];
$old_id="";
$old_time="";
$min_val=0;
$old_stat=0;
$stmt=execute_query($conn,$qry);
$v1=[];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
$id_1=$row['id'];
$dt_val=$row['dt1'];
$stat=$row['stat'];
$cur_time=$row['dt'];
if($old_id == $id_1)
{
	if ($stat=='1') {$min_val=$dt_val;$old_time=$cur_time;}
	if ($stat=='0') {
	$t_val=($dt_val-$min_val);
	$v1[$id][]="{$old_time}_{$cur_time}_{$t_val}";
	$v1[$id]['total']+=$t_val;
	$old_id=$id_1;
	}
	$old_stat=$stat;
	//echo "<br> $dt_val : $min_val";
}
if($old_id != $id_1 && $stat=='1')
{
	$id=$id_1."_".$cur_time;
	$min_val=$dt_val;
	$old_time=$cur_time;
	//echo ": old-id = id";
	$v1[$id]=[];
	$v1[$id]['total']=0;
	$v1[$id]['cnt']=0;
	$old_stat=$stat;
	$old_id=$id_1;
}
}
$lab=[];
$l_time=[];
$l_time1=[];
$dur=[];
foreach($v1 as $k2 =>$v2)
{
$cnt=count($v2);
if($cnt==2)
{
	$a1=explode("_",$k2);

	$dt1=strtotime($a1[1]);
	$dt2=strtotime("now");
	$l_time[$a1[0]]=$dt2-$dt1;
	//$lab[]=$al[0];
	//$dur[]=$dt2-$dt1;
	
	
}
//$x1=json_encode($freq_1);
//$x2=json_encode($freq_2);

}

foreach ($l_time as $k3 =>$v3)
	{
		 $lab[]= $k3."<br>";
		 $dur[]= $v3/3600;
		 //echo $k3."<br>";
	}

//prt_pre($l_time);
//prt_pre($v1);
$x1=json_encode($lab);
$x2=json_encode($dur);
$x3="canvas";
$x4="orange";
$x5="Long Lasting Alarms";
$st=<<<str1
<script>
 chart_1('$x1','$x2','$x3','$x4','$x5')
 </script>
str1;
echo($st);
return $l_time;
}
?>
<?php
function fluctuating($conn)
{
$qry = "select al_id id,UNIX_TIMESTAMP(al_date) dt1,al_date dt,m_al_desc desc1,al_stat stat from all_view av  order by al_id, al_date";
$old_id="";
$old_time="";
$min_val=0;
$old_stat=0;
$stmt=execute_query($conn,$qry);
$v1=[];
$v2=[];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
$id_1=$row['id'];
$dt_val=$row['dt1'];
$stat=$row['stat'];
$cur_time=$row['dt'];

if($old_id == $id_1 && $old_stat!=$stat)
{
	$t_val=($dt_val-$min_val);
	$v1[$id_1][]="{$old_time}_{$cur_time}_{$t_val}_{$old_stat}";
	if ($old_stat==1) $v2[$id_1][]="{$old_time}_{$cur_time}_{$t_val}_{$old_stat}";
	$old_stat=$stat;
	$old_time=$cur_time;
	$min_val=$dt_val;
/* 	if ($stat=='1') {$min_val=$dt_val;$old_time=$cur_time;}
	if ($stat=='0') {
	$t_val=($dt_val-$min_val);
	$v1[$id][]="{$old_time}_{$cur_time}_{$t_val}";
	$v1[$id]['total']+=$t_val;
	$old_id=$id_1;
	}
	$old_stat=$stat;
	//echo "<br> $dt_val : $min_val"; */
}
if($old_id != $id_1)
{
	$old_id=$id_1;
	$old_stat=$stat;
	$old_time=$cur_time;
	$min_val=$dt_val;
	$v1[$id_1][]="{$old_time}_{$cur_time}_0_{$old_stat}";
/* 	$id=$id_1."_".$cur_time;
	$min_val=$dt_val;
	$old_time=$cur_time;
	//echo ": old-id = id";
	$v1[$id]=[];
	$v1[$id]['total']=0;
	$v1[$id]['cnt']=0;
	$old_stat=$stat;
	$old_id=$id_1; */
}
}
echo "<table border=1 style='width:100%;' id='tbl_dur1'>";
	echo "<thead><tr><th>Alarms</th><th>Start Date</th><th>End Date</th><th>Duration</th><th>Status</th></tr></thead><tbody>";
foreach($v1 as $k3 =>$v3)
{

foreach($v3 as $k4 => $v4)
{
	$v5=explode("_",$v4);

	echo "<tr>";
	echo "<td>".$k3."</td>";
	foreach($v5 as $k5 =>$v6)
	echo "<td>".$v6."</td>";
	echo "</tr>";
}	
}

echo "</tbody></table>";
//prt_pre($v1);
foreach($v1 as $k2 => $v2)
{
$ev =explode("_",end($v2));
if ($ev[3]==0 || ($ev[3]==1 && count($v2)==1)) 
{
	//echo end($v2)."<br>";
	if ($k2[1]=='1') $l_time[$k2]=strtotime("now")-strtotime($ev[1]);
}
}
foreach($v1 as $k2 => $v2)
{
if($k2[1]==1)
{
$freq[$k2]=count($v2);
$freq_1[]=$k2;

$freq_2[]=count($v2);

}

/* foreach($v2 as $k3 => $v3)
{
	$label[$k3]=[];
	$hr[$k3]=[];
	$label[$k3]=$k2;
	$hr[$k3]=$v3;
	
} */
}
$x1=json_encode($freq_1);
$x2=json_encode($freq_2);
$x3="canvas2";
$x4="blue";
$x5="Frequency of Alarms";
//prt_pre($freq);
//prt_pre($label);
//prt_pre($l_time);
//echo $x2."<br>";
/* $st=<<<str1
<script>
 chart_1('$x1','$x2','$x3','$x4','$x5')
 </script>
str1;

echo($st); */
return $freq;
}
?>
<?php
fluctuating($conn);
/* echo "<table>";
echo "<tr>";
echo "<td><canvas id='canvas' width='500' height='300'></canvas></td>";
echo "<td><canvas id='canvas2' width='500' height='300'></canvas></td></tr><tr><td>";
$val1=long_lasting($conn);
echo "<table border =1 style='width:100%;padding:0px 0px 0px 0px;margin-top:0px;'>";
echo "<tr><th>Alarms</th><th>Lapsed Time (Hrs)</th></tr>";
foreach($val1 as $k1 =>$v1)
{
	$v2=round($v1/3600,2);
	echo "<tr>";
	echo "<td>$k1</td><td>$v2</td>";
	echo "</tr>";
}
echo "</table>";
echo "</td>";
echo "<td>";
$val1=fluctuating($conn);
echo "<br><br><br><br><br><br><br><br><br><br>";
echo "<table border =1 style='width:100%;padding:0px 0px 0px 0px;margin-top:0px;'>";
echo "<tr><th>Alarms</th><th>count</th></tr>";
foreach($val1 as $k1 =>$v1)
{
	echo "<tr>";
	echo "<td>$k1</td><td>$v1</td>";
	echo "</tr>";
}
echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>"; */

?>