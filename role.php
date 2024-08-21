<?php
require '../../connect.php';
include("../../user.php");
/* $candidateid=$_SESSION['candidateid'];
$userrole=$_SESSION['userrole']; */
?>
<head>
    <link rel="stylesheet" href="Qvision\commonstyle.css">
    </head>
	<style>
	.card-primary:not(.card-outline)>.card-header{
		background-color: #f1cc61 !important;
	}
	</style>
<div  class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><font size="5">ROLE MANAGEMENT SYSTEM LIST</font></h3>
			<a onclick="add_role()" style="float: right;" data-toggle="modal" class="btn btn-dark">ADD</a>
		
              </div>
           
              <div class="card-body">
       <!-- <table class="dataTables-example table table-striped table-bordered table-hover"  id="example1"> -->
		 
	   <table class="table table-striped table-bordered table-hover display nowrap"  id="example1" style="width:100%">

    <thead>
	<th>S.No</th>
      <th>Code</th>
	            <th>Role Name</th>
<th>Status</th>				        
<th>Action</th>
 
     
      <!--th>Tools</th-->
      </thead>
      <tbody>
      <?php
	  
      $assets_sql=$con->query("SELECT * FROM `z_role_master` ORDER BY id DESC");
	   $i=1;
      while($assets_res = $assets_sql->fetch(PDO::FETCH_ASSOC))
      {
       ?>
      <tr>
      <td><?php echo $i; ?></td>
	   <td><?php echo $assets_res['code']; ?></td>
      <td><?php echo $assets_res['role_name']; ?></td>
	     
			 <td>
<?php if(($assets_res['status']==1))  
{

echo '<span style="color:green;text-align:center;"><b>Active</b></span>';
}
if(($assets_res['status']==2))  
{
echo '<span style="color:red;text-align:center;"><b>Pending</b></span>';
}

?></td>
     <td>
	 
	  <button class="btn btn-success" data-id="<?php echo $assets_res['id']; ?>" onclick="role_edit(<?php echo $assets_res['id']; ?>)"><i class="fa fa-edit"></i> EDIT</button>
	   <?php $role_code  = $assets_res['code'];
	  $role_sql="SELECT * FROM `z_role_detail` where code='$role_code'";
	   $query1 = $con->query($role_sql);
	   $query1->execute();
	   $role_count = $query1->rowCount();
       if($role_count>0){
	   ?>
	   <button class="btn btn-danger" data-id="<?php echo $assets_res['id']; ?>" onclick="role_mapping_edit(<?php echo $assets_res['id']; ?>)">Role Mapping View</button> 
	   <?php }else{ ?>
	  <button class="btn btn-primary" data-id="<?php echo $assets_res['id']; ?>" onclick="role_view(<?php echo $assets_res['id']; ?>)"><i class="fa fa-eye"></i> Role Mapping</button>
	  <?php }?>
	  </td>
      </tr>
      <?php
	  $i++;
      }
      ?>
      </tbody>
      </table>
	 
   
</div>
</div>
<script>
$(document).ready(function() {
    $('#example1').DataTable( {
        "scrollX": true
    } );
} );
</script>
<!-- <script>
            $(document).ready(function() {
                $('.dataTables-example').DataTable({
                        responsive: true
                });
            });
        </script> -->
<script>
		function add_role()
    {
    $.ajax({
    type:"POST",
	url:"Qvision/role/role_add.php",
	success:function(data){
   $("#main_content").html(data);
    }
    })
  }
  
   function role_edit(v){
	  //alert(v);
	$.ajax({
	type:"POST",
	url:"Qvision/role/role_edit.php?id="+v,
    success:function(data)
	{
		$("#main_content").html(data);
	}
	})
}
     function role_view(v){
	  //alert(v);
	$.ajax({
	type:"POST",
	url:"Qvision/role/role_view.php?id="+v,
    success:function(data)
	{
		$("#main_content").html(data);
	}
	})
}
   
        function role_mapping_edit(v){
	//  alert(v);
	$.ajax({
	type:"POST",
	url:"Qvision/role/role_mapping_edit.php?id="+v,
    success:function(data)
	{
		$("#main_content").html(data);
	}
	})
}
</script>