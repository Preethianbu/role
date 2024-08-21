<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<div class="col-md-12" style="text-align: end;margin: 5px;">
  <a href="#" id="1" style="font-size:20px;" class="excel btn btn-success" onclick="ExportToExcel('xlsx')">
  <span class="fa fa-download">&nbsp;Excel</a>&nbsp;&nbsp;
  <!-- <a href="#" id="1" style="font-size:20px;" class="excel btn btn-success" onclick="tableToExcel('main', 'List User')">
  <span class="fa fa-download">&nbsp;Excel</a>&nbsp;&nbsp; -->
</div>

	<table class="dataTables-example table table-striped table-bordered table-hover" id="tbl_exporttable_to_xls">
	<thead>
<tr>
	<th>S.No</th>
	<th>PF No</th>
	<th>UAN NO</th>
	<th>ESIC No</th>
	<th>Employee No</th>
	<th>DOJ</th>
	<th>DOMC</th>
	<th>Experience</th>
	<th>Location</th>
	<th>Name</th>
	<th>Department</th>
	<th>Designation</th>
	<th>Total Gross Salary</th>
<!--	<th>Gross</th> -->
	<th>N.O. Leave Taken (Eligible)</th>
	<th>NOA</th>
	<th>LOP/Late</th>
	<th>Prorrata Salary Deduction</th>
	<th>Working Days</th>
	<th>Paid Days Salary</th>
	<th>Basic </th>
	<th>HRA </th>
	<th>OtherAllowance</th>
	<th>SiteAlloowance</th>
	<th>GrossTotal</th>
	<th>PF</th>
	<th>ESI</th>
	<th>PF working days Deduction</th>
	<th>ESI Working days Deduction</th>
	<th>PT Deduction</th>
	<th>Advance</th>
	<th>TDS Deduction</th>
	<th>E-claim reimbursement</th>
	<th>Net Amount</th>
	
</tr>
	</thead>
	<tbody>
	<?php
		require '../../../connect.php';	

		$emp_id = $_REQUEST['emp_name'];

		$sr_month = $_REQUEST['sr_month'];
		 
		$fromDate = preg_split("/\-/",$sr_month);
		$from_year = $fromDate[0]; //Year
		$from_month = $fromDate[1]; //Month

	
		//get payroll_master details
			
			if($emp_id){
		    $staff_sql=$con->query("SELECT a.* FROM staff_master a  join bb_attendance b on a.emp_code = b.emp_code where  a.id = '$emp_id' and a.status=1 and year(b.in_log_date)='$from_year' and month(b.in_log_date) = '$from_month' group by b.emp_code ");	
			
		}else{
			 $staff_sql=$con->query("SELECT a.* FROM staff_master a  join bb_attendance b on a.emp_code = b.emp_code wherea.status=1 and year(b.in_log_date)='$from_year' and month(b.in_log_date) = '$from_month' group by b.emp_code ");	
		} 
		
		$p = 1;
		while($staff_sql_res=$staff_sql->fetch(PDO::FETCH_ASSOC))
		{					
	$employee_id = $staff_sql_res['id'];
			$candid_id = $staff_sql_res['candid_id'];
			$employee_code =$staff_sql_res['emp_code'];
			$emp_name = $staff_sql_res['emp_name'];
			$department_id = $staff_sql_res['dep_id'];
			$designation = $staff_sql_res['design_id'];
			$salary_amount = $staff_sql_res['salary_amount'];
			$deduct_id = $staff_sql_res['payroll_deduction_id'];
			$pf_number = $staff_sql_res['pf_number'];
			$uan_number = $staff_sql_res['uan_number'];
			$esic_number = $staff_sql_res['esic_number'];
			$location = $staff_sql_res['location'];
		
		    //Account Number && IFSC code
			$account_num = $staff_sql_res['account_no'];
			$ifsc_code = $staff_sql_res['ifsc_code'];
			
			//Department		
			$dep_sql=$con->query("SELECT dept_name FROM z_department_master WHERE id='$department_id'");
			$dep_sql_res=$dep_sql->fetch(PDO::FETCH_ASSOC);
			$dept_name = $dep_sql_res['dept_name'];
		
			//Designation	
			
			$des_sql=$con->query("SELECT designation_name FROM designation_master WHERE id='$designation'");
			$des_sql_res=$des_sql->fetch(PDO::FETCH_ASSOC);
			$designation_names = $des_sql_res['designation_name'];
		
			//DOJ 
			$doj_sql=$con->query("SELECT * from candidate_form_details WHERE id='$candid_id'");
			$doj_sql_res=$doj_sql->fetch(PDO::FETCH_ASSOC);		
			$doj = $doj_sql_res['joining_date'];
			$Experience=$doj_sql_res['no_of_year'];
		



 //echo $getworkdaytype.'kokoko';
        $countgetworkingdays=$con->query("SELECT sum(working_days) as workdy_count,total_days FROM `bb_attendance` where emp_code='$employee_code' and year(in_log_date)='$from_year' and month(in_log_date) = '$from_month'");
		//echo "SELECT sum(working_days) as workdy_count,total_days FROM `bb_attendance` where emp_code='$employee_code' and year(in_log_date)='$y' and month(in_log_date) = '$m'";
    		$workdaystake=$countgetworkingdays->fetch(PDO::FETCH_ASSOC);
			
		$lop_dates = array(); // Array to store full-day leave dates
$lop_half_dates = array(); // Array to store half-day leave dates
$lopList_get ='0';
$getlopdate = $con->query("SELECT in_log_date, working_days FROM `bb_attendance` WHERE emp_code='$employee_code' AND (working_days='0.0' OR working_days='0.5') AND year(in_log_date)='$from_year' AND month(in_log_date) = '$from_month'");

while ($lopppp_dates = $getlopdate->fetch(PDO::FETCH_ASSOC)) {
    if ($lopppp_dates['working_days'] == '0.0') {
        $lop_dates[] = $lopppp_dates['in_log_date']; // Store full-day leave date
    } else if ($lopppp_dates['working_days'] == '0.5') {
        $lop_half_dates[] = $lopppp_dates['in_log_date']; // Store half-day leave date
    }
	// Merge both arrays
$lopList_get = array_merge($lop_dates, $lop_half_dates);

// Convert the array to a comma-separated string
$lopList_get = implode(', ', $lopList_get);

}



		$month_days = round($workdaystake['total_days']);//roundvalue 30
        if ($month_days!=0) {
		$work_days = $workdaystake['workdy_count'];
          ///$work_days=20;
		  
	$saldetails=$con->query("SELECT * FROM `joining_detail_sal_structure` WHERE candid_id='$candid_id'");
	$amtshow=$saldetails->fetch(PDO::FETCH_ASSOC);
	$sal_amt=$amtshow['fixedgross_month'];
	$pf_amt=$amtshow['employee_PF_month'];
	$esic_amt=$amtshow['employee_ESIC_month'];
	$basic_amt=$amtshow['basic_month'];
	
		if($work_days)
		{
			$work_days=$work_days;
		}
else{
	$work_days=0;
}		
	
	
	if($month_days>$work_days)
{

	   $salacalc=$amtshow['basic_month']/$month_days;
	   $basicdasal=$salacalc*$work_days;
	   
	   
	   $oacalc=$amtshow['otherallowances_permonth']/$month_days;
	$otherallowance=$oacalc*$work_days;
	
	$sacalc=$amtshow['siteallowance_permonth']/$month_days;
	$siteallowance=$sacalc*$work_days;
	
	$hraamountcalc=$amtshow['HRA_month']/$month_days;
	  $HRA=$hraamountcalc*$work_days;
		 
}	
	else
	{
	$basicdasal=$amtshow['basic_month'];

$otherallowance=$amtshow['otherallowances_permonth'];
$siteallowance=$amtshow['siteallowance_permonth'];

 $HRA=$amtshow['HRA_month'];	
	}
	
	$claimmt=$con->query("SELECT sum(amount) as claimamt FROM `claim_request` WHERE candidate_id='$candid_id' and month(date)='from_mont' and year(date)='$from_year'");
    $claim_cals=$claimmt->fetch(PDO::FETCH_ASSOC);		
    if($claim_cals['claimamt'])
	{
		$claim_amount=$claim_cals['claimamt'];
	}
	else
	{
		$claim_amount=0;
	}
$leavedays=$month_days-round($work_days);

$lop=1;//defauflop
if($leavedays>1)
{
	$lopshow=$leavedays-$lop;
	
	$perdaysalary=$sal_amt/$month_days;//perday salary
	
    $minus_salry=$lopshow*$perdaysalary;
	
	$eraned_gross=$basicdasal-$minus_salry;
	
	if($eraned_gross){
		$eraned_gross=$eraned_gross;
	}
	else
	{
		$eraned_gross=$basicdasal;
	}
}
else{
	$lopshow=0;
	$eraned_gross=$basicdasal;
}



$pfcalc = $basicdasal + $otherallowance;
$defaultpf = 1800;
if ($pfcalc > 15000) {
    $pfamount = $defaultpf;
} else {
    //$work_days1 = 12;
	//echo $month_days;
    if (round($work_days) < 15) {
        $pfcal = $defaultpf /$month_days;
        $pfemp = $pfcal * round($work_days);
        $pfamount = round($pfemp, 2);
    } else {
        $pfamount = $amtshow['employee_PF_month'];
    }
}




	 $gross_salary=$basicdasal+$HRA+$otherallowance;
  $gross_salary = $basicdasal + $HRA + $otherallowance;
$esicamount = 0; // Initialize esicamount to 0 by default.

if ($gross_salary <= 21000) {
    $esicamount = $amtshow['employee_ESIC_month'];
}



$month='0'.$from_month;
$salaryadvance=$con->query("SELECT sum(advance_amount) as advance_amt FROM `salary_advance` WHERE emp_id='$candid_id' AND DATE_FORMAT(created_on, '%Y-%m') = '$from_year-$from_month'");
 $saladvance_cals=$salaryadvance->fetch(PDO::FETCH_ASSOC);
if($saladvance_cals['advance_amt'])
{
	$advance_sal=$saladvance_cals['advance_amt'];
	
	$netsalary=$eraned_gross-round($advance_sal);
	if($netsalary)
	{
		$netsalary=$netsalary;
	}
	else
	{
		$netsalary=$eraned_gross;
	}
}	
else
{
	$advance_sal=0;
	$netsalary=$eraned_gross;
}

	
	
		

		
?>
			<tr>
			<td><?php echo $p++;?></td>
			<td><?php echo $pf_number;?></td>
			<td><?php echo $uan_number;?></td>
			<td><?php echo $esic_number;?></td>
			<td><?php echo $employee_code;?></td>
			<td><?php echo date('d/m/Y',strtotime($doj));?></td>
			<td><?php echo 0;?></td>
			<td><?php echo $Experience?></td>
			<td><?php echo $location;?></td>
			<td><?php echo $emp_name;?></td>
			<td><?php echo $dept_name;?></td>
			<td><?php echo $designation_names;?></td>
			<td><?php echo $basicdasal ;?></td>
			<td><?php echo 1; ?></td>
			<td><?php echo $lopshow ;?></td>
			<td><?php echo $lopshow .'/'.$lopList_get ; ?></td>
			<td><?php echo 0; ?></td>
			<td><?php echo $month_days;?></td>
			<td><?php echo round($work_days);?></td>
			<td><?php echo $basicdasal; ?></td>
			<td><?php  echo $HRA; ?></td>
			<td><?php echo $otherallowance?></td>
			<td><?php echo $siteallowance ?></td>
			<td><?php echo $basicdasal; ?></td>
			<td><?php echo number_format($pf_amt ,2); ?></td>
			<td><?php echo number_format($esic_amt,2); ?></td>
			<td><?php echo number_format($pfamount,2); ?></td>
			<td><?php echo number_format($esicamount,2); ?></td>
			<td><?php echo 0.0; ?></td>
			<td><?php echo number_format($advance_sal,2); ?></td>
			<td><?php echo 0 ?></td>
			<td><?php  echo $claim_amount; ?></td>
			<td><?php echo number_format($netsalary,2);?></td>
			</tr>
			<?php
		}
		}
		?>
		</tbody>
		</table>
	
<script type="text/javascript">
 var tableToExcel = (function() {
var uri = 'data:application/vnd.ms-excel;base64,'
, template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
, base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
return function(table, name) {
if (!table.nodeType) table = document.getElementById(table)
var ctx = {worksheet: name || 'Worsheet', table: table.innerHTML}

window.location.href = uri + base64(format(template, ctx))
}
})() 

 $(function () {
      
        $('#tbl_exporttable_to_xls').DataTable({
        //   "paging": true,
        //   "lengthChange": true,
        //   "searching": true,
        //   "ordering": true,
        //   "info": true,
		//   "responsive": true,
        //   "autoWidth": true,
		"scrollX": true,
          "scrollY": 200,
        });
      });
	  
	  function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('tbl_exporttable_to_xls');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('SS_Employee_Salary_Report.' + (type || 'xlsx')));
    }
</script>
</body>
</html>