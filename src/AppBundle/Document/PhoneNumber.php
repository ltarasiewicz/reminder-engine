<?php
declare(strict_types=1);

namespace AppBundle\Document;

use AppBundle\Document\Abstraction\ReminderDeliveryTargetInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ODM\EmbeddedDocument()
 */
class PhoneNumber implements ReminderDeliveryTargetInterface
{
    /**
     * @var string
     *
     * @ODM\Id(strategy="NONE", type="string")
     * @JMS\Type("string")
     */
    private $phone;

    public function __construct(string $phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getDestination(): string
    {
        return $this->phone;
    }
}
