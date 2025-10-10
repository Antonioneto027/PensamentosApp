<?php

namespace App\Helpers;

class Helper {



    public function startSession() {


        session_start();


    }

    public function hashEmail($email) { 

      
         $normalizedEmail = strtolower(trim($email));
    
    
         return hash('sha256', $normalizedEmail);

    }

    public function confCode() {

        $random_hash = substr(md5(uniqid(rand(), true)), 6, 6); 

        return $random_hash;

    }

    }
















?>