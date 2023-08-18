<?php
session_start();

echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid">
  <a class="navbar-brand" href="index.php">Lets Discuss</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Top Categories
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
        $sql = "SELECT * FROM `categories` LIMIT 3";
        $result = mysqli_query($conn,$sql);
        while ($row = mysqli_fetch_assoc($result)) {
         echo '<li><a class="dropdown-item" href="threadlist.php?catId='.$row['category_id'].'">'.$row['category_name'].'</a></li>';
        }
        echo '</ul>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php">Contact</a>
      </li>
    </ul>
    <div class="mx-3  d-flex ">';
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {
      echo '<form class="form-inline my-2 my-lg-0 d-flex" method="get" action="search.php">
      <input class="form-control mr-sm-2" name="search" type="search"  placeholder="Search" aria-label="Search">
      <button class="btn btn-success my-2 my-sm-0 mx-2" type="submit">Search</button>
        <p class="text-light my-0 mx-2 d-flex align-items-center" style="min-width: fit-content;justify-content: center;">Welcome '. $_SESSION['username']. ' </p>
        <a href="partials/_logout.php" class="btn btn-outline-success ml-2">Logout</a>
        </form>';
    }else{
        echo'<form class="form-inline d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-success" type="submit">Search</button>
        </form>
        
        <button class="btn btn-outline-success mx-2 " data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
        <button class="btn btn-outline-success me-2 " data-bs-toggle="modal" data-bs-target="#signupModal">Signup</button>';
      }
    echo'</div>
  </div>
</div> 
</nav>';
include 'partials/loginModal.php';
include 'partials/signupModal.php';
if (isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="true") {
  echo '
  <div class="alert alert-success alert-dismissible fade show my-0" role="alert">
  <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
      <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
      </symbol>
  </svg>
  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
      <strong>Success</strong> You can now login.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  '; 
}
?>