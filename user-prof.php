
<?php
include('partials-front/session.php'); 
include('partials-front/login-check.php');
?>
 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MK's User</title>

    
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
                        <a href="<?php echo SITEURL; ?>../food-order/user-prof.php">User</a>
                        
                    </li>
                    
                    
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>
    </section>
    <!---End nav-->
    
    <?php
 if(isset($_SESSION['update_quantity']))
 {
     echo $_SESSION['update_quantity'];
     unset($_SESSION['update_quantity']);
 }
 if(isset($_SESSION['delete']))
 {
     echo $_SESSION['delete'];
     unset($_SESSION['delete']);
 }
 if(isset($_SESSION['delete2']))
 {
     echo $_SESSION['delete2'];
     unset($_SESSION['delete2']);
 }
if(isset($_SESSION['checkout']))
{
    echo $_SESSION['checkout'];
    unset($_SESSION['checkout']);
}
if(isset($_SESSION['verify']))
{
    echo $_SESSION['verify'];
    unset($_SESSION['verify']);
}
if(isset($_SESSION['received']))
{
    echo $_SESSION['received'];
    unset($_SESSION['received']);
}

?>
<!--main content-->
<div class="body2 text-center">

    
            <?php
                $sql="SELECT * FROM tbl_user where id=$loggedin_id";
                $res=mysqli_query($conn,$sql);
                
            ?>
            <?php
                while($rows=mysqli_fetch_array($res)){
                $full_name = $rows['user_name'];
                $verified = $rows['verified'];
                    
            ?>

            <form action="" method="POST" id="signin" id="reg">
            <div class="head">Your Profile</div>
                <table>
                    <tr >
                        <td class="text1"> <div align="left">Full-Name:</div> </td>
                        <td class="text2"><?php echo $rows['user_name']; ?></td>
                    </tr>
                    <tr >
                        <td class="text1"><div align="left">Username:</div></td> 
                        <td class="text2"><?php echo $rows['user']; ?></td>
                    </tr>
                    <tr >
                        <td class="text1"><div align="left">Contact:</div></td>
                        <td class="text2"><?php echo $rows['contact']; ?></td>

                    </tr>
                    <tr >
                        <td class="text1"><div align="left">Address:</div></td>
                        <td class="text2"><?php echo $rows['address']; ?></td>
                    </tr>
                    <tr >
                        <td class="text1"><div align="left">Email:</div></td>
                        <td class="text2"><?php echo $rows['email']; ?></td>
                        <td>
                        <a class="btn2" href="<?php echo SITEURL; ?>../food-order/verify.php">Verify email</a>
                        </td>
                    </tr>
                    <?php 
                    if($verified == 1){
                        $verified = "Verified user";
                    }else{
                        $verified = "Unverified user";
                    }
                    
                    ?>
                    <tr >
                        <td class="text1"><div align="left">Status:</div></td>
                        <td class="text2"><?php echo $verified ?></td>
                        
                    </tr>
                    <tr>
                        <td>
                        <a class="btn2 float-left" href="<?php echo SITEURL; ?>../food-order/logout.php">Logout</a>
                        </td>
                        <td>
                        <a class="btn2" href="<?php echo SITEURL; ?>../food-order/update-user.php">Edit Profile</a>
                        </td>
                    </tr>
                     
                    
                </table>
            </form>
            <?php
             }
        ?>

      <div class="fixclear"></div>     
<section class="Cart">
    <div class="wrapper">
     <div class="head">cart</div>
            <br><br><br>
        <table>
             <thead>
                 <th>Name</th>
                 <th>Price</th>
                 <th>Quantity</th>
                 <th>Total Price</th>
                 <th>Action</th>
             </thead>

             <tbody>

                 <?php
                    $sql3 = "SELECT * FROM tbl_cart WHERE customer='$full_name' ORDER BY id DESC";
                    $select_cart = mysqli_query($conn, $sql3);
                    $grandtotal = 0;
                    

                    if(mysqli_num_rows($select_cart) > 0)
                    {
                        while($fetch_cart = mysqli_fetch_assoc($select_cart))
                        {
                 ?>
                    <tr>
                        <td><?php echo $fetch_cart['name']; ?></td>
                        <td>₱<?php echo number_format($fetch_cart['price']); ?></td>
                        <td>
                            <form action="" method="POST">
                                <input type="hidden" name="update_quantity_id" min="1" value="<?php echo $fetch_cart['id']; ?>">
                                <input type="number" name="update_quantity" min="1" value="<?php echo $fetch_cart['quantity']; ?>">
                                <input type="submit" value="Update" name="update_btn" >
                                
                                
                            </form>
                        </td>
                        <td>₱<?php echo $sub_total= number_format($fetch_cart['price'] * $fetch_cart['quantity']); ?></td>
                        <td><a href="user-prof.php?remove=<?php echo $fetch_cart['id']; ?>" onclick="return confirm('Remove item from cart?')" class="btn btn-delete"> <i class="fas fa-trash"></i> Remove</a></td>
                    </tr>

                 <?php
                    $grandtotal += $sub_total;


                    };
                };
                 ?>
                 <tr>
                     <td><a href="<?php echo SITEURL; ?>food.php" class="btn btn-primary">Order More</a></td>
                     <td colspan="2" class="btn-primary text-center">Grand Total</td>
                     <td><?php echo $grandtotal; ?></td>
                     <td><a href="user-prof.php?delete_all" onclick="return confirm('Do you want to remove all?')" class="btn btn-delete"> <i class="fas fa-trash"></i>Delete All</a></td>
                     
                 </tr>
                    
             </tbody>
                
        </table>

        <div class="checkout-btn">
        <a href="<?php echo SITEURL; ?>checkout.php" class="btn_checkout <?= ($grandtotal > 1)?'':'disabled'; ?>">Checkout</a>
        </div>

        <?php
            //update btn
            if(isset($_POST['update_btn']))
            {
                $update_value = $_POST['update_quantity'];
                $update_id = $_POST['update_quantity_id'];

                $sql4 = "UPDATE tbl_cart SET quantity = '$update_value'
                WHERE id = '$update_id'";
                $res4 = $update_quantity_query = mysqli_query($conn,$sql4);
                
                if($res4==true)
                {
                    $_SESSION['update_quantity'] = "<div class='success'>Quantity added.</div>";
                    header('location:'.SITEURL. 'user-prof.php');
                }
                else
                {
                    $_SESSION['update_quantity'] = "<div class='success'>Quantity failed to add.</div>";
                    header('location:'.SITEURL. 'user-prof.php'); 
                }

            }
            // remove product
            if(isset($_GET['remove']))
            {
                $remove_id = $_GET['remove'];
                $sql5 = "DELETE FROM tbl_cart WHERE id='$remove_id'";
                $res5 = mysqli_query($conn,$sql5);

                if($res5==true)
                {
                    $_SESSION['delete'] = "<div class='success'>Product deleted.</div>";
                    header('location:'.SITEURL. 'user-prof.php');
                }
                else
                {
                    $_SESSION['delete'] = "<div class='success'>Failed to delete.</div>";
                    header('location:'.SITEURL. 'user-prof.php');
                }
            }
            // delete btn
            if(isset($_GET['delete_all']))
            {

                $sql6 = "DELETE FROM tbl_cart";
                $res6 = mysqli_query($conn,$sql6);

                if($res6==true)
                {
                    $_SESSION['delete2'] = "<div class='success'>Cart has been deleted!!!.</div>";
                    header('location:'.SITEURL. 'user-prof.php');
                }
                else
                {
                    $_SESSION['delete2'] = "<div class='success'>Failed to delete the cart.</div>";
                    header('location:'.SITEURL. 'user-prof.php');
                }

            }

        ?>

    </div>
</section>
      
      
<!--main content -->
<div class="main-content landing-bg">
    <div class="wrapper2">
    <div class="head">Your Order</div>

            <br><br><br>

            <table class="tbl-full">
                <tr>
                    <th class="text-center">S.N</th>
                    <th class="text-center">Food</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Order Date</th>
                    <th class="text-center">Method</th>
                    <th class="text-center">Pickup Time</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Customer Name</th>
                    <th class="text-center">Contact</th>
                    <th class="text-center">Address</th>
                    
                </tr>

                <?php 
                    //get all  the orders from database
                    $sql2 = "SELECT * FROM tbl_order WHERE customer_name='$full_name' ORDER BY id DESC"; //display the latest at first
                    //execute query
                    $res2 = mysqli_query($conn, $sql2);
                    //count rows
                    $count = mysqli_num_rows($res2);

                    $sn = 1; //serial number

                    if($count>0)
                    {
                        //order available
                        while($row=mysqli_fetch_assoc($res2))
                        {
                            //get all the order details
                            $id = $row['id'];
                            $food = $row['food'];
                            $total = $row['total'];
                            $order_date = $row['order_date'];
                            $method = $row['method'];
                            $pickup = $row['pickup_time'];
                            $status = $row['status'];
                            $customer_name = $row['customer_name'];
                            $customer_contact = $row['customer_contact'];
                            $customer_address = $row['customer_address'];

                            ?>

                            <tr>
                                <td class="text-center"><?php echo $sn++; ?></td>
                                <td class="text-center"><?php echo $food; ?></td>
                                <td class="text-center"><?php echo $total; ?></td>
                                <td class="text-center"><?php echo $order_date; ?></td>
                                <td class="text-center"><?php echo $method; ?></td>
                                <td class="text-center"><?php echo $pickup; ?></td>

                                <td>
                                    <?php 
                                        //Ordered, Delivered, On Delivery, Cancelled

                                        if($status=="Ordered")
                                        {
                                            echo "<label>$status</label>";
                                        }
                                        elseif($status=="On Delivery")
                                        {
                                            echo "<label style='color: orange;'>$status</label>";
                                        }
                                        elseif($status=="Delivered")
                                        {
                                            echo "<label style='color: Green;'>$status</label>";  
                                        }
                                        elseif($status=="Cancelled")
                                        {
                                            echo "<label style='color: red;'>$status</label>";  
                                        }

                                    ?>
                                </td>

                                <td class="text-center"><?php echo $customer_name; ?></td>
                                <td class="text-center"><?php echo $customer_contact; ?></td>
                                <td class="text-center"><?php echo $customer_address; ?></td>
                                <td>
                                <a href="<?php echo SITEURL; ?>received.php?id=<?php echo $id; ?>" class="btn-primary">Received</a>
                                </td>
                                 
                                
                            </tr> 
                            

                            <?php

                        }
                    }
                    else
                    {
                        //order not available
                        echo "<tr><td colspan='12' class='error'>Orders Not Available.</td></tr>";
                    }

                ?>
            
            
                
            </table>
            
            


    </div>


    
</div>
<!--end of main content-->

</div>





<?php include('partials-front/footer.php'); ?>
