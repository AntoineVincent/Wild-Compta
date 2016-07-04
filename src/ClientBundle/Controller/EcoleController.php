<?php

namespace ClientBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ClientBundle\Entity\Ecole;

class EcoleController extends Controller
{
    public function newecoleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $newecole = new Ecole;

        $ville = $request->request->get('ville');
        $adresse = $request->request->get('adresse');

        $newecole->setVille($ville);
        $newecole->setAdresse($adresse);

        $em->persist($newecole);
        $em->flush();


        return $this->render('default/newecole.html.twig', array(
            
        ));
    }
    public function listeecoleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $ecoles = $em->getRepository('ClientBundle:Ecole')->findAll();

        return $this->render('default/listeecole.html.twig', array(
            'ecoles' => $ecoles,
        ));
    }

}