jQuery(document).ready(function($){

  setTimeout(load_players,500);

  function load_players(){

    $.ajax({
      type: 'POST',
      url: 'functions/ajax_functions.php',
      data: {
        'function' : 'players'
      },
      dataType:'JSON',
      error: function(status){
        console.log(status);
      },
      success: function(data){
        for(var i = 0; i < data.length; i++){
          var username = data[i].uName;
          var status = data[i].status;
          var badge;
          if ( status ==='T' ){
            badge = 'badge-success';
            console.log(badge);
          }
          else if( status ==='F' ){
            badge = 'badge-secondary';
            console.log(badge);
          }
          else if( status ==='G' ){
            badge = 'badge-warning';
            console.log(badge);
          }
          $( '.players-container' ).append (
            '<a class="player badge '+ badge + '" data-status="'+ status +'">'+
                            username +
                '<div class="user-history"></div>'+
            '</a>'
          );
        }
      }
    });
    update_ui();
  }//load_players()

function update_ui(){

  setInterval(function(){

    console.log('inside update ui');

    $.ajax({
      type:'POST',
      url: 'functions/ajax_functions.php',
      data:{
        'function': 'get_status_count'
      },
      success: function(data){

        console.log(data);

      }
    });
  },1000);
}


  $(".players-container").on('click', '.player', function(){
    $(".player").each(function(){
      if($(this).data("status")==='G'){
        $(this).removeClass();
      }
    });
  });


  //   setTimeout(interval, 5000);
  //
  //   function interval(){
  //
  //     setInterval(function(){
  //       var url = 'lobby.php';
  //       $.ajax({
  //         type:'POST',
  //         url:'functions/ajax_functions.php',
  //         data:{
  //           'function' : 'get_status_count'
  //         },
  //         success: function(data){
  //           if(data){
  //             $(".players").load(url + " .players-container");
  //           }
  //         }
  //       });
  //     }, 1000);
  // }
  // $(".players").on('click', '#user', function(){
  //   alert('click');
  // });

});
