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
class SmsReminder extends AbstractReminder
{
    /**
     * @var SmsReminderDelivery[]|Collection
     *
     * @ODM\EmbedMany(targetDocument="SmsReminderDelivery")
     * @JMS\Type("ArrayCollection<SmsReminderDelivery>")
     */
    protected $reminderDeliveries;
}
