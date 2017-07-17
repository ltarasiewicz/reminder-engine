<?php
declare(strict_types=1);

namespace AppBundle\Document\Abstraction;

use AppBundle\Document\Event;
use AppBundle\Document\Participant;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Document\EmailReminderDelivery;
use AppBundle\Document\SmsReminderDelivery;

/**
 * @ODM\MappedSuperclass()
 */
abstract class AbstractReminder
{
    /**
     * @var Collection
     */
    protected $reminderDeliveries;

    /**
     * @var string
     *
     * @JMS\Type("string")
     * @ODM\Id()
     */
    private $id;

    /**
     * @var Event
     *
     * @ODM\InheritanceType("Event")
     * @JMS\Type("Event")
     *
     * @Assert\NotBlank()
     */
    private $event;

    /**
     * @var Participant[]
     *
     * @JMS\Type("ArrayCollection<Participant>")
     *
     * @Assert\Count(
     *     min = 1,
     *     minMessage = "There should be at least one person to remind"
     * )
     */
    private $guests;

    /**
     * @var string
     *
     * @JMS\Type("string")
     */
    private $comment;


    public function __construct()
    {
        $this->reminderDeliveries = new ArrayCollection();
    }

    /**
     * @return EmailReminderDelivery[]|SmsReminderDelivery[]|Collection
     */
    public function getReminderDeliveries()
    {
        return $this->reminderDeliveries;
    }

    /**
     * @param EmailReminderDelivery[]|SmsReminderDelivery[]|Collection $reminderDeliveries
     *
     * @return AbstractReminder
     */
    public function setReminderDeliveries(Collection $reminderDeliveries)
    {
        $this->reminderDeliveries = $reminderDeliveries;

        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Event
     */
    public function getEvent(): Event
    {
        return $this->event;
    }

    /**
     * @param Event $event
     *
     * @return AbstractReminder
     */
    public function setEvent(Event $event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * @return Participant[]
     */
    public function getGuests()
    {
        return $this->guests;
    }

    /**
     * @param Participant[] $guests
     *
     * @return AbstractReminder
     */
    public function setGuests(array $guests)
    {
        $this->guests = $guests;

        return $this;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     *
     * @return AbstractReminder
     */
    public function setComment(string $comment)
    {
        $this->comment = $comment;

        return $this;
    }
}
