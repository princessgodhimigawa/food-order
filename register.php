<?php include('../food-order/config/constants.php')?>
 
<?php
    if(isset($_POST['verify_number'])){

        $phone = $_POST['contact'];
    $key = '76BE79DEEE044B48996F8341A90EB8EF';
    $default_country = '63';
    $ch = curl_init('https://api.veriphone.io/v2/verify?phone='.$phone.'&key='.$key.'&default_country='.$default_country);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($ch);
    curl_close($ch);
    $validationResult = json_decode($json, true);
    echo $validationResult['phone_valid'];
    echo $validationResult['country'];
    echo $validationResult['international_number'];
    echo $validationResult['carrier'];

    if($validationResult['phone_valid'] == 1){
        echo"<p>Inputed # is valid please input it again along with your info!!!.</p>";
    }else{
        echo"<p>Number is Invalid please choose another number</p>";
    }


    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register</title>
    <link rel="stylesheet" href="../food-order/css/style.css">
</head>
<body class="body">
    <!--main content-->
    
    <div class="container1">
        <h1>User</h1>
        
        <?php
            
            if(isset($_SESSION['Exist']))//checking wether the session is set
            {
                echo $_SESSION['Exist'];//display msg
                unset($_SESSION['Exist']);//display msg
            }
            if(isset($_SESSION['contact']))//checking wether the session is set
            {
                echo $_SESSION['contact'];//display msg
                unset($_SESSION['contact']);//display msg
            }
        ?>
            <!--login form-->

        <form action="" method="post">

            <div class="tbox">
            <input type="text" name="contact"  placeholder="Enter Valid Contact!!!">
            </div>
            <div class="">
            <input type="submit" name="verify_number" value=" click to check/Verify # first" class="btn1">
            </div>
            <div class="tbox">
            <input type="text" name="full_name" placeholder="Enter your Name">
            </div>
            <div class="tbox">
            <input type="text" name="username" placeholder="Enter Username">
            </div>
            <div class="tbox">
            <input type="password" name="password" placeholder="Enter Password">
            </div>
            <div class="tbox">
            <input type="EMAIL" name="email" placeholder="Enter your email">
            </div>
            <div class="tbox">
            <input type="text" name="address" rows="5" placeholder="E.g. Drive, Street, Barangay">
            </div>

            
            <input type="submit" name="submit" value="Register" class="btn1">
              
        </form>
         
    </div>
    <?php
        $errors = array(); 
        if(isset($_POST['register'])){
            $fullname = mysqli_real_escape_string($conn, $_POST['full_name']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $pass = mysqli_real_escape_string($conn, $_POST['password']);
            $contact = mysqli_real_escape_string($conn, $_POST['contact']);
            $address = mysqli_real_escape_string($db, $_POST['address']);
            

            $vkey = (rand(100000, 999999).$username);
            $vip = "User";

           $sql = "SELECT * FROM tbl_user WHERE username='$username' OR email='$email' OR contact='$contact' LIMIT 1";
           $res = mysqli_query($conn, $sql);
           $user = mysqli_fetch_assoc($res);

           if ($user) { // if user exists
                if ($user['username'] == $username) {
                    array_push($errors, "Username already exists");
                }
                if ($user['email'] === $email) {
                    array_push($errors, "email already exists");
                }
                if ($user['contact'] === $contact) {
                    array_push($errors, "contact already in used");
                }
            }
            
            if(count($errors)==0){
                $password = md5($pass);
                $sql2 = "INSERT INTO tbl_user SET
                    full_name = '$fullname',
                    email = '$email',
                    username = '$username',
                    password = '$password',
                    contact = '$contact',
                    address = '$address',
                    vkey = '$vkey',
                    vip = '$vip'
                ";
                $res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

                if($res==TRUE){
                    echo '<script type="text/javascript">';
                    echo ' alert("Registered!!!")';  //not showing an alert box.
                    echo '</script>';
                }else{
                    echo '<script type="text/javascript">';
                    echo ' alert("Failed!!!")';  //not showing an alert box.
                    echo '</script>';
                }
            }

        }
    ?>
    <!--end main content-->

    
</body>
</html>

