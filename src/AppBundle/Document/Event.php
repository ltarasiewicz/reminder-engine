<?php

namespace AppBundle\Document;

use DateTimeInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;
use DateInterval;

/**
 * @ODM\Document()
 */
class Event
{
    /**
     * @ODM\Id()
     * @JMS\Type("string")
     */
    private $id;

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
     * @var DateInterval
     *
     * @ODM\Field(type="string")
     * @JMS\Type("string")
     */
    private $duration;

    /**
     * @return string
     */
    public function getDuration(): string
    {
        return $this->duration;
    }

    /**
     * @param string $duration
     *
     * @return Event
     */
    public function setDuration(string $duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return Event
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Venue
     */
    public function getVenue()
    {
        return $this->venue;
    }

    /**
     * @param Venue $venue
     *
     * @return Event
     */
    public function setVenue(Venue $venue)
    {
        $this->venue = $venue;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param DateTimeInterface $startTime
     *
     * @return Event
     */
    public function setStartTime(DateTimeInterface $startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }
}
