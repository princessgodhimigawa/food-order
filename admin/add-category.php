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
            
        <h1>Add Category</h1>
            
        </div>
        <!--end nav-->
        <!--main content -->
        <div class="main-conttent">
    <div class="wrapper">
        
        <br><br><br>

        <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
            
        ?>
        <br><br>

        <!--Add category form-->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30"> 
                <tr>
                    <td class="text1">Title: </td>
                    <td>
                        <input class="text2" type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>

                <tr>
                    <td class="text1">Select Image: </td>
                    <td>
                        <input class="text2" type="file" name="image" >
                    </td>
                </tr>

                <tr>
                    <td class="text1">Feature: </td>
                    <td class="text1">
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td class="text1">Active: </td>
                    <td class="text1">
                        <input type="radio" name="active" Value="Yes">Yes
                        <input type="radio" name="active" Value="No">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>

        <!--End Add category form-->

        <?php 
        
            //check wether the submit button is clicked
            if(isset($_POST['submit']))
            {
                //echo"clicked";
                //get the value from form.
                $title = $_POST['title'];

                //for radio input type wether the btn is selected
                if(isset($_POST['featured']))
                {
                    //get the value
                    $featured = $_POST['featured'];

                }
                else
                {
                    //set the default
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
                //check wether the image is selected or not
                //print_r($_FILES['image']);
                //die();//break the code here
                if(isset($_FILES['image']['name']))
                {
                    //upload the image
                    //to upload we need image name,source path and destination path
                    $image_name = $_FILES['image']['name'];

                    //upload the image only if image is selected
                    if($image_name != "")
                    {

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
                            header('location:'.SITEURL.'admin/add-category.php');
                            //stop the process
                            die();
                        }

                    }
                }
                else
                {
                    //dont upload and set the image name to blank
                    $image_name="";
                }

                //create sql to insert catergory to database
                $sql = "INSERT INTO tbl_category SET
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active' 
                ";

                //execute the query and save to database
                $res = mysqli_query($conn, $sql);

                //check it the query executed 
                if($res==true)
                {
                    //query is executed, category added
                    $_SESSION['add'] = "<div class='success'> Category Added Successfully.</div>";
                    //redirect to manage category
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {   
                    //failed to execute
                    $_SESSION['add'] = "<div class='error'>Failed to add Category.</div>";
                    //redirect to add category
                    header('location:'.SITEURL.'admin/add-category.php');
                }


            }
        
        ?>

    </div>
</div>
        <!--end of main content-->
    </div>
</body>

</html>