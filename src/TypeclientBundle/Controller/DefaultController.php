<?php

namespace TypeclientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TypeclientBundle:Default:index.html.twig');
    }
}
