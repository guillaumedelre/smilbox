<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 12/11/16
 * Time: 18:11
 */

namespace AppBundle\Service;

use AppBundle\Model\Filter\WarholFilter;
use AppBundle\Model\Widget;
use AppBundle\Model\WidgetInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Process\Process;

class PiCamera implements WidgetInterface
{
    use LoggerAwareTrait;

    /**
     * @var Session
     */
    protected $session;

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
     * @param Session $session
     */
    public function __construct(array $options, Session $session)
    {
        if ($session->has('pi_camera') && !empty($session->get('pi_camera'))) {
            $this->options = $session->get('pi_camera');
        } else {
            $this->options = $options['defaults'];
            $session->set('pi_camera', $this->options);
        }

        $this->session = $session;

        $this->outputDir = $options['output_dir'];
    }

    /**
     * @param $option
     * @return Widget
     */
    public function getWidget($option)
    {
        if (!array_key_exists($option, $this->options)) {
            throw new \LogicException('Missing option');
        }

        $widget = new Widget();
        $widget->loadFromData($option, $this->options[$option]);

        return $widget;
    }

    /**
     * @param $key
     * @param $value
     * @param string|null $compute
     */
    public function set($key, $value, $compute = null)
    {
        $language = new ExpressionLanguage();
        if (in_array($key, ['colfx-u', 'colfx-v'])) {
            if ('colfx-u' === $key) {
                $this->options['colfx'][0]['default'] = $language->evaluate($value . $compute);
            }
            if ('colfx-v' === $key) {
                $this->options['colfx'][1]['default'] = $language->evaluate($value . $compute);
            }
        } else {
            if (array_key_exists($key, $this->options)) {
                $this->options[$key]['default'] = null === $compute ? $value : $language->evaluate($value . $compute);
            }
        }

        $this->session->set('pi_camera', $this->options);
    }

    /**
     * @param null $filter
     * @return bool
     */
    public function selfie($filter = null)
    {
        $now = new \DateTimeImmutable();
        $filename = sprintf('%s/pic-%d.jpg', $this->outputDir, $now->getTimestamp());

        $options = [];
        $options[] = sprintf('--output %s', $filename); // filename
        foreach ($this->options as $optionData) {
            $compound = false;

            if (is_int(key($optionData))) {
                $compound = true;
            }

            $options[] = $compound
                ? sprintf('%s %s', reset($optionData)['command'], sprintf('%d:%d', $optionData[0]['default'], $optionData[1]['default']))
                : sprintf('%s %s', $optionData['command'], $optionData['default']); // params
        }

        $options[] = '--encoding jpg'; // jpeg encoding
        $options[] = '--vstab'; // stabilization
//        $options[] = '--preview 0,0,1296,976'; // preview
        $options[] = '--preview 0,0,800,480'; // preview
        $options[] = sprintf('--exif date="%s"', $now->format('Y-m-d H:i:s')); // put the date in exif
        $options[] = '-v'; // verbose

        $command = sprintf('raspistill %s', implode(' ', $options));

        $return = $this->process($command);

        if ($return) {
            $this->applyFilter($filter, $filename);
        }

        return $return ? $filename : false;
    }

    /**
     * @return bool
     */
    public function timelaps()
    {
        $now = new \DateTimeImmutable();

        $options = [];
        $options[] = sprintf('--output %s/pic-%d.jpg', $this->outputDir, $now->getTimestamp()); // filename

        $command = sprintf('raspistill %s', implode(' ', $options));

        return $this->process($command);
    }

    /**
     * @param string $command
     * @return bool
     */
    private function process($command)
    {
        $return = true;

        $process = new Process($command);
        $this->logger->notice(sprintf('PiCamera running command: "%s"', $command));
        $process->run();

        if (!$process->isSuccessful()) {
            $return = false;
            $this->logger->error(sprintf('PiCamera proccess error: "%s"', $process->getErrorOutput()));
        } else {
            $this->logger->info(sprintf('PiCamera command done: "%s"', $process->getOutput()));
        }

        return $return;
    }

    /**
     * @param $filter
     * @param $filename
     */
    private function applyFilter($filter, $filename)
    {
        if (WarholFilter::NAME === strtoupper($filter)) {
            WarholFilter::apply($filename);
        }
    }
}