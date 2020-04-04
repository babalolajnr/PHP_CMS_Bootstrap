<?php require_once('includes/db.php'); ?>
<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/sessions.php'); ?>

<?php

if(isset($_SESSION['UserId'])){
    Redirect_to('dashboard.php');
}

if(isset($_POST['Submit'])){
    $Username = $_POST['Username'];
    $Password = $_POST['Password'];
    if (empty($Username)||empty($Password)){
        $_SESSION['ErrorMessage'] = "All fields must be filled out";
        Redirect_to("login.php");
    }else{
        // code for checking username and password existence in the database
       $Found_Account = login_attempt($Username,$Password);
       if ($Found_Account){
           $_SESSION['UserId']=$Found_Account['id'];
           $_SESSION['UserName']=$Found_Account['username'];
           $_SESSION['AdminName']=$Found_Account['aname'];
           $_SESSION["SuccessMessage"] = "Welcome ".$_SESSION['AdminName'];
           if(isset($_SESSION["TrackingURL"])){
               Redirect_to($_SESSION["TrackingURL"]);
           }else{
            Redirect_to('dashboard.php');
           }
           
       }else{
           $_SESSION["ErrorMessage"] = "Wrong Username/Password";
           Redirect_to('login.php');
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
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans&display=swap" rel="stylesheet">
    <title>Login</title>
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
                    <h1></h1>
                </div>
            </div>
        </div>
    </header>
    <!-- Header end -->
    <!-- Main Area start -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-sm-3 col-sm-6" style="min-height: 550px;">
            <br><br><br><br>
                <?php
                    echo ErrorMessage();
                    echo SuccessMessage();
                ?>
                <div class="card bg-secondary text-light">
                    <div class="card-header">
                        <h4>Welcome Back</h4>
                    </div>     
                     <div class="card-body bg-dark">

                    <form action="" class="" method="post">
                        <div class="form-group">
                            <label for="username"><span class="Fieldinfo">Username:</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-white bg-info"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" name="Username" id="username" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username"><span class="Fieldinfo">Password:</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-white bg-info"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" class="form-control" name="Password" id="password" value="">
                            </div>
                        </div>
                        <input type="submit" class="btn btn-info btn-block" name="Submit" value="Login">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Main Area end -->
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