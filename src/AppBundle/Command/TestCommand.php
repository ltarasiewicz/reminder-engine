<?php
declare(strict_types = 1);

namespace AppBundle\Command;

use AppBundle\Document\Event;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('test:command');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var DocumentManager $dm */
        $dm = $this->getContainer()->get('doctrine.odm.mongodb.document_manager');
        $repo = $dm->getRepository(Event::class);
        $all = $repo->findAll();
        /** @var Event $first */
        $first = $all[0];
        var_dump($first->getOwner());

        $reminders = $first->getReminders();
        $firstReminder = $reminders[0];

        $subscribers = $firstReminder->getSubscribers();

        foreach ($subscribers as $subscriber) {
            echo $subscriber->getName();
        }

    }
}
