
<!-- ChartJS -->
<script src="script/scripts/Chart.min.js"></script>

<?php
require_once ("mysqldb.php");
//require_once ("all_script.php");
$st_dt=get_post_val("start_date","2020-01-01 00:00:00");
$end_dt=get_post_val("end_date","2020-01-02 00:00:00");
echo "<br>$st_dt $end_dt";
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
function prt_pre($arr)
{
echo "<pre>";
print_r($arr);
echo "</pre>";	
}
?>
<canvas id="canvas" style="display: block; width: 983px; height: 491px;" width="983" height="200" ></canvas>
<canvas id="canvas1" style="display: block; width: 983px; height: 491px;" width="983" height="200" ></canvas>
<canvas id="canvas2" style="display: block; width: 983px; height: 491px;" width="983" height="200" ></canvas>
<canvas id="canvas3" style="display: block; width: 983px; height: 491px;" width="983" height="200" ></canvas>
<script>
function chart_1(dta,clr,canvas,title,title1,label)
{
	dta1=JSON.parse(dta)
	clr1=JSON.parse(clr)
	label1=JSON.parse(label)
	//canvas1=JSON.parse(canvas)
	//alert(dta1);
/* 	dta1=[
	{x: 1,y: 2}, {x: 2,y: 1}
				] */
var ctx = document.getElementById(canvas).getContext('2d');
var scatterChart = new Chart(ctx, {
    type: 'scatter',
    data: {
		labels: label1,
        datasets: [{
            label: title,
			fillColor: "rgba(220,220,220,0,5)",
			data:dta1,
			backgroundColor:clr1,
			 
 /*            data: [{
                x: -10,
                y: "7.35"
            }, {
                x: 4,
                y: 10
            }, {
                x: 10,
                y: 5
            }] */
        }]
    },
    options: {
		tooltips: {
         callbacks: {
            label: function(tooltipItem, data) {
               var label = data.labels[tooltipItem.index];
               return label + ': (' + tooltipItem.xLabel + ', ' + tooltipItem.yLabel + ')';
            }
         }
      },
		title: {
            display: true,
			fontColor:'blue',
		    fontSize:20,
            text: title1
        },
        scales: {
    yAxes: [{
      scaleLabel: {
        display: true,
		fontColor:'black',
		fontSize:20,
        labelString: 'seconds'
      }
    }],
	xAxes: [{
      scaleLabel: {
        display: true,
		fontColor:'black',
		fontSize:20,
        labelString: 'Hour'
      }
    }]
  },
    }
});
}
</script>
<?php
function fill_chart($conn,$st_dt,$end_dt)
{
$qry="select al_id, (UNIX_TIMESTAMP(al_Date)-UNIX_TIMESTAMP('$st_dt'))/3600 dt, second(al_date) sec from gail_alarms where al_stat=1 and al_date between '$st_dt' and '$end_dt' ";
$stmt=execute_query($conn,$qry);
//test_db($conn,$qry);
$arr=[];
$clr=[];
$label=[];
$i=0;
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
{
	
	$arr[$i]=[];
	$arr[$i]['x']=$row['dt'];
	$arr[$i]['y']=$row['sec'];
	$clr[$i]="red";
	$label[$i]=$row['al_id'];
	$i++;
}
$x1=json_encode($arr);
$x2=json_encode($clr);
$x3="canvas";
$x4="Alarm Distribution";
$x5="Alarm/Event/Status Distribution";
$x6=json_encode($label);
$st=<<<str1
<script>
 chart_1('$x1','$x2','$x3','$x4','$x5','$x6')
 </script>
str1;

echo($st);
}
//prt_pre($arr);
fill_chart($conn,$st_dt,$end_dt);
    
?>
<?php
function fill_chart1($conn,$st_dt,$end_dt)
{
$qry="select ev_id, (UNIX_TIMESTAMP(ev_Date)-UNIX_TIMESTAMP('$st_dt'))/3600 dt, second(ev_date) sec from gail_events where ev_stat=1 and ev_date between  '$st_dt' and '$end_dt' ";
$stmt=execute_query($conn,$qry);
//test_db($conn,$qry);
$arr=[];
$label=[];
$clr=[];
$i=0;
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
{
	
	$arr[$i]=[];
	$arr[$i]['x']=$row['dt'];
	$arr[$i]['y']=$row['sec'];
	$clr[$i]="blue";
	$label[$i]=$row['ev_id'];
	$i++;
}
$x1=json_encode($arr);
$x2=json_encode($clr);
$x3="canvas1";
$x4="Event Distribution";
$x5="";
$x6=json_encode($label);
$st=<<<str1
<script>
 chart_1('$x1','$x2','$x3','$x4','$x5','$x6')
 </script>
str1;

echo($st);
}
//prt_pre($arr);
fill_chart1($conn,$st_dt,$end_dt);
    
?>

<?php
function fill_chart2($conn,$st_dt,$end_dt)
{
$qry="select st_id,(UNIX_TIMESTAMP(st_Date)-UNIX_TIMESTAMP('$st_dt'))/3600 dt, second(st_date) sec from gail_stat where st_stat=1 and st_date between '$st_dt' and '$end_dt' ";
$stmt=execute_query($conn,$qry);
//test_db($conn,$qry);
$arr=[];
$clr=[];
$label=[];
$i=0;
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
{
	
	$arr[$i]=[];
	$arr[$i]['x']=$row['dt'];
	$arr[$i]['y']=$row['sec'];
	$clr[$i]="green";
	$label[$i]=$row['st_id'];
	$i++;
}
$x1=json_encode($arr);
$x2=json_encode($clr);
$x3="canvas2";
$x4="Status Distribution";
$x5="";
$x6=json_encode($label);
$st=<<<str1
<script>
 chart_1('$x1','$x2','$x3','$x4','$x5','$x6')
 </script>
str1;

echo($st);
}
//prt_pre($arr);
fill_chart2($conn,$st_dt,$end_dt);
    
?>
<?php
function fill_chart3($conn,$st_dt,$end_dt)
{
$qry="select al_id id, (UNIX_TIMESTAMP(al_date)-UNIX_TIMESTAMP('$st_dt'))/3600 dt, second(al_date) sec from all_view where al_stat=1 and al_date between '$st_dt' and '$end_dt' ";
$stmt=execute_query($conn,$qry);
//test_db($conn,$qry);
$arr=[];
$clr=[];
$label=[];
$i=0;

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
{
	$id=substr($row["id"],1);
    $id1=$id[0];
    $arr[$i]=[];
	$arr[$i]['x']=$row['dt'];
	$arr[$i]['y']=$row['sec'];
	if($id1=="1") $clr[$i]="red";
	if($id1=="2") $clr[$i]="blue";
	if($id1=="3") $clr[$i]="green";
	$label[$i]=$row['id'];
	$i++;
}
$x1=json_encode($arr);
$x2=json_encode($clr);
$x3="canvas3";
$x4="Combined Distribution";
$x5="";
$x6=json_encode($label);
$st=<<<str1
<script>
 chart_1('$x1','$x2','$x3','$x4','$x5','$x6')
 </script>
str1;

echo($st);
}

//prt_pre($arr);
fill_chart3($conn,$st_dt,$end_dt);
    
?>



