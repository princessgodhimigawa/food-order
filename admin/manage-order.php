<?php 
    include('partials/dashboard.php');
?>
<!DOCTYPE html> 
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/admindash.css">
    <title>Admin Panel</title>
</head>

<body>
    <!-- side bar-->
    <div class="side-menu">
        <div class="admin-name">
        <H2 class="">Mikay's Kitchen</H2>
        </div>
        <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="manage-admin.php">Admin</a></li>
                    <li><a href="manage-user.php">Users</a></li>
                    <li><a href="manage-category.php">Category</a></li>
                    <li><a href="manage-food.php">Food</a></li>
                    <?php
                        $select_rows = mysqli_query($conn,"SELECT * FROM tbl_order WHERE status='Ordered'");
                        $row_count = mysqli_num_rows($select_rows);
                    ?>
                    <li><a href="manage-order.php">Order(<span><?php echo $row_count ?></span>)</a></li>
                    <li><a href="logout.php">Logout</a></li>
            
        </ul>
    </div>
    <!-- end side bar-->
    <!--Nav bar-->
    <div class="container">
        <div class="header">
            
        <h1>Manage order</h1>
            
        </div>
        <!--end nav-->
        <!--main content -->
<div class="main-content">
    <div class="">
        

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
                    $sql = "SELECT * FROM tbl_order ORDER BY id DESC"; //display the latest at first
                    //execute query
                    $res = mysqli_query($conn, $sql);
                    //count rows
                    $count = mysqli_num_rows($res);

                    $sn = 1; //serial number

                    if($count>0)
                    {
                        //order available
                        while($row=mysqli_fetch_assoc($res))
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
                                
                                <td class="text-center">₱<?php echo $total; ?></td>
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
                                    <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Update</a>
                                    <a href="<?php echo SITEURL; ?>admin/print-order.php?id=<?php echo $id; ?>" class="btn-secondary">Print</a>
                                    
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

</body>

</html>