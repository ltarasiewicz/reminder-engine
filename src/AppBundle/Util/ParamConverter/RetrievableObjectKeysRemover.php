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
     * Modify the request.
     *
     * Remove request parameters representing retrievable entities.
     *
     * ToDo: Prepare a document about this functionality
     * ToDo: Extract this functionality into a separate bundle
     * ToDo: $retrievableEntitiesFqcn shoule be replaced with a configuration object, the object should be built with a factory service
     * ToDo: All formatting and default values logic should be encapsulated in the configuration object
     *
     * @param Request                          $request
     * @param RetrievableEntityConfiguration   $configuration
     *
     * @return array
     */
    public function removeKeys(Request $request, RetrievableEntityConfiguration $configuration): array
    {
        $classToEntityIdMap = [];
        /** @var RetrievableEntityDefinition $retrievableEntityDefinition */
        foreach ($configuration as $retrievableEntityDefinition) {
            if (!empty($retrievableEntityDefinition->getId())) {
                $classToEntityIdMap[$retrievableEntityDefinition->getFqcn()] = $retrievableEntityDefinition->getId();
                $request->request->remove($retrievableEntityDefinition->getKey());
            }
        }

        return $classToEntityIdMap;
    }
}
