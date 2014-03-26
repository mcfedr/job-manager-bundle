<?php
/**
 * Created by mcfedr on 25/03/2014 10:18
 */

namespace mcfedr\Queue\JobManagerBundle\Exception;

/**
 * Should be thrown by a Worker when the passed options are not as expected
 *
 * @package mcfedr\Queue\JobManagerBundle\Exception
 */
class InvalidArgumentsException extends UnrecoverableException
{
} 