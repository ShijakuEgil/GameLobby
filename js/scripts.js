jQuery(document).ready(function($){
  setInterval(updatePlayers, 1000);

  function updatePlayers(){
    console.log('pre ajax call');
    $.ajax({
        type:"POST",
        url:"functions/ui_updates.php",
        data:{
          'function' : 'players'
        },
        dataType: "json",
        success: function(data){

          for(var i= 0; i < data.length; i++){
            var username = data[i].uName;
            var status = data[i].status;

            $("#players").children("#user").each(function() {
              alert($(this).children().value);
            });
          }
        },
        error: function(xhr, status, errThrown){
          alert(status);
        }

    });
  }

  $(".player").on('click', function(){


  });

});
