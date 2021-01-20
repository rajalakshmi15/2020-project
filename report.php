<?php
require_once 'email.php';
?>
<?php
function get_post_val($key,$def_val)
{
	$val="";
    isset($_POST[$key]) ? $val=$_POST[$key] : $val=$def_val;
	return $val;
}
?>
<?php
function prt_pre($arr)
{
echo "<textarea style='width:100%;height:30%;'>";
print_r($arr);
echo "</textarea>";	
}
?>
<?php
function get_content($id,$st_dt,$end_dt,$dur,$head_text,$foot_text,$url)
{
	//$url = 'http://localhost:3333/alarm/fn_fp.php';
	$data = array(
		'id' => $id, 
		'start_date' => $st_dt, 
		'end_date' => $end_dt,
		'duration' => $dur
		);
	$options = array(
		'http' => array(
		'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		'method'  => 'POST',
		'content' => http_build_query($data),
	)
	);
	$context  = stream_context_create($options);
	$content1 = file_get_contents($url, false, $context);
    $loc="file:///".str_replace ('\\','/',getcwd()).'/images/gail_logo.png';
	//prt_pre($select);
$img=file_get_contents("images/gail_logo.png");
$data=base64_encode($img);
$x1=<<<str2
<img src='data:image/png;base64,$data' style='width:40px;'>
str2;
$content=<<<str1
	   
      <table width="100%" border="1" style="background: white; border:2px solid blue;">
 <tr>
 <td style="width:30px;padding:10px 10px 10px 10px;">$x1</td>
 <td>
 <font face="arial" color="black" >
 <center><a style="font-size:20px;padding-right:120px;">$head_text</a></center>
 </font>
 </td>
 </tr>
 </table> <br>
		
    $content1
	<div style='width:100%;text-align:center;border:1px solid blue;'>
         $foot_text
		 </div>

str1;

return $content;
}
?>
<?php
date_default_timezone_set('Asia/Kolkata');
$st_dt=get_post_val("start_date","2020-01-01 00:00:00");
$end_dt=get_post_val("end_date","2020-05-01 00:00:00");
$dur=get_post_val("duration","");
$id=get_post_val('id','combined');
if($id=='fn_fp') $url_file="fn_fp.php"; else $url_file="list_vals.php";

//$url="http://localhost:3333/alarm/$url_file";
$url="http://localhost/alarm/$url_file";
//$url="http://localhost/alarm/list_vals.php";
//$url1="http://localhost/alarm/fn_fp.php";

try {
	$dt_str=date('Y_m_d_H_i_s_').gettimeofday()['usec'];
	$f_name=__dir__."/pdf/{$id}_{$dt_str}.pdf";
	$html_f_name=__dir__."/pdf/{$id}_{$dt_str}.html";
	if($id=='combined')
	{
	$content=get_content("alarm_list",$st_dt,$end_dt,$dur,"Alarm list","Gail India",$url);
	file_put_contents($html_f_name,$content);
	$content=get_content("event_list",$st_dt,$end_dt,$dur,"Event list","Gail India",$url);
	file_put_contents($html_f_name,$content,FILE_APPEND);
	$content=get_content("status_list",$st_dt,$end_dt,$dur,"Status list","Gail India",$url);
	file_put_contents($html_f_name,$content,FILE_APPEND);
	$content=get_content("group_aut",$st_dt,$end_dt,$dur,"Alarm groups","Gail India",$url);
	file_put_contents($html_f_name,$content,FILE_APPEND);
	$content=get_content("fn_fp",$st_dt,$end_dt,$dur,"False Positive & False Negative Alarms","Gail India",$url);
	file_put_contents($html_f_name,$content,FILE_APPEND);
	}
	else
	{
	if($id=="apriori")
	{
	$content=get_content($id,$st_dt,$end_dt,$dur,"Apriori","Gail India",$url);
	file_put_contents($html_f_name,$content);
	}
	if($id=="alarm_list")
	{
	$content=get_content($id,$st_dt,$end_dt,$dur,"Alarm list","Gail India",$url);
	file_put_contents($html_f_name,$content);
	}
	if($id=="event_list")
		{
	$content=get_content($id,$st_dt,$end_dt,$dur,"Event list","Gail India",$url);
	file_put_contents($html_f_name,$content);
	}
	if($id=="status_list")
		{
	$content=get_content($id,$st_dt,$end_dt,$dur,"Status list","Gail India",$url);
	file_put_contents($html_f_name,$content);
	}
	if($id=="group_aut")
		{
	$content=get_content($id,$st_dt,$end_dt,$dur,"Alarm Groups","Gail India",$url);
	file_put_contents($html_f_name,$content);
	}
	if($id=="fn_fp")
		{
	$content=get_content($id,$st_dt,$end_dt,$dur,"False Positive & False Negative Alarms","Gail India",$url);
	file_put_contents($html_f_name,$content);
	}
	if($id=="alarm_master")
		{
	$content=get_content($id,$st_dt,$end_dt,$dur,"Alarm Master","Gail India",$url);
	file_put_contents($html_f_name,$content);
	}
	if($id=="event_master")
		{
	$content=get_content($id,$st_dt,$end_dt,$dur,"Event Master","Gail India",$url);
	file_put_contents($html_f_name,$content);
	}
	if($id=="status_master")
		{
	$content=get_content($id,$st_dt,$end_dt,$dur,"Status Master","Gail India",$url);
	file_put_contents($html_f_name,$content);
	}
	}
    //$html2pdf = new Html2Pdf('P', 'A4', 'en', true, 'UTF-8', array(20, 10, 0, 10));
	
	//$html_f_name=__dir__."/pdf/fn_fp_1.html";
	
	$exec_str=__dir__."/pdf/wkhtmltopdf $html_f_name $f_name";
	echo exec($exec_str);
	unlink ($html_f_name);
	//email_send("sriswarna100@gmail.com","ridhan9876","sriswarna100@gmail.com","Swarna","pgraman69@gmail.com","PGR","Hello","Hello1","this one","/gail_pdf/test.pdf");
 
 	echo "{$id}_{$dt_str}.pdf";
	//echo base64_encode ( $x );
	//echo $f_name;
	} catch (Exception $e) {
    $html2pdf->clean();
    $formatter = new ExceptionFormatter($e);
    $content=$formatter->getHtmlMessage();
	
	echo $content;
}

?>