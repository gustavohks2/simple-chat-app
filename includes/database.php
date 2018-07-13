<?php

   define("DBMS", "mysql");

   define("DB_HOST", "127.0.0.1");
   define("DB_NAME", "chat_app");

   define("DB_USER", "root");
   define("DB_PASSWORD", "gustavo");

   try {
      $conn = new PDO(DBMS.":host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $conn->exec("SET NAMES utf8");
   } catch(PDOException $e) {
      echo $e->getMessage();
   }