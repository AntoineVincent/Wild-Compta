<?php

namespace DocumentBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use DocumentBundle\Entity\Documents;
use DocumentBundle\Entity\Product;
use DocumentBundle\Entity\Counter;
use ClientBundle\Entity\Client;
use Html2Pdf_Html2Pdf;
use DocumentBundle\Form\DocumentType;



class DocumentController extends Controller
{
    public function newdocumentAction(Request $request, $idclient, $type)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $client = $em->getRepository('ClientBundle:Client')->findOneById($idclient);
        $typeclient = $client->getType();
        $products = $em->getRepository('DocumentBundle:Product')->findAll();

        $alldoc = $em->getRepository('DocumentBundle:Documents')->findAll();
        $counter = count($alldoc);

        $document = new Documents();
        $form = $this->createForm('DocumentBundle\Form\DocumentType', $document);
        $form->handleRequest($request);


        // RECUPERATION CHAMPS FORMULAIRE MAIN
        $idproduct = $request->request->get('produit');
        $date = $request->request->get('date');
        $tva = $request->request->get('tva');


        // ALGORYTHME CALCUL REFERENCE DOCUMENT
        $reference = "";
        $month = $request->request->get('month');
        $year = $request->request->get('year');
        $refdate = $year.'-'.$month;

        if ($counter < 10) {
            $count = '0'.'0'.$counter;
        }
        if ($counter < 100 && $counter > 9) {
            $count = '0'.$counter;
        }

        if ($type == 'devis') {
            $reference = 'DE-'.$refdate.'-'.$count;
        }
        elseif ($type == 'facture') {
            $reference = 'FA-'.$refdate.'-'.$count;
        }
        else {
            $reference = 'AV-'.$refdate.'-'.$count;
        }

        // ALGORYTHME POUR SAVOIR SI VALUE EXISTE OU SI A REMPLIR
        if ($typeclient == 'élève') {
            $value = $client->getValue();
        }
        else {
            $value = $request->request->get('value');
        }

        if ($form->isValid()) {
            $request->getSession()
            ->getFlashBag()
            ->add('success', 'Document Créé !')
            ;


            // ATTRIBUTION DES VALEURS A LOBJET
            $document->setIdclient($idclient);
            $document->setIdproduct($idproduct);
            $document->setType($type);
            $document->setDatecreation($date);
            $document->setEtat('ouvert');
            $document->setValue($value);
            $document->setTva($tva);
            $document->setReference($reference);

            $em->persist($document);
            $em->flush();
        }

        return $this->render('default/newdoc.html.twig', array(
            'form' => $form->createView(),
            'type' => $type,
            'client' => $client,
            'products' => $products,
            'reference' => $reference,
            'value' => $value,
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