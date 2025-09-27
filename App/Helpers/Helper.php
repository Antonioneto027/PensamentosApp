<?php

namespace App\Helpers;

class Helper {



    public function startSession() {


        session_start();


    }

    public function hashEmail($email) { 

         // Normalize the email (lowercase and trim)
         $normalizedEmail = strtolower(trim($email));
    
    // Hash using SHA-256 (more secure than SHA-1)
         return hash('sha256', $normalizedEmail);

    }

    public function confCode() {

        $random_hash = substr(md5(uniqid(rand(), true)), 6, 6); 

        return $random_hash;

    }

    }
















?>