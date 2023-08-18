<?php
    $showError="false";
    if ($_SERVER['REQUEST_METHOD']) {
        $servername = "localhost";
        $password= "";
        $database = "idiscuss";
        $username= "root";
        $conn = mysqli_connect($servername,$username,$password,$database);
        $username = $_POST['signupusername'];
        $password = $_POST['signuppassword'];
        $cpassword = $_POST['signupcpassword'];

        // check for username exists
        $existsql = "SELECT * FROM `users` where `username` ='$username'";
        $result = mysqli_query($conn,$existsql);
        $numRows = mysqli_num_rows($result);
        if ($numRows>0) {
            $showError = "Username is already taken";
        } else{
            if ($password=$cpassword) {
                $hash = password_hash($password,PASSWORD_DEFAULT);
                $sql = "INSERT INTO `users` (`username`,`password`) VALUES('$username','$hash')";
                $result = mysqli_query($conn,$sql);
                if ($result) {
                    $showAlert = true;
                    header("Location: /forum/index.php?signupsuccess=true");
                    exit();
                }
            }else{
                $showError = "Passwords do not match";
            }
        }
        header("Location: /forum/index.php?signupsuccess=false&error=$showError");
        exit();
    }

?>