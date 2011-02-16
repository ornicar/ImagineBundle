<?php

namespace Bundle\ImagineBundle;

use Bundle\ImagineBundle\DependencyInjection\Compiler\ImaginePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle as BaseBundle;

class ImagineBundle extends BaseBundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ImaginePass());
    }

    public function getNamespace()
    {
        return __NAMESPACE__;
    }

    public function getPath()
    {
        return strtr(__DIR__, '\\', '/');
    }
}
