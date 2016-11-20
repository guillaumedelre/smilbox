<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 20/11/16
 * Time: 23:19
 */

namespace AppBundle\Model\Filter;

use AppBundle\Model\Filter\Traits\ImagickCliAwareTrait;
use Symfony\Component\Process\Process;

class SepiaCliFilter extends AbstractFilter
{
    const NAME = 'SEPIA';

    use ImagickCliAwareTrait;

    /**
     * @param string $filename
     * @return string
     */
    public function apply($filename)
    {
        $sepiaFilename = str_replace('.jpg', '', $filename) . "-sepia.jpg";

        if ($this->isAware()) {
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