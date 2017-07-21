<?php
declare(strict_types=1);

namespace AppBundle\Util\ParamConverter\RetrievableEntity;

use Symfony\Component\HttpFoundation\Request;

class RequestParametersRemover
{
    const DEFAULT_IDENTIFIER = 'id';

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
    public function remove(Request $request, Configuration $configuration): array
    {
        $classToEntityIdMap = [];
        /** @var Definition $retrievableEntityDefinition */
        foreach ($configuration as $retrievableEntityDefinition) {
            if (!empty($retrievableEntityDefinition->getId())) {
                $classToEntityIdMap[$retrievableEntityDefinition->getFqcn()] = $retrievableEntityDefinition->getId();
                $request->request->remove($retrievableEntityDefinition->getPropertyName());
            }
        }

        return $classToEntityIdMap;
    }
}
