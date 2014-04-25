<?php
/**
 * Created by mcfedr on 21/03/2014 14:19
 */

namespace mcfedr\Queue\JobManagerBundle\Manager;

use mcfedr\Queue\QueueManagerBundle\Manager\QueueManager;
use mcfedr\Queue\QueueManagerBundle\Queue\Job;

class JobManager
{
    /**
     * @var \mcfedr\Queue\QueueManagerBundle\Manager\QueueManager
     */
    protected $manager;

    public function __construct(QueueManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Put a new job on a queue
     *
     * @param string $name The name of the worker
     * @param array $options Options to pass to execute - must be json_encode-able
     * @param string $queue Optional queue name, otherwise the default queue will be used
     * @param int $priority
     * @param \DateTime $when Optionally set a time in the future when this task should happen
     * @return Job
     */
    public function put($name, array $options = null, $queue = null, $priority = null, $when = null)
    {
        return $this->manager->put(json_encode([
            'name' => $name,
            'options' => $options
        ]), $queue, $priority, $when);
    }
}
