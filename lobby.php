<?php include('header.php'); ?>
<body onload="setInterval('chat.update()', 1000)">
<?php get_navbar(); ?>
<script type="text/javascript">

    // ask user for name with popup prompt
    // var name = prompt("Enter your chat name:", "Guest");
    var name = 'Egi';

    // default name is 'Guest'
  if (!name || name === ' ') {
     name = "Guest";
  }

  // strip tags
  name = name.replace(/(<([^>]+)>)/ig,"");

  // display name on page
  $("#name-area").html("You are: <span>" + name + "</span>");

  // kick off chat
    var chat =  new Chat();
  $(function() {

     chat.getState();

     // watch textarea for key presses
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

                } else {

          $(this).val(text.substring(0, maxLength));

        }


        }
         });

  });
</script>
<!-- <div class="lobby-box container-fluid row no-gutters"> -->

    <!-- <div class="col-xs-3 players-list">
        <h1>testing</h1>
    </div> -->

    <div id="page-wrap" class="col-xs-5 chat-container">

        <h2 class="text-success">Welcome to Game Loby, <?php echo $_SESSION['username']; ?></h2>

        <p id="name-area"></p>

        <div id="chat-wrap"><div id="chat-area"></div></div>

        <form id="send-message-area">
            <p>Your message: </p>
            <textarea id="sendie" maxlength = '100' ></textarea>
        </form>

    </div><!--char-container-->

    <!-- <div class="col-xs-3 games-list">
        <h1>testing</h1>
    </div> -->
<!-- </div> -->
<?php include('footer.php'); ?>
