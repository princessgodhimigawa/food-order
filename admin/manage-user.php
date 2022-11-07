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
                    <?php
                        $select_rows = mysqli_query($conn,"SELECT * FROM tbl_order WHERE status='Ordered'");
                        $row_count = mysqli_num_rows($select_rows);
                    ?>
                    <li><a href="manage-order.php">Order(<span><?php echo $row_count ?></span>)</a></li>
                    
                    <li><a href="logout.php">Logout</a></li>
            
        </ul>
    </div>
    <!-- end side bar-->
    <!--Nav bar-->
    <div class="container">
        <div class="header">
            
        <h1>Manage Users</h1>
            
        </div>
        <!--end nav-->
<!--main content -->
<div class="main-content">
        <div class="wrapper">
            

            <br><br>
            <?php
                 if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }
             ?>
            
            <br><br><br>

            <br><br><br>

            <table class="tbl-full">
                <tr>
                    <th>S.N</th>
                    <th>Fullname</th>
                    <th>Contacts</th>
                    <th>Username</th>
                    
                    <th>Actions</th>
                </tr>

                <?php
                    //query to get all admin
                    $sql = "SELECT * FROM tbl_user";
                    //execute the query
                    $res = mysqli_query($conn, $sql);

                    //check wether the query is executed or not
                    if($res==TRUE)
                    {
                        //count rows wether we have data in database
                        $count = mysqli_num_rows($res); //function to get all rows in db

                        $sn=1; //create a variable and assign the value

                        //check the num of rows
                        if($count>0)
                        {
                            //we have data in database
                            while($rows = mysqli_fetch_assoc($res))
                            {
                                // using while loop to get all the data from db
                                //and will run as long as we have data in db

                                //get individual data
                                $id = $rows['id'];
                                $full_name = $rows['user_name'];
                                $contact = $rows['contact'];
                                $username = $rows['user'];
                                

                                //display the values in table
                                ?>

                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $full_name; ?></td>
                                    <td><?php echo $contact; ?></td>
                                    <td><?php echo $username; ?></td>
                                    
                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                        
                                        <a href="<?php echo SITEURL; ?>admin/delete-user.php?id=<?php echo $id; ?>" class="btn-danger">Delete User</a>
                                    </td>
                                </tr> 

                                <?php

                            }
                        }
                        else
                        {
                            //no data in database
                        }

                    }
                ?>  

                 
            </table>


            <div class="clearfix"></div>
            </div>
        </div>
        <!--end of main content-->
    </div>
</body>

</html>