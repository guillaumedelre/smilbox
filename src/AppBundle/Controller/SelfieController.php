<?php

namespace AppBundle\Controller;

use AppBundle\Service\PiCamera;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SelfieController extends Controller
{
    /**
     * @Route("/selfie")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Selfie:default.html.twig');
    }

    /**
     * @Route("/selfie/capture")
     */
    public function captureAction(Request $request)
    {
        /** @var PiCamera $camera */
        $camera = $this->get('pi_camera');
        $success = $camera->selfie();

        return new JsonResponse(\json_encode(['success' => $success]));
    }
}
