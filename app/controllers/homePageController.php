<?php

namespace app\controllers;

use core\helpers\twigFactory;

class homePageController
{
    private $twig;
    public function __construct()
    {

    }

    public function index()
    {
        $this->twig = twigFactory::getTwig();
        // load the form template
        $template = $this->twig->loadTemplate('homePage.twig');

        // render and pass in the title at the same time
        echo $template->render(array('title' => 'Paste It'));
    }
}