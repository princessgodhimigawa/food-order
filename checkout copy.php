<?php
 include('partials-front/session.php');
 include('partials-front/login-check.php'); 
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MK's Checkout</title>

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
                        <a href="<?php echo SITEURL; ?>">Home</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>categories.php">Categories</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>food.php">Foods/Menu</a>
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
                $sql1="SELECT * FROM tbl_user where id=$loggedin_id";
                $res1=mysqli_query($conn,$sql1);
            ?>
            <?php
                while($rows=mysqli_fetch_array($res1)){
                    $full_name = $rows['user_name'];
            ?>
    <!--Checkout-->
<section class="Checkout">
    <div class="container">
        <form action="" method="post" class="order">
            <fieldset>
            <legend>Ordered foods</legend>
                <div class="checkout-order">
                <?php
                
                $sql2="SELECT * FROM tbl_cart WHERE customer='$full_name'";
                $res2=mysqli_query($conn,$sql2);
                $total = 0;
                $grand = 0;
                if(mysqli_num_rows($res2) > 0){
                    while($fetch_cart = mysqli_fetch_assoc($res2)){
                    $total_price = number_format($fetch_cart['price'] * $fetch_cart['quantity']);
                    $grand_total = $total += $total_price;
            ?>
            <span><?=$fetch_cart['name']; ?>(<?=$fetch_cart['quantity']; ?>)</span>

            <?php
                
                };
            };
            ?>
            <div>
                <span class=grand-total>Grand total: <?= $grand_total;?></span>
            </div>

                </div>

            </fieldset>
        <fieldset>
        <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" value="<?php echo $rows['user_name']; ?>" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" value="<?php echo $rows['contact']; ?>" class="input-responsive" required>
                    
                    <div class="order-label">Payment Method</div>
                    <select name="method" class="input-responsive" >
                        <option  value="Cash on Delivery" selected>Cash on Delivery</option>
                        <option  value="Pick Up">Pick Up</option>
                    </select>

                    <div class="order-label">Pickup Time</div>
                    <input type="text" name="pickup-time" placeholder="Enter time you want to pickup your order"  class="input-responsive">

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="5" class="input-responsive" required><?php echo $rows['address']; ?></textarea>

                    
                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                    
        </fieldset>
        </form>
    <?php
                }
    ?>

        <?php
            if(isset($_POST['submit']))
            {
                $full_name = $_POST['full-name'];
                $contact = $_POST['contact'];
                $address = $_POST['address'];
                $order_date = date("y-m-d h:i:sa");
                $status = "Ordered";
                $method = $_POST['method'];
                $pickup = $_POST['pickup-time'];

                $cart_query = mysqli_query($conn, "SELECT * FROM tbl_cart WHERE customer='$full_name'");
                $price_total = 0;
                if(mysqli_num_rows($cart_query) > 0){
                    while($product_item = mysqli_fetch_assoc($cart_query)){
                        $product_name[] = $product_item['name'].'('.$product_item['quantity'].')';
                        $product_price = number_format($product_item['price'] * $product_item['quantity'] );
                        $price_total += $product_price;
                    };
                };

                $total_product = implode(',',$product_name);
                
                $sql3 = "INSERT INTO tbl_order SET
                food = '$total_product',
                total = '$price_total',
                order_date = '$order_date',
                method = '$method',
                pickup_time = '$pickup',
                status = '$status',
                customer_name = '$full_name',
                customer_contact = '$contact',
                customer_address = '$address'
                ";
                
                $res3 = mysqli_query($conn,$sql3);

                if($cart_query && $res3){

                    $sqldel = "DELETE FROM tbl_cart WHERE customer='$full_name'";
                    $resdel = mysqli_query($conn,$sqldel);
                    
                    $_SESSION['checkout'] = "<div class='success text-center'>Food Ordered Successfully.</div>";
                   
                    header('location:'.SITEURL.'user-prof.php');
                }

            }

        ?>

    </div>
    
</section>
    <!--Checkout end-->

    <?php include('partials-front/footer.php'); ?>