<?php
/**
 * Created by mcfedr on 21/03/2014 14:35
 */

namespace mcfedr\Queue\JobManagerBundle\Command;

use mcfedr\Queue\JobManagerBundle\Exception\ExecuteException;
use mcfedr\Queue\JobManagerBundle\Manager\WorkerManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class WorkerCommand extends Command
{
    /**
     * @var \mcfedr\Queue\JobManagerBundle\Manager\WorkerManager
     */
    protected $manager;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    public function __construct(WorkerManager $manager, LoggerInterface $logger)
    {
        parent::__construct();

        $this->manager = $manager;
        $this->logger = $logger;
    }

    protected function configure()
    {
        $this
            ->setName('mcfedr:job:worker')
            ->setDescription('Run a worker process')
            ->addOption('queue', null, InputOption::VALUE_OPTIONAL, 'The queue to run tasks from');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        while(true) {
            try {
                $this->logger->debug('Waiting for task');
                $this->manager->execute(null, 30);
                $this->logger->debug('Task complete');
            }
            catch (ExecuteException $e) {
                $this->logger->error('There was an error running the task', [
                    'e' => $e
                ]);
            }
        }
    }
}
