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
    .que {
        min-height: 50vh;
    }
    </style>
    <title>Let's Discuss</title>
</head>

<body>
    <?php include 'partials/dbConnect.php'?>
    <?php include 'partials/_header.php'?>
    <?php
    $id = $_GET['catId'];
    $sql = "SELECT * FROM `categories` WHERE category_id=$id";
    $result = mysqli_query($conn,$sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $catname = $row['category_name'];
        $catdesc = $row['category_description'];
    }
    ?>
    <?php
    $showAlert = false;
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method=="POST") {
            // Insert thread into database
            $th_title = $_POST['title'];
            $th_title = str_replace("<","&lt;",$th_title);
            $th_title = str_replace(">","&gt;",$th_title);
            $th_title = str_replace("'",'"',$th_title);
            $th_desc = $_POST['desc'];
            $th_desc = str_replace("<","&lt;",$th_desc);
            $th_desc = str_replace(">","&gt;",$th_desc);
            $th_desc = str_replace("'",'"',$th_desc);
            $userId = $_SESSION['sno'];
            $sql = "INSERT INTO `threads` (`thread_title`, `thread_description`, `thread_user_id`, `thread_cat_id`) VALUES ('$th_title', '$th_desc', '$userId', '$id')";
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
            <h1 class="display-4">Welcome to <?php echo $catname?> Forum</h1>
            <p class="lead"><?php echo $catdesc?></p>
            <hr class="my-4">
            <p>This is the peer to peer Forum to share your knowledge with others. <br> Do not spam · Do Not Bump Posts
                · Do Not Offer to Pay for Help · Do Not Offer to Work For Hire · Do Not Advertise/Self Promote. </p>
            <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
        </div>
    </div>
    <div class="accordion  container my-5" id="accordionExample">
        <div class="accordion-item p-3">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                    <h3>Start a discussion</h3>
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
                <label for="title" class="form-label">Problem Title</label>
                <input type="text" class="form-control" name="title" id="title" placeholder="Your Title">
                <small id="emailHelp" class="form-text text-muted">Keep your title as short & crisp as
                                possible.</small>
                        </div>
                        <div class="mb-3">
                        <label for="desc" class="form-label">Ellobrate Your Concern</label>
                        <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
                        </div>
                        <button class="btn btn-success">Submit</button>                        
                        </form>
                        </div>
                        </div>';
                }
            else{
                echo '<p class="text-danger mx-1  my-2">You must be loggedin to start a discussion</p>';
            }
            ?>
        </div>
    </div>
    <div class="container que">
        <?php
            $id = $_GET['catId'];
            $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
            $result = mysqli_query($conn,$sql);
            $noresult = true;
            while ($row = mysqli_fetch_assoc($result)) {
                $noresult = false;
                $threadtitle = $row['thread_title'];
                $threadid = $row['thread_id'];
                $threaddesc = $row['thread_description'];
                $comment_time = $row['timestamp'];
                $userId = $row['thread_user_id'];
                $datetime_obj = new DateTime($comment_time);
                $formatted_datetime = $datetime_obj->format('M j, Y \a\t H:i');
                $sql2 = "SELECT username FROM `users` WHERE sno='$userId'";
                $result2 = mysqli_query($conn,$sql2);
                $row2 = mysqli_fetch_assoc($result2); 
                echo '
                <div class=" d-flex my-3 mb-5 justify-content-center">
                    <div class="flex-shrink-0">
                        <img src="img/user.png" height="60px" width="60px" class="me-2" alt="...">
                    </div>
                    <div class=" flex-grow-1 ms-3">
                        <h5 class="mt-0"><a class="text-dark text-decoration-none" href="thread.php?thread_id='.$threadid.'">'.$threadtitle.'</a></h5>
                        <p>'.$threaddesc.'</p>
                        </div>
                        <p class="my-0">Asked By <b>'.$row2['username'].'</b> at '.$formatted_datetime.' </p>
                </div>
                ';
            }
            if ($noresult) {
                echo '
                <div class="jumbotron jumbotron-fluid py-5 px-3 "style="background: #d8d8e0cf;">
                    <div class="container">
                        <p class="display-4">No Threads Found</p>
                        <p class="my-4">Be the first person to ask the question</p>
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