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
            
        <h1>Add Food</h1>
            
        </div>
        <!--end nav-->
        <!--main content -->
        <div class="main-content">
        <div class="wrapper">
            

            <br><br><br>

            <?php
                if(isset($_SESSION['upload']))
                {
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
                }
            ?>

            <form action="" method="POST" enctype="multipart/form-data">

                <table class="tbl-30">

                    <tr>
                        <td class="text1">Title: </td>
                        <td>
                            <input class="text2" type="text" name="title" placeholder="Title of the food">
                        </td>
                    </tr>

                    <tr>
                        <td class="text1">Description: </td>
                        <td>
                            <textarea class="text2" name="description" cols="30" rows="5" placeholder="Description of the food"></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td class="text1">Price: </td>
                        <td>
                            <input class="text2" type="number" name="price" >
                        </td>
                    </tr>

                    <tr>
                        <td class="text1">SelecImage: </td>
                        <td>
                            <input class="text1" type="file" name="image">
                        </td>
                    </tr>

                    <tr>
                        <td class="text1">Category: </td>
                        <td>
                            <select class="text2" name="category" >

                                <?php 
                                
                                    //create php code to display categories from database
                                    //display only active categories

                                    $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                                    //executing query
                                    $res = mysqli_query($conn, $sql);

                                    //count rows to check wether we have categories or not
                                    $count = mysqli_num_rows($res);

                                    //if count is > 0 we have categories else none
                                    if($count>0)
                                    {
                                        //we have categories
                                        while($row=mysqli_fetch_assoc($res))
                                        {
                                            //get the details of category
                                            $id = $row['id'];
                                            $title = $row['title'];
                                            ?>

                                               <option value="<?php echo $id; ?>"><?php echo $title; ?></option> 

                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        //we do not have category
                                        ?>
                                            <option value="0">No Category Found.</option>
                                        <?php
  
                                    }


                                    //display on dropdown
                                
                                ?>

                                                            
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="text1">Featured: </td>
                        <td class="text1">
                            <input type="radio" name="featured" value="Yes">Yes
                            <input type="radio" name="featured" value="No">No
                        </td>
                    </tr>

                    <tr>
                        <td class="text1">Active: </td>
                        <td class="text1">
                            <input type="radio" name="active" value="Yes">Yes
                            <input type="radio" name="active" value="No">No
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                        </td>
                    </tr>

                </table>

            </form>

            <?php

                //check wether the button is clicked
                if(isset($_POST['submit']))
                {
                    //add food to database
                    //echo"add food";

                    //get the data from form
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $category = $_POST['category'];

                    //check wether radio btn for featured is checked or not
                    if(isset($_POST['featured']))
                    {
                        $featured = $_POST['featured'];
                    }
                    else
                    {
                        $featured = "No";
                    }

                    if(isset($_POST['active']))
                    {
                        $active = $_POST['active'];
                    }
                    else
                    {
                        $active = "No";
                    }

                    //upload the image if selected
                    //check wether the selected image is click or not. upload only if the image is selected
                    if(isset($_FILES['image']['name']))
                    {
                        //get the details of the select image
                        $image_name = $_FILES['image']['name'];

                        //check wether the image is selected or not. upload only if selected
                        if($image_name!="")
                        {
                            //image is select
                            //A. rename the image
                            //get the extension of the selected image (jpg, png, gif, etc)
                            $ext = end(explode('.', $image_name));

                            //create new name for image
                            $image_name = "Food-Name-".rand(0000,9999).".".$ext; //new image name food-name-942.jpg

                            //B. upload the image
                            //get the source path and destination path

                            //source path is the current location of the image
                            $src = $_FILES['image']['tmp_name'];

                            //Destination Path for the image to be uploaded
                            $dst = "../images/food/".$image_name;

                            //upload the food image
                            $upload = move_uploaded_file($src, $dst);

                            //check wether the image is uploaded
                            if($upload==false)
                            {
                                //failed to upload the image
                                //redirect to add food page with error message
                                $_SESSION['upload'] = "<div class='erro'>Failed to upload Image</div>";
                                header('location:'.SITEURL.'admin/add-food.php');
                                //stop the process
                                die();
                            }

                        }
                        else
                        {
                            //image not selected
                        }

                    }
                    else
                    {
                        $image_name = "";//setting image name to blank
                    }

                    //insert to database

                    //create sql query to save to add food
                    $sql2 = "INSERT INTO tbl_food SET
                        title = '$title',
                        description = '$description',
                        price = $price,
                        image_name = '$image_name',
                        category_id = $category,
                        featured = '$featured',
                        active = '$active'                     
                    ";

                    //execute query
                    $res2 = mysqli_query($conn, $sql2);
                    //check wether data is inserted
                    //redirect with msg to manage foodpage
                    if($res2 == true)
                    {
                        //data inserted
                        $_SESSION['add'] = "<div class='success'>Food Added Successfully</div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                    }
                    else
                    {
                        //fail to insert data
                        $_SESSION['add'] = "<div class='error '>Failed to Add Food</div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                    }

                    
                }

            ?>

        </div>
    </div>
        <!--end of main content-->
    </div>
</body>

</html>