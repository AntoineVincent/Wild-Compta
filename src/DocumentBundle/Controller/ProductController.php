<?php

namespace DocumentBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use DocumentBundle\Entity\Product;
use DocumentBundle\Form\ProductType;

class ProductController extends Controller
{
    public function newproductAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $product = new Product();
        $form = $this->createForm('DocumentBundle\Form\ProductType', $product);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $request->getSession()
            ->getFlashBag()
            ->add('success', 'Produit Prédéfini Créé !')
            ;

            $em->persist($product);
            $em->flush();
        }

        return $this->render('default/product/newproduct.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function listeproductAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $products = $em->getRepository('DocumentBundle:Product')->findAll();

        return $this->render('default/product/listeproduct.html.twig', array(
            'products' => $products,
        ));
    }

    public function editproductAction(Request $request, $idproduct)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $nom = $request->request->get('nom');
        $contenu = $request->request->get('contenu');

        $hidden = $request->request->get('hidden');

        $product = $em->getRepository('DocumentBundle:Product')->findOneById($idproduct);

        if ($hidden == 1){
            if (!empty($nom)) {
                $product->setNom($nom);
            }
            if (!empty($contenu)) {
                $product->setContenu($contenu);
            }

            $request->getSession()
            ->getFlashBag()
            ->add('success', 'Modification enregistré !')
            ;

            $em->persist($product);
            $em->flush();
        }

        return $this->render('default/product/editproduct.html.twig', array(
            'product' => $product,
        ));
    }

    public function suprproductAction(Request $request, $idproduct)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $deleting = $em->getRepository('DocumentBundle:Product')->findOneById($idproduct);
        
        $em->remove($deleting);
        $em->flush();
        
        $request->getSession()
        ->getFlashBag()
        ->add('warning', 'Produit Supprimé !')
    ;
        return $this->redirect($this->generateUrl('liste_product'));
    }

}