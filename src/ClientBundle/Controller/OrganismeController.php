<?php

namespace ClientBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ClientBundle\Entity\Organisme;

class OrganismeController extends Controller
{
    public function neworganismeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $neworga = new Organisme;

        $nom = $request->request->get('nom');
        $adresse = $request->request->get('adresse');

        $neworga->setNom($nom);
        $neworga->setAdresse($adresse);

        $em->persist($neworga);
        $em->flush();


        return $this->render('default/neworg.html.twig', array(
            
        ));
    }
    public function listeorganismeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $organismes = $em->getRepository('ClientBundle:Organisme')->findAll();

        return $this->render('default/listeorg.html.twig', array(
            'organismes' => $organismes,
        ));
    }

    public function editorganismeAction(Request $request, $idorganisme)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $nom = $request->request->get('nom');
        $adresse = $request->request->get('adresse');

        $hidden = $request->request->get('hidden');

        $organisme = $em->getRepository('ClientBundle:Organisme')->findOneById($idorganisme);

        if ($hidden == 1){
            if (!empty($nom)) {
                $organisme->setNom($nom);
            }
            if (!empty($adresse)) {
                $organisme->setAdresse($adresse);
            }

            $request->getSession()
            ->getFlashBag()
            ->add('success', 'Modification enregistrée !')
            ;

            $em->persist($organisme);
            $em->flush();
        }

        return $this->render('default/editorg.html.twig', array(
            'organisme' => $organisme,
        ));
    }

    public function suprorganismeAction(Request $request, $idorganisme)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $deleting = $em->getRepository('ClientBundle:Organisme')->findOneById($idorganisme);
        
        $em->remove($deleting);
        $em->flush();
        
        $request->getSession()
        ->getFlashBag()
        ->add('warning', 'Organisme Supprimé !')
    ;
        return $this->redirect($this->generateUrl('liste_organisme'));
    }
}