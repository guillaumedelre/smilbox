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
        return $this->render('AppBundle:Selfie:default.html.twig', ['ext' => ['gd' => function_exists("gd_info")]]);
    }

    /**
     * @Route("/selfie/capture/{filter}")
     */
    public function captureAction(Request $request, $filter)
    {
        /** @var PiCamera $camera */
        $camera = $this->get('pi_camera');
        $success = $camera->selfie('default' == $filter ? null : $filter);

        $items = [];

        if (false !== $success) {
            list($width, $height) = getimagesize($success);
            $search = substr($success, 0, strpos($success, '/photos'));
            $imageUrl = str_replace($search, '', $success);

            $items[] = [
                'src' => $imageUrl,
                'w' => $width,
                'h' => $height,
            ];

            return new JsonResponse(['error' => false, 'items' => $items]);
        }

        return new JsonResponse(['error' => true, 'items' => $items]);
    }
}
