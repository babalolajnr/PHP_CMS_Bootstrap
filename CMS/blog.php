<?php
require_once('includes/db.php');
?>
<?php
require_once('includes/functions.php');
?>
<?php
require_once('includes/sessions.php');
?>
<style media="screen">
    .heading{
    font-family: Bitter,Georgia, 'Times New Roman', Times, serif;
    font-weight: bold;
    color: #005e90;
}
.heading:hover{
    color: #0090db;
}
</style>
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
    <title>Blog Page</title>
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
    <div class="container">
        <div class="row">
            <!-- Main Area start -->
            <div class="col-sm-8 mt-4">
                <h1>The Complete Responsive CMS Blog </h1>
                <h1 class="lead">The Complete Responsive Cms Blog Using PHP by Babalola Abdulqudduus</h1>
                <?php
                    echo ErrorMessage();
                    echo SuccessMessage();
                ?>
                <?php
                    $dbconnect;

                    if(isset($_GET['searchButton'])){
                          $search = $_GET['Search'];
                          $sql = "SELECT * FROM posts WHERE 
                          datetime LIKE :search
                          OR title LIKE :search
                          OR category LIKE :search
                          OR post LIKE :search";
                          $stmt = $dbconnect -> prepare($sql);
                          $stmt->bindValue(':search', '%'.$search.'%');
                          $stmt->execute();  
                    }
                    // Query when pagination is active
                    elseif (isset($_GET['page'])) {
                        $Page = $_GET['page'];
                        if ($Page==0||$Page<1) {
                            $ShowPostsFrom=0;
                        }else {
                            $ShowPostsFrom=($Page*5)-5;    
                        }
                        
                        $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT $ShowPostsFrom,5";
                        $stmt = $dbconnect->query($sql);

                    }elseif (isset($_GET['category'])) {
                        $Category = $_GET['category'];
                        $sql = "SELECT * FROM posts WHERE category=:categoryName ORDER BY id DESC";
                        $stmt = $dbconnect->prepare($sql);
                        $stmt->bindValue(':categoryName', $Category);
                        $stmt->execute();
                    }

                    // default query
                   else{ $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,3";
                            $stmt = $dbconnect -> query($sql); 
                        }
                    
                    while($DataRows = $stmt -> fetch()){
                        $postID = $DataRows['id'];
                        $dateTime = $DataRows['datetime'];
                        $title = $DataRows['title'];
                        $category = $DataRows['category'];
                        $author = $DataRows['author'];
                        $image = $DataRows['image'];
                        $postBody = $DataRows['post'];
                    
                ?>
                <div class="card">
                    <img src="uploads/<?php echo $image; ?>" class="img-fluid card-img-top" style="min-height: 450px;" >
                    <div class="card-body">
                        <h4 class="card-title">
                            <?php echo htmlentities($title) ; ?>
                        </h4>
                        <small class="text-muted">Category : <span class="text-dark"><a href="blog.php?category=<?php echo htmlentities($category) ; ?>"><?php echo htmlentities($category) ; ?></a></span> Written By <span class="text-dark"><a href="profile.php?username=<?php echo htmlentities($author) ; ?>"><?php echo htmlentities($author) ; ?></a></span> On <span class="text-dark"><?php echo htmlentities($dateTime) ; ?></span></small>
                        <span style="float: right;"><i class="fas fa-comments"></i><?php 
                        $Comments = ApprovedCommentsAccordingToPost($postID);
                        echo $Comments;
                        ?></span>
                        <hr>
                        <p class="card-text"><?php 
                            if(strlen($postBody)> 300){
                                $postBody = substr($postBody, 0, 300)."...";
                            }
                        echo htmlentities($postBody) ; ?></p>
                        <a href="fullpost.php?id=<?php echo $postID; ?>">
                            <span class="btn btn-info" style="float: right">Read More >> </span>
                        </a>
                    </div>
                </div>
                <?php }  ?>
                <!-- Pagination -->
                <nav>
                    <ul class="pagination paginationlg">
                         <!-- Creating THe Backward button -->
                    <?php 
                        if (isset($Page)) {
                            if ($Page>1) { ?>
                                <li class="page-item">
                                    <a href="blog.php?page=<?php echo $Page-1; ?>" class="page-link">&laquo;</a>
                                </li>
                      <?php  }
                        }
                    ?>
                   
                        <?php
                        $dbconnect;
                        $sql = "SELECT COUNT(*) FROM posts";
                        $stmt = $dbconnect->query($sql);
                        $RowPagination = $stmt->fetch();
                        $TotalPosts = array_shift($RowPagination);
                        // echo $TotalPosts."<br>";
                        $PostPagination = $TotalPosts/5;
                        $PostPagination = ceil($PostPagination);
                        // echo $PostPagination;
                        for ($i=1; $i <=$PostPagination ; $i++) { 
                            if (isset($Page)) {
                                    if ($i==$Page) { ?>
                                        <li class="page-item active">
                            <a href="blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                        </li>
                          <?php 
                          }else {
                           ?> <li class="page-item">
                            <a href="blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                        </li>
                         <?php
                        }
                    } }  ?>
                    <!-- Creating THe forward button -->
                    <?php 
                        if (isset($Page) &&!empty($Page)) {
                            if ($Page+1<=$PostPagination) { ?>
                                <li class="page-item">
                                    <a href="blog.php?page=<?php echo $Page+1; ?>" class="page-link">&raquo;</a>
                                </li>
                      <?php  }
                        }
                    ?>
                    </ul>
                </nav>
            </div>
            <!-- Side area start -->
            <div class=" col-sm-4">
                <div class="card mt-4">
                    <div class="card-body">
                        <img src="images\10-Tips-to-Get-More-Local-Customers-from-AdWords-Facebook-Ads-760x400.png" alt="" class="d-block img-fluid mb-3">
                        <div class="text-center">
                        "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <h2 class="lead">Sign Up!</h2>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-success btn-block text-center text-white mb-4">Join The Forum</button>
                        <button class="btn btn-danger btn-block text-center text-white mb-4">Login</button>
                        <div class="input-group mb-3">
                            <input type="text" name="" placeholder="Enter Your Email" value="" class="form-control">
                            <div class="input-group-append">
                                <button class="btn btn-primary btn-sm text-center text-white" name="button" type="button">Subscribe Now</button>
                            </div>
                        </div>
                    </div>
                </div> 
                <br>
                <div class="card">
                    <div class="card-header bg-primary text-light">
                        <h2 class="lead">Categories</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        
                        $dbconnect;
                        $sql ="SELECT * FROM category ORDER BY id DESC";
                        $stmt = $dbconnect->query($sql);
                        while ($DataRows=$stmt->fetch()) {
                            $CategoryId = $DataRows['id'];
                            $CategoryName = $DataRows['title'];
                            ?>
                            <a href="blog.php?category=<?php echo htmlentities($CategoryName) ; ?>"><span class="heading"><?php echo $CategoryName; ?></span></a><br>
                       <?php }
                        
                        ?>
                    </div>
                </div>  
                <br>
                <div class="card">
                    <div class="card-header bg-info text-white">
                            <h2 class="lead">Recent Posts</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        $dbconnect;
                        $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                        $stmt = $dbconnect->query($sql);
                        while ($DataRows = $stmt->fetch()) {
                            $Id =$DataRows['id'];
                            $Title = $DataRows['title'];
                            $DateTime = $DataRows['datetime'];
                            $Image = $DataRows['image'];
                        
                        ?>
                       <a href="fullpost.php?id=<?php echo $Id; ?>" target="_blank"> <div class="media">
                            <img src="uploads/<?php echo htmlentities($Image) ; ?>" class="d-block img-fluid align-self-start" width="90" height="94" alt="">
                            <div class="media-body ml-2">
                                <h6 class="lead"><?php echo htmlentities($Title) ; ?></h6>
                                <p class="small"><?php echo htmlentities($DateTime) ; ?></p>
                            </div>
                        </div></a>
                        <hr>
                        <?php } ?>
                    </div>
                </div>     
            </div>

        </div>
    </div>
    <!-- header end -->
    <br>
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