<?php

namespace App\Controllers;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
 
class SiteController
{
    private Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader('../App/View/Templates');
        $this->twig = new Environment($loader);
    }

    public function index(): void
    {
        echo $this->twig->render('index.html.twig');

    }
    
      public function my_thoughts(): void
    {
        echo $this->twig->render('input.html.twig');

    }

       public function list_thoughts(): void
        {
                if ($_SERVER['REQUEST_URI'] === '/thoughts/public/list') {
                $controller = new \App\Controllers\ThoughtsController();
                $result = $controller->listThoughts();
                $rows = $result->fetchAll(\PDO::FETCH_ASSOC);
                echo $this->twig->render('list.html.twig', ['result' => $rows]);
                session_abort();
            }
        }

    public function register(): void
    {
       
        echo $this->twig->render('register.html.twig');

    }


        public function confirm(): void
    {
       
        echo $this->twig->render('confirmation_screen.html.twig');

    }


}