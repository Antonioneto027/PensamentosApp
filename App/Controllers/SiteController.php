<?php

namespace app\Controllers;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
 
class SiteController
{
    private Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader('View/Templates/');
        $this->twig = new Environment($loader);
    }

    public function index(): void
    {
        echo $this->twig->render('index.html.twig');

    }


}