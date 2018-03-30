<?php
session_start();

function set_variables($username){
  global $db_db;
  $query = "SELECT UID, status FROM users
            WHERE uName = :username LIMIT 1";
  $statement = $db_db->prepare($query);
  // $statement->bindValue(':username', $username);
  $params = array(
    'username' => $username,
  );
  $statement->execute($params);
  $results = $statement->fetch();
  $_SESSION['UID'] = $results['UID'];
  $_SESSION['status'] = $results['status'];
  $_SESSION['uName'] = $username;
  // $verify =$username . $results['UID'];
  // $_SESSION['verify'] = $verify;
  // $id =  $results['UID'];
  // $_SESSION[ 'echo $id' . 'uName'] = $username;
}

function get_id(){
  return $_SESSION['UID'];
}
function the_id(){
  echo  $_SESSION['UID'];
}
function get_status(){
   return $_SESSION['status'];
}
function the_status(){
   echo $_SESSION['status'];
}
function get_uname(){
   return $_SESSION['uName'];
}
function the_uname(){
   echo $_SESSION['uName'];
}
// function get_verify(){
//    return  $_SESSION['verify'];
// }
// function the_verify(){
//   echo $_SESSION['verify'];
// }

function destroy_session(){

   if(session_destroy()){
     return true;
   }
   return false;
 }
