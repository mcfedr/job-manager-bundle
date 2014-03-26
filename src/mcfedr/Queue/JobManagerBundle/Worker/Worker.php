<?php
/**
 * Created by mcfedr on 21/03/2014 14:17
 */

namespace mcfedr\Queue\JobManagerBundle\Worker;

use mcfedr\Queue\JobManagerBundle\Exception\UnrecoverableException;

interface Worker
{
    /**
     * Execute this task
     *
     * @param array $options
     * @throws UnrecoverableException
     * @throws Exception
     */
    public function execute(array $options = null);
}
