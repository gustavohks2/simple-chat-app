<?php 
   ini_set("display_errors", "On");

   require_once "includes/Session.php";
   $session = Session::getInstance();
?>
<!DOCTYPE html>
<html lang="pt-br">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="css/style.css">
      <title>Login - Chat App</title>
   </head>
   <body>
      <?php if (!isset($session->user) || empty($session->user)) : ?>

      <form action="app/login.php" method="POST" class="login">
         <div class="login__input-group">
            <label for="username">Username</label>
            <input id="username" type="text" name="username">
         </div>
         <div class="login__input-group">
            <label for="password">Password</label>
            <input id="password" type="password" name="password">
         </div>
         <button class="login__button" type="submit">Login</button>
      </form>

      <?php else : ?>

      <section class="chat">
         <div class="chat__messages-container js-chat-messages-container">
            <div class="chat__current-info">
               <i class="chat__user-icon fa fa-user-circle-o fa-3x"></i>
               <h3 class="chat__username-heading"></h3>
            </div>
            <div class="chat__container">
               <div class="chat__messages js-chat__messages">
               </div>
            </div>
            <div class="chat__textbox-control">
               <textarea class="chat__textarea" spellcheck="false" data-from="<?=$session->user->user_id?>"></textarea>   
            </div>
         </div>
         <div class="chat__users js-chat-users">
         </div>
      </section>
      
      <?php endif ?>

      <script src="js/jquery-3.3.1.min.js"></script>
      <script src="js/app.js"></script>
   </body>
</html>