<?php
/**
 * Created by mcfedr on 01/04/2014 16:45
 */

namespace mcfedr\Queue\JobManagerBundle\Listener;

use mcfedr\Queue\JobManagerBundle\Worker\MailerAwareWorker;
use mcfedr\Queue\JobManagerBundle\Worker\Worker;
use Psr\Log\LoggerInterface;

class MailerListener implements PostListener
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var \Swift_Transport
     */
    protected $transport;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerInterface $logger, \Swift_Mailer $mailer = null, \Swift_Transport $transport = null)
    {
        $this->logger = $logger;
        $this->mailer = $mailer;
        $this->transport = $transport;
    }

    public function postTask(Worker $worker, array $options = null)
    {
        if ($worker instanceof MailerAwareWorker) {
            if ($this->mailer && $this->transport) {
                //Flush the mailer queue, this isn't normally done until the command execution finishes
                $this->mailer->getTransport()->getSpool()->flushQueue($this->transport);
                $this->logger->info('Flushed mail queue');
            }
        }
    }
}