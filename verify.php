<?php include('partials-front/session.php');

?>


<?php
    if(isset($_POST['sendcode'])){
        require_once 'sendgrid/sencon.php';
        require 'sendgrid/vendor/autoload.php'; // If you're using Composer (recommended)
// Comment out the above line if not using Composer
// require("<PATH TO>/sendgrid-php.php");
// If not using Composer, uncomment the above line and
// download sendgrid-php.zip from the latest release here,
// replacing <PATH TO> with the path to the sendgrid-php.php file,
// which is included in the download:
// https://github.com/sendgrid/sendgrid-php/releases

$email = new \SendGrid\Mail\Mail(); 
$email->setFrom("sendmailcodeMK@gmail.com", "MK verification");
$email->setSubject("Sending with SendGrid is Fun");
$email->addTo("$loggedin_email", "$loggedin_fullname");
$email->addContent("text/plain", "You Verification Code is: $loggedin_vkey");
$email->addContent(
    "text/html", "<strong>You Verification Code is: $loggedin_vkey</strong>"
);
$sendgrid = new \SendGrid( SENDGRID_API_KEY );
Echo"Verification SENT!!!";
try {
   $response = $sendgrid->send($email);
   //print $response->statusCode() . "\n";
  // print_r($response->headers());
  // print $response->body() . "\n";
} catch (Exception $e) {
   // echo 'Caught exception: '. $e->getMessage() ."\n";
}

    }else{
        
    }
    
    

    //process the value from form & save in database
    //check whether button is click/not
    if(isset($_POST['submit']))
{
    $email = $_POST['email'];
    $vkey = $_POST['vkey'];
    
    
    $sql1 = "SELECT * FROM tbl_user WHERE email='$email' AND vkey='$vkey'";
    $res1 = mysqli_query($conn, $sql1);
    $count = mysqli_num_rows($res1);
    
    
    if($count==1)
                        {
                            //query executed and order saved
                            $verified = 1;
                            
                            
                            $sql2 = "UPDATE tbl_user SET
                                verified = '$verified'
                                WHERE id='$loggedin_id'
                             ";
                             $res2 = mysqli_query($conn, $sql2);
                             if($res2==true){
                                $_SESSION['verify'] = "<div class='success text-center'>Email is Verified.</div>";
                                 header('location:'.SITEURL.'../food-order/user-prof.php');
                             }

                          
                        }
                        else
                        {
                            //failed to execute query
                            $_SESSION['verify'] = "<div class='error text-center'>Fail to verify email.</div>";
                            header('location:'.SITEURL.'../food-order/verify.php');

                        }



}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verify Number</title>
    <link rel="stylesheet" href="../food-order/css/style.css">
</head>
<?php
if(isset($_SESSION['verify']))
{   
    echo $_SESSION['verify'];
    unset($_SESSION['verify']);
} 
?>
    

<body class="body">
    <!--main content-->
            
    <div class="container1">
        <h1>Verify Number</h1>
        <br>
        
            <!--verify form-->
            
        
        <form action="" method="post">
            
            <div class="tbox">
            <input  type="text" name="email" value="<?php echo $loggedin_email; ?>" placeholder="Email" readonly>
            </div>
            <div class="tbox">
            <input  type="text" name="vkey"  placeholder="Enter the code!!!">
            </div>
            
            <input type="submit" name="sendcode" value="Click to send code" class="btn1">
            
            
            <input type="submit" name="submit" value="Click to validate email" class="btn1">
            
            
            

              
        </form>
         
    </div>



    
</body>
</html>

