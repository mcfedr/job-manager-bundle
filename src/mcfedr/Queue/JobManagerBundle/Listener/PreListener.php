<?php
/**
 * Created by mcfedr on 01/04/2014 16:39
 */

namespace mcfedr\Queue\JobManagerBundle\Listener;

use mcfedr\Queue\JobManagerBundle\Worker\Worker;

interface PreListener
{
    public function preTask(Worker $worker, array $options = null);
}
