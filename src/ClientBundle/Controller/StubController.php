<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Httpfoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ClientBundle\Entity\Client;
use ClientBundle\Form\ClientType;
use Symfony\Component\Finder\Finder;

class StubController extends Controller
{
    public function getStubAction(Request $request)
    {
    	$dirs = $this->get('kernel')->getRootDir().'/../web/stub';

    	$finder = new Finder();
		$finder->files()->name('candidats.json')->in($dirs);

		foreach ($finder as $file) {
    		$contents = json_decode($file->getContents(), true);

    		foreach ($contents as $content) 

    			var_dump($content);exit;
    	}


    	return array('contents' => $contents);
    }
}