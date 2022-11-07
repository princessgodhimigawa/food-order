<?php

 include('../food-order/partials-front/login-checker.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mikay's Kitchen</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="landing-bg">

   <!---nav-->
<section class="navbar">
    <div class="container">
        <div class="logo">
            <a href="#" title="Logo">
                <img src="images/logo.png" alt="Restaurant Logo" class="img-responsive img-curve">
            </a>
        </div>

        <div class="menu text-right">
                
            <ul>
                <li>
                    <a class="btn-primary img-curve" href="<?php echo SITEURL; ?>register.php">Sign-Up</a>
                </li>
            </ul>

        </div>

        <div class="clearfix"></div>
    </div>
</section>
<!---End nav-->
<!---Content-->

<section class="landing">
    
        <div class="contentland">
            <h1>Mikay's Kitchen!!!</h1>
            <p>Homemade Foods made with local ingredients</p>
            
            <a href="<?php echo SITEURL; ?>login.php" class="primary-btn">Order Now</a>
        
        </div>
        <div class="img-landing">
            <img src="images/logo.png" alt="" class=" img-responsive img-curve">

        
        
        </div>
    
    
</section>




<!--- End Content-->
<!--social-->
<section class="social color-yellow">
    <div class="container text-center">
        <H1>Socials</H1>
        <ul> 
            <li><a href="https://www.facebook.com/Mikaycooks">
                 <div class="s-box">
                     <div class="s-logo">
                         <img src="../food-order/images/facebook.png" alt="" class="img-responsive img-curve">
                     </div>
                     <div class="s-desc">
                        <h4>Contact us on our facebook page</h4>
                     </div>
                 </div> 
                </a>                                                          
            </li>
            <li><a href="">
                <div class="s-box">
                    <div class="s-logo">
                        <img src="../food-order/images/foodpanda.png" alt="" class="img-responsive img-curve">
                    </div>
                    <div class="s-desc">
                       <h4>You can also order at Food Panda</h4>
                    </div>
                </div>
                </a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
</section>
<!--end social-->

<!--footer-->
<section class="footer">
    <div class="container text-center">
        <p>All rights reserved</p>
    </div>
</section>
<!--end of footer-->

</body>
</html>