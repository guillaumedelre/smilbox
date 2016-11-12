<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 12/11/16
 * Time: 18:11
 */

namespace AppBundle\Service;

use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Process\Process;

class PiCamera
{
    use LoggerAwareTrait;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var string
     */
    protected $outputDir;

    /**
     * PiCamera constructor.
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = $options['defaults'];
        $this->outputDir = $options['output_dir'];
    }

    /**
     * @return bool
     */
    public function selfie()
    {
        $now = new \DateTimeImmutable();

        $options = [];
        $options[] = sprintf('--output %s/pic-%d.jpg', $this->outputDir, $now->getTimestamp()); // filename
        foreach ($this->options as $key => $data) {
            $options[] = sprintf('%s %s', $data['command'], $data['default']); // params
        }
        $options[] = '--encoding jpg'; // jpeg encoding
        $options[] = '--vstab'; // stabilization
        $options[] = '--fullpreview'; // use settings for preview
        $options[] = '--fullscreen'; // use settings for preview
        $options[] = sprintf('--exif date="%s"', $now->format('Y-m-d H:i:s')); // use settings for preview
        $options[] = '-v'; // verbose

        $command = sprintf('raspistill %s', implode(' ', $options));

        return $this->process($command);
    }

    /**
     * @param string $command
     * @return bool
     */
    private function process($command)
    {
        $return = false;

        $process = new Process($command);
        try {
            $process->run();
            $this->logger->info($process->getOutput());
            $return = true;
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return $return;
    }
}