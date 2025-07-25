<?php 

namespace Routes;

use App\Controllers\SiteController;
use Pecee\SimpleRouter\SimpleRouter;
 


 
SimpleRouter::get('/thoughts/', callback: [SiteController::class, 'index']);







?>