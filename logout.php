<?php
    //include constants.php for SITEURL
    include('../food-order/config/constants.php');
    //destroy session
    session_destroy();

    //redirect login page
    header('location:'.SITEURL.'../food-order/');
  
?>