<?php
require '../../connect.php';

$id=1;


$code=$_REQUEST['code'];
$name=$_REQUEST['name'];


$query=$con->query("INSERT INTO  z_role_master(`code`,`role_name`,`modified_on`) VALUES ('$code','$name',now())");

//echo "INSERT INTO  z_role_master(`code`,`role_name`,`modified_on`) VALUES ('$code','$name',now())";
if($query)
{
	echo 0;
}
else
{
	echo 1;
} 
