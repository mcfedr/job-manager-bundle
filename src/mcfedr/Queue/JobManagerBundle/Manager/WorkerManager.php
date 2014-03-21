<?php
/**
 * Created by mcfedr on 21/03/2014 14:22
 */

namespace mcfedr\Queue\JobManagerBundle\Manager;

use mcfedr\Queue\JobManagerBundle\Exception\ExecuteException;
use mcfedr\Queue\JobManagerBundle\Worker\Worker;
use mcfedr\Queue\QueueManagerBundle\Manager\QueueManager;
use Symfony\Component\DependencyInjection\Container;

class WorkerManager
{
    /**
     * @var \mcfedr\Queue\QueueManagerBundle\Manager\QueueManager
     */
    protected $manager;

    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    public function __construct(QueueManager $manager, Container $container)
    {
        $this->manager = $manager;
        $this->container = $container;
    }

    /**
     * Execute the next task on the queue
     *
     * @param string $queue
     * @throws \mcfedr\Queue\JobManagerBundle\Exception\ExecuteException
     */
    public function execute($queue = null)
    {
        $job = $this->manager->get($queue);
        $task = json_decode($job->getData());

        try {
            /** @var Worker $task */
            $worker = $this->container->get($task['name']);

            $worker->execute($task['options']);
            $this->manager->delete($job);
        }
        catch(\Exception $e) {
            throw new ExecuteException($job, $e);
        }
    }
}
