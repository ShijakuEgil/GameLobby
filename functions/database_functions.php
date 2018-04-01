<?php
/*
    @author Egil Shijaku
    @package: GameLobby
    Functions for communicationg with databse
*/
require_once('db_connection.php');
require('session_variables.php');

//Tested and debugged
function verify_user($username, $password){
  global $db_db;
  $password = sha1($username . $password);
  $query = 'SELECT uName, status FROM users
            WHERE  uName = :username AND password = :password';
  $statement = $db_db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->bindValue(':password', $password);
  $statement->execute();
  $result = $statement->fetch();
  if($statement->rowcount() == 0){
     $statement->closeCursor();
    return false;
  }
  elseif($statement->rowcount() != 0 && $result['status'] == 'F'){
    $statement->closeCursor();
    return true;
  }
}

//tested and debugged
function set_user_status($status, $username){
  global $db_db;
  $query1 = 'UPDATE users SET status = :status
              WHERE uName = :id';
  $statement1 = $db_db->prepare($query1);
  $statement1->bindValue(':id',$username);
  $statement1->bindValue(':status',$status);
  $statement1->execute();
  $statement1->closeCursor();
}

//Tested and debbuged
function add_user($username, $password, $email){
  global $db_db;
  //username needs to be unique
  $query = 'SELECT uName FROM users
            WHERE uName = :username';
  $statement = $db_db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->execute();
  $isUnique = ($statement->rowcount() < 1);
  $statement->closeCursor();

  if($isUnique){// username is unique so the user is added
    $password = sha1($username . $password);
    $query = 'INSERT INTO users (uName, password, email)
              VALUES (:username, :password, :email)';
    $statement2 = $db_db->prepare($query);
    $statement2->bindValue(':username', $username);
    $statement2->bindValue(':password', $password);
    $statement2->bindValue(':email', $email);
    $statement2->execute();
    $statement2->closeCursor();
    return true;
  }
  else{
    return false;
  }
}

function logout_user($username){
  global $db_db ;
  //find the username in the database and set its status to 'F'
  $query = "UPDATE users SET status = 'F'
            WHERE uName = $username";
  $statement = $db_db->prepare($query);
  $statement->execute();
}

//returns a list of players
function get_players_list(){
  global $db_db;
  $query = "SELECT * FROM users  ORDER BY status DESC";
  $statement = $db_db->prepare($query);
  $statement->execute();
  $results = $statement->fetchAll();
  $statement->closeCursor();
  return $results;
}


// TODO: not tested still under development
function get_status_count(){
  global $db_db;
  $query = "SELECT * FROM users  WHERE status = :status";
  $statement = $db_db->prepare($query);
  $statement->bindValue(':status', 'F');
  $statement->execute();
  $results = $statement->rowcount();
  $statement->closeCursor();
  return $results;
  }
