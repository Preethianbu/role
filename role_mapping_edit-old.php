<?php
require '../../connect.php';
$id=$_REQUEST['id'];
$stmt = $con->prepare("SELECT * FROM `z_role_master` where id='$id'");
$stmt->execute(); 
$row = $stmt->fetch();
$sta=$row['status'];
?>
<head>
    <link rel="stylesheet" href="Qvision\commonstyle.css">
    </head>
<div  class="card card-primary">
              <div class="card-header">
                <h3 style="float: left;">ROLE DETAILS MAPPING</h3>
				  <a onclick="return back()" style="float: right;" data-toggle="modal" class="btn btn-dark"><i class="fa fa-plus"></i> Back</a>
		
              </div>
           
              <div class="card-body">
              <table class="table table-striped table-bordered table-hover display nowrap"  id="example1" style="width:100%">

<br>
<br>
<div class="card-body" id="printableArea">
<form role="GET" name="" action="Qvision/role/role_mapping_insert.php" method="post" enctype="multipart/type">


<table class="table table-bordered">

<table class="table table-bordered"><!--	

<tr>
<td>Role Code:</td>
<td colspan="5">

<input type="text" class="form-control" id="Code" name="Code" value="<?php echo  $row['code'];?>" readonly>
</td>
</tr>

<tr>
<td>Role Name:</td>
<td colspan="5">

<input type="text" class="form-control" id="name" name="name" value="<?php echo  $row['role_name'];?>" readonly>
</td>
</table>
</tr>

<table class="dataTables-example table table-striped table-bordered table-hover"  id="example1">


<tbody>
<?php
$rolecode=$row['code'];
$assets_sql=$con->query("SELECT id,menu_name FROM `z_masters_menu` order by id");
$i=1;
while($menu_name = $assets_sql->fetch(PDO::FETCH_ASSOC))
{
?>
<b style="padding: 5px 0px;color:blue;"><?php echo $menu_name['menu_name']; ?></b><br>
<?php
$men=$menu_name['id']; 


$submenu=$con->query("select m.menu_name,s.name,s.id as submenuid,r.code,r.menu_id,r.submenu_id,r.view_only,r.edit_only,r.all_only,r.approval from  role_g
r join z_masters_menu m on r.menu_id=m.id join z_masters_sub_menu s on r.submenu_id=s.id where r.code='$rolecode' and r.menu_id='$men' order by r.id"); 



while($sub_menu_name = $submenu->fetch(PDO::FETCH_ASSOC))
{
$s=1;
?>
<div style="width:100%;float:left;padding: 5px 0px;">
<!--<input class="checkbox" style="width:2%;float:left;" type="checkbox" name="checkbox_<?php echo $i;?>" id="checkbox_<?php echo $i;?>" onclick="enablebox(this.id)"/>-->
<input type="hidden"  id="menu" name="menu[]" class="form-control"  value="<?php echo $menu_name['id'];?>" >
<input type="hidden"  id="submenu" name="submenu[]" class="form-control"  value="<?php echo $sub_menu_name['submenu_id'];?>" >
<div style="width:30%;float:left;">&emsp;<?php echo $sub_menu_name['name']; ?></div>

<?php if($sub_menu_name['view_only']==1 && $sub_menu_name['edit_only']==1 && $sub_menu_name['all_only']==1) {
?>
<div style="width:10%;float:left;">
<input type="radio" name="View<?php echo $i ; ?>" id="View<?php echo $i.$s++ ; ?>" checked value="1" />&emsp;View</div>
<div style="width:10%;float:left;">
<input type="radio" name="Edit<?php echo $i ; ?>" id="Edit<?php echo $i.$s++ ; ?>" checked value="1"/>&emsp;Edit</div>
<div style="width:10%;float:left;"><input type="radio" name="All<?php echo $i ; ?>" id="All<?php echo $i.$s++ ; ?>" checked value="1"/>&emsp;All</div>
<?php
} elseif($sub_menu_name['view_only']==1 && $sub_menu_name['edit_only']==1) {
?>
<div style="width:10%;float:left;">
<input type="radio" name="View<?php echo $i ; ?>" id="View<?php echo $i.$s++ ; ?>" checked value="1" />&emsp;View</div>
<div style="width:10%;float:left;">
<input type="radio" name="Edit<?php echo $i ; ?>" id="Edit<?php echo $i.$s++ ; ?>" checked value="1"/>&emsp;Edit</div>
<div style="width:10%;float:left;"><input type="radio" name="All<?php echo $i ; ?>" id="All<?php echo $i.$s++ ; ?>"  value="1"/>&emsp;All</div>
<?php
} elseif($sub_menu_name['edit_only']==1 && $sub_menu_name['all_only']==1) {
?>
<div style="width:10%;float:left;">
<input type="radio" name="View<?php echo $i ; ?>" id="View<?php echo $i.$s++ ; ?>"  value="1" />&emsp;View</div>
<div style="width:10%;float:left;">
<input type="radio" name="Edit<?php echo $i ; ?>" id="Edit<?php echo $i.$s++ ; ?>" checked value="1"/>&emsp;Edit</div>
<div style="width:10%;float:left;"><input type="radio" name="All<?php echo $i ; ?>" id="All<?php echo $i.$s++ ; ?>" checked value="1"/>&emsp;All</div>
<?php
} elseif($sub_menu_name['view_only']==1 && $sub_menu_name['all_only']==1) {
?>		
<div style="width:10%;float:left;">
<input type="radio" name="View<?php echo $i ; ?>" id="View<?php echo $i.$s++ ; ?>"  checked value="1" />&emsp;View</div>
<div style="width:10%;float:left;">
<input type="radio" name="Edit<?php echo $i ; ?>" id="Edit<?php echo $i.$s++ ; ?>"  value="1"/>&emsp;Edit</div>
<div style="width:10%;float:left;"><input type="radio" name="All<?php echo $i ; ?>" id="All<?php echo $i.$s++ ; ?>" checked value="1"/>&emsp;All</div>

<?php
} elseif($sub_menu_name['view_only']=='' && $sub_menu_name['edit_only']=='' && $sub_menu_name['all_only']==''){
?>
<div style="width:10%;float:left;">
<input type="radio" name="View<?php echo $i ; ?>" id="View<?php echo $i.$s++ ; ?>"   value="1" readonly />&emsp;View</div>
<div style="width:10%;float:left;">
<input type="radio" name="Edit<?php echo $i ; ?>" id="Edit<?php echo $i.$s++ ; ?>"  value="1" readonly />&emsp;Edit</div>
<div style="width:10%;float:left;"><input type="radio" name="All<?php echo $i ; ?>" id="All<?php echo $i.$s++ ; ?>"   value="1"/>&emsp;All</div>
<?php
} elseif($sub_menu_name['view_only']=='1'){
?>
<div style="width:10%;float:left;">
<input type="radio" name="View<?php echo $i ; ?>" id="View<?php echo $i.$s++ ; ?>"   checked value="1" />&emsp;View</div>
<div style="width:10%;float:left;">
<input type="radio" name="Edit<?php echo $i ; ?>" id="Edit<?php echo $i.$s++ ; ?>"  value="1"/>&emsp;Edit</div>
<div style="width:10%;float:left;"><input type="radio" name="All<?php echo $i ; ?>" id="All<?php echo $i.$s++ ; ?>"  value="1"/>&emsp;All</div>
<?php

}elseif($sub_menu_name['edit_only']=='1'){
?>
<div style="width:10%;float:left;">
<input type="radio" name="View<?php echo $i ; ?>" id="View<?php echo $i.$s++ ; ?>"    value="1" />&emsp;View</div>
<div style="width:10%;float:left;">
<input type="radio" name="Edit<?php echo $i ; ?>" id="Edit<?php echo $i.$s++ ; ?>" checked value="1"/>&emsp;Edit</div>
<div style="width:10%;float:left;"><input type="radio" name="All<?php echo $i ; ?>" id="All<?php echo $i.$s++ ; ?>"  value="1"/>&emsp;All</div>
<?php

}elseif($sub_menu_name['all_only']=='1'){
?>
<div style="width:10%;float:left;">
<input type="radio" name="View<?php echo $i ; ?>" id="View<?php echo $i.$s++ ; ?>"    value="1" />&emsp;View</div>
<div style="width:10%;float:left;">
<input type="radio" name="Edit<?php echo $i ; ?>" id="Edit<?php echo $i.$s++ ; ?>"  value="1"/>&emsp;Edit</div>
<div style="width:10%;float:left;"><input type="radio" name="All<?php echo $i ; ?>" id="All<?php echo $i.$s++ ; ?>"  checked readonly value="1"/>&emsp;All</div>
<?php

}
?>
</div>
<?php
$i++;
}
}
?>
</tbody>
</table>		 
<br>
<br>

</form>
</div>
</div>
</div>
<script>
function back()
{
role()
}
function role_update()
{
var id=0;
var data = $('form').serialize();
//alert(data);
$.ajax({
type:'GET',
data:"id="+id, data,
url:"HRMS/role/role_mapping_insert.php",
success:function(data)
{
if(data!='')
{ 
alert('Entry Successfully');
role()
}
else
{
alert("No Data choose");
}

}       
});
} 
</script>
