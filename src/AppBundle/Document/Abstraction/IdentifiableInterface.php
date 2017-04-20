<?php
declare(strict_types = 1);

namespace AppBundle\Document\Abstraction;

interface IdentifiableInterface
{
    /**
     * @return string
     */
    public function getId();
}
