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
    private $key;

    /**
     * @var string
     */
    private $fqcn;

    /**
     * @param string $fqcn
     * @param string $key
     * @param string $id
     */
    public function __construct(string $fqcn, string $key, string $id)
    {
        $this->id = $id;
        $this->key = $id;
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
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getFqcn(): string
    {
        return $this->fqcn;
    }
}
