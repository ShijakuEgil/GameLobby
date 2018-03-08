<?php
    // Following John Baugh's template from handout for connecting to db
    // according to following link I can use the PDO like mysql even though its mariadb
    // https://stackoverflow.com/questions/16195013/pdo-and-mariadb
    // $db_dataSourceName = 'mysql:host=localhost;dbname=gamelobbydb'; // game lobby DB
    $db_dataSourceName = 'mysql:host=localhost;dbname=globbydb';
    $db_username = 'root'; //replace w/ your own
    $db_password = ''; // replace w/ your own
    $db_dbErrorMsg = ""; // Echo this out if your having problems, might give hint as to whats wrong
    $db_db = NULL; // Initialize to null
    //try connecting to DB
    try{
        $db_db = new PDO($db_dataSourceName, $db_username, $db_password);
        //https://phpdelusions.net/pdo#errors
        $db_db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        $db_isDbConnect = true;
    }
    catch(PDOException $e){
        $db_error_message = $e->getMessage();
        $db_dbErrorMsg .=  $db_error_message;
        echo '<p>PDOEXCEPTION: ' . $db_dbErrorMsg . '</p>';
        exit();
    }
?>
