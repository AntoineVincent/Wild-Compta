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

        $camois = "";
        $camoisht = "";

        $reglementsmois = $em->getRepository('ComptaBundle:Reglement')->findByDatereg( "now"|date("m/Y"));

        foreach ($reglementsmois as $reglementmois) {
            $valuemois = $reglementmois->getMontant();
            $camois += $value;
            $camois = number_format((float)($ca), 2, ',', ' ');
            $camoisht += $value / 1.2;
            $camoisht = number_format((float)($caht), 2, ',', ' ');  
        }

        return $this->render('default/dashboard.html.twig', array(
            'ca' => $ca,
            'caht' => $caht,
            'camois' => $camois,
            'camoisht' => $camoisht,
            'ecoles' => $ecoles
        ));
    }
    public function whereCurrentMonth(QueryBuilder $qb)
    {
    $qb
      ->andWhere('a.date BETWEEN :start AND :end')
      ->setParameter('start', new \Datetime(date('m/Y').'-01'))  // Date entre le 1er du mois en cours
      ->setParameter('end',   new \Datetime(date('d/m/Y')))     // Et la date du jour
    ;
    }
}