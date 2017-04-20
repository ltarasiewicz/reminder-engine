<?php

namespace AppBundle\Document;

use AppBundle\Document\Abstraction\IdentifiableInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use DateTimeInterface;

/**
 * @ODM\EmbeddedDocument()
 */
class Reminder implements IdentifiableInterface
{
    const EMAIL_CHANNEL = 1;
    const SMS_CHANNEL = 2;

    /**
     * @ODM\Id()
     */
    private $id;

    /**
     * @var DateTimeInterface
     *
     * @ODM\Field(type="date")
     */
    private $time;

    /**
     * @var int
     *
     * @ODM\Field(type="int")
     */
    private $status;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    private $message;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    private $title;

    /**
     * @var ReminderTemplate
     *
     * @ODM\ReferenceOne(targetDocument="ReminderTemplate")
     */
    private $template;

    /**
     * @var array
     *
     * @ODM\Field(type="collection")
     */
    private $channels = [];

    /**
     * @return array
     */
    public function getChannels(): array
    {
        return $this->channels;
    }

    /**
     * @param array $channels
     *
     * @return Reminder
     */
    public function setChannels(array $channels): Reminder
    {
        $this->channels = $channels;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return Reminder
     */
    public function setTitle(string $title): Reminder
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return ReminderTemplate
     */
    public function getTemplate(): ReminderTemplate
    {
        return $this->template;
    }

    /**
     * @param ReminderTemplate $template
     *
     * @return Reminder
     */
    public function setTemplate(ReminderTemplate $template): Reminder
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return Reminder
     */
    public function setMessage(string $message): Reminder
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param DateTimeInterface $time
     * @return Reminder
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return Reminder
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }
}
