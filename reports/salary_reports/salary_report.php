<?php
	require '../../../connect.php';
?>

<style>
.card-primary:not(.card-outline)>.card-header{
	background-color: #f1cc61 !important;
}
.card-primary:not(.card-outline)>.card-header a {
	color: black;
}
.card-primary:not(.card-outline)>.card-header{
	color: black !important;
}
</style>	

	<div  class="card card-primary">
    <div class="card-header">
	<div class="col-lg-12">
	<h4>SALARY REPORT</h4>
	</div>
    <div class="panel-body">
	<form method="GET" name="salary_reports" role="form">

	<div class="row">	
		<div class="col-lg-2">
		<div class="form-group">
			<label> Employee Name </label>
		</div>
		</div>

		<div class="col-lg-3">
		<div class="form-group">
		    <select class="form-control" name="emp_name" >
				<option value="0"> -- Select Employee -- </option>
				<?php 
			        $staff = $con->query("select id,emp_name from staff_master where  status='1' ");
					while($staffView = $staff->fetch(PDO::FETCH_ASSOC)){	
				?>
				<option value="<?php echo $staffView['id'];?>"> <?php echo $staffView['emp_name'];?> </option>
                  
				<?php } ?>
			</select> 
		</div>
		</div>

		<div class="col-lg-1">
		<div class="form-group">
		   <label> Month </label>
		</div>		
		</div>
		
		<div class="col-lg-3">
		<div class="form-group">
		  <input type="month" name="sr_month" class="form-control" required>  
		</div>		
		</div>
		
		<div class="col-lg-2">
		<div class="form-group">		
		<input  type="button" class="btn btn-default" value="search" onclick="salaryReport_empview()">
		</div>
		</div>
		
		</div>
	</form>
	</div>
    </div>
  <!-- /.card-header -->
    <div class="card-body">
      <div id="salaryReport_details_view">
      </div>
    </div>
    <!-- /.card-body   style="overflow-x: scroll !important;"-->
  </div>

	
<script>
function salaryReport_empview()
{
	var data = $('form').serialize();
	$.ajax({
	type: 'GET',
	url: 'Qvision/reports/salary_reports/salary_report_empview.php',
	data: data,
	success: function(data)
	{
	$("#salaryReport_details_view").html(data);		
	}				
	});	
}
</script>