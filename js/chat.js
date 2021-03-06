var instanse = false;
var state;
var mes;
var file;

function Chat() {
    this.update = updateChat;
    this.send = sendChat;
    this.getState = getStateOfChat;
    this.join = notifyChat;
}

//gets the state of the chat
function getStateOfChat(){
  console.log('getstateofchat');
	if(!instanse){
            instanse = true;
            $.ajax({
                type: "POST",
                url: "process.php",
                data: {'function': 'getState','file': file},
                dataType: "json",
		success: function(data){
                    state = data.state;
                    instanse = false;},
            });
        }
}

//Updates the chat
function updateChat(){
  console.log('updateChat');
	 if(!instanse){
		 instanse = true;
	     $.ajax({
                type: "POST",
                url: "process.php",
                data: { 'function': 'update',
                        'state': state,
                        'file': file
                        },
                dataType: "json",
                success: function(data){
                        if(data.text){
                            for (var i = 0; i < data.text.length; i++) {
                            $('#chat-area').append($("<p>"+ data.text[i] +"</p>"));
                        }
            }
            document.getElementById('chat-area').scrollTop = document.getElementById('chat-area').scrollHeight;
            instanse = false;
            state = data.state;},
			});
	 }
	 else {
		 setTimeout(updateChat, 1500);
	 }
}

//send the message
function sendChat(message, nickname)
{
    updateChat();
     $.ajax({
		   type: "POST",
		   url: "process.php",
		   data: {
                        'function': 'send',
                        'message': message,
                        'nickname': nickname,
                        'file': file
				 },
		   dataType: "json",
		   success: function(data){
			   updateChat();
		   },
		});
}

// notify other users that you have joined the lobby
function notifyChat(func){
  console.log(func);
  console.log(name);
  updateChat();
  $.ajax({
    type: 'POST',
    url:  'process.php',
    data: {
                      'function': func,
                      'nickname': name,
                      'file': file

    },
    dataType: 'json',
    error: function(status){
      console.log('error');
      console.log(status);
    },
    success: function(data){
      console.log(data);
      updateChat();
    },
  });
}
//
// function leave_lobby(){
//   var username = $('#username-text').text();
//   updateChat();
//   $.ajax({
//     type: 'POST',
//     url:  'process.php',
//     data: {
//                       'function': 'leave',
//                       'nickname': username,
//                       'file': file
//
//     },
//     dataType: 'json',
//     success: function(data){
//       updateChat();
//     },
//   });
// }
