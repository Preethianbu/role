<?php
require '../../connect.php';
include("../../user.php");
$id=$_REQUEST['id'];
$stmt = $con->prepare("SELECT * FROM `z_role_master` where id='$id'");
$stmt->execute(); 
$row = $stmt->fetch();
$sta=$row['status'];
?>
<!-- <div class="container-fluid">
<div class="card mb-3">
<div class="card-header">
<i class="fa fa-table"></i> Role Details Mapping
<a onclick="return back()" style="float: right;" data-toggle="modal" class="btn btn-danger">Back</a>
</div>

<br>
<br> -->
<head>
    <link rel="stylesheet" href="Qvision\commonstyle.css">
    </head>
	<style>
	.card-primary:not(.card-outline)>.card-header{
		background-color: #f1cc61 !important;
	}
	.card-primary:not(.card-outline)>.card-header a {
		color: #3c0808 !important;
    background-color: #ed5d00 !important;
	}
	</style>
<div  class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><font size="5">ROLE DETAILS MAPPING</font></h3>
		<a onclick="return back()" style="float: right;" data-toggle="modal" class="btn btn-danger">BACK</a>
				
              </div>
<div class="card-body" id="printableArea">
<form name="" action="" enctype="multipart/type">

<table class="table table-bordered">

<tr>
<td>Role Code</td>
<td colspan="5">

<input type="text" class="form-control" id="Code" name="Code" value="<?php echo  $row['code'];?>" readonly>
</td>
</tr>

<tr>
<td>Role Name</td>
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
$i=0;
while($menu_name = $assets_sql->fetch(PDO::FETCH_ASSOC))
{
?>
<b style="padding: 5px 0px;color:blue;"><?php echo $menu_name['menu_name']; ?></b><br>
<?php
$men=$menu_name['id']; 

//echo $men;
$submenu=$con->prepare("select m.menu_name,s.name,s.id as submenuid,r.code,r.menu_id,r.submenu_id,r.view_only,r.edit_only,r.all_only,r.approval from  z_role_detail
r join z_masters_menu m on m.id= r.menu_id join z_masters_sub_menu s on r.submenu_id=s.id where r.code='$rolecode' and r.menu_id='$men' order by r.id"); 

$submenu->execute();
$count = $submenu->rowCount();


/* if($count=='0'){
$submenu=$con->prepare("select m.menu_name,s.name,s.id as submenuid,r.code,r.menu_id,r.submenu_id,r.view_only,r.edit_only,r.all_only,r.approval from  z_role_detail
r join z_masters_menu m on r.menu_id=m.id join z_masters_sub_menu s on r.submenu_id=s.id where  NOT IN s.menu_id ='$men' order by r.id");



}
$submenu->execute();
echo $count = $submenu->rowCount(); */
/* echo "select m.menu_name,s.name,s.id as submenuid,r.code,r.menu_id,r.submenu_id,r.view_only,r.edit_only,r.all_only,r.approval from  z_role_detail
r join z_masters_menu m on r.menu_id=m.id join z_masters_sub_menu s on r.submenu_id=s.id where r.code='$rolecode' and r.menu_id='$men' order by r.id"; */



/* 
"select m.menu_name,s.name,s.id as submenuid,r.code,r.menu_id,r.submenu_id,r.view_only,r.edit_only,r.all_only,r.approval from z_role_detail r 
join z_masters_menu m on r.menu_id=m.id join z_masters_sub_menu s on r.submenu_id=s.id where r.code='$rolecode' and r.menu_id='$men' 
                                                     UNION 
select m1.menu_name,s1.name,s1.id as submenuid,r1.code,r1.menu_id,r1.submenu_id,r1.view_only,r1.edit_only,r1.all_only,r1.approval from z_role_detail r1 
join z_masters_menu m1 on r1.menu_id=m1.id join z_masters_sub_menu s1 on r1.submenu_id=s1.id where r1.code='$rolecode' and not(r1.menu_id='$men')" */



/* 
(SELECT a.menu_name,b.name,b.id as submenuid,e.* FROM z_masters_menu a join z_masters_sub_menu b on(a.id=b.id ) 
join z_role_detail e on(e.menu_id=a.id) WHERE e.code='R007' and a.id='12' and b.status='1') UNION ALL 
(SELECT a1.menu_name,b1.name,b1.id as submenuid,e1.* FROM z_masters_menu a1 join z_masters_sub_menu b1 on(a1.id=b1.id) 
join z_role_detail e1 on(e1.menu_id=a1.id) WHERE NOT a1.id ='12' and e1.code='R007' and b1.status='1' order by b1.id) */

/* echo "select m.menu_name,s.name,s.id as submenuid,r.code,r.menu_id,r.submenu_id,r.view_only,r.edit_only,r.all_only,r.approval from  z_role_detail
r join z_masters_menu m on r.menu_id=m.id join z_masters_sub_menu s on r.submenu_id=s.id where r.code='$rolecode' and  r.menu_id='$men'  and r.status='1' order by r.id"; */

/* echo "select m.menu_name,s.name,s.id as submenuid,r.code,r.menu_id,r.submenu_id,r.view_only,r.edit_only,r.all_only,r.approval from  z_role_detail
r join z_masters_menu m on r.menu_id=m.id join z_masters_sub_menu s on r.submenu_id=s.id where r.code='$rolecode' and r.menu_id='$men'  order by r.id"; */


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
<input type="checkbox" name="View<?php echo $i ; ?>" id="View<?php echo $i.$s++ ; ?>" checked value="1"/>&emsp;View</div>
<div style="width:10%;float:left;">
<input type="checkbox" name="Edit<?php echo $i ; ?>" id="Edit<?php echo $i.$s++ ; ?>" checked value="1"/>&emsp;Edit</div>
<div style="width:10%;float:left;"><input type="checkbox" name="All<?php echo $i ; ?>" id="All<?php echo $i.$s++ ; ?>" checked value="1"/>&emsp;All</div>
<?php
} elseif($sub_menu_name['view_only']==1 && $sub_menu_name['edit_only']==1) {
?>
<div style="width:10%;float:left;">
<input type="checkbox" name="View<?php echo $i ; ?>" id="View<?php echo $i.$s++ ; ?>" checked value="1" />&emsp;View</div>
<div style="width:10%;float:left;">
<input type="checkbox" name="Edit<?php echo $i ; ?>" id="Edit<?php echo $i.$s++ ; ?>" checked value="1"/>&emsp;Edit</div>
<div style="width:10%;float:left;"><input type="checkbox" name="All<?php echo $i ; ?>" id="All<?php echo $i.$s++ ; ?>"  value="1"/>&emsp;All</div>
<?php
} elseif($sub_menu_name['edit_only']==1 && $sub_menu_name['all_only']==1) {
?>
<div style="width:10%;float:left;">
<input type="checkbox" name="View<?php echo $i ; ?>" id="View<?php echo $i.$s++ ; ?>"  value="1" />&emsp;View</div>
<div style="width:10%;float:left;">
<input type="checkbox" name="Edit<?php echo $i ; ?>" id="Edit<?php echo $i.$s++ ; ?>" checked value="1"/>&emsp;Edit</div>
<div style="width:10%;float:left;"><input type="checkbox" name="All<?php echo $i ; ?>" id="All<?php echo $i.$s++ ; ?>" checked value="1"/>&emsp;All</div>
<?php
} elseif($sub_menu_name['view_only']==1 && $sub_menu_name['all_only']==1) {
?>		
<div style="width:10%;float:left;">
<input type="checkbox" name="View<?php echo $i ; ?>" id="View<?php echo $i.$s++ ; ?>"  checked value="1" />&emsp;View</div>
<div style="width:10%;float:left;">
<input type="checkbox" name="Edit<?php echo $i ; ?>" id="Edit<?php echo $i.$s++ ; ?>"  value="1"/>&emsp;Edit</div>
<div style="width:10%;float:left;"><input type="checkbox" name="All<?php echo $i ; ?>" id="All<?php echo $i.$s++ ; ?>" checked value="1"/>&emsp;All</div>

<?php
} elseif($sub_menu_name['view_only']=='' && $sub_menu_name['edit_only']=='' && $sub_menu_name['all_only']==''){
?>
<div style="width:10%;float:left;">
<input type="checkbox" name="View<?php echo $i ; ?>" id="View<?php echo $i.$s++ ; ?>"   value="1" readonly />&emsp;View</div>
<div style="width:10%;float:left;">
<input type="checkbox" name="Edit<?php echo $i ; ?>" id="Edit<?php echo $i.$s++ ; ?>"  value="1" readonly />&emsp;Edit</div>
<div style="width:10%;float:left;"><input type="checkbox" name="All<?php echo $i ; ?>" id="All<?php echo $i.$s++ ; ?>"   value="1"/>&emsp;All</div>
<?php
} elseif($sub_menu_name['view_only']=='1'){
?>
<div style="width:10%;float:left;">
<input type="checkbox" name="View<?php echo $i ; ?>" id="View<?php echo $i.$s++ ; ?>"   checked value="1" />&emsp;View</div>
<div style="width:10%;float:left;">
<input type="checkbox" name="Edit<?php echo $i ; ?>" id="Edit<?php echo $i.$s++ ; ?>"  value="1"/>&emsp;Edit</div>
<div style="width:10%;float:left;"><input type="checkbox" name="All<?php echo $i ; ?>" id="All<?php echo $i.$s++ ; ?>"  value="1"/>&emsp;All</div>
<?php

}elseif($sub_menu_name['edit_only']=='1'){
?>
<div style="width:10%;float:left;">
<input type="checkbox" name="View<?php echo $i ; ?>" id="View<?php echo $i.$s++ ; ?>"    value="1" />&emsp;View</div>
<div style="width:10%;float:left;">
<input type="checkbox" name="Edit<?php echo $i ; ?>" id="Edit<?php echo $i.$s++ ; ?>" checked value="1"/>&emsp;Edit</div>
<div style="width:10%;float:left;"><input type="checkbox" name="All<?php echo $i ; ?>" id="All<?php echo $i.$s++ ; ?>"  value="1"/>&emsp;All</div>
<?php

}elseif($sub_menu_name['all_only']=='1'){
?>
<div style="width:10%;float:left;">
<input type="checkbox" name="View<?php echo $i ; ?>" id="View<?php echo $i.$s++ ; ?>"    value="1" />&emsp;View</div>
<div style="width:10%;float:left;">
<input type="checkbox" name="Edit<?php echo $i ; ?>" id="Edit<?php echo $i.$s++ ; ?>"  value="1"/>&emsp;Edit</div>
<div style="width:10%;float:left;"><input type="checkbox" name="All<?php echo $i ; ?>" id="All<?php echo $i.$s++ ; ?>"  checked readonly value="1"/>&emsp;All</div>
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
<input type="button" class="btn btn-primary btn-md"  style="float:right;" name="Update" onclick="role_update()" value="save">
</form>
</div>
</div>
<!--<script>
var myRadio = document.getElementById('ssn_byphone');
var booRadio;

myRadio.onclick = function(){

    if(booRadio == this){
        this.checked = false;
        booRadio = null;
    }else{
        booRadio = this;
    }
};
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<input id="ssn_byphone" class="ssn_byphone" type="radio" name="pi[ssn_byphone]" value="Yes"><label for="radio1"> I will provide SSN by phone</label> */
-->
</div>
<script>
function back()
{
    role_master()
}
function role_update()
{
var id=0;
var data = $('form').serialize();
//alert(data);
$.ajax({
type:'POST',
data:"id="+id, data,
url:"Qvision/role/role_mapping_update.php",
success:function(data)
{
if(data!='')
{ 
alert('Updated Successfully');
role_master()
}
else
{
alert("No Data choose");
}

}       
});
} 
</script>