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
                        <a href="<?php echo SITEURL; ?>"home.php>Home</a>
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
    <!-- food search -->
    <section class="food-search text-center">
        <div class="container"> 
            <div class="food-search-msg">
                <?php     

                    //get the search keyword
                    //$search = $_POST['search'];
                    $search = mysqli_real_escape_string($conn, $_POST['search']);

                ?>

                <h2>Foods on Your Search <a href="#" class="color-yellow"><?php echo $search; ?></a></h2>
            </div>          
        </div>
    </section> 
    <!-- end food search-->

    <!--food menu-->
<!---End search-->

    <!--food menu-->
    <section class="food-menu">
        <div class="container">
        <h2 class="text-center color-yellow">Food Menu</h2>
        <?php
                $sql5="SELECT * FROM tbl_user where id=$loggedin_id";
                $res5=mysqli_query($conn,$sql5);
                
            ?>
            <?php
                while($rows=mysqli_fetch_array($res5)){
                $full_name = $rows['user_name'];
                    
            ?>

            <?php
                //display active foods
                $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

                //execute query
                $res=mysqli_query($conn, $sql);

                //count rows
                $count = mysqli_num_rows($res);
                
                //check wether the foods are available or not
                if($count>0)
                {
                    //food available
                    While($row=mysqli_fetch_assoc($res))
                    {
                        //get the values
                        $id = $row['id'];
                        $title = $row['title'];
                        $description = $row['description'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        ?>
                            <form action="" method="post" enctype="multipart/form-data">
                            <div class="food-menu-box">
                                <div class="food-menu-img">
                                    <?php 
                                        //check  wether image  is available
                                        if($image_name=="")
                                        {
                                            //image not available
                                            echo "<div class='error'>Image not available.</div>";
                                        }
                                        else
                                        {
                                            //image available
                                            ?>
                                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="" class="img-responsive img-curve">
                                            <?php
                                        }
                                    
                                    ?>
                                    
                                </div>
                                <div class="food-menu-desc">
                                    <h4><?php echo $title; ?></h4>
                                    <p class="food-price">₱<?php echo $price; ?></p>
                                    <p class="food-detail">
                                        <?php echo $description; ?>
                                    </p>
                                    <br>
                                    <input type="hidden" name="product_name" value="<?php echo $title; ?>">
                                    <input type="hidden" name="product_price" value="<?php echo $price; ?>">
                                    <input type="hidden" name="customer" value="<?php echo $full_name ?>">
                                        
                                    
                                    <input type="submit" class="btn btn-primary" value="add to cart" name="add_to_cart">
                                    

                                </div>
                            </div>
                            </form>

                        <?php 
                    }
                    
                }
                else
                {
                    //food not available
                    echo"<div class='error'>Food not found.</div>";
                }
            
            ?>
              <?php
             }
        ?> 
    <?php
        if(isset($_POST['add_to_cart']))
        {
            
            $product_name = $_POST['product_name'];
            $product_price = $_POST['product_price'];
            $customer = $_POST['customer'];
            
            
            $product_quantity = 1;
            
            $sql3 = "SELECT * FROM tbl_cart WHERE customer='$customer' AND name='$product_name'";
            $select_cart = mysqli_query($conn, $sql3);

            if(mysqli_num_rows($select_cart) > 0){
                $_SESSION['addcart'] = "<div class='error text-center'>item already added to cart.</div>";
                header('location:'.SITEURL.'food.php');
            }
            else{
                $sql2 = "INSERT INTO tbl_cart SET
                name = '$product_name',
                price = '$product_price',
                customer = '$customer',
                quantity = '$product_quantity'                     
            ";
                $insert_product = mysqli_query($conn, $sql2);
                
                $_SESSION['addcart'] = "<div class='success text-center'>item has been added to cart.</div>";
                header('location:'.SITEURL.'food.php');
                
            }

        }
    ?>


            <div class="clearfix"></div>
        </div>
    </section>
    <!--end of food menu-->

    <?php include('partials-front/footer.php'); ?>