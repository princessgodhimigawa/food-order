<?php
    //include constants file
    include('../config/constants.php');

    //chech wether the id and image value is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //get the value and delete
        //echo "Get Value and delte";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //remove the physical image
        if($image_name != "")
        {
            //image is available. remove it
            $path = "../images/category/".$image_name;
            //remove image
            $remove = unlink($path);

            //if fail to remove  img add error msg stop process
            if($remove == false)
            {
                //set the session message
                $_SESSION['remove'] = "<div class='error'>failed to remove image.</div>";
                //redirect to manage category page
                header('location:'.SITEURL.'admin/manage-category.php');
                //stop process
                die();
            }
        }

        //delte data from database
        //sql query to delete data from database
        $sql = "DELETE FROM tbl_category WHERE id=$id";

        //execute query
        $res = mysqli_query($conn, $sql);
        
        //check wether the data is deleted from the database
        if($res==true)
        {
            //set success msg
            $_SESSION['delete'] = "<div class='success'>Category Deleted sucessfully.</div>";
            //redirect to manage category
            header('location:'.SITEURL.'admin/manage-category.php');
            
        }
        else
        {
            //set fail and redirect
            $_SESSION['delete'] = "<div class='error'>Failed to delete Category.</div>";
            //redirect to manage category
            header('location:'.SITEURL.'admin/manage-category.php');
        }

        //redirect to manage category page with msg

    }
    else
    {
        // redirect to manage category page
        header('location:'.SITEURL.'admin/manage-category.php');
    }

?>