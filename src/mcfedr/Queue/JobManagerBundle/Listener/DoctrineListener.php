<?php
/**
 * Created by mcfedr on 01/04/2014 16:38
 */

namespace mcfedr\Queue\JobManagerBundle\Listener;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use mcfedr\Queue\JobManagerBundle\Worker\DoctrineAwareWorker;
use mcfedr\Queue\JobManagerBundle\Worker\Worker;
use Psr\Log\LoggerInterface;

class DoctrineListener implements PreListener, PostListener
{

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var Registry
     */
    protected $doctrine;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerInterface $logger, Connection $connection = null, Registry $doctrine = null)
    {
        $this->logger = $logger;
        $this->connection = $connection;
        $this->doctrine = $doctrine;
    }

    public function preTask(Worker $worker, array $options = null)
    {
        if ($worker instanceof DoctrineAwareWorker) {
            if ($this->connection) {
                try {
                    $this->connection->executeQuery('SELECT 1');
                } catch (DBALException $e) {
                    if ($e->getPrevious()->getCode() == "HY000") {
                        $this->logger->info(
                            'Reconnecting doctrine',
                            [
                                'e' => $e
                            ]
                        );
                        $this->connection->close();
                    }
                    else {
                        throw $e;
                    }
                }
            }
        }
    }

    public function postTask(Worker $worker, array $options = null)
    {
        if ($worker instanceof DoctrineAwareWorker) {
            if ($this->doctrine) {
                $this->doctrine->getManager()->clear();
            }
        }
    }
}