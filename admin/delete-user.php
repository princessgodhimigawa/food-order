<?php 
    //include constants.php
    include('../config/constants.php');
    
    //get the ide of admin to be deleted
    $id = $_GET['id'];

    //create sql query to delete admin
    $sql = "DELETE FROM tbl_user WHERE id=$id";

    //execute the query
    $res = mysqli_query($conn, $sql);

    //check wether the query executed successfully or not
    if($res==true)
    {
        //query executed successfully and admin delete
        //echo"admin deleted";
        //Create Session Variable to display message
        $_SESSION['delete'] = "<div class='success'>User Deleted Successfully.</div>";
        //redirect to manage admin page
        header('location:'.SITEURL. 'admin/manage-user.php');
    }
    else
    {
        //failed to delete admin
        //echo"faile to delete"
        $_SESSION['delete'] = "<div class='error'>Failed to Delete User</div>";
        header('location:'.SITEURL. 'admin/manage-user.php');
    }
    

?>

