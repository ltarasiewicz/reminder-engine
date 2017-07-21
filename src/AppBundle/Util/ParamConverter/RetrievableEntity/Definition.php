<?php
declare(strict_types=1);

namespace AppBundle\Util\ParamConverter\RetrievableEntity;

class Definition
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $propertyName;

    /**
     * @var string
     */
    private $fqcn;

    /**
     * @param string $fqcn
     * @param string $propertyName
     * @param string $id
     */
    public function __construct(string $fqcn, string $propertyName, string $id)
    {
        $this->id = $id;
        $this->propertyName = $id;
        $this->fqcn = $fqcn;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPropertyName(): string
    {
        return $this->propertyName;
    }

    /**
     * @return string
     */
    public function getFqcn(): string
    {
        return $this->fqcn;
    }
}
