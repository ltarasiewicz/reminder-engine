<?php
declare(strict_types=1);

namespace AppBundle\Util\ParamConverter;

use Symfony\Component\HttpFoundation\Request;

class RetrievableEntitiesConfigurationFactory
{
    const DEFAULT_IDENTIFIER = 'id';

    /** @var  FqcnToJsonKeyTransformer */
    private $fqcnToJsonKeyTransformer;

    public function create(Request $request, array $configuration)
    {
        $retrievableEntityDefinitions = [];

        foreach ($this->flipIfArrayNumeric($configuration) as $fqcn => $config) {
            $retrievableEntityJsonKey = $config['jsonKey'] ?? $this->fqcnToJsonKeyTransformer->convert($fqcn);
            $identifierKey = $config['identifier'] ?? self::DEFAULT_IDENTIFIER;
            $identifier = $request->request->get($retrievableEntityJsonKey)[$identifierKey];
            $retrievableEntityDefinitions[] = new RetrievableEntityDefinition($fqcn, $retrievableEntityJsonKey, $identifier);
        }

        return $retrievableEntityDefinitions;

    }

    /**
     * // ToDo: Convert into a service, add unit tests
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
