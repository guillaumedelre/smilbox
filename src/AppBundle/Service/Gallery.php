<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 20/11/16
 * Time: 17:38
 */

namespace AppBundle\Service;

use Symfony\Component\Finder\Finder;

class Gallery
{
    /**
     * @var string
     */
    protected $outputDir;

    /**
     * Gallery constructor.
     * @param string $outputDir
     */
    public function __construct($outputDir)
    {
        $this->outputDir = $outputDir;
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        $finder = new Finder();
        $finder->files()->in($this->outputDir);

        $items = [];

        foreach ($finder as $file) {
            list($width, $height) = getimagesize($file->getRealPath());
            $items[] = [
                'src' => sprintf('/photos/%s', $file->getRelativePathname()),
                'w' => $width,
                'h' => $height,
            ];
        }

        return $items;
    }
}