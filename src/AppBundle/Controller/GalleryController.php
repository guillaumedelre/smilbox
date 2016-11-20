<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class GalleryController extends Controller
{
    /**
     * @Route("/gallery")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Gallery:default.html.twig', [
            'items' => $this->get('gallery')->getFiles(),
        ]);
    }
}
