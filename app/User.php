<?php

namespace App;

require_once "Model.php";

use App\Model;
use \PDO;

class User extends Model {
   
   protected $table = "user";

   public function update_last_activity($user_id) {
      $return = false;
      try {
         $sql = "UPDATE login_details
                 SET last_activity = now()
                 WHERE login_details_id = '$user_id'";
         if (self::$connection->exec($sql) > 0) 
            $return = true;
            
         $return = false;
      } catch (PDOException $e) {
         echo $e->getMessage();
      }
      return $return;
   }

   public function save_message($from, $to, $message) {
      $return = false;
      try {
         $sql = "INSERT INTO chat (fk_from_user, fk_to_user, message, timestamp)
                 VALUES (:from_user, :to_user, :message, now())";
         
         $stmt = self::$connection->prepare($sql);
         $stmt->bindParam(":from_user", $from);
         $stmt->bindParam(":to_user", $to);
         $stmt->bindParam(":message", $message);

         $return = $stmt->execute();

      } catch (PDOException $e) {
         echo $e->getMessage();
      }
      return $return;
   }

   public function fetch_chat_history($from_user, $to_user) {
      $return = null;
      try {
         $sql = "SELECT * FROM chat 
                 WHERE (fk_from_user = :from_user AND fk_to_user = :to_user)
                 OR (fk_to_user = :from_user AND fk_from_user = :to_user)
                 ORDER BY timestamp";
         
         $stmt = self::$connection->prepare($sql);
         $stmt->bindParam(":from_user", $from_user);
         $stmt->bindParam(":to_user", $to_user);

         $stmt->execute();

         if (!$rows = $stmt->fetchAll(PDO::FETCH_OBJ)) $return = false;

         $return = $rows;

      } catch (PDOException $e) {
         echo $e->getMessage();
      }
      return $return;
   }
}

   
