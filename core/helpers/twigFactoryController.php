<?php

namespace core\helpers;



class twigFactory
{
    public static function getTwig()
    {
        // create twig environment and tell it where the templates live
        $loader = new \Twig_Loader_Filesystem('app/templates');

        // set up a twig instance, enable auto-escaping
        return new \Twig_Environment($loader, array('debug' => true,
            'autoescape' => true,
            'auto_reload' => true));
    }
}