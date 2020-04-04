<?php require_once('includes/db.php'); ?>
<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/sessions.php'); ?>
<?php
if(isset($_GET['id'])){
    $SearchQueryParameter = $_GET['id'];
    $dbconnect;
   
    $sql = "DELETE FROM admins WHERE id='$SearchQueryParameter'";
    $Execute = $dbconnect->query($sql);
    if($Execute){
        $_SESSION['SuccessMessage']='Admin Deleted Successfully';
        Redirect_to('admins.php');
    }else{
        $_SESSION['ErrorMessage']='Something went wrong!';
        Redirect_to('admins.php');
    }
}


?>