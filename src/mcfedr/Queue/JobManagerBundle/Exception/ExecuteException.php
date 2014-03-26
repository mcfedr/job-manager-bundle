<?php
/**
 * Created by mcfedr on 21/03/2014 14:27
 */

namespace mcfedr\Queue\JobManagerBundle\Exception;

use mcfedr\Queue\QueueManagerBundle\Queue\Job;

/**
 * Thrown by the WorkerManager when there was a problem running a job.
 * This Exception will be wrapped around the original exception
 *
 * @package mcfedr\Queue\JobManagerBundle\Exception
 */
class ExecuteException extends \Exception
{
    /**
     * @var \mcfedr\Queue\QueueManagerBundle\Queue\Job
     */
    protected $job;

    /**
     * @param Job $job the job that failed
     * @param \Exception $e the origonal exception
     */
    public function __construct(Job $job, \Exception $e)
    {
        $this->job = $job;
        parent::__construct("Exception was thrown when executing job", 0, $e);
    }

    /**
     * @param \mcfedr\Queue\QueueManagerBundle\Queue\Job $job
     * @return ExecuteException
     */
    public function setJob($job)
    {
        $this->job = $job;
        return $this;
    }

    /**
     * @return \mcfedr\Queue\QueueManagerBundle\Queue\Job
     */
    public function getJob()
    {
        return $this->job;
    }
} 