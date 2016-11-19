<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 19/11/16
 * Time: 15:43
 */

namespace AppBundle\Model\Filter;

use Symfony\Component\Process\Process;

class SepiaFilter implements FilterInterface
{
    const NAME = 'SEPIA';

    /**
     * @param string $filename
     * @return string
     */
    public static function apply($filename)
    {
        $sepiaFilename = str_replace('.jpg', '', $filename) . "-sepia.jpg";
        $command = sprintf('convert -sepia-tone %s %s %s', '75%', $filename, $sepiaFilename);
        dump($command);
        $process = new Process($command);
        $process->run();

        dump($process->isSuccessful());

        if ($process->isSuccessful()) {
            return $sepiaFilename;
        }

        return $filename;
    }

}