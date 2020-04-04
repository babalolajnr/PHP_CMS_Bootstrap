<?php
require_once('includes/db.php');
?>
<?php
require_once('includes/functions.php');
?>
<?php
require_once('includes/sessions.php');
?>
<?php confirm_login(); ?>
<?php
$SearchQueryParameter = $_GET['id'];
if(isset($_POST["submit"])){
    $PostTitle = $_POST['posthead'];
    $Category = $_POST['Category'];
    $Image = $_FILES["Image"]["name"];
    $Target = "uploads/".basename($_FILES["Image"]["name"]);
    $PostText = $_POST['postBody'];
    $Admin = 'Abdulqudduus';
    date_default_timezone_set("Africa/Lagos");
    $CurrentTime=time();
    $DateTime=strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
 
    if(empty($PostTitle)){
        $_SESSION['ErrorMessage']= "Title Cant't be Empty";
        Redirect_to('posts.php');
    }
    elseif(strlen($PostTitle)<5){
        $_SESSION['ErrorMessage']= 'Post Title should be greater than 5 characters';
        Redirect_to('posts.php');
    }
    elseif(strlen($PostText)>9999){
        $_SESSION['ErrorMessage']= 'Post Description should be less than 1000 characters';
        Redirect_to('posts.php'); 
    }

    else{

        //Query to update post in Database
        $dbconnect;
       if(!empty($_FILES["Image"]["name"])){
        $sql = "UPDATE posts 
        SET title='$PostTitle', category='$Category', image='$Image', post='$PostText' 
        WHERE id = '$SearchQueryParameter'";
   
       }
       
     else{  $sql = "UPDATE posts 
                SET title='$PostTitle', category='$Category', post='$PostText' 
                WHERE id = '$SearchQueryParameter'";
                $Execute = $dbconnect->query($sql);
        move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
        
        }
        if($Execute){
            $_SESSION["SuccessMessage"] = "Post Updated Successfully";
            Redirect_to('posts.php');
        }
        else{
            $_SESSION["ErrorMessage"] = "Something went wrong. Try Again!";
            Redirect_to('posts.php');
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
    <title>Edit Posts</title>
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
                  <h1><i class="fas fa-user-edit"></i> <span> Edit Post </span></h1>
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
            //Fetching data from our database
            $dbconnect;
           
            $sql = "SELECT * FROM posts WHERE id='$SearchQueryParameter'";
            $stmt = $dbconnect->query($sql);
            while($DataRows = $stmt->fetch()){
                    $updateTitle = $DataRows['title'];
                    $updateCategory = $DataRows['category'];
                    $updateImage = $DataRows['image'];
                    $updatePost = $DataRows['post'];    
            }
            ?>
                <form action="edit.php?id=<?php echo$SearchQueryParameter; ?>" class="" method="post" enctype="multipart/form-data" >
                    <div class="card bg-secondary text-light mb-3">
                       
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"><span class="FieldInfo"> Post Title: </span></label>
                                <input type="text" class="form-control" name="posthead" id="title" placeholder="Enter Category Title" value="<?php echo $updateTitle; ?>">
                            </div>
                            <div class="form-group">
                                <span class="FieldInfo">Exsiting Category</span>
                                <?php echo $updateCategory; ?><br>
                                <label for="CategoryTitle"><span class="FieldInfo"> Choose Category: </span></label>
                                <select name="Category" id="CategoryTitle" class="form-control">
                                    <?php
                                    $dbconnect;
                                    $sql="SELECT id, title FROM category";
                                    $stmt = $dbconnect->query($sql);
                                    while($DataRows = $stmt->fetch()){
                                        $ID = $DataRows['id'];
                                        $CategoryName = $DataRows['title'];
                                    
                                    ?>
                                    <option><?php echo $CategoryName; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group mb-1">
                                <span class="FieldInfo">Existing Image:</span>
                                <img src="uploads/<?php echo $updateImage; ?>" width="250px" height="200px" alt="" class="mb-4">
                                <div class="custom-file">
                                    <input class="custom-file-input" type="file" name="Image" id="imageSelect" value="">
                                    <label for="imageSelect" class="custom-file-label">Select Image</label>
                                </div>
                            </div>
                            <div class="form-group">
                            <label for="post"><span class="FieldInfo">Post:</span></label>
                            <textarea name="postBody" id="" cols="80" rows="8" class="form-control">
                                <?php echo $updatePost; ?>
                            </textarea>
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