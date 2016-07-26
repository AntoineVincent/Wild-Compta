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

        $ecoles = $em->getRepository('ClientBundle:Ecole')->findAll();
        $ecolerslt = $request->request->get('ecole');

        $ca = "";
        $caht = "";

        $reglements = $em->getRepository('ComptaBundle:Reglement')->findAll();

        foreach ($reglements as $reglement) {
            $value = $reglement->getMontant();
            $ca += $value;
            $ca = number_format((float)($ca), 2, ',', ' ');
            $caht += $value / 1.2;
            $caht = number_format((float)($caht), 2, ',', ' ');
            
        }

        return $this->render('default/dashboard.html.twig', array(
            'ca' => $ca,
            'caht' => $caht,
            'ecoles' => $ecoles
        ));
    }
}