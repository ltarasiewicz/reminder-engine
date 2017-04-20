<?php
namespace AppBundle\DataFixtures\MongoDB;

use AppBundle\Document\Guest;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadGuestData extends AbstractFixture  implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $guest1 = new Guest();
        $guest1->setName('Fella');
        $guest1->setEmailAddress('example@example.com');
        $guest1->setPhoneNumber('123-123-123');

        $guest2 = new Guest();
        $guest2->setName('Some Guy');
        $guest2->setEmailAddress('him@them.us');
        $guest2->setPhoneNumber('9999999');

        $manager->persist($guest1);
        $manager->persist($guest2);
        $manager->flush();

        $this->addReference('guest1', $guest1);
        $this->addReference('guest2', $guest2);
    }

    public function getOrder()
    {
        return 1;
    }
}
