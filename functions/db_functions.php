<?php
/*
    @author Egil Shijaku
    Theme: GameLobby
*/
function authenticateAccount($userName, $password){
    global $db_db;
    $password = sha1($userName . $password);
    $query = 'SELECT username FROM Account
              WHERE username = :user AND password = :password';
    $statement = $db_db->prepare($query);
    $statement->bindValue(':user', $userName);
    $statement->bindValue(':password', $password);
    $statement->execute();
    $isValid = ($statement->rowcount() == 1);
    $statement->closeCursor();
    if($isValid){
        // Update their playerState to logged in
        $query = 'UPDATE playerstate
                SET state = "in"
                WHERE username = :user';
        $statement2 = $db_db->prepare($query);
        $statement2->bindValue(':user', $userName);
        $statement2->execute();
        $statement2->closeCursor();
    }
    return $isValid;
}

//logOut user
function db_logOut_user($username){
  global $db_db;
  $query = 'UPDATE playerstate
          SET state = DEFAULT
          WHERE username = :user';
  $statement2 = $db_db->prepare($query);
  $statement2->bindValue(':user', $username);
  $statement2->execute();
  $statement2->closeCursor();
}

//Register function:
function addUser($userName, $password, $email){
    global $db_db;
    // First check this username is unique
    $query = 'SELECT username FROM Account
              WHERE username = :user';
    $statement = $db_db->prepare($query);
    $statement->bindValue(':user', $userName);
    $statement->execute();
    $isUnique = ($statement->rowcount() < 1);
    $statement->closeCursor();
    // Go insert the new entr
    if($isUnique){
        $password = sha1($userName . $password);
        $query = 'INSERT INTO Account (username, password, email)
              VALUES (:user, :password, :email)';
        $statement2 = $db_db->prepare($query);
        $statement2->bindValue(':user', $userName);
        $statement2->bindValue(':password', $password);
        $statement2->bindValue(':email', $email);
        $statement2->execute();
        $statement2->closeCursor();
        // Also inser their corresponding PlayerState record
        // default values are taken care of by database
        $query = 'INSERT INTO PlayerState (username)
              VALUES (:user)';
        $statement3 = $db_db->prepare($query);
        $statement3->bindValue(':user', $userName);
        $statement3->execute();
        $statement3->closeCursor();
    }
    return $isUnique;
}

// return the rows for games list
// only going to be rock paper scissor/tic-tac-toe
// so may as well return statistics
// UP TO CALLER to parse the records returned
function db_getGameList(){
    global $db_db;
    // First check this username is unique
    $query = 'SELECT * FROM Game
              ORDER BY gamename ASC';
    $statement = $db_db->prepare($query);
    $statement->execute();
    $gameRows = $statement->fetchAll();
    $statement->closeCursor();
    return $gameRows;
} // have not tested this function yet


function db_getGameStat($gameName){
    global $db_db;
    // First check this username is unique
    $query = 'SELECT (numPlayed, lastPlayed) FROM Game
              WHERE gamename = :gamename';
    $statement = $db_db->prepare($query);
    $statement->bindValue(':gamename', $gameName);
    $statement->execute();
    $gameStat = $statement->fetch();
    $statement->closeCursor();
    return $gameStat;

}

function db_getPlayerStates(){
    global $db_db;
    // First check this username is unique
    $query = 'SELECT (username, state) FROM PlayerStates
              ORDER BY username ASC';
    $statement = $db_db->prepare($query);
    $statement->execute();
    $playerStateRows = $statement->fetchAll();
    $statement->closeCursor();
    /*Could now parse in this manner:
     * $count = 0;
     * foreach($playerStateRows as $record){
     *      $playerNames[$count] = $record['username'];
     *      $playerState[$count] = $record['state'];
     *      count++;
     * }
     *
     */
    return $playerStateRows;
} // not yet tested

// Return one record for this user
// W/L/D/time last game was played
function db_getPlayerStat($userName){
    global $db_db;
    // First check this username is unique
    $query = 'SELECT (win, loss, draw, lastgame) FROM PlayerStates
              WHERE username = :user';
    $statement = $db_db->prepare($query);
    $statement->bindValue(':user', $userName);
    $statement->execute();
    $playerStateStat = $statement->fetch();
    $statement->closeCursor();
    /*Could now parse in this manner:
     * $count = 0;
     * foreach($playerStateRows as $record){
     *      $playerNames[$count] = $record['username'];
     *      $playerState[$count] = $record['state'];
     *      count++;
     * }
     *
     */
    return $playerStateStat;
} // not yet tested

// Set the user to the "awaitchallenge" state
// if false is return, do nothing and await a challenger
// else if true is returned, means user should be directed to current game
function db_openChallenge($userName){
    global $db_db;
    // first check if already committed to another game
    // and redirect into it, can tell by if player has an opponent
    $isAlreadyInGame = false;
    $query = 'SELECT (state, currentopponent, isChallenger)
              FROM PlayerState
              WHERE username = :user';
    $statement = $db_db->prepare($query);
    $statement->bindValue(':user', $userName);
    $statement->execute();
    $statement->closeCursor();
    if($statement['currentopponent'] != "none"){
        $isAlreadyInGame = true;
        // Be sure they are ingame status, may have switched to loggedin
        // if had lost connect and re-entered site
        $query = 'UPDATE PlayerState
              SET state = "ingame"
              WHERE username = :user';
        $statement2 = $db_db->prepare($query);
        $statement2->bindValue(':user', $userName);
        $statement2->execute();
        $statement2->closeCursor();
    }
    //else await a challenger
    if(!$isAlreadyInGame){
        $query = 'UPDATE PlayerState
                  SET state = "awaitchallenge"
                  WHERE username = :user';
        $statement3 = $db_db->prepare($query);
        $statement3->bindValue(':user', $userName);
        $statement3->execute();
        $statement3->closeCursor();
    }
    return $isAlreadyInGame; // caller responsible to handle true condition
}

// User only knows to enter a game when they have an opponent
// If no opponent, return false else return true
// and store opponent name inside pass by ref var
function db_queryCheckOpponent($userName,& $curOpponent){
    global $db_db;
    $query = 'SELECT currentopponent FROM PlayerStates
              WHERE username = :user';
    $statement = $db_db->prepare($query);
    $statement->bindValue(':user', $userName);
    $statement->execute();
    $opponentName = $statement->fetch();
    $statement->closeCursor();
    if(is_null($opponentName['currentopponent'])){
        return false;
    }
    else{
        $curOpponent = $opponentName['currentopponent'];
        return true;
    }
} // Has not been tested, check that the associate array value is retrieved

// Makes sense if user withdraws challenge, they do so
// from logged in position of the lobby
function db_withdrawOpenChallenge($userName){
    global $db_db;
    $query = 'UPDATE PlayerState
              SET state = "loggedin"
              WHERE username = :user';
    $statement = $db_db->prepare($query);
    $statement->bindValue(':user', $userName);
    $statement->execute();
    $statement->closeCursor();
}

// The complicated scenario:
// Must know who is accepting the challenge
// Who is opponent
// game name
// And create the game, unless its already on-going, then
// just ensure playerState is correct and allow game to continue
function db_acceptChallenge($challenger, $opener, $gameName){
    $gameID; // May not need to return this, handled by DB
    $gameFileName = $gameName . "-" . $challenger . "-" . $opener;
    // is this a new game or on-going?
    // TO-DO make f_isGameEnded
    if(f_isGameEnded($gameFileName)){
        // initialize for a new game
        // update game info
        db_incrementGameStats($gameName);
        // update playerStates
        db_gameInitPlayerStates($challenger, $opener);
        // insert new GameHistory and get it's record ID
        $gameID = db_initGameHistory($gameFileName);
        f_makeNewGame($gameFileName, $gameID); // TO-DO make f_makeNewGame
    }
    else{
        // game already exists, only thing to do is perhaps make sure they are in-game state
        // do nothing, either they have abandoned game for new game
        // or they opened a game, and should be redirected to prev. game
        // via the openGame request

    }
}

function db_incrementGameStats($gameName){
    global $db_db;
    // increment num played and update time
    $query = 'UPDATE Game
              SET numPlayed = numPlayed + 1,
              lastPlayed = NOW()
              WHERE gamename = :gamename';
    $statement = $db_db->prepare($query);
    $statement->bindValue(':gamename', $gameName);
    $statement->execute();
    $statement->closeCursor();
}

// playerStates table must know these platers are now in-game
// and set their lastGame time, and who is the challenger
function db_gameInitPlayerStates($challenger, $opener){
    global $db_db;
    // update challenger state first
    $query = 'UPDATE PlayerState
              SET state = "ingame",
              lastgametime = NOW(),
              isChallenger = "yes",
              currentopponent = :opener
              WHERE username = :challenger';
    $statement = $db_db->prepare($query);
    $statement->bindValue(':opener', $opener);
    $statement->bindValue(':challenger', $challenger);
    $statement->execute();
    $statement->closeCursor();
    // Update opener as well
    $query = 'UPDATE PlayerState
              SET state = "ingame",
              lastgametime = NOW(),
              isChallenger = "no"
              WHERE username = :opener';
    $statement2 = $db_db->prepare($query);
    $statement2->bindValue(':opener', $opener);
    $statement2->execute();
    $statement2->closeCursor();
}

// init a new game, many vals autoaccounted for, return gameID
function db_initGameHistory($gameFileName){
    global $db_db;
    $query = 'INSERT INTO GameHistory (gamefile)
              VALUES (:gamefname)';
    $statement = $db_db->prepare($query);
    $statement->bindValue(':gamefname', $gameFileName);
    $statement->execute();
    $gameID = $db_db->lastInsertId();
    $statement->closeCursor();
    return $gameID;
}

 ?>
