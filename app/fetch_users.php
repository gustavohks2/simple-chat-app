<?php

   ini_set("display_errors", "On");

   require_once "../includes/Session.php";
   require_once "User.php";
   use App\User;

   $session = Session::getInstance();

   if (isset($session->user)) {
      $user = new User;
      $users = $user->select("u.user_id, u.username, ld.last_activity", 
      "u INNER JOIN login_details ld
       ON u.user_id = ld.login_details_id
       WHERE u.username <> '{$session->user->username}'");
      
      foreach($users as $key => $value) {
         $users[$key]->last_activity = strtotime($users[$key]->last_activity) * 1000;
      }

      echo json_encode($users);
      exit;
   }

