<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Httpfoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ClientBundle\Entity\Client;
use ClientBundle\Entity\Ecole;
use ClientBundle\Form\ClientType;
class ClientController extends Controller
{
    public function newclientAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $ecoles = $em->getRepository('ClientBundle:Ecole')->findAll();
        $orgas = $em->getRepository('ClientBundle:Organisme')->findAll();

        $client = new Client();
        $form = $this->createForm('ClientBundle\Form\ClientType', $client);
        $form->handleRequest($request);

        $ecolerslt = $request->request->get('ecole');
        $orgarslt = $request->request->get('orga');

        if ($form->isValid()) {
            $request->getSession()
            ->getFlashBag()
            ->add('success', 'Client Créé !')
            
            ;

            if ($client->getType() == 'élève') {
                $client->setValue(6000);
            }

            $client->setEcole($ecolerslt);
            $client->setOrgapayeur($orgarslt);

            $em->persist($client);
            $em->flush();
        }

        return $this->render('default/client/newclient.html.twig', array(
            'form' => $form->createView(),
            'ecoles' => $ecoles,
            'orgas' => $orgas,
        ));
    }

    public function listeclientAction(Request $request)
    {
    	
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $clients = $em->getRepository('ClientBundle:Client')->findAll();

        return $this->render('default/client/listeclient.html.twig', array(
        	'clients' => $clients,
        ));
    }

    public function ficheclientAction(Request $request, $idclient)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $client = $em->getRepository('ClientBundle:Client')->findOneById($idclient);

        return $this->render('default/client/ficheclient.html.twig', array(
            'client' => $client,
        ));
    }

    public function editclientAction(Request $request, $idclient)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $nom = $request->request->get('nom');
        $type = $request->request->get('type');

        $hidden = $request->request->get('hidden');

        $client = $em->getRepository('ClientBundle:Client')->findOneById($idclient);

        if ($hidden == 1){
            if (!empty($nom)) {
                $client->setNom($nom);
            }
            if (!empty($type)) {
                $client->setType($type);
            }

            $request->getSession()
            ->getFlashBag()
            ->add('success', 'Modification enregistrée !')
            ;

            $em->persist($client);
            $em->flush();
        }

        return $this->render('default/client/editclient.html.twig', array(
            'client' => $client,
        ));
    }

    public function suprclientAction(Request $request, $idclient)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $deleting = $em->getRepository('ClientBundle:Client')->findOneById($idclient);
        
        $em->remove($deleting);
        $em->flush();
        
        $request->getSession()
        ->getFlashBag()
        ->add('warning', 'Client Supprimé !')
    ;
        return $this->redirect($this->generateUrl('liste_client'));
    }

}