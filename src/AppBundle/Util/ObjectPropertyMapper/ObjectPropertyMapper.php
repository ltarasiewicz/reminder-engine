<?php
declare(strict_types = 1);

namespace AppBundle\Util\ObjectPropertyMapper;

class ObjectPropertyMapper
{
    private const UNMAPPED_PROPERTIES = ['id']; // These properties are not written

    /**
     * Write property values from source to target
     *
     * @param object $target
     * @param object $source
     * @return void
     */
    public function mapObjectProperties($target, $source): void
    {
        $reflection = new \ReflectionClass($source);
        $reflectionProperties = $reflection->getProperties(\ReflectionProperty::IS_PRIVATE);
        $classProperties = array_column($reflectionProperties, 'name');

        foreach ($this->filterUnmappedProperties($classProperties) as $property) {
            $setter = 'set'.$property;
            $getter = 'get'.$property;
            $target->$setter($source->$getter());
        }
    }

    /**
     * @param array $properties
     *
     * @return array|string[]
     */
    private function filterUnmappedProperties(array $properties): array
    {
        return array_diff($properties, self::UNMAPPED_PROPERTIES);
    }
}
