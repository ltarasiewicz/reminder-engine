<?php
declare(strict_types=1);

namespace AppBundle\Document\Abstraction;

use AppBundle\Document\Participant;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ODM\MappedSuperclass()
 */
abstract class AbstractContactMean implements ReminderDeliveryTargetInterface
{
    /**
     * @var string
     *
     * @ODM\Id(strategy="NONE", type="string")
     */
    private $id;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    ///**
    // * @var Participant
    // *
    // * @JMS\Type("Participant")
    // * @Assert\NotBlank()
    // */
    //private $guest;
    //
    ///**
    // * @return Participant
    // */
    //public function getGuest()
    //{
    //    return $this->guest;
    //}
    //
    ///**
    // * @param Participant $guest
    // *
    // * @return AbstractContactMean
    // */
    //public function setGuest(Participant $guest)
    //{
    //    $this->guest = $guest;
    //
    //    return $this;
    //}

    /**
     * @return string
     */
    abstract public function getDestination();
}
