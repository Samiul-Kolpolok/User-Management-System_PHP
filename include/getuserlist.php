<?php

include "connect_Db.php";



$db = new Db();

$contact=$db->Getuserlist($ID = $_GET['id']?? null);

//var_dump($contact);


?>