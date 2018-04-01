<?php
include('header.php');?>
<body>
<?php get_navbar(); //display the navbar after login
?>

<script type="text/javascript">

    var name = $('#username-text').text();
  // strip tags
  name = name.replace(/(<([^>]+)>)/ig,"");

  // display name on page
  $("#name-area").html("<span>" + name + "</span>");

  // kick off chat
    var chat =  new Chat();
  $(function(){

     chat.getState();
     //watch textarea for key presses
         $("#sendie").keydown(function(event) {

             var key = event.which;
             //all keys including return.
             if (key >= 33) {

                 var maxLength = $(this).attr("maxlength");
                 var length = this.value.length;

                 // don't allow new content if length is maxed out
                 if (length >= maxLength) {
                     event.preventDefault();
                 }
              }
          });
     // watch textarea for release of key press
     $('#sendie').keyup(function(e) {

        if (e.keyCode == 13) {

          var text = $(this).val();
          var maxLength = $(this).attr("maxlength");
          var length = text.length;

          // send
          if (length <= maxLength + 1) {
            chat.send(text, name);
            $(this).val("");
          }
          else {
          $(this).val(text.substring(0, maxLength));
          }
        }
      });
  });

  jQuery(document).ready(function($){
    // console.log(name);
    // $('[data-toggle="popover"]').popover();
    // var username = $('#username-text').text();
    chat.join('join');
    setInterval('chat.update()', 1000);
  });
</script>
<div class="row lobby-box no-gutters">

    <div class="col-3 players-list">
      <div class="inner-container">
        <h1 class="title">PLAYERS</h1>

        <div class="players" name='players'>
          <div class="players-container">
          <!-- <?php //$player_list = get_players_list();

          //foreach($player_list as $players):?>
          <?php //if( $players['status'] == 'T'):  $badge = 'badge-success'; ?>
          <?php //elseif( $players['status'] == 'G'):$badge = 'badge-warning'; ?>
          <?php// elseif( $players['status'] == 'F'):$badge = 'badge-secondary'; ?>
          <?php //endif; ?>

          <a  id="user" class="player badge <?php //echo $badge; ?>" href="#">
              <?php //echo $players['uName']; ?>
              <div class="user-history">

              </div>
          </a>

          <?php //endforeach; ?> -->
          </div>
        </div>
      </div>
    </div>

    <div id="page-wrap" class="col-6 chat-container">

      <h2 class="text-success">Welcome to Game Loby, <?php the_uname(); ?></h2>

      <p id="name-area"></p>

      <div id="chat-wrap">
        <div id="chat-area">

        </div>
      </div>

      <form id="send-message-area">
          <p>Your message: </p>
          <textarea class="form-control" id="sendie" maxlength = '500' ></textarea>
      </form>

    </div><!--char-container-->


    <div class="col-3 games-list">
      <div class="inner-container container-fluid">
        <h1 class="title">GAMES</h1>
      </div>
    </div>
</div>
<?php include('footer.php'); ?>
