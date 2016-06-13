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
            $em->persist($product);
            $em->flush();
        }

        return $this->render('default/newproduct.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function listeproductAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $products = $em->getRepository('DocumentBundle:Product')->findAll();

        return $this->render('default/listeproduct.html.twig', array(
            'products' => $products,
        ));
    }

    public function editproductAction(Request $request, $idproduct)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $type = $request->request->get('type');
        $nom = $request->request->get('nom');
        $contenu = $request->request->get('contenu');

        $hidden = $request->request->get('hidden');

        $product = $em->getRepository('DocumentBundle:Product')->findOneById($idproduct);

        if ($hidden == 1){
            if (!empty($type)) {
                $product->setType($type);
            }
            if (!empty($nom)) {
                $product->setNom($nom);
            }
            if (!empty($contenu)) {
                $product->setContenu($contenu);
            }

            $em->persist($product);
            $em->flush();
        }

        return $this->render('default/editproduct.html.twig', array(
            'product' => $product,
        ));
    }

}