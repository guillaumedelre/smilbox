<?php

namespace AppBundle\Controller;

use AppBundle\Service\PiCamera;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class TimelapsController extends Controller
{
    /**
     * @Route("/timelaps")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Timelaps:default.html.twig');
    }

    /**
     * @Route("/timelaps/capture")
     */
    public function captureAction()
    {
        /** @var PiCamera $camera */
        $camera = $this->get('pi_camera');
        $success = $camera->timelaps();

        return new JsonResponse(\json_encode(['success' => $success]));
    }
}
