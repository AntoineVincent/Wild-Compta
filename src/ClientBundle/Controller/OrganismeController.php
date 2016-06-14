<?php

namespace ClientBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ClientBundle\Entity\Organisme;

class OrganismeController extends Controller
{
    public function neworganismeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $neworga = new Organisme;

        $nom = $request->request->get('nom');
        $adresse = $request->request->get('adresse');

        $neworga->setNom($nom);
        $neworga->setAdresse($adresse);

        $em->persist($neworga);
        $em->flush();


        return $this->render('default/neworg.html.twig', array(
            
        ));
    }
}