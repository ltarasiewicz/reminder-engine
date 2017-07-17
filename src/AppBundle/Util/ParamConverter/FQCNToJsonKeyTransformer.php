<?php
declare(strict_types=1);

namespace AppBundle\Util\ParamConverter;

class FQCNToJsonKeyTransformer
{
    /**
     * @param string $fqcn E.g. "AppBundle\Document\SportingEvent"
     *
     * @return string E.g. "sporting_event"
     */
    public function convert(string $fqcn): string
    {
        $fqcnParts = explode('\\', $fqcn);
        $classShortName = end($fqcnParts);
        $jsonPayloadKey = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $classShortName));

        return $jsonPayloadKey;
    }
}
