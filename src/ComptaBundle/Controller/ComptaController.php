<?php

namespace ComptaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ClientBundle\Entity\Client;
use ComptaBundle\Entity\Reglement;
use ComptaBundle\Form\ReglementType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;


class ComptaController extends Controller
{
    public function reglementAction(Request $request, $idclient)
    {
    	$em = $this->getDoctrine()->getManager();

        $client = $em->getRepository('ClientBundle:Client')->findOneById($idclient);

        $reglement = new Reglement();
        $form = $this->createForm('ComptaBundle\Form\ReglementType', $reglement);
        $form->handleRequest($request);

        $reglement->setDatereg($request->request->get('date'));

        if ($form->isValid()) {

            $scan = $reglement->getUploadscan();

            $scanName = md5(uniqid()).'.'.$scan->guessExtension();
            $scanDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads/scan';
            $scan->move($scanDir, $scanName);

            $reglement->setUploadscan($scanName);
            $reglement->setIdclient($idclient);

            $request->getSession()
            ->getFlashBag()
            ->add('success', 'Paiement effectué !')
            ;

            $em->persist($reglement);
            $em->flush();
        }

        return $this->render('default/reglement.html.twig', array(
        	'client' => $client,
            'form' => $form->createView()
        ));
    }
}
