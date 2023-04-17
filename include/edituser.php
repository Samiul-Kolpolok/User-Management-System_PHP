<?php

//To get edit user data
$getUserEditData = '';

if( isset($_GET['edit_id']) ){
    $getUserEditData = $db->getEditUser($_GET['edit_id'] );
}
//var_dump($getUserEditData);

//for update data
if (isset($_POST['email']) && isset($_POST['password'])){
    $ID=$_GET['edit_id']; 
    $email = $_POST['email'];
    $password = $_POST['password'];
if($db->update('register_user',$email,$password,$ID )){
    $getUserEditData['email']=$email;
  echo "success";
}else{
  echo "fail";
}
}

//validations
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

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 rounded">
            <div class="card bg-light" style="width: 28rem;">
                <div class="card-body align-items-center">
                    <div class="d-flex justify-content-center">
               
                <h2 class="text-secondary border-secondary px-3">Edit User Information</h2>
                </div>
                
                    <form method="post" class="py-4">
                        <div class="form-group my-4">
                            <input type="hidden" name="id" value="<?=$getUserEditData['id']?>">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?=$getUserEditData['email']?>">
                            <?php if(isset($errors['email-required'])) { echo "<span class='error'>" . $errors['email-required'] . "</span>"; } ?>
                            <?php if(isset($errors['invalid-email'])) { echo "<span class='error'>" . $errors['invalid-email'] . "</span>"; } ?>
                        </div>
                        <div class="form-group my-4">
                    
                            <input type="text" class="form-control" id="password" name="password" placeholder="Password" value="<?=$getUserEditData['password']?>">
                            <?php if(isset($errors['password-required'])) { echo "<span class='error'>" . $errors['password-required'] . "</span>"; } ?>
                            <?php if(isset($errors['password-length'])) { echo "<span class='error'>" . $errors['password-length'] . "</span>"; } ?>
                            <?php if(isset($errors['password-number'])) { echo "<span class='error'>" . $errors['password-number'] . "</span>"; } ?>
                            <?php if(isset($errors['password-capitalletter'])) { echo "<span class='error'>" . $errors['password-capitalletter'] . "</span>"; } ?>
                            <?php if(isset($errors['password-smallletter'])) { echo "<span class='error'>" . $errors['password-smallletter'] . "</span>"; } ?>
                            <?php if(isset($errors['auth-failed'])) { echo "<span class='error'>" . $errors['auth-failed'] . "</span>"; } ?>
                        </div>
                        <button type="submit" class="btn btn-danger" name="send" style="width: 100%;" href="dashboard.php">Continue</button>
                       
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