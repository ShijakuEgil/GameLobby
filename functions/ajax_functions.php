<?php
require_once('database_functions.php');
require_once('session_variables.php');

$function = $_POST['function'];

switch ($function) {
  case 'players':
    $players = get_players_list();
    echo json_encode( $players );
    break;

  case 'get_status_count':
    $f_count = get_status_count();
    $curr_count = get_session_count();
    echo json_encode( $f_count );
    break;
}
