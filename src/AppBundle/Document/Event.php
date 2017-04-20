<?php

namespace AppBundle\Document;

use AppBundle\Document\Abstraction\IdentifiableInterface;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ODM\Document()
 */
class Event implements IdentifiableInterface
{
    /**
     * @ODM\Id()
     * @JMS\Type("string")
     */
    private $id;

    /**
     * @var Participant[]
     *
     * @ODM\ReferenceMany(targetDocument="Participant", cascade="persist")
     * @JMS\Type("array<Participant>")
     */
    private $hosts;

    /**
     * @var Participant[]
     *
     * @ODM\ReferenceMany(targetDocument="Participant", cascade="persist")
     */
    private $guests;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @JMS\Type("string")
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var Venue
     *
     * @ODM\ReferenceOne(targetDocument="Venue", cascade="persist")
     * @JMS\Type("AppBundle\Document\Venue")
     * @Assert\Valid()
     */
    private $venue;

    /**
     * @var DateTimeInterface
     *
     * @ODM\Field(type="date")
     * @JMS\Type("DateTime<'Y-m-d'>")
     */
    private $startTime;

    /**
     * @var DateTimeInterface
     *
     * @ODM\Field(type="date")
     * @JMS\Type("DateTime<'Y-m-d'>") // ToDo: Change the format to include time
     */
    private $endTime;

    /**
     * @var ArrayCollection
     *
     * @ODM\EmbedMany(targetDocument="Reminder")
     */
    private $reminders;

    public function __construct()
    {
        $this->hosts = new ArrayCollection();
        $this->guests = new ArrayCollection();
        $this->reminders = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return Event
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return ArrayCollection|Participant[]
     */
    public function getHosts(): ?ArrayCollection
    {
        return $this->hosts;
    }

    /**
     * @param ArrayCollection|Participant[] $hosts
     *
     * @return Event
     */
    public function setHosts(ArrayCollection $hosts = null): Event
    {
        $this->hosts = $hosts;

        return $this;
    }

    /**
     * @param Participant $host
     *
     * @return $this
     */
    public function addHost(Participant $host)
    {
        $this->hosts->add($host);

        return $this;
    }

    /**
     * @param Participant $host
     *
     * @return $this
     */
    public function removeHost(Participant $host)
    {
        $this->hosts->removeElement($host);

        return $this;
    }

    /**
     * @return ArrayCollection|Participant[]
     */
    public function getGuests(): ?ArrayCollection
    {
        return $this->guests;
    }

    /**
     * @param ArrayCollection|Participant[] $guests
     *
     * @return Event
     */
    public function setGuests(ArrayCollection $guests = null): Event
    {
        $this->guests = $guests;

        return $this;
    }

    /**
     * @param Participant $guest
     *
     * @return $this
     */
    public function addGuest(Participant $guest)
    {
        $this->guests->add($guest);

        return $this;
    }

    /**
     * @param Participant $guest
     *
     * @return $this
     */
    public function removeGuest(Participant $guest)
    {
        $this->guests->removeElement($guest);

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return Event
     */
    public function setTitle(string $title): Event
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Venue
     */
    public function getVenue(): ?Venue
    {
        return $this->venue;
    }

    /**
     * @param Venue $venue
     *
     * @return Event
     */
    public function setVenue(Venue $venue = null): Event
    {
        $this->venue = $venue;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getStartTime(): ?DateTimeInterface
    {
        return $this->startTime;
    }

    /**
     * @param DateTimeInterface $startTime
     *
     * @return Event
     */
    public function setStartTime(DateTimeInterface $startTime = null): Event
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getEndTime(): ?DateTimeInterface
    {
        return $this->endTime;
    }

    /**
     * @param DateTimeInterface $endTime
     *
     * @return Event
     */
    public function setEndTime(DateTimeInterface $endTime = null): Event
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getReminders(): ?ArrayCollection
    {
        return $this->reminders;
    }

    /**
     * @param ArrayCollection $reminders
     *
     * @return Event
     */
    public function setReminders(ArrayCollection $reminders = null): Event
    {
        $this->reminders = $reminders;

        return $this;
    }

    /**
     * @param Reminder $reminder
     *
     * @return Event
     */
    public function addReminder(Reminder $reminder): Event
    {
        $this->reminders->add($reminder);

        return $this;
    }

    /**
     * @param Reminder $reminder
     *
     * @return Event
     */
    public function removeReminder(Reminder $reminder): Event
    {
        $this->reminders->removeElement($reminder);

        return $this;
    }

    /**
     * @return string
     */
    public function getVenueId()
    {
        return $this->venue->getId();
    }
}
