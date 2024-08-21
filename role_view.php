<?php
require '../../connect.php';
include("../../user.php");
// echo "SELECT * FROM `z_role_master` where id='$id'";
 $id=$_REQUEST['id'];
$stmt = $con->prepare("SELECT * FROM `z_role_master` where id='$id'");
$stmt->execute(); 
$row = $stmt->fetch();
$sta=$row['status'];
?>
<head>
    <link rel="stylesheet" href="Qvision\commonstyle.css">
     <script>
        function toggleMenu(source, menuId) {
            const checkboxes = document.querySelectorAll(`input[data-menu="${menuId}"]`);
            checkboxes.forEach(checkbox => {
                checkbox.checked = source.checked;
            });
        }
    </script>
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
                <h3 class="card-title" style="float: left;"><font size="5">ROLE DETAILS MAPPING</font></h3>
		  		  <a onclick="return back()" style="float: right;" data-toggle="modal" class="btn btn-dark"><i class="fa fa-plus"></i>Back</a>
		      </div>
           
 <form method="POST" enctype="multipart/form-data" autocomplete="off">
<table class="table table-bordered">

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
	  
      $assets_sql=$con->query("SELECT id,menu_name FROM `z_masters_menu` order by id");
	   $i=0;
      while($menu_name = $assets_sql->fetch(PDO::FETCH_ASSOC))
      	      {
      	      	$menu_id = $menu_name['id'];
       ?>
	   <b style="padding: 5px 0px;color:blue;"><?php echo $menu_name['menu_name']; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
	    <input type="checkbox" onclick="toggleMenu(this, '<?php echo $menu_id; ?>');" /> Check All<br />
           <br />
	   <?php
				 $men=$menu_name['id']; 
				 
				 
				  $submenu=$con->query("select id,name from z_masters_sub_menu where menu_id=' $men' order by id");
				 
				  while($sub_menu_name = $submenu->fetch(PDO::FETCH_ASSOC))
      {
					  $s=1;
				?>
    <div style="width:100%;float:left;padding: 5px 0px;">
      <!--<input class="checkbox" style="width:2%;float:left;" type="checkbox" name="checkbox_<?php echo $i;?>" id="checkbox_<?php echo $i;?>" onclick="enablebox(this.id)"/>-->
	      <input type="hidden"  id="menu" name="menu[]" class="form-control"  value="<?php echo $menu_name['id'];?>" >

		   <input type="hidden"  id="submenu" name="submenu[]" class="form-control"  value="<?php echo $sub_menu_name['id'];?>" >

		<div style="width:30%;float:left;">&emsp;<?php echo $sub_menu_name['name']; ?></div>
     <div style="width:10%;float:left;">
				<input type="checkbox" name="View<?php echo $i ; ?>" id="View<?php echo $i.$s++ ; ?>" value="1" data-menu="<?php echo $menu_id; ?>" />&emsp;View</div>
				<div style="width:10%;float:left;">
				<input type="checkbox" name="Edit<?php echo $i ; ?>" id="Edit<?php echo $i.$s++ ; ?>" value="1" data-menu="<?php echo $menu_id; ?>"/>&emsp;Edit</div>
				<div style="width:10%;float:left;"><input type="checkbox" name="All<?php echo $i ; ?>" id="All<?php echo $i.$s++ ; ?>" value="1" data-menu="<?php echo $menu_id; ?>"/>&emsp;All</div>
     </div>
      <?php
	  $i++;
      }
	  }
      ?>

      </tbody>
      <input type="button" class="btn btn-primary btn-md"  style="float:right;" name="Update" onclick="role_update()" value="save">
      </table>		 
<br>
<br>

<!--<input type="submit" class="btn btn-primary btn-md"  style="float:right;" name="Update" value="save">--> 
</form>
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
    data:"id="+id,data,
	url:"Qvision/role/role_mapping_insert.php",
    success:function(data)
    {
      if(data!='')
      { 
        alert('Entry Successfully');
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
