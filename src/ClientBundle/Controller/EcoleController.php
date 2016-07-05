<?php

namespace ClientBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ClientBundle\Entity\Ecole;

class EcoleController extends Controller
{
    public function newecoleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $newecole = new Ecole;
        $ville = $request->request->get('ville');
        $adresse = $request->request->get('adresse');

        $newecole->setVille($ville);
        $newecole->setAdresse($adresse);

        if ($request->request->get('ville') != NULL) {
            $request->getSession()
            ->getFlashBag()
            ->add('success', 'Ecole Créée !')
            ;

            $em->persist($newecole);
            $em->flush();
        }
        

        return $this->render('default/ecole/newecole.html.twig', array(
            
        ));
    }
    public function listeecoleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $ecoles = $em->getRepository('ClientBundle:Ecole')->findAll();

        return $this->render('default/ecole/listeecole.html.twig', array(
            'ecoles' => $ecoles,
        ));
    }
    public function editecoleAction(Request $request, $idecole)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $ville = $request->request->get('ville');
        $adresse = $request->request->get('adresse');

        $hidden = $request->request->get('hidden');

        $ecole = $em->getRepository('ClientBundle:Ecole')->findOneById($idecole);

        if ($hidden == 1){
            if (!empty($ville)) {
                $ecole->setVille($ville);
            }
            if (!empty($adresse)) {
                $ecole->setAdresse($adresse);
            }

            $request->getSession()
            ->getFlashBag()
            ->add('success', 'Modification enregistré !')
            ;

            $em->persist($ecole);
            $em->flush();
        }

        return $this->render('default/ecole/editecole.html.twig', array(
            'ecole' => $ecole,
        ));
    }

    public function suprecoleAction(Request $request, $idecole)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $deleting = $em->getRepository('ClientBundle:Ecole')->findOneById($idecole);
        
        $em->remove($deleting);
        $em->flush();
        
        $request->getSession()
        ->getFlashBag()
        ->add('warning', 'Ecole Supprimé !')
    ;
        return $this->redirect($this->generateUrl('liste_ecole'));
    }

}