<?php

namespace mcfedr\Queue\JobManagerBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class mcfedrJobManagerExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $container->setDefinition(
            'mcfedr_job_manager.jobs',
            new Definition('mcfedr\Queue\JobManagerBundle\Manager\JobManager', [
                new Reference("mcfedr_queue_manager." . $config['manager'])
            ])
        );

        $container->setDefinition(
            'mcfedr_job_manager.workers',
            new Definition('mcfedr\Queue\JobManagerBundle\Manager\WorkerManager', [
                new Reference("mcfedr_queue_manager." . $config['manager']),
                new Reference('service_container'),
                new Reference("logger")
            ])
        );

        $container->setDefinition(
            'mcfedr_job_manager.command.worker',
            (new Definition('mcfedr\Queue\JobManagerBundle\Command\WorkerCommand', [
                new Reference('mcfedr_job_manager.workers'),
                new Reference("logger")
            ]))->addTag('console.command')
        );
    }
}