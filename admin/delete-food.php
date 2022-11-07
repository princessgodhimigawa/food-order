<?php
    include('../config/constants.php');

 if(isset($_GET['id']) && isset($_GET['image_name']))
 {
    //process to delete
    //echo "Process to delete";
    //Get id and image name
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];


    //Remove the image if available
    //check wether the image is available. delete if available
    if($image_name != "")
    {
        //has image and need to remove image
        //get the image path
        $path = "../images/food/".$image_name;

        //Remove image file from folder
        $remove = unlink($path);

        //check wether the image is removed or not
        if($remove==false)
        {
            //failed to remove image
            $_SESSION['upload'] = "<div class='error'> Failed to remove image file.</div>";
            //redirect to manage food
            header('location'.SITEURL.'admin/manage-food.php');
            //stop the process of deleting
            die();
        }

    }

    //Delete food from Database
    $sql = "DELETE FROM tbl_food WHERE id=$id";
    //execute the query
    
    $res = mysqli_query($conn, $sql);

    //check wether the query is executed
    //Redirect to manage food with session message
    if($res==true)
    {
        //food delte
        $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
    else
    {
        //failed to delete food
        $_SESSION['delete'] = "<div class='error'>Failed to delete food.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');   
    }

 }
 else
 {
     //redirect to manage food page
     //Echo"redirect";
     $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";
     header('location:'.SITEURL.'admin/manage-food.php');

 }

?>