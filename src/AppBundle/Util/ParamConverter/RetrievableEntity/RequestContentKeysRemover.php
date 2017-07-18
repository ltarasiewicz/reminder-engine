<?php
declare(strict_types=1);

namespace AppBundle\Util\ParamConverter\RetrievableEntity;

use Symfony\Component\HttpFoundation\Request;

class RequestContentKeysRemover
{
    const DEFAULT_IDENTIFIER = 'id';

    /** @var  FqcnToJsonKeyTransformer */
    private $fqcnToJsonKeyTransformer;

    /**
     * RequestContentKeysRemover constructor.
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
     * @param Request       $request
     * @param Configuration $configuration
     *
     * @return array
     */
    public function removeKeys(Request $request, Configuration $configuration): array
    {
        $classToEntityIdMap = [];
        /** @var Definition $retrievableEntityDefinition */
        foreach ($configuration as $retrievableEntityDefinition) {
            if (!empty($retrievableEntityDefinition->getId())) {
                $classToEntityIdMap[$retrievableEntityDefinition->getFqcn()] = $retrievableEntityDefinition->getId();
                $request->request->remove($retrievableEntityDefinition->getKey());
            }
        }

        return $classToEntityIdMap;
    }
}
