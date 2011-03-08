<?php

namespace Bundle\ImagineBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension,
    Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\Config\FileLocator,
    Symfony\Component\DependencyInjection\Definition,
    Symfony\Component\DependencyInjection\Reference,
    Symfony\Component\DependencyInjection\Container,
    Symfony\Component\DependencyInjection\Parameter,
    Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class ImagineExtension extends Extension
{
    protected $resources = array(
        'imagine' => 'imagine.xml'
    );

    public function load(array $configs, ContainerBuilder $container)
    {
        $mergedConfig = array();
        foreach ($configs as $config) {
            $mergedConfig = array_merge($mergedConfig, $config);
        }
        $this->doConfigLoad($mergedConfig, $container);
    }

    public function doConfigLoad(array $config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load($this->resources['imagine']);

        foreach ($config as $processorName => $processorConfig) {
            $this->createProcessor($container, $processorName, $processorConfig);
        }
    }

    protected function createProcessor(ContainerBuilder $container, $name, array $config)
    {
        $processorId = sprintf('imagine.processor.%s', $name);
        $processor = $container
            ->register($processorId, '%imagine.processor_class%')
            ->setPublic(false)
            ->addTag('imagine.processor', array('alias' => $name));

        $commands = isset ($config['commands']) ? $config['commands'] : array();
        foreach ($commands as $command) {
            if ( ! isset ($command['name'])) {
                throw new \LogicException('Command doesn\'t have a name, check your app configuration');
            }
            $processor->addMethodCall($command['name'], (array)$command['arguments']);
        }
    }

    /**
     * Returns the namespace to be used for this extension (XML namespace).
     *
     * @return string The XML namespace
     */
    public function getNamespace()
    {
        return 'http://symfony.com/schema/dic/symfony';
    }

    /**
     * @return string
     */
    public function getXsdValidationBasePath()
    {
        return __DIR__ . '/../Resources/config/';
    }

    /**
     * Returns the recommended alias to use in XML.
     *
     * This alias is also the mandatory prefix to use when using YAML.
     *
     * @return string The alias
     */
    public function getAlias()
    {
        return 'imagine';
    }
}
