<?php 

    //check wether the user is logged in or not
    if(!isset($_SESSION['user']))//if user session is not set
    {
        //user is not login
        //redirect to login page
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to access Order.</div>";
        //redirect to login page
        header('location:'.SITEURL.'../food-order/login.php'); 
    }
    

?>