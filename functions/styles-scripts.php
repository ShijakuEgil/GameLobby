<?php
function get_header(){
?>
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
  <link rel="stylesheet" href="css/ionicons.min.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/chat.css">
  <!--JQuery and Chat.js need to be intialized before the body of the website  -->
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="js/chat.js"></script>
<?php
}

function get_footer(){
  ?>
  <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<?php
}

function get_navbar(){?>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" >
      <div class="container-fluid mx-5 position-relative">
       <div class="nav-logo text-dark">
           <i class="icon ion-ios-americanfootball-outline m-0 p-0"></i>
           <i class="icon ion-ios-baseball-outline m-0 p-0"></i>
           <i class="icon ion-ios-basketball-outline m-0 p-0"></i>
           <i class="icon ion-ios-football-outline m-0 p-0"></i>
           <h6 >Game Lobby</h6>
       </div>
       <div class="user-thumbnail">
         <h3 class="text-dark"><?php echo $_SESSION['username']; ?>
           <!-- <span class="badge badge-pill badge-secondary"></span> -->
           <span class="dropleft show">
              <a class="btn btn-secondary btn-sm" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon ion-android-person text-success"></i>
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <form class="" action="index.html" method="post">
                  <a class="dropdown-item" type="submit" name="logout"href="index.php">logOut</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something else here</a>
                </form>

              </div>
            </span>
         </h3>

       </div>
     </div>
   </nav>
  </header>
<?php
}
?>
