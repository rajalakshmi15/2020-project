<?php
require_once("mysqldb.php");
require_once("all_script.php");
require_once("all_css.php");
?>
<script>
function add_table(table)
{
	//alert(tbl_name)
	//cellText['some_text']='hello';
	cellText={};
	i=0
	$('#t_add input').each(function() {
		x=$(this).attr('name')
    cellText[x]=$(this).val(); 
	//alert($(this).html())
	i++;	
}); 
x1=JSON.stringify(cellText)
$.ajax({
	url: "add_db.php",
    type: "post",
	data: {values:x1,table_name:table},
	success: function(result) {
		$('#t_info').html(result)
		location.reload()
    }, 
	error: function(error,exception) { 
	$('#t_info').html(error)
	
    }
	});		 
//alert(x1)
}
function edit_tbl(tbl_name,iden_val,edit_val)
{
	iden_val1=JSON.parse(iden_val)
	edit_val1=JSON.parse(edit_val)
	//alert(iden_val)
	$('#t_'+tbl_name).Tabledit({
    url: 'edit.php?tbl_name='+tbl_name,
    columns: {
        identifier: iden_val1,
        editable: edit_val1
    },
			restoreButton:false,
		buttons: {
				edit: {
				  class: 'btn btn-sm btn-default',
				  html: '<span class="fa fa-edit fa-xs" ></span>',
				  action: 'edit-'+tbl_name
				},
				delete: {
				  class: 'btn btn-sm btn-default',
				  html: '<span class="fa fa-trash fa-xs" ></span>',
				  action: 'delete-'+tbl_name
				},
				save: {
				  class: 'btn btn-sm btn-success',
				  html: 'Save'
				},
				restore: {
				  class: 'btn btn-sm btn-warning',
				  html: 'Restore',
				  action: 'restore'
				},
				confirm: {
				  class: 'btn btn-sm btn-danger',
				  html: 'Confirm'
				}
				},
				onSuccess: function(data, textStatus, jqXHR) {
					alert(JSON.stringify(data)+textStatus+jqXHR);
					location.reload()
					//if(data.action == 'delete'){
					//$('#'+data.id1).remove();
					//}
				//console.log(data);
				//console.log(textStatus);
				//console.log(jqXHR);
				},
				onFail: function(jqXHR, textStatus, errorThrown) {
				alert("Failed:"+textStatus+":"+errorThrown);
				//console.log(jqXHR);
				//console.log(textStatus);
				//console.log(errorThrown);
				},
});
}
</script>
<?php
class MySQLTableEdit {
public $table_name="";
public $row_count=0;
public $col_count=0;
public $col_names=[];
public $id_col="";

function __construct($conn,$table)
{
$this->table_name=$table;
$qry="select * from $table";
$stmt=execute_query($conn,$qry);
$row_count = $stmt->rowCount();
$col_count=$stmt->columnCount();
$a=0;
echo "<div style='border:1px solid blue;'><table style='width:100%;' id='t_add'><br>";
for($i=0;$i<$col_count;$i++)
{
	$x=$stmt->getColumnMeta($i);
	$this->col_names[]=$x['name'];
	$col_name=$x['name'];
	//echo "<tr><td><label for='$col_name'>$col_name</label></td>";
	//echo "<td><input type='text' name='$col_name' id='$col_name' ></td></tr>";
	if ($this->id_col=="" && $i==0)	$this->id_col=$stmt->getColumnMeta(0)['name'];
	if($this->id_col==$x['name']) $id_td=$i;
	else
	{
		$edit_val[$a]=[];
	$edit_val[$a][0]=$i;
	$edit_val[$a][1]=$x['name'];
	$a++;
	}
}

echo "<tr>";
foreach($this->col_names as $k1 =>$v1)
echo "<td align='center'>$v1</td>";
echo "<td rowspan=2 align='center'><button class='btn btn-lg btn-warning' onclick='add_table(\"$table\")'> <span class='fa fa-plus fa-xs'  ></span></button></td>";
echo "</tr>";
echo "<tr>";
foreach($this->col_names as $k1 =>$v1)
echo "<td align='center'><input type='text' name='$v1' id='$v1' ></td>";
echo "</tr>";



echo "</table><br>";
echo "<div id='t_info'>Fill above Form and click Add Button to add new value</div>";
echo "</div><br>";
$id_val[0]=$id_td;
$id_val[1]=$this->id_col;
$id1_val= json_encode($id_val);
$edit1_val= json_encode($edit_val);
$this->create_table($stmt);
$tbl_name =$this->table_name;
$str=<<<str1
<script>
edit_tbl('$tbl_name','$id1_val','$edit1_val')
</script>
str1;
echo $str;
} // function _construct ends here	
function create_table($stmt)
{
	$id="t_".$this->table_name;
	//echo $id;

echo "<table border=1 id='$id' style='width:100%;'>";
echo "<thead><tr style='background-color:cyan;'>";
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
/* echo "<tfoot><tr>";
foreach($this->col_names as $key => $val) echo "<th>$val</th>";
echo "</tr></tfoot>"; */
echo "</table>";
}  // create table ends here
} // class ends here

$a = new MySQLTableEdit($conn,"email_table");


//$a->x($conn);
?>
