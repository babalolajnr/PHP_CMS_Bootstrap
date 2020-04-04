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
if(isset($_POST["submit"])){
    $Category = $_POST['categoryTitle'];
    $Admin= $_SESSION['UserName'];
    date_default_timezone_set("Africa/Lagos");
    $CurrentTime=time();
    $DateTime=strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
 
    if(empty($Category)){
        $_SESSION['ErrorMessage']= "All fields must be filled out";
        Redirect_to('categories.php');
    }
    elseif(strlen($Category)<3){
        $_SESSION['ErrorMessage']= 'Category should be greater than 2 characters';
        Redirect_to('categories.php');
    }
    elseif(strlen($Category)>49){
        $_SESSION['ErrorMessage']= 'Category should be less than 49 characters';
        Redirect_to('categories.php'); 
    }

    else{

        //Query to insert categories into database
        $dbconnect;
        $sql = "INSERT INTO category (title, author, datetime)";
        $sql .= "VALUES(:categoryName, :adminName, :dateTime)";
        $stmt = $dbconnect->prepare($sql);
        $stmt->bindValue(':categoryName',$Category);
        $stmt ->bindValue(':adminName',$Admin);
        $stmt ->bindValue(':dateTime',$DateTime);
        $Execute = $stmt->execute();

        if($Execute){
            $_SESSION["SuccessMessage"] = "Category with id:".$dbconnect->lastInsertId(). " Added Successfully";
            Redirect_to('categories.php');
        }
        else{
            $_SESSION["ErrorMessage"] = "Something went wrong. Try Again!";
            Redirect_to('categories.php');
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
    <title>Categories</title>
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
                  <h1><i class="fas fa-edit" style="color:#3870b0;"></i>Manage Categories</h1>
                </div>
            </div>
        </div>
    </header>
    <!-- Main body -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-lg-1 col-lg-10" style="min-height: 400px;" >
            <?php 
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
                <form action="categories.php" class="" method="post">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-header">
                            <h1>Add New Category</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"><span class="FieldInfo"> Category Title: </span></label>
                                <input type="text" class="form-control" name="categoryTitle" id="title" placeholder="Enter Category Title" value="">
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
                <h2>Existing Categories</h2>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No. </th>
                            <th>Date&Time</th>
                            <th>Category Name</th>
                            <th>Creator Name</th>
                            <th>Action</th>
                            
                        </tr>
                    </thead>
                
                <?php
                    $dbconnect;
                    $sql = "SELECT * FROM category ORDER BY id DESC";
                    $Execute = $dbconnect->query($sql);
                    $SrNo = 0;
                    while($DataRows=$Execute->fetch()){
                        $CategoryId = $DataRows['id'];
                        $CategoryName = $DataRows['title'];
                        $CreatorName = $DataRows['author'];
                        $DateTime = $DataRows['datetime'];
                          
                        $SrNo++;
                        
                        
                ?>
                <tbody>
                    <td><?php echo htmlentities($SrNo) ; ?></td>
                    <td><?php echo htmlentities($DateTime) ; ?></td>
                    <td><?php echo htmlentities($CategoryName) ; ?></td>
                    <td><?php echo htmlentities($CreatorName) ; ?></td>
                    <td><a href="deleteCategories.php?id=<?php echo $CategoryId; ?>" class="btn btn-danger">Delete</a></td>
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