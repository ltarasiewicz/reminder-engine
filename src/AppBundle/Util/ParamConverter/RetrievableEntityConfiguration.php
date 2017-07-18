<?php
declare(strict_types=1);

namespace AppBundle\Util\ParamConverter;

use IteratorAggregate;
use ArrayIterator;

class RetrievableEntityConfiguration implements IteratorAggregate
{
    /** @var RetrievableEntityDefinition[] */
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
