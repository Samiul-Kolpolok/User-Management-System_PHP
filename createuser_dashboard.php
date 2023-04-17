<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create User Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>



<!--Navbar Starts here-->
<?php
include 'include/navbar.php';
 ?>
<!--Navbar ends here -->

<div class="container-fluid">
<div class="d-md-flex mt-3 pt-2 justify-content-around">

<div class="mr-1 pr-1">
<!--leftsidebar Starts here-->
<?php
include 'include/leftsidebar.php';
 ?>
<!--leftsidebar ends here -->
</div>

<div class="container-fluid">
    <h3>Create User</h3>
    <h3><hr></h3>
    <?php
include 'include/createuser.php';
 ?>
</div>


<div class="ml-5 pl-5">
<!--rightsidebar Starts here-->
<?php
include 'include/rightsidebar.php';
 ?>
<!--rightsidebar ends here -->
</div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>