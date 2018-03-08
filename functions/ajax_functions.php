<?php
require_once('functions/db_functions.php');
session_start();
$function = $_POST['function'];
$usename = $_POST['uname'];
switch ($function) {
  case 'db_logOut_user':
      db_logOut_user($usename);
    break;
}
 ?>
