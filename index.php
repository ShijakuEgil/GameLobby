<?php
/*
    @author Egil Shijaku
    Theme: GameLobby
*/
  include('header.php');
  ?>

  <?php
  $is_authenticated = false;
  $errorMsgUser = '';
  $errorMsgPass = '';
  $errorMsgEmail = '';
  $errorNoAccount = '';
  $feedBackMsg = '';
  //Is this page displayed as result of post submit?
  if($_SERVER['REQUEST_METHOD'] == "POST"):
    if(isset($_POST['signin'])){
      $username = filter_input(INPUT_POST, 'username');
      $password = filter_input(INPUT_POST, 'password');
         // Name and Password can be check against DB
      $isAuthenticated = authenticateAccount($username, $password);
         // If they are a valid user, take them to Lobby
      if($isAuthenticated){
             // http://php.net/manual/en/function.header.php
        $_SESSION['username'] = $username;
        header("Location:lobby.php");
             exit();
         }
      else{
             // let them know an error occured
             $errorNoAccount = '<p class="text-danger">Please try again, no such username and password exists</p>';
         }
       }
       if(isset($_POST['register'])){
         $username = filter_input(INPUT_POST, 'username');
         $password = filter_input(INPUT_POST, 'password');
         $email = filter_input(INPUT_POST, 'email');
         if(validate_username($username, $errorMsgUser)
            && validate_password($password, $errorMsgPass)
            && validate_email($email, $errorMsgEmail)){
              //Name and Password can be check against DB
              $isRegistered = addUser($username, $password, $email);

              if($isRegistered){
                  $feedBackMsg = '<p class="text-success">
                  Congrats you are registered, please <a href=index.php>login</a></p>';
              }
              else{
                  // let them know an error occured, likely duplicate username
                  $feedBackMsg = '<p class="text-warning">Please try again with a different username</p>';
              }
            }
       }
       ?>
 <?php
endif; // If not submitting, or if submission in error, then display page
  ?>
  <body>
   <form class="form-signin" method="post" action="index.php">
     <div class="logo-box text-success">
         <i class="icon ion-ios-americanfootball-outline m-0 p-0"></i>
         <i class="icon ion-ios-baseball-outline m-0 p-0"></i>
         <i class="icon ion-ios-basketball-outline m-0 p-0"></i>
         <i class="icon ion-ios-football-outline m-0 p-0"></i>
         <h1 >Game Lobby</h1>
     </div>
     <?php if(isset($_POST['new-user']) || isset($_POST['register'])):?>
     <h1 class="h3 mb-3 font-weight-normal">Fill out form to register</h1>
   <?php else: ?>
      <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <?php endif; ?>

     <?php if(isset($_POST['new-user']) ||isset($_POST['register'])):?>
     <label for="email" class="sr-only">Email address</label>
     <input type="email" id="email" class="form-control" name="email" placeholder="Email address" required>
      <?php endif; ?>

     <label for="username" class="sr-only">User Name</label>
     <input type="text" id="username" class="form-control" name="username" placeholder="Username" required >
     <label for="password" class="sr-only">Password</label>
     <input type="password" id="password" class="form-control" name="password" placeholder="Password" required>

      <?php if(isset($_POST['new-user'])||isset($_POST['register']) ):?>
     <button class="btn btn-lg btn-primary btn-block" type="submit" name="register">Register</button>
   <?php endif; ?>

    <?php if(!isset($_POST['new-user']) && !isset($_POST['register'])):?>
     <button class="btn btn-lg btn-primary btn-block" type="submit" name="signin">Sign in</button>
   </form>
   <form class="form-new-user" method="post" action="index.php">
     <button class="btn btn-lg btn-primary btn-block" type="submit" name="new-user">New User</button>
      <?php endif; ?>

      <?php echo $errorNoAccount;
            // echo $errorMsgUser;
            // echo $errorMsgPass;
            // echo $errorMsgEmail;
            echo $feedBackMsg;
      ?>
   </form>

<?php include('footer.php'); ?>
