<?php

namespace AppBundle\Document;

use AppBundle\Document\Abstraction\IdentifiableInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ODM\Document()
 */
class Venue implements IdentifiableInterface
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
     * @Assert\NotNull()
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
    private $street;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @JMS\Type("string")
     */
    private $buildingNumber;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @JMS\Type("string")
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
     * @param mixed $id
     *
     * @return Venue
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     *
     * @return Venue
     */
    public function setCountry(string $country): Venue
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     *
     * @return Venue
     */
    public function setCity(string $city): Venue
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getProvince(): string
    {
        return $this->province;
    }

    /**
     * @param string $province
     *
     * @return Venue
     */
    public function setProvince(string $province): Venue
    {
        $this->province = $province;

        return $this;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     *
     * @return Venue
     */
    public function setStreet(string $street): Venue
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return string
     */
    public function getBuildingNumber(): string
    {
        return $this->buildingNumber;
    }

    /**
     * @param string $buildingNumber
     *
     * @return Venue
     */
    public function setBuildingNumber(string $buildingNumber): Venue
    {
        $this->buildingNumber = $buildingNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getContactNumber(): string
    {
        return $this->contactNumber;
    }

    /**
     * @param string $contactNumber
     *
     * @return Venue
     */
    public function setContactNumber(string $contactNumber): Venue
    {
        $this->contactNumber = $contactNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getShortName(): string
    {
        return $this->shortName;
    }

    /**
     * @param string $shortName
     *
     * @return Venue
     */
    public function setShortName(string $shortName): Venue
    {
        $this->shortName = $shortName;

        return $this;
    }
}
