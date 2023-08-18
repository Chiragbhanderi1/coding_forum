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
            min-height:90vh;
        }
    </style>
    <title>Let's Discuss</title>
</head>

<body>
    <?php include 'partials/dbConnect.php'?>
    <?php include 'partials/_header.php'?>
    <!-- Slider -->
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/slider1.jpg"
                    height="450vh" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="img/slider2.jpg"
                    height="450vh" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="img/slider3.jpg"
                    height="450vh" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div class="container my-4 ">
        <h2 class="text-center my-4">Let's Discuss - Categories</h2>
        <!-- Categories  -->
        <div class="row  que">
            <!-- Fetch all categories -->
            <?php
            $sql = "SELECT * FROM `categories`";
            $result = mysqli_query($conn,$sql);
            while ($row = mysqli_fetch_assoc($result)) {
              echo '
              <div class="col-md-3 justify-content-center my-1">
              <div class="card my-4 m-auto" style="width: 18rem;">
              <img src="https://images.pexels.com/photos/1181263/pexels-photo-1181263.jpeg?auto=compress&cs=tinysrgb&w=600" class="card-img-top" alt="...">
              <div class="card-body">
              <h5 class="card-title"><a href="threadlist.php?catId='.$row['category_id'].'">'.$row['category_name'].'</a></h5>
              <p class="card-text">'.substr($row['category_description'],0,90).'...</p>
              <a href="threadlist.php?catId='.$row['category_id'].'" class="btn btn-primary">View Threads</a>
              </div>
              </div>
              </div>';
            };
      ?>

        </div>
    </div>
    <?php include 'partials/_footer.php'?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>