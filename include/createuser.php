<?php


// Data checking

if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['retypedPassword'])) {

    ##TODO-01: data validation
    $errors = [];
   
    $email = $_POST['email'];
    $password = $_POST['password'];
    $retyped_Password = $_POST['retypedPassword'];

    //email validation
  
    if (empty($email)) {
        $errors['email-required'] = "Email is required";
      }
    if(!empty($email)){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['invalid-email'] = "Invalid email format";
      }
    }

    //password validation
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
    
    //retyped password validation
    if (empty($retyped_Password)) {
        $errors['retyped_Password-required'] = "Retype Password is required";
      }
    if(($retyped_Password) !== $password){
        
            $errors['password-missmatched'] = "Password not matched with the previous one";
    }
    

    //db connection
    include "connect_Db.php";
    $db = new Db();

    if (empty($email && $password && $retyped_Password)){
        $errors['data-required'] = "Please type required data";
        } else {

    if (empty($errors)){  
    
    //save in db
   if($db->registerdata($email,$password)){
    echo "success";
    }else{
   echo "fail";
    }
}} }

?>


<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 rounded">
            <div class="card bg-light" style="width: 28rem;">
                <div class="card-body align-items-center">
                    <h2 class="text-center">Create new user</h2>
                    <form method="post"class="py-3">
                        <div class="form-group my-3">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                            <?php if(isset($errors['email-required'])) { echo "<span class='error'>" . $errors['email-required'] . "</span>"; } ?>
                            <?php if(isset($errors['invalid-email'])) { echo "<span class='error'>" . $errors['invalid-email'] . "</span>"; } ?>
                        </div>
                        <div class="form-group my-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Set your Password">
                            <?php if(isset($errors['password-required'])) { echo "<span class='error'>" . $errors['password-required'] . "</span>"; } ?>
                            <?php if(isset($errors['password-length'])) { echo "<span class='error'>" . $errors['password-length'] . "</span>"; } ?>
                            <?php if(isset($errors['password-number'])) { echo "<span class='error'>" . $errors['password-number'] . "</span>"; } ?>
                            <?php if(isset($errors['password-capitalletter'])) { echo "<span class='error'>" . $errors['password-capitalletter'] . "</span>"; } ?>
                            <?php if(isset($errors['password-smallletter'])) { echo "<span class='error'>" . $errors['password-smallletter'] . "</span>"; } ?>
                        </div>
                        <div class="form-group my-3">
                            <input type="password" class="form-control" id="password" name="retypedPassword" placeholder="Set your Password">
                            <?php if(isset($errors['retyped_Password-required'])) { echo "<span class='error'>" . $errors['retyped_Password-required'] . "</span>"; } ?>
                            <?php if(isset($errors['password-missmatched'])) { echo "<span class='error'>" . $errors['password-missmatched'] . "</span>"; } ?>
                        </div>                       
                        <button type="submit" class="btn btn-danger" name="send" style="width: 100%;">Continue</button>

                        <?php if(isset($errors['data-required'])) { echo "<span class='error'>" . $errors['data-required'] . "</span>"; } ?>
                </div>
            </div>
        </div>
    </div>
</div>
