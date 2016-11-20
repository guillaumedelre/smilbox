<?php

namespace AppBundle\Controller;

use AppBundle\Service\PiCamera;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class SelfieController extends Controller
{
    /**
     * @Route("/selfie")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Selfie:default.html.twig', $this->getData());
    }

    /**
     * @Route("/selfie/capture/{filter}")
     */
    public function captureAction(Request $request, $filter)
    {
        $items = [];

        $data = $this->getData(false, $items);

        /** @var PiCamera $camera */
        $camera = $this->get('pi_camera');

        list($error, $filename) = $camera->selfie('default' == $filter ? null : $filter);

        if (!$error) {
            list($width, $height) = getimagesize($filename);
            $search = substr($filename, 0, strpos($filename, '/photos'));
            $imageUrl = str_replace($search, '', $filename);

            $items[] = [
                'src' => $imageUrl,
                'w' => $width,
                'h' => $height,
            ];
            $data = $this->getData(false, $items);
        }

        return $this->render('AppBundle:Selfie:default.html.twig', $data);
    }

    /**
     * @param bool $error
     * @param array $items
     * @return array
     */
    private function getData($error = false, $items = [])
    {
        return [
            'ext' => [
                'gd' => function_exists("gd_info"),
            ],
            'error' => $error,
            'items' => $items,
        ];
    }
}
