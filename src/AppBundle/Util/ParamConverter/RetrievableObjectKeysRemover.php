<?php
declare(strict_types=1);

namespace AppBundle\Util\ParamConverter;

use Symfony\Component\HttpFoundation\Request;

class RetrievableObjectKeysRemover
{
    const DEFAULT_IDENTIFIER = 'id';

    /** @var  FqcnToJsonKeyTransformer */
    private $fqcnToJsonKeyTransformer;

    /**
     * RetrievableObjectKeysRemover constructor.
     *
     * @param FqcnToJsonKeyTransformer $fqcnToJsonKeyTransformer
     */
    public function __construct(FqcnToJsonKeyTransformer $fqcnToJsonKeyTransformer)
    {
        $this->fqcnToJsonKeyTransformer = $fqcnToJsonKeyTransformer;
    }

    /**
     * Modify the request,
     *
     * Remove request parameters representing retrievable entities
     *
     * ToDo: Prepare a document about this functionality
     * ToDo: Extract this functionality into a separate bundle
     * ToDo: $retrievableEntitiesFqcn shoule be replaced with a configuration object, the object should be built with a factory service
     * ToDo: All formatting and default values logic should be encapsulated in the configuration object
     *
     * @param Request $request
     * @param array   $retrievableEntitiesFqcn
     *
     * @return array
     */
    public function removeKeys(Request $request, array $retrievableEntitiesFqcn = []): array
    {
        $classToEntityIdMap = [];
        foreach ($this->flipIfArrayNumeric($retrievableEntitiesFqcn) as $fqcn => $config) {
            $retrievableEntityJsonKey = $config['jsonKey'] ?? $this->fqcnToJsonKeyTransformer->convert($fqcn);
            $identifierKey = $config['identifier'] ?? self::DEFAULT_IDENTIFIER;
            $identifierValue = $request->request->get($retrievableEntityJsonKey)[$identifierKey];
            if (!empty($identifierValue)) {
                $classToEntityIdMap[$fqcn] = $identifierValue;
                $request->request->remove($retrievableEntityJsonKey);
            }
        }

        return $classToEntityIdMap;
    }

    /**
     *
     *
     * @param array[] $retrievableEntitiesFqcn
     *
     * @return array[][]
     */
    private function flipIfArrayNumeric(array $retrievableEntitiesFqcn): array
    {
        if ($this->isNumericallyIndexed($retrievableEntitiesFqcn)) {
            return array_flip($retrievableEntitiesFqcn);
        }

        return $retrievableEntitiesFqcn;
    }

    function isNumericallyIndexed(array $array) {
        return 0 === count(array_filter(array_keys($array), 'is_string'));
    }
}
