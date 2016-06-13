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

        return $this->render('default/newproduct.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}