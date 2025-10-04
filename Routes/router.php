<?php 

namespace Routes;

use App\Controllers\SiteController;
use App\Controllers\UserController;
use App\Controllers\ThoughtsController;
//use Labs\HashLabs\UserControllerTest;
//use Labs\Test;
//use Labs\Test2;
use Pecee\SimpleRouter\SimpleRouter;
 


 
SimpleRouter::get('/thoughts/', callback: [SiteController::class, 'index']);

  
SimpleRouter::group(['prefix' => '/thoughts'], function () {
    SimpleRouter::get('/my_thoughts',  [SiteController::class,'my_thoughts']);
    SimpleRouter::post('/my_thoughts',  [ThoughtsController::class,'saveThoughts']);
    SimpleRouter::get('/list', [SiteController::class,'list_thoughts']);    
    SimpleRouter::post('/list', [UserController::class,'login']);     
    SimpleRouter::get('/register',  [SiteController::class,'register']); 
    SimpleRouter::post('/register', [UserController::class,'register']);
    //SimpleRouter::post('/register', [UserControllerTest::class,'register']); //Testando
    SimpleRouter::post('/save_thoughts', [ThoughtsController::class, 'saveThoughts']);    
    SimpleRouter::get('/logout', [UserController::class, 'logout']);
    SimpleRouter::get('/confirm', [SiteController::class,'confirm']);
    SimpleRouter::post('/confirm', [UserController::class, 'verifyConfirmationCode' ]);
    SimpleRouter::get('/list', [ThoughtsController::class,'listThoughts']);
    SimpleRouter::post('/delete', callback: [ThoughtsController::class,'deleteThoughts']);
  


     
    

     });

/* SimpleRouter::group(['prefix'=> '/thoughts/labs'], function () {

    SimpleRouter::get('/test', [Test::class,'getUserName']);
    SimpleRouter::get('/test2', [Test2::class,'testarFuncao']);
    SimpleRouter::get('/test3', [Test2::class,'testarFuncao']);











}); */

 



?>