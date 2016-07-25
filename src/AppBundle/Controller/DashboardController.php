<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ComptaBundle\Entity\Reglement;

class DashboardController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function dashboardAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $ca = "";
        


        $reglements = $em->getRepository('ComptaBundle:Reglement')->findAll();

        foreach ($reglements as $reglement) {
            $value = $reglement->getMontant();
            $ca += $value;
            $ca = number_format((float)($ca), 2, ',', ' ');
        }

        return $this->render('default/dashboard.html.twig', array(
            'ca' => $ca,
        ));
    }
}