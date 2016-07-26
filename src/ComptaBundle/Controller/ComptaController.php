<?php

namespace ComptaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ClientBundle\Entity\Client;
use ComptaBundle\Entity\Reglement;
use DocumentBundle\Entity\Documents;
use ComptaBundle\Form\ReglementType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;


class ComptaController extends Controller
{
    public function reglementAction(Request $request, $idclient)
    {
    	$em = $this->getDoctrine()->getManager();

        $client = $em->getRepository('ClientBundle:Client')->findOneById($idclient);
        $document = $em->getRepository('DocumentBundle:Documents')->findOneByIdclient($idclient);
        $ecoles = $em->getRepository('ClientBundle:Ecole')->findAll();

        $reglement = new Reglement();
        $form = $this->createForm('ComptaBundle\Form\ReglementType', $reglement);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $scan = $reglement->getUploadscan();

            $scanName = md5(uniqid()).'.'.$scan->guessExtension();
            $scanDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads/scan';
            $scan->move($scanDir, $scanName);

            $date = $request->request->get('date');

            $reglement->setUploadscan($scanName);
            $reglement->setIddocument($document->getId());
            $reglement->setIdclient($idclient);
            $reglement->setDatereg($date);

            $request->getSession()
            ->getFlashBag()
            ->add('success', 'Paiement effectué !')
            ;

            $em->persist($reglement);
            $em->flush();
        }

        return $this->render('default/reglement.html.twig', array(
        	'client' => $client,
            'ecoles' => $ecoles,
            'document' => $document,
            'form' => $form->createView()
        ));
    }
}
