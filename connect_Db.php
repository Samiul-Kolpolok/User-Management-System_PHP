<?php
class Db{

  private $server_name = 'localhost';
  private $user_name='root';
  private $password='';
  private $db='ums_db';
  private $dbconnect;

  function __construct() {
    $this->dbconnect = new mysqli($this->server_name,$this->user_name, $this->password,$this->db);
  }
  
  //register data
  function registerdata($email, $password) {
    $response = false;
  
    $sql_Select="SELECT * from register_user WHERE email='$email'";
    $result = $this->dbconnect->query($sql_Select);
    if($result->num_rows>0) {
      echo ('already exists');
    }else {
      $sql = "INSERT INTO register_user (email, password) 
      values('$email', '$password')";
       if (mysqli_query($this->dbconnect,$sql)) {
        $response = true;
    } 
    };
     return $response;
  }



     //function to get userdata in the UI 
     function Getuserlist($id = false){
      $cond = "";
      if($id) {
        $cond = " WHERE id='$id'";
      }
  
      $sql_Select="SELECT * from register_user $cond";
      $result = $this->dbconnect->query($sql_Select);
       
    
      if (mysqli_num_rows($result) > 0) { //This is the built in function
        // output data of each row
        ?>
        <table class="table">
          <tr>
            <th>Id</th>
            <th>Email</th>
            <th>Password</th>
            <th>Edit</th>
            <th>Delete</th>
            
          </tr>
        <?php
        while($row = mysqli_fetch_assoc($result)) {  //this is the built in function 
          ?>
          <tr>
          <td ><?= $row["id"]?></td>  
          <td ><?php echo $row["email"]?></td>
          <td ><?= $row["password"]?></td>
          <td><a href="edituser_dashboard.php?edit_id=<?php echo  $row["id"]?>"><button class="btn btn-success">EDIT</button></a></td>
          <td><a href="deleteuser.php?delete_id=<?php echo  $row["id"]?>"><button class="btn btn-danger">Delete</button></a></td>
        </tr>
          <?php
        }
        ?>
         </table>
        <?php
      } else {
        echo ('nothing found');
      }
   }

   // Function to get user admin who logged in

   function Getuseradmin($id = false){
    $cond = "";
    if($id) {
      $cond = " WHERE id='$id'";
    }
    //Get the ID of the currently logged in user admin from the session
    $user_id = $_SESSION['user_id'];
    $sql_Select="SELECT * from register_user $cond WHERE id='$user_id'";
    $result = $this->dbconnect->query($sql_Select);
  
    if (mysqli_num_rows($result) > 0) {
      ?>
        <?php
        while($row = mysqli_fetch_assoc($result)) {
          ?>
          
            <span class="mr-3"><?php echo $row["email"]?></span>
            <span><?= $row["password"]?></span>
        
          <?php
        }
        ?>
    
      <?php
    } else {
      echo ('nothing found');
    }
  }

  //Function to edit user
  function Update($table, $email, $password, $ID){
    $response=false;
    $sql = "UPDATE $table SET email='".$email."', password='".$password."'  WHERE id = $ID";
    if (mysqli_query($this->dbconnect, $sql)) {
      $response = true;
     } 
     return $response; 
  }

  //Function to get edit user data in the form
  function getEditUser($id){
    $sql_Select="SELECT * from register_user WHERE id = $id";
    $result = $this->dbconnect->query($sql_Select);
    return mysqli_fetch_assoc($result);
  }

  //Function to delete user

  function Delete($table, $ID){
    $response = false;
    $sql = "DELETE FROM $table WHERE id=$ID";
    if (mysqli_query($this->dbconnect, $sql)) {
        $response = true;
       } 

       return $response;
  }
  
  //Function to close connection
  function __destruct(){
    $this->dbconnect->close();
   }
  
  }

?>