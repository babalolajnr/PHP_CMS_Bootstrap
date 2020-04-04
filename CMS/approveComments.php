<?php require_once('includes/db.php'); ?>
<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/sessions.php'); ?>
<?php
if(isset($_GET['id'])){
    $SearchQueryParameter = $_GET['id'];
    $dbconnect;
    $Admin = $_SESSION['AdminName'];
    $sql = "UPDATE comments SET status='ON', approvedby='$Admin' WHERE id='$SearchQueryParameter'";
    $Execute = $dbconnect->query($sql);
    if($Execute){
        $_SESSION['SuccessMessage']='Comment Approved Successfully';
        Redirect_to('comments.php');
    }else{
        $_SESSION['ErrorMessage']='Something went wrong!';
        Redirect_to('comments.php');
    }
}


?>