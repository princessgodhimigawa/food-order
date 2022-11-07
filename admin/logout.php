<?php
    //include constants.php for SITEURL
    include('../config/constants.php');
    //destroy session
    session_destroy();

    //redirect login page
    header('location:'.SITEURL.'admin/login.php');
  
?>