<?php 

namespace Routes;

use App\Controllers\SiteController;
use App\Controllers\UserController;
use Pecee\SimpleRouter\SimpleRouter;
 


 
SimpleRouter::get('/thoughts/', callback: [SiteController::class, 'index']);
 

SimpleRouter::group(['prefix' => '/thoughts'], function () {
    SimpleRouter::get('/my_thoughts',  [SiteController::class,'my_thoughts']);
    SimpleRouter::get('/list', [SiteController::class,'list_thoughts']);    
    SimpleRouter::get('/register',  [SiteController::class,'register']);
    SimpleRouter::post('/register', [UserController::class,'register']);      
     });






?>