
<?php
 include('partials-front/session.php');
 include('partials-front/login-check.php'); 
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Website</title>

    
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
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
                        <a href="<?php echo SITEURL; ?>home.php">Home</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>categories.php">Categories</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>food.php">Foods/Menu</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>admin/login.php">Admin</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>../food-order/user-prof.php">User</a>
                    </li>
                    
                    
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>
</section>
    <!---End nav-->


    <?php
        //check wether food is set
        if(isset($_GET['food_id'])) 
        {
            //get food id and details
            $food_id = $_GET['food_id'];

            //get details of selected food
            $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
            //execute the query
            $res = mysqli_query($conn, $sql);
            //count rows
            $count = mysqli_num_rows($res);
            //check wether data is available
            if($count==1)
            {
                //we have data
                //get the data from database
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_name'];

            }
            else
            {
                //no data
                //redirect to home page
                header('location:'.SITEURL);
            }

        }
        else
        {
            //redirect
            header('location:'.SITEURL);
        }

    ?>

            <?php
                $sql3="SELECT * FROM tbl_user where id=$loggedin_id";
                $res3=mysqli_query($conn,$sql3);
            ?>
            <?php
                while($rows=mysqli_fetch_array($res3)){
            ?>
    <!--topbg-->
    <section class="topbg">
        <div class="container">
        </div>
    </section>
    <!--end of top bg-->

    <!--order-->
    <section class="food-order">
        <div class="container">
            <h2 class="text-center color-yellow">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <?php

                            //check wether the image is available
                            if($image_name=="")
                            {
                                //image not available
                                echo "<div class='error'>Image not available.</div>";
                            }
                            else
                            {
                                //image available
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="sisig" class="img-responsive img-curve">
                                <?php

                            }

                        ?>
                           
                    </div>
                    <div class="food-menu-desc">
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">

                        <p class="food-price">$<?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" value="<?php echo $rows['user_name']; ?>" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" value="<?php echo $rows['contact']; ?>" class="input-responsive" required>


                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Drive, Street, Barangay"class="input-responsive" required><?php echo $rows['address']; ?></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">

                </fieldset>

            </form>
            <?php
             }
        ?>

            <?php

                //check wether the submit btn is clicked
                if(isset($_POST['submit']))
                {
                    //get all the details from the form
                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];

                    $total = $price * $qty;//total = price x quantity

                    $order_date = date("y-m-d h:i:sa");//order date

                         // ordered/on delivery/delivered

                    $customer_name = $_POST['full-name'];
                    $customer_contact = $_POST['contact'];
                    $customer_address = $_POST['address'];

                    //save the order in database
                    //sql to save
                    $sql2 = "INSERT INTO tbl_order SET
                        food = '$food',
                        price = '$price',
                        qty = '$qty',
                        total = '$total',
                        order_date = '$order_date',
                        status = '$status',
                        customer_name = '$customer_name',
                        customer_contact = '$customer_contact',
                        customer_address = '$customer_address'                      
                    ";

                    //execute the query
                    $res2 = mysqli_query($conn, $sql2);

                    //check if query is successfull
                    if($res2==true)
                    {
                        //query executed and order saved
                        $_SESSION['order'] = "<div class='success text-center'>Food Ordered Successfully.</div>";
                        header('location:'.SITEURL);
                    }
                    else
                    {
                        //failed to execute query
                        $_SESSION['order'] = "<div class='error text-center'>Failed to order Food.</div>";
                        header('location:'.SITEURL);

                    }


                }

            ?>

        </div>
    </section>
    <!--end of order-->

    <?php include('partials-front/footer.php'); ?>