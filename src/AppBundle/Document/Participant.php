<?php

namespace AppBundle\Document;

use AppBundle\Document\Abstraction\IdentifiableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique;

/**
 * @ODM\Document()
 * @Unique("emailAddress")
 */
class Participant implements IdentifiableInterface
{
    /**
     * @ODM\Id()
     */
    private $id;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @Assert\NotBlank()
     * @JMS\Type("string")
     */
    private $name;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @ODM\UniqueIndex()
     * @JMS\Type("string")
     */
    private $emailAddress;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @JMS\Type("string")
     */
    private $phoneNumber;

    /**
     * @var Event[]
     *
     * @ODM\ReferenceMany(targetDocument="Event")
     */
    private $incomingEvents;

    /**
     * @var Reminder[]
     *
     * @ODM\EmbedMany(targetDocument="Reminder")
     */
    private $reminders;


    public function __construct()
    {
        $this->incomingEvents = new ArrayCollection();
        $this->reminders = new ArrayCollection();
    }

    /**
     * @return Reminder[]
     */
    public function getReminders(): array
    {
        return $this->reminders;
    }

    /**
     * @param ArrayCollection $reminders
     *
     * @return Participant
     */
    public function setReminders(ArrayCollection $reminders): Participant
    {
        $this->reminders = $reminders;

        return $this;
    }

    /**
     * @param Reminder $reminder
     *
     * @return Participant
     */
    public function addReminder(Reminder $reminder): Participant
    {
        $this->reminders->add($reminder);

        return $this;
    }

    /**
     * @param Reminder $reminder
     *
     * @return Participant
     */
    public function removeReminder(Reminder $reminder): Participant
    {
        $this->reminders->removeElement($reminder);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getIncomingEvents(): ArrayCollection
    {
        return $this->incomingEvents;
    }

    /**
     * @param ArrayCollection $incomingEvents
     *
     * @return Participant
     */
    public function setIncomingEvents(ArrayCollection $incomingEvents): Participant
    {
        $this->incomingEvents = $incomingEvents;

        return $this;
    }

    /**
     * @param Event $event
     *
     * @return Participant
     */
    public function addIncomingEvent(Event $event): Participant
    {
        if (!$this->incomingEvents->contains($event)) {
            $this->incomingEvents->add($event);
        }

        return $this;
    }

    /**
     * @param Event $event
     *
     * @return Participant
     */
    public function removeIncomingEvent(Event $event): Participant
    {
        $this->incomingEvents->removeElement($event);

        return $this;
    }

    /**
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @param string $emailAddress
     *
     * @return Participant
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     *
     * @return Participant
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Participant
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    function __toString(): string
    {
        return $this->getName();
    }
}
