<?php
 include('../food-order/config/constants.php');
 
$user_check=$_SESSION['user'];
$ses_sql=mysqli_query($conn,"SELECT id,user,contact,address,email,vkey,verified,user_name FROM tbl_user where user='$user_check'");
$row=mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
$loggedin_session=$row['user'];
$loggedin_id=$row['id'];
$loggedin_contact=$row['contact'];
$loggedin_fullname=$row['user_name'];
$loggedin_address=$row['address'];
$loggedin_email=$row['email'];
$loggedin_vkey=$row['vkey'];
$loggedin_verified=$row['verified'];
if(!isset($loggedin_session) && $loggedin_session==NULL) {
 echo "Go back";
 header('location:'.SITEURL.'../food-order/index.php');
}
?>