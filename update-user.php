<?php
include('partials-front/session.php'); 
include('partials-front/login-check.php');
?>

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
                        <a href="<?php echo SITEURL; ?>">Home</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>categories.php">Categories</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>food.php">Foods/Menu</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>admin/login.php">Admin</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>../food-order/user-prof.php">User</a>
                        
                    </li>
                    
                    
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>
    </section>
<!---End nav-->
<?php
            
            
            if(isset($_SESSION['failed']))//checking wether the session is set
            {
                echo $_SESSION['failed'];//display msg
                unset($_SESSION['failed']);//display msg
            }
        ?>
<div class="body2">
    
            <?php
                $sql2="SELECT * FROM tbl_user where id=$loggedin_id";
                $res2=mysqli_query($conn,$sql2);
            ?>
            <?php
                while($rows=mysqli_fetch_array($res2)){
            ?>

<form action="" method="POST" id="signin" id="reg">
            <div class="head">Your Profile</div>
                <table>
                    <tr>
                        <td><input type="hidden" name="id" value="<?php echo $rows['id']; ?>"></td>
                    </tr>
                    <tr >
                        <td class="text1"> <div align="left">Full-Name:</div> </td>
                        <td >
                            <input class="text2" type="text" name="full_name" value="<?php echo $rows['user_name']; ?>">
                        </td>
                    </tr>
                    <tr >
                        <td class="text1"><div align="left">Username:</div></td> 
                        <td >
                            <input class="text2" type="text" name="username" value="<?php echo $rows['user']; ?>">
                        </td>
                    </tr>
                    <tr >
                        <td class="text1"><div align="left">Contact:</div></td>
                        <td >
                            <input class="text2" type="text" name="contact" value="<?php echo $rows['contact']; ?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                        
                        <input class="btn2 " type="submit" name="submit" value="Update User" class="btn-secondary">
                        </td>
                        
                    </tr>
                     
                    
                </table>
            </form>

      <div class="fixclear"></div>                          

</div>
        <?php
             }
        ?>
        

<?php 

    //check if the button is clicked
   if(isset($_POST['submit']))
   {
       //echo "click";
       //get the value from form to update
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $contact = $_POST['contact'];
        $username = $_POST['username'];

        //create sql query to update
        $sql ="UPDATE tbl_user SET
        user_name = '$full_name',
        contact = '$contact',
        user = '$username'
        WHERE id='$id'
        ";

        //execute the query
        $res = mysqli_query($conn, $sql);

        //check wether the query executed successfully
        if($res==true)
    {
        //query executed successfully and admin delete
        //echo"admin Updated";
        //Create Session Variable to display message
        $_SESSION['update-user'] = "<div class='success'>User Updated Please Relogin</div>";
        //redirect to manage admin page
        header('location:'.SITEURL. '../food-order/logout.php');
    }
    else
    {
        //failed to update admin
        //echo"faile to update"
        $_SESSION['update-user'] = "<div class='error'>Failed to update Admin</div>";
        header('location:'.SITEURL. '../food-order/update-user.php');
    }

   }

?>



<?php include('partials-front/footer.php'); ?>