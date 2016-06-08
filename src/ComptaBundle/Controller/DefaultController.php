<?php

namespace ComptaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ComptaBundle:Default:index.html.twig');
    }
}
