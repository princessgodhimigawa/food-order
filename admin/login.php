<?php include('../config/constants.php')?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body class="body">
    <div class="container1">
        <h1>Admin</h1>
        <br>
        <?php 
            if(isset($_SESSION['login']))
            {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            } 
            if(isset($_SESSION['no-login-message']))
            {
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }    
            ?>
            <!--login form-->

        <form action="" method="post">
            <div class="tbox">
            <input type="text" name="username" placeholder="Enter Username">
            </div>
            <div class="tbox">
            <input type="password" name="password" placeholder="Enter Password">
            </div>
            <input type="submit"  name="submit" value="Log In" class="btn1">
            
            
        </form>
        
        

    </div>

    
</body>
</html>

<?php 

    //chech if the btn is clicked
    if(isset($_POST['submit']))
    {
        //process for login
        //get the data from form
        
        //$username = $_POST['username'];
        $username = mysqli_real_escape_string($conn, $_POST['username']);

        //$password = md5($_POST['password']);
        $raw_password = md5($_POST['password']);
        $password = mysqli_real_escape_string($conn, $raw_password);

        //sql to check wether the user exist
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        //execute query
        $res = mysqli_query($conn, $sql);

        //count rows to check if user exist
        $count = mysqli_num_rows($res);

        if($count==1)
        {
            //user available
            $_SESSION['login'] = "<div class='success'>Login Successfull.</div>";
            $_SESSION['user'] = $username; //check if login or not
            //redirect dashboard
            header('location:'.SITEURL.'admin/');
        }
        else
        {
            //user not available
            $_SESSION['login'] = "<div class='error text-center'>Login Failed.</div>";
            //redirect dashboard
            header('location:'.SITEURL.'admin/login.php');
        }

    }

?>