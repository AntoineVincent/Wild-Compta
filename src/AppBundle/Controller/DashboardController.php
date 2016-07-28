<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ComptaBundle\Entity\Reglement;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use ClientBundle\Entity\Ecole;

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

        // DECLARATION VARIABLES CA ET CA HORS TAXE ANNUEL
        $ca = "";
        $caht = "";
        
        // CALCUL POUR CHAQUE REGLEMENT DU CA ET DU CA HT A L'ANNEE
        $reglements = $em->getRepository('ComptaBundle:Reglement')->findAll();
        foreach ($reglements as $reglement) {
            $value = $reglement->getMontant();
            $ca += $value;
            $ca = number_format((float)($ca), 2, ',', ' ');
            $caht += $value * 0.8;
            $caht = number_format((float)($caht), 2, ',', ' ');    
        }
        
        //DACLERATION VARABLES CA PAR MOIS
        $camois = "";
        $camoisht = "";
        // CALCUL POUR CHAQUE REGLEMENT DU CA ET DU CA HT AU MOIS EN COURS
        $datemois = new \DateTime();
        $reglementsmois = $em->getRepository('ComptaBundle:Reglement')->findByDatemois($datemois->format('m/Y'));
        
        foreach ($reglementsmois as $reglementmois) {
            $valuemois = $reglementmois->getMontant();
            $camois += $valuemois;
            $camois = number_format((float)($camois), 2, ',', ' ');
            $camoisht += $valuemois * 0.8;
            $camoisht = number_format((float)($camoisht), 2, ',', ' ');  
        }

        return $this->render('default/dashboard.html.twig', array(
            'ca' => $ca,
            'caht' => $caht,
            'camois' => $camois,
            'camoisht' => $camoisht,
            'ecoles' => $ecoles
        ));
    }
    /**
     * @Route("/dashboard/cabyecole", name="requestajax")
     */
    public function cabyecole(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $caville = 0;
        $cavilleht = 0;
        $tabcaville = [];
        $ecole = $this->getRequest()->request->get('ecole');

        if ($ecole == 'Total') {
            $reglements = $em->getRepository('ComptaBundle:Reglement')->findAll();
            foreach($reglements as $reglement) {
                $value = $reglement->getMontant();
                $caville += $value;
                $caville = number_format((float)($caville), 2, ',', ' ');
                $cavilleht += $value * 0.8;
                $cavilleht = number_format((float)($cavilleht), 2, ',', ' ');
            }
            $tabcaville[]=array(
                "cattc"=>$caville,
                "caht"=>$cavilleht,
            );
        }
        else {
            $clients = $em->getRepository('ClientBundle:Client')->findByEcole($ecole);
            foreach ($clients as $client) {
                $reglements = $em->getRepository('ComptaBundle:Reglement')->findByIdclient($client->getId());
                foreach($reglements as $reglement) {
                    $value = $reglement->getMontant();
                    $caville += $value;
                    $caville = number_format((float)($caville), 2, ',', ' ');
                    $cavilleht += $value * 0.8;
                    $cavilleht = number_format((float)($cavilleht), 2, ',', ' ');
                }
            }
            $tabcaville[]=array(
                "cattc"=>$caville,
                "caht"=>$cavilleht,
            );
        }

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($tabcaville, 'json');

        $response = new Response($jsonContent);
        return $response;
    }
}