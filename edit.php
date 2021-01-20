<?php
require_once ("mysqldb.php");
// Basic example of PHP script to handle with jQuery-Tabledit plug-in.
// Note that is just an example. Should take precautions such as filtering the input data.
//header('Content-Type: application/json');
// CHECK REQUEST METHOD
try
{
if ($_SERVER['REQUEST_METHOD']=='POST') {
  $input = filter_input_array(INPUT_POST);
} else {
  $input = filter_input_array(INPUT_GET);
}
// PHP QUESTION TO MYSQL DB
// Connect to DB

  /*  Your code for new connection to DB*/
$action=explode("-",$input['action']);
$input1=$input;

//if ($action['1']=='gail_alarms')
// Php question
if ($action['0'] === 'edit') {
	$i=0;
	$tbl_name=$action['1'];
	$val_key=[];
	$vals=[];
	foreach($input as $k1 => $v1)
	{
		if($i==0) {$chk_id=$k1;$chk_val=$v1;}
		else
		{
		if($k1!="action")
		{
		$val_key[]=$k1;
		$vals[]="$k1='$v1'";
		}
		}
		$i++;
	}
	$set_vals=implode(",",$vals);
	$b1=[];
	$qry="update $tbl_name SET $set_vals where $chk_id='$chk_val'";
	$stmt=execute_query($conn,$qry);
	$stmt=execute_query($conn,"commit");
	$b1[0]=$qry;
  // PHP code for edit action
/* if ($action['1']=='tbl_alarm_master')
  {
	$m_id=$input['id1'];
	$m_desc=$input['col1'];
	//echo "1";
	$qry = "UPDATE gail_al_master SET m_al_desc='$m_desc' WHERE m_al_id='$m_id' ";
	$stmt=execute_query($conn,$qry);
	$stmt=execute_query($conn,"commit");
  } */

} else if ($action['0'] === 'delete') {
	$i=0;
	$tbl_name=$action['1'];
	$val_key=[];
	$vals=[];
  	foreach($input as $k1 => $v1)
	{
		if($i==0) {$chk_id=$k1;$chk_val=$v1;}
		else
		{
		if($k1!="action")
		{
		$val_key[]=$k1;
		$vals[]="$k1='$v1'";
		}
		}
		$i++;
	}
	$qry = "delete from $tbl_name WHERE $chk_id='$chk_val' ";
	$stmt=execute_query($conn,$qry);
	$stmt=execute_query($conn,"commit");
  // PHP code for delete

} else if ($action['0'] === 'restore') {

  // PHP code for  restore

}

// Close connection to DB

/*  Your code for close connection to DB*/

// RETURN OUTPUT
$a[0]="hello";
$a[1]="test";
//echo json_encode($input);
//echo "1";
echo json_encode($input);
}
catch(Exception $e)
{
    //echo json_encode($a);
	$a=[];
	$a[0]=$e;
	echo json_encode($a);
}
?>