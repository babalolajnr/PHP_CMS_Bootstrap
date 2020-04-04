<?php require_once('includes/db.php');?>
<?php
require_once('includes/functions.php');
?>
<?php
require_once('includes/sessions.php');
?>
<!-- fetching exixting data -->
<?php
$SearchQueryParameter = $_GET['username'];
$dbconnect;
$sql = "SELECT aname,aheadline,abio,aimage FROM admins WHERE username=:userName";
$stmt = $dbconnect->prepare($sql);
$stmt->bindValue(':userName', $SearchQueryParameter);
$stmt->execute();
$Result = $stmt->rowCount();
if ($Result==1) {
    while ($DataRows = $stmt->fetch()) {
        $ExistingName = $DataRows['aname'];
        $ExistingBio = $DataRows['abio'];
        $ExistingImage = $DataRows['aimage'];
        $ExistingHeadline = $DataRows['aheadline'];
    }
}else {
    $_SESSION['ErrorMessage'] = "Bad Request!";
    Redirect_to('Blog.php?page=1');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/6ac9cae576.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    
    <!--NAVBAR-->
    <div style="height:10px; background-color:#3870b0"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="#" class="navbar-brand">BABALOLA.COM</a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
                <span class="navbar-toggler-icon"></span>
            </button>
        <div class="collapse navbar-collapse" id="navbarcollapseCMS">
        <ul class="navbar-nav mr-auto">
            
            <li class="nav-item">
                <a href="blog.php" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">About Us</a>
            </li>
            <li class="nav-item">
                <a href="blog.php" class="nav-link">Blog</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">Contact Us</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">Features</a>
            </li>
            
        </ul>
        <ul class="navbar-nav ml-auto">
            <form action="blog.php" class="form-inline d-none d-sm-block">
                <div class="form-group">
                    <input type="text" class="form-control" name="Search" placeholder="Search" value="">
                    <button class="btn btn-primary" name="searchButton"><i class="fas fa-search"></i></button>
                </div>    
            </form>
        </ul>
    </div>
    </div>
    </nav>
    <div style="height:10px; background-color:#3870b0"></div>
    <!-- Navbar End -->
    <!-- Header -->
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><i class="fas fa-user text-success mr-2" style="color:#27aae1;"></i><?php echo $ExistingName; ?></h1>
                    <h3><?php echo $ExistingHeadline; ?></h3>
                </div>
            </div>
        </div>
    </header>
  <!-- header ending -->
  <section class="container py-2 mb-4">
      <div class="row">
          <div class="col-md-3">
              <img src="images\<?php echo $ExistingImage; ?>" alt="avatar" class="d-block img-fluid mb-3 rounded-circle">
          </div>
          <div class="col-md-9" style="min-height: 450px;">
              <div class="card">
                  <div class="card-body">
                      <p class="lead"><?php echo $ExistingBio; ?></p>
                  </div>
              </div>
          </div>
      </div>
  </section>
    <!-- Footer -->
    <footer class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="lead text-center">Theme By | Babalola Abdulqudduus | <span id="year"></span> &copy; ---All Rights Reserved.</p>
                </div>    
            </div>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script>
    $('#year').text(new Date().getFullYear());
    </script>
</body>

</html>