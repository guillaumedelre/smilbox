<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->redirectToRoute('app_selfie_index');
    }

    /**
     * @Route("/admin")
     */
    public function adminAction()
    {
        return $this->render('AppBundle:Default:admin.html.twig');
    }

    /**
     * @Route("/help")
     */
    public function helpAction()
    {
        return new JsonResponse(\json_encode(['success' => true]));
    }
}
