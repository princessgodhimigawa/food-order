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
            
        <h1>Food Update</h1>
            
        </div>
        <!--end nav-->
        <!--main content -->
        <?php
//check wether id is set or not
    if(isset($_GET['id']))
    {
        //get all the details
        $id = $_GET['id'];

        //sql query to get the selected food
        $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
        //execute query
        $res2 = mysqli_query($conn, $sql2);

        //get the value based on query executed
        $row2 = mysqli_fetch_assoc($res2);

        //get  the individual values of selected food.
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];



    }
    else
    {
        //redirect to manage food
        header('location:'.SITEURL.'admin/manage-food.php');
    }

?>

<div class="main-content">
    <div class="wrapper">
        

        <br><br><br>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">

                <tr>
                    <td class="text1">Title: </td>
                    <td>
                        <input class="text2" type="text" name="title" value="<?php echo $title; ?>" >
                    </td>
                </tr>

                <tr>
                    <td class="text1">Description: </td>
                    <td>
                        <textarea class="text2" name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td class="text1">Price: </td>
                    <td>
                        <input class="text2" type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>

                <tr>
                    <td class="text1">CurrentImage: </td>
                    <td>
                        <?php 
                            if($current_image == "")
                            {
                                //image is not available
                                echo "<div class='error'>Image not Available.</div>";
                            }
                            else
                            {
                                //image available
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                                <?php
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td class="text1">Select NewImage: </td>
                    <td>
                        <input class="text1" type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td class="text1">Category: </td>
                    <td>
                        <select class="text2" name="category">

                        <?php
                            //query to get active categories
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            //execute the query
                            $res = mysqli_query($conn, $sql);
                            //count rows
                            $count = mysqli_num_rows($res);

                            //wether category is available
                            if($count>0)
                            {
                                //category available
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];
                                    
                                    //echo"<option value='$category_id'>$category_title</option>";
                                    ?>
                                    <option <?php if($current_category==$category_id){echo"selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                    <?php
                                }
                            }
                            else
                            {
                                //category no available
                                echo "<option value='0'>Category Not Available</option>";
                            }

                        ?>

                        
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="text1">Featured: </td>
                    <td class="text1">
                        <input <?php if($featured=='Yes') {echo "Checked";} ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if($featured=='No') {echo "Checked";} ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td class="text1">Active: </td>
                    <td class="text1">
                        <input <?php if($active=='Yes') {echo "Checked";} ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active=='No') {echo "Checked";} ?> type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php

            if(isset($_POST['submit']))
            {
                //echo "clicked";
                //1. get the details from form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];

                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //2. upload the image if selected
                //check wether the upload button is clicked
                if(isset($_FILES['image']['name']))
                {
                    //button clicked
                    $image_name = $_FILES['image']['name'];
                    
                    //check wether the file is available
                    if($image_name!="")
                    {
                        //image is available and
                        //A. Uploading new image

                        // rename the image
                        $ext = end(explode('.', $image_name));//get the extension of image

                        $image_name = "Food_Name-".rand(0000,9999).'.'.$ext; //this will be renamed image

                        //get the source path and destination path
                        $src_path = $_FILES['image']['tmp_name'];//path
                        $dest_path = "../images/food/".$image_name;//destination

                        //upload image
                        $upload = move_uploaded_file($src_path, $dest_path);

                        //check wether the image is uploaded
                        if($upload==false)
                        {
                            //failed to upload
                            $_SESSION['upload'] = "<div class='error'>Failed to upload image</div>";
                            //redirect to  manage food
                            header('location:'.SITEURL.'admin/manage-food.php');
                            //stop the process
                            die();
                        }
                        //3.remove the image if new image is uploaded
                        //B. remove current image if available
                        if($current_image != "")
                        {
                            //current image is available
                            //remove image 
                            $remove_path = "../images/food/".$current_image;

                            $remove = unlink($remove_path);

                            //check if the image is removed
                            if($remove==false)
                            {
                                //failed to remove
                                $_SESSION['remove-failed'] = "<div class='error'>Failed to remove image.</div>";
                                //redirect to manage food
                                header('location:'.SITEURL.'admin/manage-food.php');
                                //stop the process
                                die();

                            

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

                //4.update the food in database
                $sql3 = "UPDATE tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id
                ";

                //execute the sql query
                $res3 = mysqli_query($conn, $sql3);

                //check wether the query is executed or not
                if($res3==true)
                {
                    //query executed and food update
                    $_SESSION['update'] = "<div class='success'>Food Updated Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //faile to update
                    $_SESSION['update'] = "<div class='error'>Failed to update Food.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
            
            
                }
            }

        ?>

    </div>

</div>
        <!--end of main content-->
    </div>
</body>

</html>