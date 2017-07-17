<?php
declare(strict_types=1);

namespace AppBundle\Document;

use AppBundle\Document\Abstraction\AbstractReminderDelivery;
use AppBundle\Document\Abstraction\ReminderDeliveryTargetInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ODM\EmbeddedDocument()
 */
class SmsReminderDelivery extends AbstractReminderDelivery
{
    /**
     * @var PhoneNumber|ReminderDeliveryTargetInterface
     *
     * @JMS\Type("PhoneNumber")
     */
    protected $target;
}
