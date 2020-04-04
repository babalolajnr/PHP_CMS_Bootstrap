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
    <title>Dashboard</title>
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
            <li class="nav-item"><a href="logout.php" class="nav-link  text-danger"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
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
                    <h1><i class="fas fa-cog"> Dashboard</i></h1>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="addNewPosts.php" class="btn btn-primary btn-block">
                        <i class="fas fa-edit"></i>Add New Post
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="categories.php" class="btn btn-info btn-block">
                        <i class="fas fa-folder-plus"></i>Add New Category
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="admins.php" class="btn btn-warning btn-block">
                        <i class="fas fa-user-plus"></i>Add Admin
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="comments.php" class="btn btn-success btn-block">
                        <i class="fas fa-check"></i>Approved Comments
                    </a>
                </div>
            </div>
        </div>
    </header>
    <br>
    <!-- Main Area -->
    <section class="container py-2 mb-4">
        <div class="row">
            
            <?php 
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
           <!-- left side area start -->
            <div class="col-lg-2 d-none d-md-block">
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Posts</h1>
                        <h4 class="display-5">
                            <i class="fab fa-readme"></i>
                            <?php
                                TotalPosts();
                            ?>
                        </h4>
                    </div>
                </div>
            

            
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Categories</h1>
                        <h4 class="display-5">
                            <i class="fas fa-folder"></i>
                            <?php
                                TotalCategories();
                            ?>
                        </h4>
                    </div>
                </div>
            

            
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Admins</h1>
                        <h4 class="display-5">
                            <i class="fas fa-users"></i>
                            <?php
                                TotalAdmins();
                            ?>
                        </h4>
                    </div>
                </div>
            

           
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Comments</h1>
                        <h4 class="display-5">
                            <i class="fas fa-comments"></i>
                            <?php
                                TotalComments();
                            ?>
                        </h4>
                    </div>
                </div>
                </div>

           <!-- left side area end    -->
           <!-- Right Side arear start -->
           <div class="col-lg-10">
               <h1>Top Posts</h1>
               <table class="table table-striped table hover">
                   <thead class="thea-dark">
                       <tr>
                           <th>No.</th>
                           <th>Title</th>
                           <th>Date&Time</th>
                           <th>Author</th>
                           <th>Comments</th>
                           <th>Details</th>
                       </tr>
                   </thead>
                   <?php
                    $SrNo = 0;
                    $dbconnect;
                    $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT 0,5";
                    $stmt = $dbconnect->query($sql);
                    while($DataRows=$stmt->fetch()){
                        $PostId = $DataRows['id'];
                        $DateTime = $DataRows['datetime'];
                        $Author = $DataRows['author'];
                        $Title = $DataRows['title'];
                        $SrNo++;                    
                    
                   ?>
                   <tbody>
                       <tr>
                           <td><?php echo $SrNo; ?></td>
                           <td><?php echo $Title; ?></td>
                           <td><?php echo $DateTime; ?></td>
                           <td><?php echo $Author; ?></td>
                           <td>
                               
                                   <?php
                                        $Total = ApprovedCommentsAccordingToPost($PostId);
                                        if($Total>0){
                                    ?>
                                        <span class="badge badge-success">    
                                            <?php
                                    
                                            echo $Total;  ?>
                                        </span>
                                        <?php } ?>

                                        <?php
                                       $Total = DisApprovedCommentsAccordingToPost($PostId);
                                        if($Total>0){
                                    ?>
                                        <span class="badge badge-danger">    
                                            <?php
                                    
                                            echo $Total;  ?>
                                        </span>
                                        <?php } ?>
                           </td>
                           <td>
                           <a target="_blank" href="fullpost.php?id=<?php echo $PostId; ?>"><span class="btn btn-info"> Preview</span></a>
                           </td>
                       </tr>
                   </tbody>
                   <?php } ?>
               </table>
           </div>     
            <!-- Right side area end     -->
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