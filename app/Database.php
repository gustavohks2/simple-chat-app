<?php

namespace App;

use \PDO;

class Database {
   const DBMS = "mysql";

   const DB_HOST = "127.0.0.1";
   const DB_NAME = "chat_app";

   const DB_USER = "root";
   const DB_PASSWORD = "gustavo";

   protected static $connection;

   public function __construct() {
      if (!isset(self::$connection)) {
         try {
            $conn = new PDO(self::DBMS.":host=".self::DB_HOST.";dbname=".self::DB_NAME, self::DB_USER, self::DB_PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->exec("SET NAMES utf8");
         } catch(PDOException $e) {
            echo $e->getMessage();
         }
         self::$connection = $conn;
      }
      return self::$connection;
   }
}