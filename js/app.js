$(document).ready(function () {
   const $chatUsersContainer = $(".js-chat-users"),
      $chatMessagesContainer = $(".js-chat-messages-container"),
      $chatUserHeading = $(".chat__username-heading"),
      $chatTexarea = $(".chat__textarea"),
      $chatMessages = $(".js-chat__messages"),
      sec = 5;

   setInterval(updateUI, sec * 1000);

   function updateLastActivity() {
      $.ajax({
         url: "http://localhost/chat-app/app/update_last_activity.php",
         method: "POST",
         success: function (data) {
            // console.log("Ok!");
         }
      });
   }

   function updateUsers() {
      // Fetch Users
      $.ajax({
         url: "http://localhost/chat-app/app/fetch_users.php",
         method: "POST",
         success: function (data) {
            try {
               const users = JSON.parse(data);
               renderUsers(users);
            } catch (e) { console.error(e); }
         }
      });
   }

   function renderUsers(users) {
      let template = "";

      users.forEach(function (user) {
         const userLastActivity = new Date(user.last_activity).getTime();
         const currentDateTime = new Date().getTime() - 4000;

         const status = userLastActivity > currentDateTime ? "online" : "offline";

         template += `
            <div class="chat__user" data-touser="${user.user_id}">
               <i class="chat__icon fa fa-user fa-2x"></i> 
               <span class="chat__username">${user.username}</span>
               <i class="chat__status chat__status--${status}">&bullet;</i>
            </div>
         `;
      });

      $chatUsersContainer.html(template);
   }

   $chatUsersContainer.click(function (evt) {
      if ($(evt.target).hasClass("chat__user")) {

         if (!$chatMessagesContainer.hasClass("show")) 
            $chatMessagesContainer.addClass("show");

         const $userDiv = $(evt.target);
         const currentChatUser = $userDiv.attr("data-touser");
         $chatUserHeading.text($userDiv.find(".chat__username").text());
         $chatTexarea.attr("data-to", currentChatUser);

         updateCurrentChatHistory(currentChatUser);
      }
   });

   const sendMessage = function() {
      const userfrom_id = $chatTexarea.attr("data-from");
      const userto_id = $chatTexarea.attr("data-to");

      const message = $chatTexarea.val();
      $chatTexarea.val("");

      $.ajax({
         url: "http://localhost/chat-app/app/send-message.php",
         method: "POST",
         data: {userfrom_id, userto_id, message},
         success: function(data) {
            updateCurrentChatHistory(userto_id);  
         },
         error: function(e) {
            console.log(e);
         }
      });
   }

   $chatTexarea.on("keydown", function(evt) {
      const keyCode = evt.which || evt.keyCode;
      if (keyCode === 13) {
         sendMessage();
         evt.preventDefault();
         return false;
      }
   });

   const renderMessages = function(messages, currentChatUser) {
      let template = "";

      messages.forEach(function(message) {
         const leftOrRightMessage = parseInt(currentChatUser) === parseInt(message.fk_from_user) ? "user-to" : "user-from";

         const D = new Date(message.timestamp);

         const timestamp = D.getHours() + ":" + D.getMinutes();

         template += `
            <div class="chat__message chat__message--${leftOrRightMessage}">
               <p class="chat__text">
                  ${message.message}
               </p>
               <span class="chat__timestamp">${timestamp}</span>
            </div>
         `;
      });

      $chatMessages.html(template);
   }

   const updateCurrentChatHistory = function(currentChatUser) {
      $.ajax({
         url: "http://localhost/chat-app/app/fetch_chat_history.php",
         method: "POST",
         data: { to_user: currentChatUser },
         success: function(data) {
            let messages = [];
            try { messages = JSON.parse(data) } catch (e) {} 
            renderMessages(messages, currentChatUser);
         }
      });
   }

   const updateMessages = function() {
      const messageTargetUser = $chatTexarea.attr("data-to")
      if (typeof $chatTexarea.attr("data-to") !== "undefined")
         updateCurrentChatHistory(messageTargetUser);
   }

   function updateUI() {
      updateLastActivity();
      updateUsers();
      updateMessages();
   }
   
   updateUsers();
});