<?php


if (isset($_POST['email']) && isset($_POST['password'])) {

    $errors = [];
   
    $email = $_POST['email'];
    $password = $_POST['password'];

    //Email validation
    if (empty($email)) {
        $errors['email-required'] = "Email is required";
      }
    if(!empty($email)){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['invalid-email'] = "Invalid email format";
      }
    }

    //Password Validation
    if (empty($password)) {
        $errors['password-required'] = "Password is required";
      }
    if(!empty($password)){
        if (strlen($_POST["password"]) <= '8') {
            $errors['password-length'] = "Your Password Must Contain At Least 8 Characters!";
        }
        elseif(!preg_match("#[0-9]+#",$password)) {
            $errors['password-number'] = "Your Password Must Contain At Least 1 Number!";
        }
        elseif(!preg_match("#[A-Z]+#",$password)) {
            $errors['password-capitalletter'] = "Your Password Must Contain At Least 1 Capital Letter!";
        }
        elseif(!preg_match("#[a-z]+#",$password)) {
            $errors['password-smallletter'] = "Your Password Must Contain At Least 1 Lowercase Letter!";
        }
    }

       //db connection
       $db_host = 'localhost'; //database host
       $db_user = 'root'; //database user
       $db_password = ''; //database password
       $db_name = 'ums_db'; //database name
   
       $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
   
       // check connection
       if (!$conn) {
           die("Connection failed: " . mysqli_connect_error());
       }

    // Initialize the session
    session_start();
 
    // Check if the user is already logged in, if yes then redirect him to welcome page
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: dashboard.php");
    exit;
    }
   
       $sql = "SELECT * FROM register_user WHERE email = '$email' AND password = '$password' LIMIT 1";
       $result = mysqli_query($conn, $sql);
   
       if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['id'];
           // user is logged in successfully
           
           //initialize the session 
           session_start();
                            
           // Store data in session variables
           $_SESSION["loggedin"] = true;
           $_SESSION['user_id'] = $user_id;

           header("Location: dashboard.php");
           echo ('login successfull');
           exit();
       } else {
           // authentication failed
           $errors['auth-failed'] = "Invalid email or password.";
       }
   
       mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 rounded">
            <div class="card bg-light">
                <div class="card-body align-items-center">
                    <div class="d-flex justify-content-center">
                <img src="assets/logo.png" alt="logo" class="pr-3">
                <h2 class="text-secondary border-left border-secondary px-3">Account</h2>
                </div>
                <h2 class="text-center pt-4 fw-bold">Log in</h2>
                <h5 class="text-center pt-4">Don't have an account?<u class="text-primary"><a href="signup.php" class="h5 mx-2" role="button">Sign up</a></u></h5>
                    <form method="post" class="py-4">
                        <div class="form-group my-4">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                            <?php if(isset($errors['email-required'])) { echo "<span class='error'>" . $errors['email-required'] . "</span>"; } ?>
                            <?php if(isset($errors['invalid-email'])) { echo "<span class='error'>" . $errors['invalid-email'] . "</span>"; } ?>
                        </div>
                        <div class="form-group my-4">
                    
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                            <?php if(isset($errors['password-required'])) { echo "<span class='error'>" . $errors['password-required'] . "</span>"; } ?>
                            <?php if(isset($errors['password-length'])) { echo "<span class='error'>" . $errors['password-length'] . "</span>"; } ?>
                            <?php if(isset($errors['password-number'])) { echo "<span class='error'>" . $errors['password-number'] . "</span>"; } ?>
                            <?php if(isset($errors['password-capitalletter'])) { echo "<span class='error'>" . $errors['password-capitalletter'] . "</span>"; } ?>
                            <?php if(isset($errors['password-smallletter'])) { echo "<span class='error'>" . $errors['password-smallletter'] . "</span>"; } ?>
                            <?php if(isset($errors['auth-failed'])) { echo "<span class='error'>" . $errors['auth-failed'] . "</span>"; } ?>
                        </div>
                        <button type="submit" class="btn btn-danger" name="send" style="width: 100%;" href="dashboard.php">Continue</button>
                        <h3 class="text-center pt-3"><u class="text-primary"><a href="#" class="h6 text-center" role="button">Forgot your password?</a></u></h3>
                        <div class="border rounded-5 border-dark border-size:3 my-4" style="height: 50%; width: 100%;"><h3 class="text-center"><u class="text-primary"><a href="#" class="h6 text-center text=align-center" role="button"><img src="assets/google.png" alt="logo" class="pr-3">Sign in with Google</a></u></h3></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>