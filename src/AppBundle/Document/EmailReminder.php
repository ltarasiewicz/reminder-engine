<?php
declare(strict_types=1);

namespace AppBundle\Document;

use AppBundle\Document\Abstraction\AbstractReminder;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as JMS;

/**
 * @ODM\Document()
 */
class EmailReminder extends AbstractReminder
{
    /**
     * @var EmailReminderDelivery[]|Collection
     * @ODM\EmbedMany(targetDocument="EmailReminderDelivery")
     * @JMS\Type("ArrayCollection<EmailReminderDelivery>")
     */
    protected $reminderDeliveries;
}
