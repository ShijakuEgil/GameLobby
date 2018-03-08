<?php
/*
    @author Egil Shijaku
    Theme: GameLobby
    Functions for communicationg with databse
*/

//Verify the user log in
function verify_user($username, $password){
  global $db_db;
  $password = sha1($username . $password);
  $query = 'SELECT uName FROM users
            WHERE  uName = :username AND password = :password';
  $statement = $db_db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->bindValue(':password', $password);
  $statement->execute();
  if($statement->rowcount() == 0){
    return false;
  }
  else{
    return true;
    session_start();
    $_SESSION['UID'] = $statment->lastInsertId();
  }
  $statement->closeCursor();
}

// add a new user in the databasez
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
