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
            
        <h1>Update Category</h1>
            
        </div>
        <!--end nav-->
        <!--main content -->
        <div class="main-content">
    <div class="wrapper">
        

        <br><br><br>

        <?php

            //check wether the id is set
            if(isset($_GET['id']))
            {
                //get the id and all other details
                //echo "getting data";
                $id = $_GET['id'];
                //create sql to get details
                $sql =  "SELECT * FROM tbl_category WHERE id=$id";

                //execute the query
                $res = mysqli_query($conn, $sql);

                //count the rows to check if id is valid
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //get all data
                    $row =mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                }
                else
                {
                    //redirect to manage category with msg
                    $_SESSION['no-category-found'] ="<div class='error'>Category not found.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
            }
            else
            {
                //redirect to manage category
                header('location:'.SITEURL.'admin/manage-category.php');
            }

        ?>


        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td class="text1">Title: </td>
                    <td>
                        <input class="text2" type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td class="text1">Current Image: </td>
                    <td>
                        
                        <?php  
                        
                            if($current_image != "")
                            {
                                //display image
                                ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?> " alt="" width="150px">
                                <?php
                                
                            }
                            else
                            {
                                //display message
                                echo "<div class='error'>Image not added</div>";
                            }

                        ?>

                    </td>
                </tr>

                <tr>
                    <td class="text1">New Image: </td>
                    <td>
                        <input class="text2" type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td class="text1">Featured: </td>
                    <td class="text1">
                        <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td class="text1">Active: </td>
                    <td class="text1">
                        <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">   
                    </td>
                </tr>

            </table>
        </form>

        <?php 
        
            if(isset($_POST['submit']))
            {
                //echo"clicked";
                //get all the value from form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //updating image if selected
                //chech wether the image is selected or not
                if(isset($_FILES['image']['name']))
                {
                    //get image details
                    $image_name = $_FILES['image']['name'];

                    //check wether the image is available
                    if($image_name != "")
                    {
                        //image available
                        //A. upload new image

                        //auto rename our image
                        //get the extension of our image(jpg, png, gif, etc) e.g. "special.food.jpg"
                        $ext = end(explode('.', $image_name));

                        //renamge the image
                        $image_name = "Food_Category_".rand(000, 999).'.'.$ext; //e.g. Food_Category_921.jpg 


                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../images/category/".$image_name;

                        //upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //check wether the image is uploaded
                        //if the image is not upload. stop the process and redirect with error msg.
                        if($upload==false)
                        {
                            //set msg
                            $_SESSION['upload'] ="<div class='error'>Fail to upload image. </div>";
                            //redirect to category page
                            header('location:'.SITEURL.'admin/manage-category.php');
                            //stop the process
                            die();
                        }

                        //B. remove  the current image if available
                        if($current_image != "")
                        {
                            $remove_path = "../images/category/".$current_image;

                            $remove = unlink($remove_path);

                            //check wether the image is remove
                            //if not then display msg and stop process
                            if($remove==false)
                            {
                                //failed to remove image 
                                $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image</div>";
                                header('location:'.SITEURL.'admin/manage-category.php');
                                die();// to stop the process
                            }
                        }
                        
                    }
                    else
                    {
                        $image_name = $current_image;
                    }
                }
                else
                {
                    $image_name = $current_image;
                }

                //update the database
                $sql2 = "UPDATE tbl_category SET 
                    title = '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active' 
                    WHERE id=$id
                ";

                //execute the query
                $res2 = mysqli_query($conn, $sql2);

                //redirect to manage category
                //chech wether executed or not
                if($res2==true)
                {
                    //category added
                    $_SESSION['update'] = "<div class='success'>Category updated successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //failed to update category
                    $_SESSION['update'] = "<div class='error'>Category update failed.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }

            }

        ?>

    </div>
</div>
        <!--end of main content-->
    </div>
</body>

</html>