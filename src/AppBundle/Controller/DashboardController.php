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
use DocumentBundle\Entity\Documents;


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
        $factures = $em->getRepository('DocumentBundle:Documents')->findByType("facture");
        foreach ($factures as $facture) {
            $client = $em->getRepository('ClientBundle:Client')->findOneById($facture->getIdclient());
            $value = $client->getValue();
            $ca += $value;
            $caht += $value * 0.8;  
        }
        
        //DACLERATION VARABLES CA PAR MOIS
        $camois = "";
        $camoisht = "";
        // CALCUL POUR CHAQUE REGLEMENT DU CA ET DU CA HT AU MOIS EN COURS
        $datemois = new \DateTime();
        $facturesmois = $em->getRepository('DocumentBundle:Documents')->findBy(array(
                'type' => "facture",
                'datemois' => $datemois->format('m/Y') 
                ));
        
        foreach ($facturesmois as $facturemois) {
            $client = $em->getRepository('ClientBundle:Client')->findOneById($facturemois->getIdclient());
            $valuemois = $client->getValue();
            $camois += $valuemois;
            $camoisht += $valuemois * 0.8;  
        }

        return $this->render('default/dashboard.html.twig', array(
            'ca' => $ca,
            'caht' => $caht,
            'camois' => $camois,
            'camoisht' => $camoisht,
            'ecoles' => $ecoles,
            'value' => $value
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
        $tabfacture = [];
        $ecole = $this->getRequest()->request->get('ecole');

        if ($ecole == 'Total') {
            $factures = $em->getRepository('DocumentBundle:Documents')->findByType("facture");
            foreach($factures as $facture) {
                $client = $em->getRepository('ClientBundle:Client')->findOneById($facture->getIdclient());
                $value = $client->getValue();
                $caville += $value;
                $cavilleht += $value * 0.8;
            }
            $tabcaville[]=array(
                "cattc"=>$caville,
                "caht"=>$cavilleht,
            );
        }
        else {
            $clients = $em->getRepository('ClientBundle:Client')->findByEcole($ecole);
            foreach ($clients as $client) {
                $factures = $em->getRepository('DocumentBundle:Documents')->findBy(array(
                    'idclient' => $client->getId(),
                    'type' => "facture"
                    ));
                foreach($factures as $facture) {
                    $client = $em->getRepository('ClientBundle:Client')->findOneById($facture->getIdclient());
                    $value = $client->getValue();
                    $caville += $value;
                    $cavilleht += $value * 0.8;
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

    /**
     * @Route("/dashboard/camensubyecole", name="requestajaxtwo")
     */
    public function camensubyecole(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $caville = 0;
        $cavilleht = 0;
        $tabcaville = [];
        $ecole = $this->getRequest()->request->get('ecole');

        $datemois = new \DateTime();
            
        if ($ecole == 'Total') {
            $factures = $em->getRepository('DocumentBundle:Documents')->findBy(array(
                    'type' => "facture",
                    'datemois' => $datemois->format('m/Y') 
                ));
            foreach($factures as $facture) {
                $client = $em->getRepository('ClientBundle:Client')->findOneById($facture->getIdclient());
                $value = $client->getValue();
                $caville += $value;
                $cavilleht += $value * 0.8;
            }
            $tabcaville[]=array(
                "cattc"=>$caville,
                "caht"=>$cavilleht,
            );
        }
        else {
            $clients = $em->getRepository('ClientBundle:Client')->findByEcole($ecole);
            foreach ($clients as $client) {
                $factures = $em->getRepository('DocumentBundle:Documents')->findBy(array(
                    'type' => "facture",
                    'idclient' => $client->getId(),
                    'datemois' => $datemois->format('m/Y') 
                ));
                foreach($factures as $facture) {
                    $client = $em->getRepository('ClientBundle:Client')->findOneById($facture->getIdclient());
                    $value = $client->getValue();
                    $caville += $value;
                    $cavilleht += $value * 0.8;
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