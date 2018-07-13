<?php
   ini_set("display_errors", "On");
   require_once "User.php";
   require_once "../includes/Session.php";

   $userfrom_id = $_POST["userfrom_id"];
   $userto_id = $_POST["userto_id"];
   $message = $_POST["message"];

   use App\User;
   $user = new User;

   $session = Session::getInstance();

   if ($user->save_message($userfrom_id, $userto_id, $message))
      echo true;