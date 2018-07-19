<?php

namespace Bywulf\UserBundle;

use Bywulf\UserBundle\DependencyInjection\BywulfUserExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BywulfUserBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new BywulfUserExtension();
    }
}