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
            
        <h1>Add Admin</h1>
            
        </div>
        <!--end nav-->
        <!--main content -->
<div class="main-content">
    <div class="wrapper">
        
        <br><br><br>

        <?php
            if(isset($_SESSION['a']))//checking wether the session is set
            {
                echo $_SESSION['add'];//display msg
                unset($_SESSION['add']);//display msg
            }
        ?>

        <form action="" method="POST">
 
            <table class="tbl-30">
                <tr>
                    <td class="text1">Fullname: </td>
                    <td><input class="text2" type="text" name="full_name" placeholder="Enter your Name"></td>                   
                </tr>
                <tr>
                    <td class="text1">Username: </td>
                    <td><input class="text2" type="text" name="username" placeholder="Enter Username"></td>                   
                </tr>
                <tr>
                    <td class="text1">Password: </td>
                    <td><input class="text2" type="password" name="password" placeholder="Enter Password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
    </div>
</div>



<?php
    //process the value from form & save in database
    //check whether button is click/not

    if(isset($_POST['submit']))
    {
        //button clicked
       // echo"button click";

       //get data from form 
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); //password encryption md5

        // SQL query to save to database
        $sql = "INSERT INTO tbl_admin SET
            full_name = '$full_name',
            username = '$username',
            password = '$password'
        ";
        
        // executing query and save data to database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        //check whether the data is inserted or not
        if($res==TRUE)
        {
            //data inserted
            //echo "data inserted"
            //create a session variable to display message
            $_SESSION['add'] = "<div class='success'>Admin Added Successfully.</div>";
            //redirect page to manage admin
            header("location:".SITEURL.'admin/manage-admin.php');
             
        }
        else
        {
            //failed to insert data
            //echo"fail, data not inserted";
            //create a session variable to display message
            $_SESSION['add'] = "<div class='error'>Failed to Add Admin.</div>";
            //redirect page to add admin
            header("location:".SITEURL.'admin/add-admin.php');
        }
    }
    

?>
        <!--end of main content-->
    </div>
</body>

</html>