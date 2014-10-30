<?php
namespace app\controllers;

use app\models\userModel;
use core\helpers\twigFactory;

class SignUpController
{
    private $twig;
    public function __construct()
    {

    }

    public function index()
    {
        $this->twig = twigFactory::getTwig();
        // load the form template
        $template = $this->twig->loadTemplate('SignUp.twig');

        // render and pass in the title at the same time
        echo $template->render(array('title' => 'Paste It'));
    }

    public function SignUp()
    {
        $user = new userModel();
        $user->AddUser($_POST['email'], $_POST['password'], $_POST['full_name']);
        header( 'Location: /' ) ;
    }
}