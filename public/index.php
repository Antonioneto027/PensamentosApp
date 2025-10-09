<?php 

use Pecee\SimpleRouter\SimpleRouter; 
 
require_once '../vendor/autoload.php';
require_once '../Routes/router.php';
 

SimpleRouter::setDefaultNamespace('Routes');
  
SimpleRouter::start();





?> 