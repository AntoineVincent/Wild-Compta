<?php

namespace DocumentBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use DocumentBundle\Entity\Documents;
use Html2Pdf_Html2Pdf;
use DocumentBundle\Form\DocumentType;



class DocumentController extends Controller
{
    public function newdocumentAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $document = new Documents();
        $form = $this->createForm('DocumentBundle\Form\DocumentType', $document);
        $form->handleRequest($request);



        if ($form->isValid()) {
            $request->getSession()
            ->getFlashBag()
            ->add('success', 'Document Créé !')
            ;

            $em->persist($document);
            $em->flush();
        }

        return $this->render('default/newdoc.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function newdevisAction(Request $request, $idclient)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $client = $em->getRepository('ClientBundle:Client')->findOneById($idclient);

        $documents = $em->getRepository('DocumentBundle:Documents')->findAll();

        return $this->render('default/newdevis.html.twig', array(
            'documents' => $documents,
            'client' => $client
        ));
    }

    public function pdfAction(Request $request, $idclient)
    {
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository('ClientBundle:Client')->findOneById($idclient);
        //on stocke la vue à convertir en PDF, en n'oubliant pas les paramètres twig si la vue comporte des données dynamiques
        $html = $this->renderView('default/newdevis.html.twig', array('client' => $client));

        
         
        //on instancie la classe Html2Pdf_Html2Pdf en lui passant en paramètre
        //le sens de la page "portrait" => p ou "paysage" => l
        //le format A4,A5...
        //la langue du document fr,en,it...
        $html2pdf = new Html2Pdf_Html2Pdf('P','A4','fr');
 
        //SetDisplayMode définit la manière dont le document PDF va être affiché par l’utilisateur
        //fullpage : affiche la page entière sur l'écran
        //fullwidth : utilise la largeur maximum de la fenêtre
        //real : utilise la taille réelle
        $html2pdf->pdf->SetDisplayMode('fullpage');
 
        //writeHTML va tout simplement prendre la vue stocker dans la variable $html pour la convertir en format PDF
        $html2pdf->writeHTML($html);
 
        //Output envoit le document PDF au navigateur internet avec un nom spécifique qui aura un rapport avec le contenu à convertir (exemple : Facture, Règlement…)
        $html2pdf->Output('document.pdf', array(
            /*'client' => $client*/
            ));
        exit;
         
     
        return new Response();
    }


}