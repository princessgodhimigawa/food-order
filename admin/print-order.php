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
    <title>Mikay's Kitchen</title>
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
            
            <h1>Print receipt</h1>
            
</div>
        <!--end nav-->
        <!--main content -->
        <div class="main-content">
    <div class="wrapper">
        
        <br><br><br>

        
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
                    $method = $row['method'];
                    $pickup = $row['pickup_time'];
                    $order_date = $row['order_date'];
                    
                    
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
            

            <div class='print-container'>
                        <div class='message-container'>
                            <h3>Thankyou for Shopping</h3>
                            <div class='order_detail'>

                                <span>"<?php echo $food ?>"</span>

                            </div>
                            <span class='total'> Total: ₱"<?php echo $price ?>"/- </span>


                            <div class='customer_details'>
                                <p>Name:  <span>"<?php echo $customer_name?>"</span> </p>
                                <p>Contact:  <span>"<?php echo $customer_contact?>"</span> </p>
                                <p>Address:  <span>"<?php echo $customer_address?>"</span> </p>
                                <p>Method: <span>"<?php echo $method?></span> </p>
                                <p>Pickup time: <span>"<?php echo $pickup?>"</span> </p>
                                <p>Date Ordered: <span>"<?php echo $order_date?>"</span> </p> 
                            </div>      

                            <p class='text-center tc'>Mikay's Kitchen</p>
                            
                        </div>
                        <button class="btn-primary" onclick="window.print();">
                                print
                        </button>
    
                        </div>

        

    </div>
</div>




    </div>
    
</body>

</html>