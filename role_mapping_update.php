<?php
require '../../connect.php';
include("../../user.php");

$Code=$_REQUEST['Code'];
$menu=$_REQUEST['menu'];
$submenu=$_REQUEST['submenu'];


 $menu_id= count($menu);


 for($i=0;$i<$menu_id;$i++)
{
	
	
	//echo  $i;
	/* $View=$_REQUEST[$v]; */
$menus= $menu[$i]; 
$submenus=$submenu[$i];
$res1="View$i";
$Views= $_REQUEST[$res1];
$res2="Edit$i";
$Edits= $_REQUEST[$res2];
$res3="All$i";
$Alls= $_REQUEST[$res3];


 $sql=$con->query("update z_role_detail set view_only = '$Views', edit_only = '$Edits', all_only = '$Alls' WHERE code = '$Code' and menu_id= '$menus' and submenu_id= '$submenus'"); 

echo "update z_role_detail set view_only = '$Views', edit_only = '$Edits', all_only = '$Alls' WHERE code = '$Code' and menu_id= '$menus' and submenu_id= '$submenus'";
}