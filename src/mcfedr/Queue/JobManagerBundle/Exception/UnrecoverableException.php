<?php
/**
 * Created by mcfedr on 25/03/2014 10:21
 */

namespace mcfedr\Queue\JobManagerBundle\Exception;

use mcfedr\Queue\QueueManagerBundle\Queue\Job;

/**
 * Represents an error performing a task that will always happen
 * This causes the task to be logged, and deleted, so that it will not be retried.
 *
 * @package mcfedr\Queue\JobManagerBundle\Exception
 */
class UnrecoverableException extends \Exception
{
    protected $job;

    /**
     * @param mixed $job
     * @return UnrecoverableException
     */
    public function setJob($job)
    {
        $this->job = $job;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getJob()
    {
        return $this->job;
    }
} 