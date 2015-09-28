<?php

namespace app\controllers;

use app\models\userModel;
use core\helpers\twigFactory;

class CertificationController
{
    private $twig;
    public function index()
    {
        $this->twig = twigFactory::getTwig();
        // load the form template
        $template = $this->twig->loadTemplate('certification.twig');
        $error = 'no';
        if(!empty($_GET['q']))
        {
            $error = "yes";
        }
        echo $template->render(['error' => $error]);
    }

    public function agree()
    {
        $user = new userModel();
        $user->makeCertified();
        header( 'Location: /survivor' ) ;
    }
}