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
            
        <h1>Update Admin Password</h1>
            
        </div>
        <!--end nav-->

<div class="main=content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php
            if(isset($_GET['id']))
            {
                $id=$_GET['id'];

            }
        

        ?>
        
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td class="text1">Current Password:</td>
                    <td>
                        <input class="text2" type="password" name="current_password" placeholder="Current Password">
                    </td>
                </tr>

                <tr>
                    <td class="text1">New Password:</td>
                    <td>
                        <input class="text2" type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>

                <tr>
                    <td class="text1">Confirm Pass:</td>               
                
                    <td>
                        <input class="text2" type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>

    </div>
</div>

<?php 
    
            //check if the btn is clicked
            if(isset($_POST['submit']))
            {
                //echo "clicked";
                //get the data from form
                $id = $_POST['id'];
                $current_password = md5($_POST['current_password']);
                $new_password = md5($_POST['new_password']);
                $confirm_password = md5($_POST['confirm_password']);

                //check wether the user with current id and pass exist
                $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

                //execute query
                $res = mysqli_query($conn, $sql);

                if($res==true)
                {
                    //check wether data is available
                    $count=mysqli_num_rows($res);

                    if($count==1)
                    {
                        //user exist and password will change
                        //echo"user exist";
                        //check if new pass and confirm pass match
                        if($new_password==$confirm_password)
                        {
                            //update password
                            //echo"match";
                            $sql2 = "UPDATE tbl_user SET
                                pass = '$new_password' 
                                WHERE id=$id
                            ";

                            //execute the query
                            $res2 = mysqli_query($conn, $sql2);

                            //check wether the query executed or not
                            if($res2==true)
                            {
                                //display
                                    //redirect to manage admin
                                $_SESSION['change-pwd'] = "<div class='success'>password changed.</div>";
                                header("location:".SITEURL.'admin/manage-user.php');
                            }
                            else
                            {
                                //error msg
                                    //redirect to manage admin
                                $_SESSION['change-pwd'] = "<div class='error'>fail to change password.</div>";
                                header("location:".SITEURL.'admin/manage-user.php');
                                
                            }
                        }
                        else
                        {
                            //redirect to manage admin
                            $_SESSION['pwd-not-match'] = "<div class='error'>password not match</div>";
                            header("location:".SITEURL.'admin/manage-user.php');
                        }
                    }
                    else
                    {
                        //user does not exist set message & redirect
                        $_SESSION['user-not-found'] = "<div class='error'>User not found!!!</div>";
                        header("location:".SITEURL.'admin/manage-user.php');
                    }

                }

                //check wether the new pass match with the confirm password

                //change password if all  above is true
            }

?>


<?php include('partials/footer.php');?>