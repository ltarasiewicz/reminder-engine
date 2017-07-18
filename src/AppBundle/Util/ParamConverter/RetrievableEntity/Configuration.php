<?php
declare(strict_types=1);

namespace AppBundle\Util\ParamConverter\RetrievableEntity;

use IteratorAggregate;
use ArrayIterator;

class Configuration implements IteratorAggregate
{
    /** @var Definition[] */
    private $retrievableEntityDefinitions;

    /**
     * @param array $retrievableEntityDefinitions
     */
    public function __construct(array $retrievableEntityDefinitions)
    {
        $this->retrievableEntityDefinitions = $retrievableEntityDefinitions;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->retrievableEntityDefinitions);
    }
}
