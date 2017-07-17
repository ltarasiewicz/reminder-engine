<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints as MongoAssert;

/**
 * @ODM\Document()
 * @MongoAssert\Unique("emailAddress")
 * @MongoAssert\Unique("phoneNumber")
 */
class Participant
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
    private $firstName;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @JMS\Type("string")
     * @Assert\NotBlank()
     */
    private $lastName;

    /**
     * @var EmailAddress
     *
     * @ODM\EmbedOne(targetDocument="EmailAddress")
     * @JMS\Type("AppBundle\Document\EmailAddress")
     */
    private $emailAddress;

    /**
     * @var PhoneNumber
     *
     * @ODM\EmbedOne(targetDocument="PhoneNumber")
     * @JMS\Type("AppBundle\Document\PhoneNumber")
     */
    private $phoneNumber;


    /**
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @param EmailAddress $emailAddress
     *
     * @return Participant
     */
    public function setEmailAddress(EmailAddress $emailAddress)
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param PhoneNumber $phoneNumber
     *
     * @return Participant
     */
    public function setPhoneNumber(PhoneNumber $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return string
     */
    public function setLastName(string $lastName)
    {
        return $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return Participant
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;

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
    function __toString()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }
}
