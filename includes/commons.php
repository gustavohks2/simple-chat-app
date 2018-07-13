<?php

function redirect($location, $exit = true) {
   header("Location: " . $location);
   if ($exit) exit;
}