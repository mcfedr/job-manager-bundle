<?php
/**
 * Created by mcfedr on 21/03/2014 14:17
 */

namespace mcfedr\Queue\JobManagerBundle\Worker;

interface Worker
{
    /**
     * Execute this task
     *
     * @param array $options
     */
    public function execute(array $options = null);
}
