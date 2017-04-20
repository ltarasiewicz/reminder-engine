<?php
namespace AppBundle\DataFixtures\MongoDB;

use AppBundle\Document\Event;
use AppBundle\Document\EmailReminder;
use AppBundle\Document\Host;
use AppBundle\Document\SmsReminder;
use Carbon\Carbon;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Document\Guest;

class LoadEventData extends AbstractFixture  implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $startTime  = new Carbon('today');
        $endTime = new Carbon('tomorrow');

        $host1 = new Host();
        $host1->setName('Mr. Tooth Extractor');
        $host1->setPhoneNumber('123123123');

        $event1 = new Event();
        $event1->setTitle('Tooth extraction.');
        $event1->setHost($host1);

        /** @var Guest $guest1 */
        $guest1 = $this->getReference('guest1');

        $event1->setVenue('Warsaw');
        $event1->addGuest($guest1);
        $event1->setStartTime($startTime);
        $event1->setEndTime($endTime);

        $event1->setEmailReminderMessage('Email reminder message');
        $event1->setSmsReminderMessage('Sms reminder message');

        $event1->setSmsReminderTime(new \DateTime('tomorrow'));
        $event1->setEmailReminderTime(new \DateTime('tomorrow'));

        $guest1->addIncomingEvent($event1);

        $smsReminder1 = new SmsReminder();
        $emailReminder1 = new EmailReminder();

        $smsReminder1->setMessage('Custom sms message');
        $emailReminder1->setMessage('Custom email message');

        $smsReminder1->setEvent($event1);
        $emailReminder1->setEvent($event1);

        $guest1->addReminder($smsReminder1);
        $guest1->addReminder($emailReminder1);

        $manager->persist($event1);
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
