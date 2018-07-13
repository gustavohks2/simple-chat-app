<?php
   require "../includes/database.php";
   require "../includes/commons.php";
   require "../includes/Session.php";

   if ($_SERVER["REQUEST_METHOD"] !== "POST") redirect("../index.php");

   $form = new \stdClass;

   foreach($_POST as $key => $value) { $form->$key = $value; }

   foreach($form as $input => $value) {
      if (!isset($input) || empty($value)) redirect("../index.php");
   }

   $sql = "SELECT * FROM user
           WHERE username = :username 
           LIMIT 1";

   try {

      $stmt = $conn->prepare($sql);
      $stmt->bindParam(":username", $form->username);

      $user = null;
      if ($stmt->execute()) 
         $user = $stmt->fetchObject();
   } catch(PDOException $e) {
      echo $e->getMessage();
   }
   
   if (!$user) redirect("../index.php");
   
   if (!password_verify($form->password, $user->password)) redirect("../index.php");

   $session = Session::getInstance();
   $session->user = $user;
   redirect("../index.php");

   
   

   






   

   





