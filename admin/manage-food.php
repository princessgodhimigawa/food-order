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
            
        <h1>Manage food</h1>
            
        </div>
        <!--end nav-->
        <!--main content-->
        <div class="main-content">
    <div class="wrapper">

        <br><br><br>

            <!--button add admin-->
            <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary">Add Food</a>

            <br><br><br>

            <?php
                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }
                if(isset($_SESSION['delete']))
                {
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                }
                if(isset($_SESSION['upload']))
                {
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
                }
                if(isset($_SESSION['unauthorize']))
                {
                    echo $_SESSION['unauthorize'];
                    unset($_SESSION['unauthorize']);
                }
                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }

            ?>

            <table class="tbl-full">
                <tr>
                    <th>S.N</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Action</th>
                </tr>

                <?php  
                    //create a sql query to get all the food
                    $sql = "SELECT * FROM tbl_food";

                    //Execute the Query
                    $res = mysqli_query($conn, $sql);

                    //count rows to check wether we have food or not
                    $count = mysqli_num_rows($res);

                    //create serial number variable
                    $sn=1;

                    if($count>0)
                    {
                        //we have food in database
                        //geh the foods from database and display
                        while($row=mysqli_fetch_assoc($res))
                        {
                            //get the value from individual columns
                            $id = $row['id'];
                            $title = $row['title'];
                            $price = $row['price'];
                            $image_name = $row['image_name'];
                            $featured = $row['featured'];
                            $active = $row['active'];
                            ?>

                            <tr>
                                <td><?php echo $sn++; ?>.</td>
                                <td><?php echo $title; ?></td>
                                <td>₱<?php echo $price; ?></td>
                                <td>
                                    <?php 
                                    //check wther we have image or not
                                    if($image_name=="")
                                    {
                                        //we do not have image display error
                                        echo "<div class='error'>Image not Added.</div>";
                                    }
                                    else
                                    {
                                        //we have to display image
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" width="100px">
                                        <?php
                                    }
                                    
                                    ?>
                                </td>
                                <td><?php echo $featured; ?></td>
                                <td><?php echo $active; ?></td>
                                <td>
                                    <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-secondary">Update Food</a>
                                    <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Food</a>
                                </td>
                            </tr> 

                            <?php
                        }
                    }
                    else
                    {
                        //food not adden in database
                        Echo "<tr><td colspan='7' class='error'>Food not Added yet. </td></tr>";
                    }

                ?>

                 
            </table>

    </div>
    
</div>
        <!--end main content-->
    </div>
</body>

</html>