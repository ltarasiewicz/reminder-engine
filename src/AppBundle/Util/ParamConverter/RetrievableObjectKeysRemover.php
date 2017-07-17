<?php
declare(strict_types=1);

namespace AppBundle\Util\ParamConverter;

use Symfony\Component\HttpFoundation\Request;

class RetrievableObjectKeysRemover
{
    /** @var  FQCNToJsonKeyTransformer */
    private $fqcnToJsonKeyTransformer;

    /**
     * RetrievableObjectKeysRemover constructor.
     *
     * @param FQCNToJsonKeyTransformer $fqcnToJsonKeyTransformer
     */
    public function __construct(FQCNToJsonKeyTransformer $fqcnToJsonKeyTransformer)
    {
        $this->fqcnToJsonKeyTransformer = $fqcnToJsonKeyTransformer;
    }

    /**
     * Remove
     *
     * @param Request $request
     * @param array   $classesForRemoval
     *
     * @return array
     */
    public function removeKeys(Request $request, array $classesForRemoval = []): array
    {
        $classToEntityIdMap = [];
        foreach ($classesForRemoval as $fqcn) {
            $jsonKey = $this->fqcnToJsonKeyTransformer->convert($fqcn);
            $payload = $request->request->get($jsonKey);
            if (!is_null($payload) && isset($payload['id'])) {
                $classToEntityIdMap[$fqcn] = $payload['id'];
                $request->request->remove($jsonKey);
            }
        }

        return $classToEntityIdMap;
    }
}
