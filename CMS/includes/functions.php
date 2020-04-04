<?php require_once('includes/db.php'); ?>
<?php
function Redirect_to($New_Location){
    header("Location:".$New_Location);
    exit;
}

function checkUsernameExistence($Username){
    global  $dbconnect;
    $sql =  "SELECT username FROM admins WHERE username=:userNaMe";
    $stmt = $dbconnect->prepare($sql);
    $stmt->bindValue(':userNaMe', $Username);
    $stmt->execute();
    $Result = $stmt -> rowcount();
    if ($Result==1){
        return true;
    }else{
        return false;
    }
}

function login_attempt($Username,$Password){
   
    global $dbconnect;
    $sql = "SELECT * FROM admins WHERE username=:userName AND password=:passwoRd LIMIT 1";
    $stmt = $dbconnect->prepare($sql);
    $stmt->bindValue(':userName', $Username);
    $stmt->bindValue(':passwoRd', $Password);
    $stmt->execute();
    $Result = $stmt->rowcount();
    if ($Result==1){
        return $Found_Account=$stmt->fetch();

    }else {
        return null;
    }
}

function confirm_login(){
    if(isset($_SESSION['UserId'])){
        return true;
    }else{
        $_SESSION['ErrorMessage']="Login Required!";
        Redirect_to('login.php');
    }
}

function TotalPosts(){
     global $dbconnect;
    $sql = "SELECT COUNT(*) FROM posts";
    $stmt = $dbconnect->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalPosts = array_shift($TotalRows);
    echo $TotalPosts;
}

function TotalCategories(){
    global $dbconnect;
    $sql = "SELECT COUNT(*) FROM category";
    $stmt = $dbconnect->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalCategories = array_shift($TotalRows);
    echo $TotalCategories;
}
function TotalAdmins(){
    global $dbconnect;
    $sql = "SELECT COUNT(*) FROM admins";
    $stmt = $dbconnect->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalAdmins = array_shift($TotalRows);
    echo $TotalAdmins;
}

function TotalComments(){
    global $dbconnect;
    $sql = "SELECT COUNT(*) FROM comments";
    $stmt = $dbconnect->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalComments = array_shift($TotalRows);
    echo $TotalComments;
}

function ApprovedCommentsAccordingToPost($PostId){
    global $dbconnect;
    $sqlApprove = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='ON'";
    $stmtApprove = $dbconnect->query($sqlApprove);
    $RowsTotal = $stmtApprove->fetch();
    $Total = array_shift($RowsTotal);
    return $Total;
}

function DisApprovedCommentsAccordingToPost($PostId){
    global  $dbconnect;
    $sqlDisApprove = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='OFF'";
    $stmtDisApprove = $dbconnect->query($sqlDisApprove);
    $RowsTotal = $stmtDisApprove->fetch();
    $Total = array_shift($RowsTotal);
    return $Total;
}
?>