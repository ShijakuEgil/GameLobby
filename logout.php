<?php
require_once('functions/db_connection.php');
require_once('functions/database_functions.php');
require_once('functions/session_variables.php');
$username = get_uname();
if(destroy_session()) // Destroying All Sessions
{
set_user_status('F', $username);
header("Location: index.php"); // Redirecting To Home Page
}
