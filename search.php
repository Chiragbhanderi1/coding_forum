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
        #maincontainer{
            min-height:78vh;
        }
    </style>
    <title>Let's Discuss</title>
</head>
<body>
    <?php include 'partials/dbConnect.php'?>
    <?php include 'partials/_header.php'?>
    
    <!-- Search results -->
    <div class="container my-3 py-3" id="maincontainer">
        <h1>Search Results for <em>"<?php echo $_GET['search'] ?>"</em></h1>
        
        <?php
            $query = $_GET["search"];
            $noresults = true;
            $sql = "SELECT * FROM `threads` WHERE MATCH (thread_title,thread_description) against ('$query')";
            $result = mysqli_query($conn,$sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $threadtitle = $row['thread_title'];
                $noresults=false;
                $threaddesc = $row['thread_description'];
                $thread_id = $row['thread_id'];
                $url = "thread.php?thread_id=".$thread_id;
                // Displaying the result  
                echo '<div class="results">
                        <h3><a href="'.$url.'" class="text-dark">'.$threadtitle.'</a></h3>
                        <p>'.$threaddesc.'</p>
                        </div>';
            }
            if ($noresults) {
                echo '<div class="jumbotron jumbotron-fluid py-5 px-3 "style="background: #d8d8e0cf;">
                <div class="container">
                    <p class="display-4">No Results Found</p>
                    <p class="my-4">Suggestions:
                        <ul>
                            <li>Make sure that all words are spelled correctly.</li>
                            <li>Try different keywords.</li>
                            <li>Try more general keywords.</li>
                        </ul>
                    </p>
                </div>
            </div>';
            }
        ?>
    </div>

    <?php include 'partials/_footer.php'?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>
</html>