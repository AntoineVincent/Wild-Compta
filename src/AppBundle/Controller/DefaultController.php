<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

    public function listuserAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $users = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('default/campusManager/listuser.html.twig', array(
            'users' => $users,
        ));
    }

    public function edituserAction(Request $request, $iduser)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $nom = $request->request->get('nom');
        $ecole = $request->request->get('ecole');
        $email = $request->request->get('email');

        $hidden = $request->request->get('hidden');

        $user = $em->getRepository('AppBundle:User')->findOneById($iduser);

        if ($hidden == 1){
            if (!empty($nom)) {
                $user->setUsername($nom);
            }
            if (!empty($ecole)) {
                $user->setEcole($ecole);
            }
            if (!empty($email)) {
                $user->setEmail($email);
            }

            $request->getSession()
            ->getFlashBag()
            ->add('success', 'Modification enregistré !')
            ;

            $em->persist($user);
            $em->flush();
        }

        return $this->render('default/campusManager/edituser.html.twig', array(
            'user' => $user,
        ));
    }

    public function supruserAction(Request $request, $iduser)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $deleting = $em->getRepository('AppBundle:User')->findOneById($iduser);
        
        $em->remove($deleting);
        $em->flush();
        
        $request->getSession()
        ->getFlashBag()
        ->add('warning', 'Campus Manager Supprimé(e) !')
    ;
        return $this->redirect($this->generateUrl('list_user'));
    }
}
