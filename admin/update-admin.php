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
            
        <h1>Update admin</h1>
            
        </div>
        <!--end nav-->
        <!--main content -->
<div class="main-content">  
    <div class="wrapper">
        
        <br><br>

        <?php
            //get the id of admin
            $id =$_GET['id'];

            //create sql query get details
            $sql="SELECT * FROM tbl_admin WHERE id=$id";

            //execute query
            $res=mysqli_query($conn, $sql);

            //check wether the query is executed
            if($res==true)
            {
                //check wether the data is available
                $count = mysqli_num_rows($res);
                //check if we have admin data
                if($count==1)
                {
                    //get details
                    //echo "admin available";
                    $row=mysqli_fetch_assoc($res);

                    $full_name = $row['full_name'];
                    $username = $row['username'];
                }
                else{
                    //redirect to manage admin
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }

            }

        ?>

            <form action="" method="POST">
                <table class="tbl-30">
                    <tr>
                        <td class="text1">Full Name: </td>
                        <td>
                            <input class="text2" type="text" name="full_name" value="<?php echo $full_name; ?>">
                        </td>
                    </tr>

                    <tr>
                        <td class="text1">Username: </td>
                        <td>
                            <input class="text2" type="text" name="username" value="<?php echo $username; ?>">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>
    </div>
</div>

<?php 

    //check if the button is clicked
   if(isset($_POST['submit']))
   {
       //echo "click";
       //get the value from form to update
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];

        //create sql query to update
        $sql ="UPDATE tbl_admin SET
        full_name = '$full_name',
        username = '$username' 
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
        $_SESSION['delete'] = "<div class='success'>Admin Updated Successfully.</div>";
        //redirect to manage admin page
        header('location:'.SITEURL. 'admin/manage-admin.php');
    }
    else
    {
        //failed to update admin
        //echo"faile to update"
        $_SESSION['delete'] = "<div class='error'>Failed to update Admin</div>";
        header('location:'.SITEURL. 'admin/manage-admin.php');
    }

   }

?>
        <!--end of main content-->
    </div>
</body>

</html>