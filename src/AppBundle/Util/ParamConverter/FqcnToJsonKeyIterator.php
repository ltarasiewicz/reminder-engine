<?php
declare(strict_types=1);

namespace AppBundle\Util\ParamConverter;

use Iterator;
use Exception;

class FqcnToJsonKeyIterator implements Iterator
{

    /** @var string[] */
    private $classNameToIdMap;

    /**
     * @param array $classNameToIdMap
     */
    public function __construct(array $classNameToIdMap)
    {
        $this->classNameToIdMap = $classNameToIdMap;
    }

    /**
     * @return string
     */
    public function current()
    {
        return current($this->classNameToIdMap);
    }

    /**
     * @return string
     */
    public function next()
    {
        return next($this->classNameToIdMap);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function key()
    {
        return $this->convertFQCNToJsonPayloadKey(key($this->classNameToIdMap));
    }

    /**
     * @return bool
     */
    public function valid()
    {
        $key = key($this->classNameToIdMap);
        return !empty($key);
    }

    /**
     * @return void
     */
    public function rewind()
    {
        reset($this->classNameToIdMap);
    }

    /**
     * @param string $fqcn E.g. "AppBundle\Document\SportingEvent"
     *
     * @throws Exception
     * @return string E.g. "sporting_event"
     */
    private function convertFQCNToJsonPayloadKey(string $fqcn): string
    {
        if (!class_exists($fqcn)) {
            throw new Exception($fqcn . ' does not exist.');
        }

        $classShortName = end(explode('\\', $fqcn));
        $jsonPayloadKey = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $classShortName));

        return $jsonPayloadKey;
    }
}
