<?php
declare(strict_types=1);

namespace AppBundle\Document;

use AppBundle\Document\Abstraction\ReminderDeliveryTargetInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ODM\EmbeddedDocument()
 */
class EmailAddress implements ReminderDeliveryTargetInterface
{
    /**
     * @var string
     *
     * @JMS\Type("string")
     * @ODM\Id(strategy="NONE", type="string")
     * @Assert\Email()
     */
    private $email;

    /**
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getDestination()
    {
        return $this->email;
    }
}
