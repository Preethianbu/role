<?php
require '../../connect.php';
include("../../user.php");
$Code=$_REQUEST['Code'];
$menu=$_REQUEST['menu'];
$submenu=$_REQUEST['submenu'];

$date = date("Y-m-d");


$menu_id= count($menu);


 for($i=0;$i<$menu_id;$i++)
{
	
	
	/* $v="View".$i;
	 $View=$_REQUEST[$v]; */
$menus= $menu[$i];
$submenus=$submenu[$i];
$res1="View$i";
$Views= $_REQUEST[$res1];
$res2="Edit$i";
$Edits= $_REQUEST[$res2];
$res3="All$i";
$Alls= $_REQUEST[$res3];


// echo "<pre>";
// echo $Views.'--'.$Edits.'--'.$Alls;
// echo "</pre>";

 $sql=$con->query("INSERT into `z_role_detail`(`code`, `menu_id`, `submenu_id`, `view_only`, `edit_only`, `all_only`,`created_on`)  values('$Code','$menus','$submenus','$Views','$Edits','$Alls','$date')");

// echo "INSERT into `z_role_detail`(`code`, `menu_id`, `submenu_id`, `view_only`, `edit_only`, `all_only`,`modified_on`)  values('$Code','$menus','$submenus','$Views','$Edits','$Alls','$date')";

 header('Location:../index.php'); 

// echo "insert into `z_role_detail`(`code`, `menu_id`, `submenu_id`, `view_only`, `edit_only`, `all_only`)  values('$Code','$menus','$submenus','$Views','$Edits','$Alls');";
}