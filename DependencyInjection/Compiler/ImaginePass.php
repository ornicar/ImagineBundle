<?php
namespace Bundle\ImagineBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class ImaginePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('imagine.manager')) {
            return;
        }
        $definition = $container->getDefinition('imagine.manager');

        foreach ($container->findTaggedServiceIds('imagine.processor') as $id => $attributes) {
            if (isset($attributes[0]['alias'])) {
                $definition->addMethodCall('addProcessor', array($attributes[0]['alias'], new Reference($id)));
            }
        }
    }
}
