<?php

namespace App;

require_once "Database.php";

use App\Database;
use \PDO;

class Model extends Database {

   protected $table;

   public function select($columns = "*", $where = "") {
      $return = null;
      try {
         $sql = "SELECT $columns FROM {$this->table} $where";
         $result = self::$connection->query($sql);
         if (!$rows = $result->fetchAll(PDO::FETCH_OBJ)) 
            $return = [];
         $return = $rows;
      } catch (PDOException $e) {
         echo $e->getMessage();
      }
      return $return;
   }

   // public function update($data, $key) {
   //    $return = false;
   //    try {
   //       $sql = "UPDATE $columns FROM {$this->table} $where";
   //       $result = self::$connection->query($sql);
   //       if (!$rows = $result->fetchAll(PDO::FETCH_OBJ)) 
   //          $return = [];
   //       $return = true;
   //    } catch (PDOException $e) {
   //       echo $e->getMessage();
   //    }
   //    return $return;
   // }
}

   
