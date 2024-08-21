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
	<th>LTA</th>
	<!-- <th>SAD</th> -->
	<th>Conveyance</th>
	<th>Spl Allowance</th>
	<th>Bas,Con,Spl Allw</th>
	<th>GrossTotal</th>
	<th>PF</th>
	<th>ESI</th>
	<th>PF working days Deduction</th>
	<th>ESI Working days Deduction</th>
	<th>PT Deduction</th>
	<th>Advance/Laptop Deduction/Others</th>
	<th>TDS Deduction</th>
	<th>E-claim reimbursement</th>
	<th>Total Deduction</th>
	<th>Net Amount</th>
	<th>ESIC Employer</th>
</tr>
	</thead>
	<tbody>
	<?php
		require '../../../connect.php';	

		$srFromDate = $_REQUEST['sr_FromDate'];
		$srToDate = $_REQUEST['sr_ToDate']; 
		
		$fromDate = preg_split("/\-/",$srFromDate);
		$from_year = $fromDate[0]; //Year
		$from_month = $fromDate[1]; //Month
	
		$toDate = preg_split("/\-/",$srToDate);
		$to_year = $toDate[0]; //Year 
		$to_month = $toDate[1]; //Month
		//get payroll_master details
			

		$staff_sql=$con->query("SELECT a.* FROM staff_master a  join bb_attendance b on a.id = b.emp_code where  a.status=1 group by b.emp_code ");	
	
		$p = 1;
		while($staff_sql_res=$staff_sql->fetch(PDO::FETCH_ASSOC))
		{					
		 	$employee_id = $staff_sql_res['id'];
			$candid_id = $staff_sql_res['candid_id'];
			$employee_code = $staff_sql_res['prefix_code'].$staff_sql_res['emp_code'];
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
			$doj_sql=$con->query("SELECT joining_date from candidate_form_details WHERE id='$candid_id'");
			$doj_sql_res=$doj_sql->fetch(PDO::FETCH_ASSOC);		
			$doj = $doj_sql_res['joining_date'];
			
			//Account details
			$acc_sql=$con->query("SELECT acc_number,ifsc,acc_holder_name FROM emp_personal_details where emp_id='$candid_id'");
			$acc_sql_res=$acc_sql->fetch(PDO::FETCH_ASSOC);		
			$ac_number = $acc_sql_res['acc_number'];
			$ifsc = $acc_sql_res['ifsc'];
			
			//Days of working		
			$days_sql=$con->query("SELECT total_no_of_days,days_worked FROM payroll_salary_deduction where employee_code='$employee_id' and (( payroll_month between '$from_month' and '$to_month') or ( payroll_year  between '$from_year' and '$to_year')) and total_no_of_days is not null limit 0,1");
			
			$days_sql_res=$days_sql->fetch(PDO::FETCH_ASSOC);		
			$month_days = $days_sql_res['total_no_of_days'];
			$work_days = $days_sql_res['days_worked'];
			
			//Earnings
			$earning_sql=$con->query("SELECT earnings,amount FROM payroll_salary_earnings WHERE (( payroll_month between '$from_month' and '$to_month') or ( payroll_year  between '$from_year' and '$to_year')) and employee_code='$employee_id' order by id asc");
			
			$amount=array();
			
			while($earning_sql_res=$earning_sql->fetch(PDO::FETCH_ASSOC))
			{	
				$ear_name = $earning_sql_res['earnings'];
				$amount[$ear_name] = $earning_sql_res['amount'];
			}			
		    //$gross_salary = array_sum($amount); 
			
		//Earned salary START
			$earned_sql=$con->query("SELECT earnings,amount FROM payroll_earned_salary WHERE (( payroll_month between '$from_month' and '$to_month') or ( payroll_year  between '$from_year' and '$to_year')) and  employee_code='$employee_id' order by id asc");
			
			$earned_amount=array();
			
			while($earned_sql_res=$earned_sql->fetch(PDO::FETCH_ASSOC))
			{	
				$earned_name = $earned_sql_res['earnings'];
				$earned_amount[$earned_name] = $earned_sql_res['amount'];
			}			
		     $gross_salary = array_sum($earned_amount); 	
		//Earned salary END
			
			//deductions		
			$earning_sql=$con->query("SELECT * FROM payroll_salary_deduction WHERE (( payroll_month between '$from_month' and '$to_month') or ( payroll_year  between '$from_year' and '$to_year')) and employee_code='$employee_id' order by id asc");
			
			$deduction=array();
			$ded_amount=array();
			
			while($earning_sql_res=$earning_sql->fetch(PDO::FETCH_ASSOC))
			{		
				$deduction_name = $earning_sql_res['deduction'];
				$ded_amount[$deduction_name] = $earning_sql_res['amount'];
			}
			
			$deduction_total = array_sum($ded_amount);
			$number=$gross_salary-$deduction_total;

			if (array_key_exists("Loss Of Pay",$ded_amount)) { 
			    $lop_add= $ded_amount['Loss Of Pay']; 	
				
			}else { 
			    $lop_add= 0;
			}
			$ear_amount=$gross_salary-$lop_add;

			 
			  if (array_key_exists("PF",$ded_amount)) { 
			    $pfamt= $ded_amount['PF'];
			 }else{
				 $pfamt=0;
			 }
			 
			 if (array_key_exists("PT",$ded_amount)) { 
			    $ptamt= $ded_amount['PT'];
			 }else{
				 $ptamt=0;
			 }
			 
			 if (array_key_exists("Salary Advance",$ded_amount)) { 
			    $SalaryAdvanceamt= $ded_amount['Salary Advance'];
			 }else{
				 $SalaryAdvanceamt=0;
			 }

			 if (array_key_exists("TDS",$ded_amount)) { 
			    $tdsamt= $ded_amount['TDS'];
			 }else{
				$tdsamt=0;
			 }
			//$gross_amount= $salary_amount+$esiamt;  //+$clbamt
		
		//SAD 
			if (array_key_exists("SAD",$ded_amount)) { 
			    $sadamt= $ded_amount['SAD'];
			 }else{
				$sadamt=0;
			 }
			 
			//NET Salary
			  if (array_key_exists("ESIC",$ded_amount)) { 
		     $ear_esi=round($ear_amount * 0.75/100); 
				
			  }else{
				  
			    $ear_esi=0;
			  }
			  $net_amount=$ear_amount-$pfamt-$ear_esi-$tdsamt-$sadamt-$ptamt-$SalaryAdvanceamt; //-$clbamt

	////////////////////////////// Actual ESIC ///////////////////////////////////
			  if (array_key_exists("ESIC",$ded_amount)) { 
				$actual_asi = round($salary_amount * 0.75/100); 
				   
				 }else{
					 
				   $actual_asi=0;
				 }

				 if (array_key_exists("ESIC",$ded_amount)) { 
					$actual_employer_esi = round($salary_amount * 3.25/100); 
					   
					 }else{
						 
					   $actual_employer_esi = 0;
					 }

    //////////////////////////////// Actual PF /////////////////////////////////////

	$deduct_sql = $con->query("SELECT id, name, from_date, amount, percentage, min_amount, max_amount, status FROM payroll_deduction_master where id in ($deduct_id)");
	while($deduct_data = $deduct_sql->fetch(PDO::FETCH_ASSOC)) {

					$deduction=$deduct_data['name'];
					$deduct_amount=$deduct_data['amount'];
					$percentage=$deduct_data['percentage'];

					if($deduct_amount == 0 && $deduction == 'PF'){
						if($deduction == 'PF'){
						  $PFamount = round($salary_amount * $percentage/100);
						}
					}
					elseif($deduct_amount > 0 && $deduction == 'PF'){
						 $PFamount = $deduct_amount;   //When salary more than 15K the PF deduction is RS.1800/- as default;
						}
					else{
						$PFamount = 0;
					}
				}
 //////////////////////////////////////////// Actual PF END ////////////////////////////////////////////////
 //////////////////////////////////////////// SUM basic, conveyance,LTA,Special Allowance ////////////////////////////////////////////////
  if (array_key_exists("Basics",$earned_amount)) 
  { 
	 $basic =  $earned_amount['Basics']; 
}else { 
	 $basic =  0;
} 

 if (array_key_exists("LTA",$earned_amount)) 
 { 
	 $lta =  $earned_amount['LTA']; 
}else { 
	 	$lta =  0;
} 

if (array_key_exists("Conveyance",$earned_amount)) 
{ 
	 $conveyance = $earned_amount['Conveyance']; 
}else { 
	 $conveyance =  0;
} 

 if (array_key_exists("Special Allowance",$earned_amount))
  { 
	 	$sa =  $earned_amount['Special Allowance']; 
}else { 
	 $sa =  0;
} 

$blcs = number_format($basic + $lta + $conveyance + $sa) ;

 //////////////////////////////////////////// SUM basic, conveyance,LTA,Special Allowance  END////////////////////////////////////////////////
 //////////////////////////////////////////// Total Deduction  ////////////////////////////////////////////////

if (array_key_exists("claim",$earned_amount)) 
{
	 $calimAmt = number_format($earned_amount['claim'],2); 
}else { 
	$calimAmt =  0;
} 

$total_deduction = $pfamt + $ear_esi + $ptamt + $SalaryAdvanceamt + $tdsamt + $calimAmt;

 //////////////////////////////////////////// Total Deduction  END////////////////////////////////////////////////
 
$date1 = $doj;
$date2 = date('Y-m-d');
//$days  = (strtotime($date2) - strtotime($date1)) / (60 * 60 * 24);
//print $days; 


$datetime1 = date_create($date2);
$datetime2 = date_create($date1);
$diff = date_diff($datetime1, $datetime2);

//echo $diff->format("%m")."months<br>";
//Outputs difference in months.

//echo $diff->format("%a")."days<br>";
//Outputs difference in days.

//echo $diff->format("%h")."hours<br>";
//Outputs difference in hours.

//echo $diff->format("%y years %m months %d days %h hours %i minutes %s seconds");
//Outputs difference in years, months, days hours, minutes and seconds


?>
			<tr>
			<td><?php echo $p++;?></td>
			<td><?php echo $pf_number;?></td>
			<td><?php echo $uan_number;?></td>
			<td><?php echo $esic_number;?></td>
			<td><?php echo $employee_code;?></td>
			<td><?php echo date('d/m/Y',strtotime($doj));?></td>
			<td><?php echo 0;?></td>
			<td><?php echo $diff->format("%y years %m months %d days");?></td>
			<td><?php echo $location;?></td>
			<td><?php echo $emp_name;?></td>
			<td><?php echo $dept_name;?></td>
			<td><?php echo $designation_names;?></td>
			<td><?php echo number_format($salary_amount,2) ;?></td>
			<td><?php echo 0 ;?></td>
			<td><?php echo 0 ;?></td>
			<td><?php if (array_key_exists("Loss Of Pay",$ded_amount)) { echo number_format($ded_amount['Loss Of Pay'],2); }else { echo 0;} ?></td>
			<td><?php echo 0; ?></td>
			<td><?php echo $month_days;?></td>
			<td><?php echo $work_days;?></td>
			<td><?php if (array_key_exists("Basics",$earned_amount)) { echo number_format($earned_amount['Basics'],2); }else { echo 0;} ?></td>
			<td><?php if (array_key_exists("House Rent Allowance",$earned_amount)) { echo number_format($earned_amount['House Rent Allowance'],2); }else { echo 0;} ?></td>
			<td><?php if (array_key_exists("LTA",$earned_amount)) { echo number_format($earned_amount['LTA'],2); }else { echo 0;} ?></td>
			<td><?php if (array_key_exists("Conveyance",$earned_amount)) { echo number_format($earned_amount['Conveyance'],2); }else { echo 0;} ?></td>
			<td><?php if (array_key_exists("Special Allowance",$earned_amount)) { echo number_format($earned_amount['Special Allowance'],2); }else { echo 0;} ?></td>
			<td><?php echo $blcs; ?></td>
			
			<!-- <td><?php if (array_key_exists("claim",$earned_amount)) { echo number_format($earned_amount['claim'],2); }else { echo 0;} ?></td> -->
		<!--	<td>< ?php echo $gross_amount;?></td> -->
			
			
			
			<td><?php echo number_format($ear_amount,2);  ?></td>	
			<td><?php echo number_format($PFamount,2); ?></td>
			<td><?php echo number_format($actual_asi,2); ?></td>
			<td><?php echo number_format($pfamt,2); ?></td>
			<td><?php echo number_format($ear_esi,2); ?></td>
			<td><?php echo number_format($ptamt,2); ?></td>
			<td><?php echo number_format($SalaryAdvanceamt,2); ?></td>
			<td><?php echo number_format($tdsamt,2); ?></td>
			<td><?php if (array_key_exists("claim",$earned_amount)) { echo number_format($earned_amount['claim'],2); }else { echo 0;} ?></td>
			<td><?php echo number_format($total_deduction,2);?></td>
			<td><?php echo number_format($net_amount,2);?></td>
			<td><?php echo number_format($actual_employer_esi,2);?></td>
			</tr>
			<?php
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