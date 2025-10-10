<?php 

use Pecee\SimpleRouter\SimpleRouter; 
 
require_once '../vendor/autoload.php';
require_once '../Routes/router.php';
 

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

 


SimpleRouter::setDefaultNamespace('Routes');
  
SimpleRouter::start();





?> 