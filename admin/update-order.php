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
                    <li><a href="manage-order.php">Order</a></li>
                    <li><a href="logout.php">Logout</a></li>
            
        </ul>
    </div>
    <!-- end side bar-->
    <!--Nav bar-->
    <div class="container">
        <div class="header">
            
            <h1>Update Order</h1>
            
        </div>
        <!--end nav-->
        <!--main content -->
        <div class="main-content">
    <div class="wrapper">
        
        <br><br><br>

        <?php
            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }

        ?>
        <br><br>

        <?php

            //check wether id is set or not
            if(isset($_GET['id']))
            {
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
                    
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_address = $row['customer_address'];


                    
                }
                else
                {
                    //detail not available
                    //redirect to manage order
                    header('location:'.SITEURL.'admin/manage-order.php');
                }

            }
            else
            {
                //redirect to manage order page
                header('location:'.SITEURL.'admin/manage-order.php');
            }

        ?>


        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td class="text1">Orders</td>
                    <td class="text2"><b><?php echo $food; ?></b></td>
                </tr>

                <tr>
                    <td class="text1">Price</td>
                    <td class="text2"><b>₱<?php echo $price; ?></b></td>
                </tr>

                

                <tr>
                    <td class="text1">Status</td>
                    <td>
                        <select class="text2" name="status" >
                            <option <?php if($status=="Ordered"){echo "selected";} ?> value="Ordered">Ordered</option>
                            <option <?php if($status=="On Delivery"){echo "selected";} ?> value="On Delivery">On Delivery</option>
                            <option <?php if($status=="Delivered"){echo "selected";} ?> value="Delivered">Delivered</option>
                            <option <?php if($status=="Cancelled"){echo "selected";} ?> value="Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="text1">Customer Name:</td>
                    <td>
                        <input class="text2" type="text" name="customer_name" value="<?php echo $customer_name; ?>">
                    </td>
                </tr>
                <tr>
                    <td class="text1">Customer Contact:</td>
                    <td>
                        <input class="text2" type="text" name="customer_contact" value=" <?php echo $customer_contact; ?>">
                    </td>
                </tr>
                <tr>
                    <td class="text1">Customer Address:</td>
                    <td>
                        <textarea class="text2" name="customer_address"  cols="30" rows="5"><?php echo $customer_address; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        <input type="submit" name="submit" value="Update Order" class="btn-secondary"> 
                    </td>
                </tr>

                

            </table>

        </form>

        <?php
            //check wether update button is clicked
            if(isset($_POST['submit']))
            {
                //echo "clicked";
                //get all the values
                $id = $_POST['id'];
                $price = $_POST['total'];
                
                
                

                $status = $_POST['status'];

                $customer_name = $_POST['customer_name'];
                $customer_contact = $_POST['customer_contact'];
                $customer_address = $_POST['customer_address'];

                //update the values
                $sql2 = "UPDATE tbl_order SET
                    
                    
                    status='$status',
                    customer_name = '$customer_name',
                    customer_contact = '$customer_contact',
                    customer_address = '$customer_address'
                    WHERE id=$id
                ";

                //execute query
                $res2 = mysqli_query($conn, $sql2);

                //check wether it updated or not
                //redirect to manage order with msg
                if($res2==true)
                {
                    //update
                    $_SESSION['update'] = "<div class='success'>Order updated successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-order.php');
                }
                else
                {
                    //failed to update
                    $_SESSION['update'] = "<div class='error'>Failed to update Order.</div>";
                    header('location:'.SITEURL.'admin/manage-order.php');

                }

            }

        ?>

    </div>
</div>
        <!--end of main content-->
    </div>
</body>

</html>