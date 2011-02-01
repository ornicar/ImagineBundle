<?php

namespace Bundle\ImagineBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle as BaseBundle;

class ImagineBundle extends BaseBundle
{
    public function getNamespace()
    {
        return __NAMESPACE__;
    }

    public function getPath()
    {
        return strtr(__DIR__, '\\', '/');
    }
}
