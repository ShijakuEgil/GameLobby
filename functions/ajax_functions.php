<?php
require_once('database_functions.php');

$function = $_POST['function'];

switch ($function) {
  case 'players':
    $players = get_players_list();
    echo json_encode( $players );
    break;
    case 'get_status_count':
      if( get_status_count() ){
        return 1;
      }
      elseif( !get_status_count() ){
        return 0;
      }



    break;
}
