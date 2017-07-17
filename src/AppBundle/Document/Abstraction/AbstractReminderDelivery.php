<?php
declare(strict_types=1);

namespace AppBundle\Document\Abstraction;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use DateInterval;
use AppBundle\DBAL\Types\ReminderDeliveryStatusEnum;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ODM\MappedSuperclass()
 */
abstract class AbstractReminderDelivery
{
    /**
     * @var DateInterval
     *
     * @JMS\Type("DateInterval")
     */
    private $deliverBeforeEvent;

    /**
     * @var string
     *
     * @JMS\Type("string")
     */
    private $status;

    /**
     * @var string
     *
     * @JMS\Type("string")
     */
    private $message;

    /**
     * @var ReminderDeliveryTargetInterface
     *
     * @Assert\NotBlank()
     */
    protected $target;

    /**
     * @return DateInterval
     */
    public function getDeliverBeforeEvent()
    {
        return $this->deliverBeforeEvent;
    }

    /**
     * @param DateInterval $deliverBeforeEvent
     *
     * @return AbstractReminderDelivery
     */
    public function setDeliverBeforeEvent(DateInterval $deliverBeforeEvent)
    {
        $this->deliverBeforeEvent = $deliverBeforeEvent;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return AbstractReminderDelivery
     */
    public function setStatus(string $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return AbstractReminderDelivery
     */
    public function setMessage(string $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return ReminderDeliveryTargetInterface
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param ReminderDeliveryTargetInterface $target
     *
     * @return AbstractReminderDelivery
     */
    public function setTarget(ReminderDeliveryTargetInterface $target)
    {
        $this->target = $target;

        return $this;
    }
}
