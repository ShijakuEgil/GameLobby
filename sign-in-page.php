<?php
/*
    @author Egil Shijaku
    Theme: GameLobby
*/
require_once('functions/db_connection.php');
require_once('functions/db_functions.php');
require_once('functions/validateUserInfo.php');
$is_authenticated = false;
$errorNoAccount = '';
//Is this page displayed as result of post submit?
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['signin'])){
  $username = filter_input(INPUT_POST, 'username');
  $password = filter_input(INPUT_POST, 'password');
      // Name and Password can be check against DB
      $isAuthenticated = authenticateAccount($userName, $password);
      // If they are a valid user, take them to Lobby
      if($isAuthenticated){
          // http://php.net/manual/en/function.header.php
          header("Location:lobby.php");
          exit();
      }
      else{
          // let them know an error occured
          $errorNoAccount = "Please try again, no such username and password exists";
      }
      ?>
<?php
} // If not submitting, or if submission in error, then display page
 ?>
  <form class="form-signin" method="post" action="index.php">
    <div class="logo-box text-success">
        <i class="icon ion-ios-americanfootball-outline m-0 p-0"></i>
        <i class="icon ion-ios-baseball-outline m-0 p-0"></i>
        <i class="icon ion-ios-basketball-outline m-0 p-0"></i>
        <i class="icon ion-ios-football-outline m-0 p-0"></i>
        <h1 >Game Lobby</h1>
    </div>
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <!-- <label for="inputEmail" class="sr-only">Email address</label> -->
    <!-- <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus> -->
    <label for="username" class="sr-only">User Name</label>
    <input type="text" id="username" class="form-control" placeholder="Username" required autofocus>
    <label for="password" class="sr-only">Password</label>
    <input type="password" id="password" class="form-control" placeholder="Password" required>
  <?php if($_SESSION['status'] == 'loggedOut'): ?>
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="signin">Sign in</button>
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="new_user">New User</button>
  </form>
<?php endif; ?>
<?php echo $errorNoAccount; ?>
