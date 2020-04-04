<?php
require_once('includes/db.php');
?>
<?php
require_once('includes/functions.php');
?>
<?php
require_once('includes/sessions.php');
?>
<?php 
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
confirm_login(); ?>
<?php
// fetching the exixting admin data start
$AdminId = $_SESSION['UserId'];
$dbconnect;
$sql = "SELECT * FROM admins WHERE id='$AdminId'";
$stmt = $dbconnect->query($sql);
    while ($DataRows = $stmt->fetch()) {
        $ExistingName = $DataRows['aname'];
        $ExistingUsername = $DataRows['username'];
        $ExistingHeadline = $DataRows['aheadline'];
        $ExistingBio = $DataRows['abio'];
        $ExistingImage = $DataRows['aimage'];
    }
?>
<?php
if(isset($_POST["submit"])){
    $AName = $_POST['Name'];
    $AHeadline = $_POST['Headline'];
    $ABio = $_POST['Bio'];
    $Image = $_FILES["Image"]["name"];
    $Target = "images/".basename($_FILES["Image"]["name"]);
    date_default_timezone_set("Africa/Lagos");
    $CurrentTime=time();
    $DateTime=strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
    if(strlen($AHeadline)>30){
        $_SESSION['ErrorMessage']= 'Headline should not be greater than 30 characters';
        Redirect_to('myProfile.php');
    }
    elseif(strlen($ABio)>500){
        $_SESSION['ErrorMessage']= 'Bio should not be greater than 500 characters';
        Redirect_to('myProfile.php'); 
    }

    else{

        //Query to update Admin info in Database when everything is fine
        $dbconnect;
       if(!empty($_FILES["Image"]["name"])){
        $sql = "UPDATE admins  
        SET aname='$AName', aheadline='$AHeadline', abio='$ABio', aimage='$Image' 
        WHERE id = '$AdminId'";
   
       }
       
     else{ 
         $sql = "UPDATE admins  
        SET aname='$AName', aheadline='$AHeadline', abio='$ABio'
        WHERE id = '$AdminId'";
        
        }
        $Execute = $dbconnect->query($sql);
        move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
        if($Execute){
            $_SESSION["SuccessMessage"] = "Details updated Successfully";
            Redirect_to('myProfile.php');
        }
        else{
            $_SESSION["ErrorMessage"] = "Something went wrong. Try Again!";
            Redirect_to('myProfile.php');
        }
    }
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
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>My Profile</title>
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
                <a href="myprofile.php" class="nav-link"><i class="fas fa-user text-success"></i>My Profile</a>
            </li>
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link">Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="posts.php" class="nav-link">Posts</a>
            </li>
            <li class="nav-item">
                <a href="categories.php" class="nav-link">Categories</a>
            </li>
            <li class="nav-item">
                <a href="manageadmins.php" class="nav-link">Manage Admins</a>
            </li>
            <li class="nav-item">
                <a href="comments.php" class="nav-link">Comments</a>
            </li>
            <li class="nav-item">
                <a href="blog.php?page=1" class="nav-link">Live Blog</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a href="#" class="nav-link  text-danger"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
        </ul>
    </div>
    </div>
    </nav>
    <div style="height:10px; background-color:#3870b0"></div>
    <!-- Navbar End -->
    <!-- Header -->
    <header class="bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                  <h1><i class="fas fa-user text-success mr-2"></i>@<?php echo $ExistingUsername; ?></h1>
                  <small><?php echo $ExistingHeadline; ?></small>
                </div>
            </div>
        </div>
    </header>
    <!-- Main body -->
    <section class="container py-2 mb-4">
        <div class="row">
            <!-- left area -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <h3><?php echo $ExistingName; ?></h3>
                    </div>
                    <div class="card-body">
                        <img src="images\<?php echo $ExistingImage; ?>" alt="" class="block img-fluid mb-3">
                        <div class="">
                        <?php echo $ExistingBio; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- right area -->
            <div class="col-md-9" style="min-height: 400px;" >
            <?php 
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
                <form action="myProfile.php" class="" method="post" enctype="multipart/form-data" >
                    <div class="card bg-dark text-light">
                       <div class="card-header bg-secondary text-light">
                        <h4>Edit Profile</h4>
                       </div>
                        <div class="card-body">
                            <div class="form-group">
                                <input type="text" class="form-control" name="Name" id="title" placeholder="Your name" value="">
                            </div>
                            <div class="form-group">
                                 
                                <input type="text" class="form-control"  name="Headline" id="title"placeholder="Headline" value="">
                                <small class="text-muted">Add a Professional Headline like 'Engineer at XYZ' or 'Architect'</small>
                                <span class="text-danger">Not more than 12 characters</span>
                            </div>
                            <div class="form-group">
                                <textarea name="Bio" id="" cols="80" rows="8" placeholder="Bio" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                
                                <div class="custom-file">
                                    <input class="custom-file-input" type="file" name="Image" id="imageSelect" value="">
                                    <label for="imageSelect" class="custom-file-label">Select Image</label>
                                </div>
                            </div>
                          
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="dashboard.php" class="btn btn-warning btn-block" ><i class="fas fa-arrow-left"></i>Dashboard</a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="Submit" name="submit" class="btn btn-success btn-block">
                                    <i class="fas fa-check"></i>Publish
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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