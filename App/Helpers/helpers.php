<?php



class Helpers {



    public function startSession() {


        session_start();


    }

    public function hashEmail($email) { 

         // Normalize the email (lowercase and trim)
         $normalizedEmail = strtolower(trim($email));
    
    // Hash using SHA-256 (more secure than SHA-1)
         return hash('sha256', $normalizedEmail);




    }











}







?>