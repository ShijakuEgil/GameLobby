<?php
require_once('database_functions.php');
$ui_function = $_POST['function'];

switch( $ui_function ){

  case( 'players' ):

  $players = get_players_list();

  break;

}

  echo json_encode( $players );
