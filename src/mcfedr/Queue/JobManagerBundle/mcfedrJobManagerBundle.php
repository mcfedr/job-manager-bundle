<?php

namespace mcfedr\Queue\JobManagerBundle;

use mcfedr\Queue\JobManagerBundle\DependencyInjection\ListenerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class mcfedrJobManagerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ListenerCompilerPass());
    }
}
