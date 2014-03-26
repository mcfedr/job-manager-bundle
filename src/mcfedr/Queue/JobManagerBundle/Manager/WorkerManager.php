<?php
/**
 * Created by mcfedr on 21/03/2014 14:22
 */

namespace mcfedr\Queue\JobManagerBundle\Manager;

use mcfedr\Queue\JobManagerBundle\Exception\ExecuteException;
use mcfedr\Queue\JobManagerBundle\Exception\UnrecoverableException;
use mcfedr\Queue\JobManagerBundle\Worker\Worker;
use mcfedr\Queue\QueueManagerBundle\Manager\QueueManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

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

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    public function __construct(QueueManager $manager, Container $container, LoggerInterface $logger)
    {
        $this->manager = $manager;
        $this->container = $container;
        $this->logger = $logger;
    }

    /**
     * Execute the next task on the queue
     *
     * @param string $queue
     * @param int $timeout
     * @throws \Exception
     * @throws \mcfedr\Queue\JobManagerBundle\Exception\UnrecoverableException
     * @throws \mcfedr\Queue\JobManagerBundle\Exception\ExecuteException
     */
    public function execute($queue = null, $timeout = null)
    {
        $job = $this->manager->get($queue, $timeout);
        if (!$job) {
            return;
        }
        $task = json_decode($job->getData(), true);
        $this->logger->info('Got task', [
            'task' => $task['name'],
            'options' => $task['options']
        ]);

        try {
            /** @var Worker $task */
            $worker = $this->container->get($task['name']);

            $worker->execute($task['options']);
            $this->manager->delete($job);
        }
        catch (ServiceNotFoundException $e) {
            $this->manager->delete($job);
            $throw = new UnrecoverableException("Service for job not found", 0, $e);
            $throw->setJob($job);
            throw $throw;
        }
        catch (UnrecoverableException $e) {
            $this->manager->delete($job);
            $e->setJob($job);
            throw $e;
        }
        catch(\Exception $e) {
            throw new ExecuteException($job, $e);
        }
    }
}
