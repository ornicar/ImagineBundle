<?php

namespace Bundle\ImagineBundle\Services;

use Symfony\Component\DependencyInjection\Container;

class ProcessorManager
{
    protected $processors = array();

    public function addProcessor($name, $processor)
    {
        $this->processors[$name] = $processor;
    }

    public function getProcessor($name)
    {
        if(!isset($this->processors[$name])) {
            throw new \InvalidArgumentException(sprintf('Processor "%s" does not exist. Available processors are %s', $name, implode(', ', array_keys($this->processors))));
        }

        return $this->processors[$name];
    }
}
