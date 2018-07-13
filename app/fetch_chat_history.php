<?php
   ini_set("display_errors", "On");
   require_once "User.php";
   require_once "../includes/Session.php";

   use App\User;
   $user = new User;

   $session = Session::getInstance();

   $messages = $user->fetch_chat_history($session->user->user_id, $_POST["to_user"]);

   foreach($messages as $key => $value) {
      $messages[$key]->timestamp = strtotime($messages[$key]->timestamp) * 1000;
   }

   echo json_encode($messages);

   