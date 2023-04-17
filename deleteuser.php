<?php

include "connect_Db.php";
$db = new Db();



$ID=$_GET['delete_id']; 

if($db->delete(' register_user',$ID )){
  echo "success";
  header("location: userlist_dashboard.php");
}else{
  echo "fail";
}

?>