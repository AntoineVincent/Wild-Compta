<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Httpfoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ClientBundle\Model\Client;
use ClientBundle\Form\ClientType;
class ClientController extends Controller
{
    public function newclientAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $client = new Client();
        $form = $this->createForm('ClientBundle\Form\ClientType', $client);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $request->getSession()
            ->getFlashBag()
            ->add('success', 'Client Créé !')
            ;

            $em->persist($client);
            $em->flush();
        }

        return $this->render('default/newclient.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function listeclientAction(Request $request)
    {
    	
        $candidats = $this->getCandidats();

        return $this->render('default/listeclient.html.twig', array(
        	'clients' => $candidats,
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

        return $this->render('default/editclient.html.twig', array(
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

    private function getCandidats()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $file = $this->get('kernel')->getRootDir().'/../web/stub/candidats.json';
        $object = json_decode(file_get_contents($file), true);

        $candidats = [];

        foreach ($object['data'] as $value) {
            $candidat = new Client();
            $candidat->setNom($value['title']);
            $candidat->setIdpipedrive($value['id']);
            $candidat->setIdecole($value['value']);
            $candidat->setType($value['value']);
            array_push($candidats, $candidat);
        }

        return $candidats;
    }

}