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
                <h3 class="card-title"><font size="5">EDIT ROLE DETAILS</font></h3>
		<a onclick="return back()" style="float: right;" data-toggle="modal" class="btn btn-danger">BACK</a>
				
              </div>
<div class="card-body" id="printableArea">
<form role="form" name="" action="" method="post" enctype="multipart/type">

<table class="table table-bordered">
<tr>
<td>Role Code</td>
<td colspan="5">
<input type="hidden" class="form-control" id="get_id" name="get_id" value="<?php echo  $id;?>">
<input type="text" class="form-control" id="Code" name="Code" value="<?php echo  $row['code'];?>" readonly>
</td>
</tr>

<tr>
<td>Role Name</td>
<td colspan="5">

<input type="text" class="form-control" id="name" name="name" value="<?php echo  $row['role_name'];?>">
</td>
</tr>
</table>
<input type="button" class="btn btn-primary btn-md"  style="float:right;" name="Update" onclick="role_update()" value="Update"> 

</form>
</div>
</div>
</div>
<script>
		function back()
    {
      role_master()
  }
     function role_update()
    {
    var id=$('#get_id').val();
	//alert(id);
    var data = $('form').serialize();
    $.ajax({
    type:'GET',
    data:"id="+id, data,
    url:'Qvision/role/update_role.php',
    success:function(data)
    {
      if(data==1)
      { 
        alert('Not updated');
      
      }
      else
      {
        alert("Update Successfully");
		role_master()
      }
      
    }       
    });
    }
  </script>