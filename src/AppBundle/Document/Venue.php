<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ODM\Document()
 */
class Venue
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
     */
    private $country;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @JMS\Type("string")
     */
    private $city;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @JMS\Type("string")
     */
    private $province;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @JMS\Type("string")
     */
    private $streetAddress;

    /**
     * @var PhoneNumber
     *
     * @ODM\EmbedOne(targetDocument="PhoneNumber")
     * @JMS\Type("AppBundle\Document\PhoneNumber")
     */
    private $contactNumber;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @JMS\Type("string")
     */
    private $shortName;

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
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     *
     * @return Venue
     */
    public function setCountry(string $country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     *
     * @return Venue
     */
    public function setCity(string $city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param string $province
     *
     * @return Venue
     */
    public function setProvince(string $province)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * @return string
     */
    public function getStreetAddress(): string
    {
        return $this->streetAddress;
    }

    /**
     * @param string $streetAddress
     *
     * @return Venue
     */
    public function setStreetAddress(string $streetAddress)
    {
        $this->streetAddress = $streetAddress;

        return $this;
    }

    /**
     * @return PhoneNumber
     */
    public function getContactNumber()
    {
        return $this->contactNumber;
    }

    /**
     * @param string $contactNumber
     *
     * @return Venue
     */
    public function setContactNumber(string $contactNumber)
    {
        $this->contactNumber = $contactNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * @param string $shortName
     *
     * @return Venue
     */
    public function setShortName(string $shortName)
    {
        $this->shortName = $shortName;

        return $this;
    }
}
