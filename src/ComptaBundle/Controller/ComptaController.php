<?php

namespace ComptaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ComptaBundle\Entity\Compta;
use ClientBundle\Entity\Client;
use ComptaBundle\Entity\Reglement;
use ComptaBundle\Form\ReglementType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ComptaController extends Controller
{
    public function reglementAction(Request $request, $idclient)
    {
    	$em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();


        $client = $em->getRepository('ClientBundle:Client')->findOneById($idclient);

        $reglement = new Reglement();
        $form = $this->createForm('ComptaBundle\Form\ReglementType'/*, $reglement*/);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $request->getSession()
            ->getFlashBag()
            ->add('success', 'Paiement effectué !')
            ;

            $em->persist($reglement);
            $em->flush();
        }

        return $this->render('Default/reglement.html.twig', array(
        	'client' => $client,
            'form' => $form->createView()
        ));
    }
}
