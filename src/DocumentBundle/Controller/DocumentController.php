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
use DocumentBundle\Form\DevisType;



class DocumentController extends Controller
{
    public function newdocumentAction(Request $request, $idclient, $type)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $client = $em->getRepository('ClientBundle:Client')->findOneById($idclient);
        $typeclient = $client->getType();
        $products = $em->getRepository('DocumentBundle:Product')->findAll();

        $dateforcount = new \DateTime();
        $alldoc = $em->getRepository('DocumentBundle:Documents')->findByDatemois($dateforcount->format('m/Y'));
        $counter = count($alldoc)+1;

        $document = new Documents();
        $form = $this->createForm('DocumentBundle\Form\DocumentType', $document);
        $form->handleRequest($request);

        // RECUPERATION CHAMPS FORMULAIRE MAIN
        $idproduct = $request->request->get('produit');
        $date = $request->request->get('date');
        $tva = $request->request->get('tva');
        $valuetotale = $request->request->get('valuetotale');
        $datemois = $request->request->get('datemois');
        
        if($typeclient=='kids'.'autres'){

            $quantite = $request->request->get('quantite');
        }
        else {
            $quantite = 1;

        }
        

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
            $reference = /*'DE-'.*/$refdate.'-'.$count;
        }
        elseif ($type == 'facture') {
            $reference = /*'FA-'.*/$refdate.'-'.$count;
        }
        else {
            $reference = /*'AV-'.*/$refdate.'-'.$count;
        }

        // ALGORYTHME POUR SAVOIR SI VALUE EXISTE OU SI A REMPLIR
        if ($typeclient == 'élève') {
            $value = $client->getValue();
        }
        else {
            $value = $request->request->get('value');
        }
        // ALGORYTHME POUR SAVOIR SI TVA EXISTE OU SI A REMPLIR
        if ($typeclient != 'élève') {
            $tva = $client->getTva();
        }
        else {
            $tva = $request->request->get('tva');
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

            $document->setQuantite($quantite);
            $document->setDatemois($datemois);

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

    public function newDevisAction(Request $request, $idclient, $iddocument)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $client = $request->request->get('nom');
        $product = $request->request->get('produit');
        $type = $request->request->get('type');
        $reference = $request->request->get('reference');
        $date = $request->request->get('datecreation');
        $valeur = $request->request->get('valeur');
        $tva = $request->request->get('tva');        
        $quantite = $request->request->get('quantite');
        
        $valuettc = $request->request->get('valuettc');
        $valuetotale = $request->request->get('valuetotale');


        $hidden = $request->request->get('hidden');

        $client = $em->getRepository('ClientBundle:Client')->findOneById($idclient);

        $document = $em->getRepository('DocumentBundle:Documents')->findOneById($iddocument);
        
        $produits = $em->getRepository('DocumentBundle:Product')->findOneById($document->getIdproduct());
        $typeclient = $client->getType();
        $tvaa = $document->getTva();
            // ALGORYTHME POUR QUANTITÉ
            if ($quantite != 1) {

                $valuetotaleHT = $document->getValue() * $document->getQuantite();

            }
            if ($typeclient == 'élève') {
                $valuetva = null;

            }
            
            // ALGORYTHME POUR TTC        
            if ($tvaa != null) {

                $valuetva = $valuetotaleHT * 0.2;


            }

            // VALUE TTC
            $valueTTC = $valuetotaleHT + $valuetva;

        if ($hidden == 1){
            if (!empty($nom)) {
                $document->setNom($client);
            }
            if (!empty($produit)) {
                $document->setType($produit);
            }
            if (!empty($type)) {
                $document->setType($type);
            }
            if (!empty($datecreation)) {
                $document->setType($datecreation);
            }
            if (!empty($valeur)) {
                $document->setType($valeur);
            }
            if (!empty($tva)) {
                $document->setType($tva);
            }

            $request->getSession()
            ->getFlashBag()
            ->add('success', 'Modification enregistrée !')
            ;

            $em->persist($document);
            $em->flush();
        }
        $devis = new Documents();
        $form = $this->createForm('DocumentBundle\Form\DevisType', $devis);

        $form->handleRequest($request);

        return $this->render('default/newdevis.html.twig', array(
            'form' => $form->createView(),
            'document' => $document,
            'client' => $client,
            'produits' => $produits,
            'devis' => $devis,
            'valuetotaleHT' => $valuetotaleHT,
            'valuetva' => $valuetva,
            'valueTTC' => $valueTTC,
            
        ));
    }

    public function suprdocAction(Request $request, $iddocument, $idclient)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $deleting = $em->getRepository('DocumentBundle:Documents')->findOneById($iddocument);
        $client = $em->getRepository('ClientBundle:Client')->findOneById($idclient);
        
        $deleting->setEtat('delete');

        $em->persist($deleting);
        $em->flush();
        
        $request->getSession()
        ->getFlashBag()
        ->add('warning', 'Document Supprimé !')
    ;
        return $this->redirect($this->generateUrl('fiche_client', array(
                'idclient' => $idclient
        )));
    }

    public function refusdocAction(Request $request, $iddocument, $idclient)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $refusing = $em->getRepository('DocumentBundle:Documents')->findOneById($iddocument);
        $client = $em->getRepository('ClientBundle:Client')->findOneById($idclient);
        
        $refusing->setEtat('refuse');

        $em->persist($refusing);
        $em->flush();
        
        $request->getSession()
        ->getFlashBag()
        ->add('warning', 'Document Refusé/Classé !')
    ;
        return $this->redirect($this->generateUrl('fiche_client', array(
                'idclient' => $idclient
        )));
    }

    public function envdocAction(Request $request, $iddocument, $idclient)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $senddoc = $em->getRepository('DocumentBundle:Documents')->findOneById($iddocument);
        $client = $em->getRepository('ClientBundle:Client')->findOneById($idclient);
        
        $senddoc->setEtat('envoyer');

        $em->persist($senddoc);
        $em->flush();
        
        $request->getSession()
        ->getFlashBag()
        ->add('warning', 'Document Refusé/Classé !')
    ;
        return $this->redirect($this->generateUrl('fiche_client', array(
                'idclient' => $idclient
        )));
    }

    public function newFactureAction(Request $request, $idclient, $iddocument)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $client = $request->request->get('nom');
        $product = $request->request->get('produit');
        $type = $request->request->get('type');
        
        $valeur = $request->request->get('valeur');
        $tva = $request->request->get('tva');
        $reference = $request->request->get('reference');
        $month = $request->request->get('month');
        $year = $request->request->get('year');
        $refdate = $year.'-'.$month;
        $valuettc = $request->request->get('valuettc');
        $valuetotale = $request->request->get('valuetotale');


        $document = $em->getRepository('DocumentBundle:Documents')->findOneById($iddocument);
        
        $hidden = $request->request->get('hidden');

        $client = $em->getRepository('ClientBundle:Client')->findOneById($idclient);

        $document = $em->getRepository('DocumentBundle:Documents')->findOneById($iddocument);
        
        $produits = $em->getRepository('DocumentBundle:Product')->findOneById($document->getIdproduct());

        $valuetotaleHT = $document->getValue() * $document->getQuantite();

        $valuetva = $valuetotaleHT * 0.2;

        $valueTTC = $valuetotaleHT + $valuetva;

        
        $type = $document->getType();
            if ($type == 'devis') {
                $document->setType('facture');
            }
        
        if ($hidden == 1){

            
            }

            $em->persist($document);
            $em->flush();
        

        $facture = new Documents();
        $form = $this->createForm('DocumentBundle\Form\FactureType', $facture);

        $form->handleRequest($request);

        return $this->render('default/newfacture.html.twig', array(
            'form' => $form->createView(),
            'document' => $document,
            'client' => $client,
            'produits' => $produits,
            'type' => $type,
            'valuetotaleHT' => $valuetotaleHT,
            'valuetva' => $valuetva,
            'valueTTC' => $valueTTC,
            
        ));

    }

    public function newAvoirAction(Request $request, $idclient, $iddocument)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $client = $request->request->get('nom');
        $product = $request->request->get('produit');
        $type = $request->request->get('type');
        
        $valeur = $request->request->get('valeur');
        $tva = $request->request->get('tva');
        $reference = "";
        $month = $request->request->get('month');
        $year = $request->request->get('year');
        $refdate = $year.'-'.$month;
        $valuettc = $request->request->get('valuettc');
        $valuetotale = $request->request->get('valuetotale');


        $document = $em->getRepository('DocumentBundle:Documents')->findOneById($iddocument);
        
        $hidden = $request->request->get('hidden');

        $client = $em->getRepository('ClientBundle:Client')->findOneById($idclient);

        $document = $em->getRepository('DocumentBundle:Documents')->findOneById($iddocument);
        
        $produits = $em->getRepository('DocumentBundle:Product')->findOneById($document->getIdproduct());

        $reference = $document->getReference();
        $type = $document->getType();

        $valuetotaleHT = $document->getValue() * $document->getQuantite();

        $valuetva = $valuetotaleHT * 0.2;

        $valueTTC = $valuetotaleHT + $valuetva;

        if ($type == 'facture') {
                $document->setType('avoir');
        }
        
        if ($hidden == 1){
            }

            $em->persist($document);
            $em->flush();
        

        return $this->render('default/newavoir.html.twig', array(
            'document' => $document,
            'client' => $client,
            'produits' => $produits,
            'type' => $type,
            'valuetotaleHT' => $valuetotaleHT,
            'valuetva' => $valuetva,
            'valueTTC' => $valueTTC,
            
        ));

    }

    public function pdfAction(Request $request, $idclient, $iddocument)
    {
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository('ClientBundle:Client')->findOneById($idclient);
        $document = $em->getRepository('DocumentBundle:Documents')->findOneById($iddocument);
        $produits = $em->getRepository('DocumentBundle:Product')->findOneById($document->getIdproduct());

        $valuetotaleHT = $document->getValue() * $document->getQuantite();
        $valuetva = $valuetotaleHT * 0.2;
        $valuettc = $request->request->get('valuettc');
        $valueTTC = $valuetotaleHT + $valuetva;



        //on stocke la vue à convertir en PDF, en n'oubliant pas les paramètres twig si la vue comporte des données dynamiques
        $html = $this->renderView('default/newpdf.html.twig', array('client' => $client, 'document'=> $document, 'produits'=> $produits, 'valuetotaleHT' => $valuetotaleHT, 'valuetva' => $valuetva, 'valueTTC' => $valueTTC));

        
         
        //on instancie la classe Html2Pdf_Html2Pdf en lui passant en paramètre
        //le sens de la page "portrait" => p ou "paysage" => l
        //le format A4,A5...
        //la langue du document fr,en,it...
        $html2pdf = new \Html2Pdf_Html2Pdf('P','A4','fr');
 
        //SetDisplayMode définit la manière dont le document PDF va être affiché par l’utilisateur
        //fullpage : affiche la page entière sur l'écran
        //fullwidth : utilise la largeur maximum de la fenêtre
        //real : utilise la taille réelle
        $html2pdf->pdf->SetDisplayMode('fullpage');
 
        //writeHTML va tout simplement prendre la vue stocker dans la variable $html pour la convertir en format PDF
        $html2pdf->writeHTML($html);
 
        //Output envoit le document PDF au navigateur internet avec un nom spécifique qui aura un rapport avec le contenu à convertir (exemple : Facture, Règlement…)
        $html2pdf->Output('Document.pdf'/*, array(
            'client' => $client,
            'produits' => $produits,
            )*/);
        exit;
         
     
        return new Response();
    }
}