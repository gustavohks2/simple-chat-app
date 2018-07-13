<?php
   ini_set("display_errors", "On");
   require_once "User.php";
   require_once "../includes/Session.php";

   use App\User;
   $user = new User;

   $session = Session::getInstance();

   if (isset($session->user)) $user->update_last_activity($session->user->user_id);
   exit;