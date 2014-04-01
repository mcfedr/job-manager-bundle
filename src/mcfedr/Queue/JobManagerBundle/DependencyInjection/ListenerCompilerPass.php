<?php
/**
 * Created by mcfedr on 01/04/2014 16:59
 */

namespace mcfedr\Queue\JobManagerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ListenerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('mcfedr_job_manager.workers')) {
            return;
        }

        $definition = $container->getDefinition('mcfedr_job_manager.workers');

        foreach ($container->findTaggedServiceIds('mcfedr_job_manager.listener.pre') as $id => $attributes) {
            $definition->addMethodCall('addPreListener', [new Reference($id)]);
        }

        foreach ($container->findTaggedServiceIds('mcfedr_job_manager.listener.post') as $id => $attributes) {
            $definition->addMethodCall('addPostListener', [new Reference($id)]);
        }
    }
}
