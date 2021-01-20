<?php
function dateTimeRange($id,$etc)
{
$grp_aut="";
$grp_aut1=<<<str2
<input type="text" readonly="readonly" id="dur_$id"  style="width:300px;"/>
<input type="hidden" name="seconds"  id="t_dur_$id" />
str2;
//echo $id;
if ($id=="group_aut")
{
//$grp_aut=$grp_aut1;
$grp_aut="";
}
//echo $grp_aut;
//echo $etc;
$dt_range=<<<str1
<div class="input-group">
<div class="input-group-prepend">
<span class="input-group-text"><i class="far fa-clock"></i></span>
</div>
$grp_aut
<input type="text" class="float-right" id="dtr_$id"  style="width:250px;" autocomplete="off">
<div class="input-group-append">
<span class="input-group-text" style="cursor:pointer;" id='$id' $etc >
<i class="fa fa-search"></i></span>
</div>
</div>
<!-- /.input group -->
str1;
return $dt_range;
}
?>

<?php
function card_expa($id,$body_text, $header_text,$url,$data_arr,$method,$dt_in_type,$card_type)  // card expandable
{

$a1=array("some_text"=>(mt_rand(0,10000)/10000));
//print_r( $a1);
$a2=array_merge($a1,$data_arr);
//print_r( $a2);
//$json_str=json_encode($a2);
$json_str= base64_encode(json_encode($a2));
$onclick="onclick=\"card_click(this,'$url','$json_str','$method');\"";
$search=<<<str2
<button $onclick style="cursor:pointer;" id="$id"> 
<i class="fa fa-search ml-2 mr-2" ></i>
</button>
str2;

$apriori=<<<str2
<input id='apri_id'/>
<button $onclick style="cursor:pointer;" id="$id"> 
<i class="fa fa-search ml-2 mr-2" ></i>
</button>
str2;

$dt_rp=" ";

if($dt_in_type=="list") $dt_rp=dateTimeRange($id,$onclick);	
if($dt_in_type=="master") $dt_rp=$search;
if($dt_in_type=="group") $dt_rp=dateTimeRange($id,$onclick);
if($dt_in_type=="apriori") $dt_rp=$apriori;
if($dt_in_type=="dist_chart" || $dt_in_type=="pattern_chart" ) $dt_rp=dateTimeRange($id,$onclick);

$card_expa=<<<str1
<div class="card $card_type collapsed-card" id="card_$id" >
<!-- /.card-tools -->
<div class="card-header" >
<h3 class="card-title mt-1"><span><bold>$header_text</bold></span></h3>
<div class="float-left ml-2 ">$dt_rp</div>
<div class="float-left ml-2 " onclick="report_call('$id');" id='rep_div_$id' style="display:none;" ><button style='cursor:pointer;height:30px;padding:0px 5px;' class='btn btn-light'  id='rep_but_$id'><i class='fas fa-file-pdf fa-sm'></i></button>  <img src='images/loading1.gif' style='display:none;width:30px;' id='rep_img_$id'> </div>
<div class="card-tools">
<button type="button" class="btn btn-tool" data-card-widget="collapse" >
<i class="fas fa-plus" id='i_$id'></i>
</button>
</div>
</div>
<!-- /.card-header -->
<div class="card-body" id="content_$id">
$body_text
</div> <!-- /.card-body -->
<!-- Loading (remove the following to stop the loading)-->
<div class="overlay" style="display:none;" id="loading_$id">
<i class="fas fa-2x fa-sync-alt fa-spin"></i>
</div>
<!-- end loading -->
</div> <!-- /.card -->
str1;
echo $card_expa;
}
?>

<?php
function logo()
{
$logo=<<<str1
<!-- Brand Logo -->
<a href="index.php" class="brand-link">
  <img src="images/gail_logo.png" alt="Gail" class="brand-image img-circle elevation-3"
	   style="opacity: .8;width:50px;">
  <span class="brand-text font-weight-light">Gail India Ltd..</span>
</a>

str1;
echo $logo;
}
?>
<?php
function nav_item($url,$icon_text,$icon_class,$span_text,$span_class,$etc)
{
	$span=" ";
	
	if($span_text!="")
	{$span="<span class='$span_class'>$span_text</span>";}

$nav_item=<<<str1
<li class="nav-item">
<a href="$url" class="nav-link" $etc>
  <i class="$icon_class"></i>
  <p>
	$icon_text
	$span
  </p>
</a>
</li>
str1;
echo $nav_item;
}
?>
<?php
function content_header()
{
$content_header=<<<str1
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
	<div class="row mb-2">
	  <div class="col-sm-6">
		<h1 class="m-0 text-dark">Dashboard v2</h1>
	  </div><!-- /.col -->
	  <div class="col-sm-6">
		<ol class="breadcrumb float-sm-right">
		 <li class="breadcrumb-item"><a href="#">Home</a></li>
		  <li class="breadcrumb-item active">Dashboard v2</li>
		</ol>
	  </div><!-- /.col -->
	</div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
str1;
echo $content_header;
}
?>

<?php
function info_box($icon_class,$text1,$text2)
{
$info_box=<<<str1
<div class="info-box">
<span class="info-box-icon bg-info elevation-1"><i class="$icon_class"></i></span>
  <div class="info-box-content">
	<span class="info-box-text">$text1</span>
	<span class="info-box-number">
	 $text2
	</span>
  </div>
  <!-- /.info-box-content -->
</div>
<!-- /.info-box -->
str1;
echo $info_box;
}
?>