<?php


$showalert=false;
$showerror=false;

// echo $_SERVER['REQUEST_METHOD'];

if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    include '_dbconnect.php';
    $name=$_POST['signupname'];
    $email=$_POST['signupemail'];
    $pass=$_POST['signuppassword'];
    $cpass=$_POST['signupcpassword'];
    
    $sql="select * from `users` where User_email='$email'";
    $result=mysqli_query($conn,$sql);
    
    //checking email exists or not
    $nuwrows=mysqli_num_rows($result);
    if($nuwrows>0){
        //$showerror="Email Already Exists";
        header("Location: /restaurant/index.php?userexists=false");
    }else{
        if($pass == $cpass){
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $addsql="INSERT INTO `users` (`User_name`,`User_email`, `User_pass`, `User_time`) VALUES ('$name','$email', '$hash', current_timestamp());";
            $result=mysqli_query($conn,$addsql);
            if($result){
                $showalert=true;
                header("Location: /restaurant/index.php?signupsuccess=true");
                exit();
            }
        }else{
            // $showerror="Passwords do not Match";
            header("Location: /restaurant/index.php?signupsuccess=false");
        }
    }

}


?>