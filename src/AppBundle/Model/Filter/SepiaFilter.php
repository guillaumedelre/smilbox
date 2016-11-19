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
    const NAME = 'WARHOL';

    public static function apply($filename)
    {
        $sepiaFilename = str_replace('.jpg', '', $filename) . "-sepia.jpg";
        $command = sprintf('convert -sepia-tone 75% %s %s',$filename, $sepiaFilename);
        $process = new Process($command);
        $process->run();
    }

}