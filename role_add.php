<?php
require '../../connect.php';
include("../../user.php");
$userrole=$_SESSION['userrole'];
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
<div class="card card-primary">
              <div class="card-header">
                
				       <h3 class="card-title"><font size="5">ADD ROLE</font></h3>
		<a onclick="return back()" style="float: right;" data-toggle="modal" class="btn btn-danger">BACK</a>
              </div>
<form method="POST" action="">
<table class="table table-bordered">

           
        <tr>
       <td>Role  Code</td>
        <td colspan="5"><input type="text" class="form-control" placeholder="Role code" id="code" name="code"></td>
        </tr>
        
        
         <tr>
        <td>Role Name</td>
        <td colspan="5"><input type="text" class="form-control" placeholder="Role Name"  name="name" id="name"></td>
        </tr>
		
			
		
	
		
        <td colspan="6"><input type="button" class="btn btn-success" name="save" onclick="insert_role()" value="save" style="float:right;" ></td>
        </tr>
        </table>
</form>
</div>
<script>
		function back()
    {
      role_master()
  }
  </script>
  <script>
    function insert_role()
    {
    var id=0;
    var data = $('form').serialize();
	//alert(data);
    $.ajax({
    type:'GET',
    data:"id="+id, data,
	url:"Qvision/role/role_insert.php",
    success:function(data)
    {
      if(data!='')
      { 
        alert('Entry Successfully');
		
        role_master()
      }
      else
      {
        alert("Entry Successfully");
		
        role_master()
      }
      
    }       
    });
    }
	
	$(document).ready(function() {
$('#Department').on('change', function() {

var department_id = this.value;
//alert(department_id);
$.ajax({
url: "Qvision/CRM/find_emp.php",
type: "POST",
data: {
department_id: department_id
},
cache: false,
success: function(result){
$("#employee").html(result);


}
});
});
});
    </script>
