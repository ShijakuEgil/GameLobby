<?php
  session_start();
  date_default_timezone_set("America/New_York");
  $namecheck = ' ';
  $function = $_POST['function'];

  $log = array();

  switch($function) {

    case('getState'):
      if(file_exists('chat.txt')){
        $lines = file('chat.txt');
      }
      $log['state'] = count($lines);
    break;

    case('update'):
      $state = $_POST['state'];

      if(file_exists('chat.txt')){

        $lines = file('chat.txt');
      }
      $count =  count($lines);

      if($state == $count){
        $log['state'] = $state;
        $log['text'] = false;
      }
      else{
        $text= array();
        $log['state'] = $state + count($lines) - $state;

        foreach ($lines as $line_num => $line){

          if($line_num >= $state){
            $text[] =  $line = str_replace("\n", "", $line);
        	}
        }

        $log['text'] = $text;
      }
      break;

    	case('send'):
        $nickname = htmlentities(strip_tags($_POST['nickname']));
			  $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
        $message = htmlentities(strip_tags($_POST['message']));
		    if(($message) != "\n"){

			       if(preg_match($reg_exUrl, $message, $url)) {
       			     $message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message);
				     }

                 fwrite(fopen('chat.txt','a'), "<span id='name'>" . $nickname . "</span><span id='time'> at ". date('Y-m-d h:i:sa') . "</span><span id='text' class='text'>" . $message = str_replace("\n", " ", $message) . "</span>" . "\n");

     }
     break;
      case 'join':
        $username = $_POST['nickname'];
        fwrite(fopen('chat.txt', 'a'), '<small class="text-info">'.$username.' has joined the lobby.</small>' ."\n");
      break;

    case 'leave':
      $username = $_POST['nickname'];
      fwrite(fopen($_SERVER['DOCUMENT_ROOT'].'chat.txt', 'a'), '<small class="text-warning">'.$username.' has left the lobby.</small>' ."\n");
    break;
  }
    echo json_encode($log);

?>
