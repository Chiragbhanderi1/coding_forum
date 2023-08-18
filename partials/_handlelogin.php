<?php
$showError="false";
if ($_SERVER['REQUEST_METHOD']) {
    $servername = "localhost";
    $password= "";
    $database = "idiscuss";
    $username= "root";
    $conn = mysqli_connect($servername,$username,$password,$database);
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM `users` where username='$username'";
    $result = mysqli_query($conn,$sql);
    $numRows = mysqli_num_rows($result);
        if ($numRows==1) {
           $row = mysqli_fetch_assoc($result);
                    if (password_verify($password,$row['password'])) {
                              session_start();
                              $_SESSION['loggedin']=true;
                              $_SESSION['sno']=$row['sno'];
                              $_SESSION['username']=$username;
                    }
                    header("Location: /forum/index.php");
          }
          header("Location: /forum/index.php");                   
}
?>