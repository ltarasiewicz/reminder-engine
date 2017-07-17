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
class EmailReminderDelivery extends AbstractReminderDelivery
{
    /**
     * @var EmailAddress|ReminderDeliveryTargetInterface
     *
     * @JMS\Type("EmailAddress")
     */
    protected $target;
}
