<?php require_once('includes/db.php');?>
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
    <title>Comments</title>
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
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><i class="fas fa-comments" style="color: #27aae1;"></i> Manage Comments</h1>
                </div>
            </div>
        </div>
    </header>
    <!-- Main area start -->
    <section class="container py-2 mb-4">
        <div class="row" style="min-height:30px;">
            <div class="col-lg-12" style="min-height:400px;">
            <?php 
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
                <h2>Unapproved Comments</h2>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No. </th>
                            <th>Name</th>
                            <th>Date&Time</th>
                            <th>Comment</th>
                            <th>Approve</th>
                            <th>Delete</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                
                <?php
                    $dbconnect;
                    $sql = "SELECT * FROM comments WHERE status='OFF' ORDER BY id DESC";
                    $Execute = $dbconnect->query($sql);
                    $SrNo = 0;
                    while($DataRows=$Execute->fetch()){
                        $CommmentId = $DataRows['id'];
                        $DatTimeOfComment = $DataRows['datetime'];
                        $CommenterName = $DataRows['name'];
                        $CommentContent = $DataRows['comment'];
                        $CommentPostId = $DataRows['post_id'];  
                        $SrNo++;
                        
                        // code to minimise the amount of space taken up in the table
                        // if(strlen($CommenterName)>10){ $CommenterName = substr($CommenterName,0,10).'..'; }
                        // if(strlen($DatTimeOfComment)>11){ $DatTimeOfComment = substr($DatTimeOfComment,0,11).'..'; }
                ?>
                <tbody>
                    <td><?php echo htmlentities($SrNo) ; ?></td>
                    <td><?php echo htmlentities($CommenterName) ; ?></td>
                    <td><?php echo htmlentities($DatTimeOfComment) ; ?></td>
                    <td><?php echo htmlentities($CommentContent) ; ?></td>
                    <td><a href="approveComments.php?id=<?php echo $CommmentId; ?>" class="btn btn-success">Approve</a></td>
                    <td><a href="deleteComments.php?id=<?php echo $CommmentId; ?>" class="btn btn-danger">Delete</a></td>
                    <td style="min-width: 140px;"><a class="btn btn-primary" href="fullpost.php?id=<?php echo $CommentPostId; ?>" target="_blank">Live Preview</a></td>
                </tbody>
                <?php } ?>
                </table>
                <h2>Approved Comments</h2>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No. </th>
                            <th>Name</th>
                            <th>Date&Time</th>
                            <th>Comment</th>
                            <th>Revert</th>
                            <th>Delete</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                
                <?php
                    $dbconnect;
                    $sql = "SELECT * FROM comments WHERE status='ON' ORDER BY id DESC";
                    $Execute = $dbconnect->query($sql);
                    $SrNo = 0;
                    while($DataRows=$Execute->fetch()){
                        $CommmentId = $DataRows['id'];
                        $DatTimeOfComment = $DataRows['datetime'];
                        $CommenterName = $DataRows['name'];
                        $CommentContent = $DataRows['comment'];
                        $CommentPostId = $DataRows['post_id'];  
                        $SrNo++;
                        
                        // code to minimise the amount of space taken up in the table
                        // if(strlen($CommenterName)>10){ $CommenterName = substr($CommenterName,0,10).'..'; }
                        // if(strlen($DatTimeOfComment)>11){ $DatTimeOfComment = substr($DatTimeOfComment,0,11).'..'; }
                ?>
                <tbody>
                    <td><?php echo htmlentities($SrNo) ; ?></td>
                    <td><?php echo htmlentities($CommenterName) ; ?></td>
                    <td><?php echo htmlentities($DatTimeOfComment) ; ?></td>
                    <td><?php echo htmlentities($CommentContent) ; ?></td>
                    <td style="min-width: 140px;"><a href="disApproveComments.php?id=<?php echo $CommmentId; ?>" class="btn btn-warning">Dis-Approve</a></td>
                    <td><a href="deleteComments.php?id=<?php echo $CommmentId; ?>" class="btn btn-danger">Delete</a></td>
                    <td style="min-width: 140px;"><a class="btn btn-primary" href="fullpost.php?id=<?php echo $CommentPostId; ?>" target="_blank">Live Preview</a></td>
                </tbody>
                <?php } ?>
                </table>
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