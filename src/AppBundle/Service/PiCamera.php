<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 12/11/16
 * Time: 18:11
 */

namespace AppBundle\Service;

use AppBundle\Model\Filter\FilterInterface;
use AppBundle\Model\Widget;
use AppBundle\Model\WidgetInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Process\Process;

class PiCamera implements WidgetInterface
{
    /** @var LoggerInterface */
    protected $logger;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var FilterInterface[]
     */
    protected $filters;

    /**
     * @var array
     */
    protected $rpi;

    /**
     * @var string
     */
    protected $outputDir;

    /**
     * PiCamera constructor.
     * @param LoggerInterface $logger
     * @param array $options
     * @param Session $session
     * @param array $rpi
     * @param FilterInterface[] $filters
     */
    public function __construct(LoggerInterface $logger, array $options, Session $session, array $rpi, $filters)
    {
        $this->logger = $logger;

        if ($session->has('pi_camera') && !empty($session->get('pi_camera'))) {
            $this->options = $session->get('pi_camera');
        } else {
            $this->options = $options['defaults'];
            $session->set('pi_camera', $this->options);
        }

        $this->rpi = $rpi;

        $this->session = $session;

        $this->outputDir = $options['output_dir'];

        $this->filters = $filters;
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
     * @param string|null $filter
     * @return array
     */
    public function selfie($filter = null)
    {
        $now = new \DateTimeImmutable();
        $filename = sprintf('%s/pic-%d.jpg', $this->outputDir, $now->getTimestamp());
        $filename = sprintf('%s/%s.jpg', $this->outputDir, 'platon-photographer-putin-man-of-the-year-portrait'); // filename

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
        $options[] = sprintf('--preview 0,0,%d,%d', $this->rpi['width'], $this->rpi['height']); // preview
        $options[] = sprintf('--exif date="%s"', $now->format('Y-m-d H:i:s')); // put the date in exif
        $options[] = '-v'; // verbose

        $command = sprintf('raspistill %s', implode(' ', $options));

        $return = $this->process($command);

        $filename = $this->applyFilter($filter, $filename);

        return [(bool)$return, $filename];
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
     * @param string $filtername
     * @param string $filename
     * @return string|void
     */
    private function applyFilter($filtername, $filename)
    {
        $return = $filename;

        foreach ($this->filters as $filter) {
            $this->logger->info($filter->canSupport($filtername));
            if ($filter->canSupport($filtername)) {
                return $filter->apply($filename);
            }
        }

        return $return;
    }
}