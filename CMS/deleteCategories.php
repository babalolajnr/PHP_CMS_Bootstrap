<?php require_once('includes/db.php'); ?>
<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/sessions.php'); ?>
<?php
if(isset($_GET['id'])){
    $SearchQueryParameter = $_GET['id'];
   global $dbconnect;
   
    $sql = "DELETE FROM category WHERE id='$SearchQueryParameter'";
    $Execute = $dbconnect->query($sql);
    if($Execute){
        $_SESSION['SuccessMessage']='Category Deleted Successfully';
        Redirect_to('categories.php');
    }else{
        $_SESSION['ErrorMessage']='Something went wrong!';
        Redirect_to('categories.php');
    }
}


?>