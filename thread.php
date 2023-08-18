<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .que{
            min-height:50vh;
        }
    </style>
    <title>Let's Discuss</title>
</head>

<body>
    <?php include 'partials/dbConnect.php'?>
    <?php include 'partials/_header.php'?>
    <?php
    $id = $_GET['thread_id'];
    $sql = "SELECT * FROM `threads` WHERE thread_id=$id";
    $result = mysqli_query($conn,$sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $threadtitle = $row['thread_title'];
        $threaddesc = $row['thread_description'];
        $commentedBy = $row['thread_user_id'];
        $sql2 = "SELECT username FROM `users` WHERE sno='$commentedBy'";
        $result2 = mysqli_query($conn,$sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $postedby = $row2['username'];
    }
    ?>
    <?php
    $showAlert = false;
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method=="POST") {
            // Insert thread into database
            $comment = $_POST['comment'];
            $comment = str_replace("<","&lt;",$comment);
            $comment = str_replace(">","&gt;",$comment);
            $comment = str_replace("'",'"',$comment);
            $userId =$_SESSION["sno"];
            $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`,`commented_by`) VALUES ('$comment', '$id','$userId')";
            $result = mysqli_query($conn,$sql);
            $showAlert = true;
            if ($showAlert) {
               echo '
               <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Your Thread has been added ! Please wait for community to respond.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
               ';
            }
        }
    ?>
    <div class="container my-4 p-5" style="background: #d8d8e0cf;">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $threadtitle?> Forum</h1>
            <p class="lead"><?php echo $threaddesc?></p>
            <hr class="my-4">
            <p>This is the peer to peer Forum to share your knowledge with others. <br> Do not spam · Do Not Bump Posts
                · Do Not Offer to Pay for Help · Do Not Offer to Work For Hire · Do Not Advertise/Self Promote. </p>
            <p>PostedBy -  <b><?php echo $postedby ?></b></p>
        </div>
    </div>
    <div class="accordion  container my-5" id="accordionExample">
        <div class="accordion-item p-3">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                    <h3>Post a Comment</h3>
                </button>
            </h2>
            <?php
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {
                echo '
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                data-bs-parent="#accordionExample">
                <div class=" my-5">                    
                    <form action="'.$_SERVER["REQUEST_URI"].'" method="post">
                        <div class="mb-3">
                            <label for="comment" class="form-label">Type Your Comment</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                        </div>                        
                        <button class="btn btn-success">Post Comment</button>                        
                    </form>
                </div>
            </div>';
                }
            else{
                echo '<p class="text-danger mx-1  my-2">You must be loggedin to Post a Comment.</p>';
            }
            ?>
            
        </div>
    </div>
    <div class="container que">
        <h1>Discussions</h1>
        <?php
            $id = $_GET['thread_id'];
            $sql = "SELECT * FROM `comments` WHERE thread_id=$id";
            $result = mysqli_query($conn,$sql);
            $noresult = true;
            while ($row = mysqli_fetch_assoc($result)) {
                $noresult = false;
                $comment = $row['comment_content'];
                $comment_time = $row['comment_time'];
                $datetime_obj = new DateTime($comment_time);
                $formatted_datetime = $datetime_obj->format('M j, Y \a\t H:i');
                $userId = $row['commented_by'];
                $sql2 = "SELECT username FROM `users` WHERE sno='$userId'";
                $result2 = mysqli_query($conn,$sql2);
                $row2 = mysqli_fetch_assoc($result2);
                $username = $row2['username'];
                echo '
                <div class=" d-flex my-3 justify-content-center">
                    <div class="flex-shrink-0">
                        <img src="img/user.png" height="60px" width="60px" class="me-2" alt="...">
                    </div>
                    <div class=" flex-grow-1 ms-3">
                        <p class="my-0"><b>'.$username.' answered </b> '.$formatted_datetime.' </p>
                        <p class="my-0">'.$comment.'</p>                        
                    </div>
                </div>
                ';
            }
            if ($noresult) {
                echo '
                <div class="jumbotron jumbotron-fluid py-5 px-3 "style="background: #d8d8e0cf;">
                    <div class="container">
                        <p class="display-4">No Comments Found</p>
                        <p class="my-4">No one has answered your question yet.</p>
                    </div>
                </div>
                ';
            }
        ?>
    
    </div>
    <?php include 'partials/_footer.php'?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>