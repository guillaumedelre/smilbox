<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 19/11/16
 * Time: 15:43
 */

namespace AppBundle\Model\Filter;

use AppBundle\Model\Filter\Traits\ImagickAwareTrait;
use Symfony\Component\Process\Process;

class SepiaFilter extends AbstractFilter
{
    const NAME = 'SEPIA';

    use ImagickAwareTrait;

    /**
     * @param string $filename
     * @return string
     */
    public function apply($filename)
    {
        $sepiaFilename = str_replace('.jpg', '', $filename) . "-sepia.jpg";

        if ($this->isAware()) {
            $image = new \Imagick($filename);
            $image->sepiaToneImage(80);
            $image->writeImage($sepiaFilename);
        } else {
            $command = sprintf('convert -sepia-tone %s %s %s', '80%', $filename, $sepiaFilename);
            $process = new Process($command);
            $process->run();

            if (!$process->isSuccessful()) {
                $sepiaFilename = $filename;
            }
        }

        return $sepiaFilename;
    }

    /**
     * @return string
     */
    protected function getName()
    {
        return self::NAME;
    }
}