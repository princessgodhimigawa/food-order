<?php include('partials-front/session.php'); ?>



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

                    <?php
                        $select_rows = mysqli_query($conn,"SELECT * FROM tbl_cart WHERE customer='$loggedin_fullname'");
                        $row_count = mysqli_num_rows($select_rows);
                    ?>

                    <li>
                        <a href="<?php echo SITEURL; ?>../food-order/user-prof.php">Cart(<span><?php echo $row_count ?></span>)</a>
                        
                    </li>
                    
                    
                </ul>

            </div>

            <div class="clearfix"></div>
        </div>
</section>
    <!---End nav-->

    <?php 
    //check wether id is set or not
    if(isset($_GET['id'])){
        //get the order details
        $id = $_GET['id'];

        //get all other details base on id
                //sql query
                $sql = "SELECT * FROM tbl_order WHERE id=$id";
                //execute Query
                $res = mysqli_query($conn, $sql);
                //count rows
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //detail available
                    $row=mysqli_fetch_assoc($res);

                    $food = $row['food'];
                    $price = $row['total'];
                    $order_date = $row['order_date'];
                    $method = $row['method'];
                    $pickup = $row['pickup_time'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_address = $row['customer_address'];
                    
                }
                else
                {
                    //detail not available
                    //redirect to manage order
                    header('location:'.SITEURL.'user-prof.php');
                }
    }else
    {
        //redirect to manage order page
        header('location:'.SITEURL.'user-prof.php');
    }

    ?>
<div class="container">
    <div class="wrapper">
    
<form action="" method="POST">
<input type="submit" name="submit" value="Order Received" class="btn-primary"> 
            <table >
                <tr>
                    <td >Orders</td>
                    <td ><b><?php echo $food; ?></b></td>
                </tr>

                <tr>
                    <td >Price</td>
                    <td ><b>₱<?php echo $price; ?></b></td>
                </tr>
                <tr>
                    <td >Order_date:</td>
                    <td>
                        <input  type="text" name="order_date" value="<?php echo $order_date; ?>"readonly>
                    </td>
                </tr>
                <tr>
                    <td >Method:</td>
                    <td>
                        <input  type="text" name="method" value="<?php echo $method; ?>"readonly>
                    </td>
                </tr>
                <tr>
                    <td >Pickup time</td>
                    <td>
                        <input  type="text" name="pickup" value="<?php echo $pickup; ?>"readonly>
                    </td>
                </tr>


                <tr>
                    <td >Customer Name:</td>
                    <td>
                        <input  type="text" name="customer_name" value="<?php echo $customer_name; ?>"readonly>
                    </td>
                </tr>
                
                <tr>
                    <td >Customer Contact:</td>
                    <td>
                        <input type="text" name="customer_contact" value=" <?php echo $customer_contact; ?>"readonly>
                    </td>
                </tr>
                <tr>
                    <td >Customer Address:</td>
                    <td>
                        <textarea class="text2" name="customer_address"  cols="30" rows="5"readonly ><?php echo $customer_address; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td >
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        
                    </td>
                </tr>

                

            </table>

        </form>

        <?php
            //check wether update button is clicked
            if(isset($_POST['submit']))
            {
                
                
                
                $order_date = $_POST['order_date'];
                $method = $_POST['method'];
                $pickup = $_POST['pick_up'];
                $customer_name = $_POST['customer_name'];
                $customer_contact = $_POST['customer_contact'];
                $customer_address = $_POST['customer_address'];
                $status = "Delivered";

                $sql = "UPDATE tbl_order SET
                    status = '$status'
                    WHERE id = $id
                ";
                $res = mysqli_query($conn,$sql);

                // insert to history
                $sql2 = "INSERT INTO tbl_history SET
                    food = '$food',
                    total = '$price',
                    order_date = '$order_date',
                    method = '$method',
                    pickup_time = '$pickup',
                    customer_name = '$customer_name',
                    customer_contact = '$customer_contact',
                    customer_address = '$customer_address'
                ";
                $res2 = mysqli_query($conn,$sql2);

                if($res2==true)
                {
                    $_SESSION['received'] = "<div class='success'>Food received Thank You for ordering.</div>";
            
                    header('location:'.SITEURL. 'user-prof.php');
                }

            }else{
                echo"error";
            }



        ?>

    </div>
</div>
        </div>
        </div>
        <!--end of main content-->
    </div>

    <?php include('partials-front/footer.php'); ?>