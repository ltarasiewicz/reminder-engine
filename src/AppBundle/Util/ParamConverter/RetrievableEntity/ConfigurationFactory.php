<?php
declare(strict_types=1);

namespace AppBundle\Util\ParamConverter\RetrievableEntity;

use Symfony\Component\HttpFoundation\Request;
use Exception;

class ConfigurationFactory
{
    const DEFAULT_IDENTIFIER = 'id';

    /** @var  FqcnToJsonKeyTransformer */
    private $fqcnToJsonKeyTransformer;

    /**
     * ConfigurationFactory constructor.
     *
     * @param FqcnToJsonKeyTransformer $fqcnToJsonKeyTransformer
     */
    public function __construct(FqcnToJsonKeyTransformer $fqcnToJsonKeyTransformer)
    {
        $this->fqcnToJsonKeyTransformer = $fqcnToJsonKeyTransformer;
    }

    public function create(Request $request, array $configuration)
    {
        $retrievableEntityDefinitions = [];

        //ToDo: Validate passed configuration with the validator service

        foreach ($this->flipIfArrayNumeric($configuration) as $fqcn => $config) {
            $retrievableEntityJsonKey = $this->getRetrievableEntityJsonKey($fqcn, $config);
            $identifierKey = $this->getRetrievableEntityIdentifierJsonKey($config);
            $identifierValue = $this->getRetrievableEntityIdentifierValue(
                $request,
                $retrievableEntityJsonKey,
                $identifierKey
            );
            if (empty($identifierValue)) {
                throw new Exception('Retrievable entity identifier was not found in the request content.');
            }
            $retrievableEntityDefinitions[] = new Definition($fqcn, $retrievableEntityJsonKey, $identifierValue);
        }

        return new Configuration($retrievableEntityDefinitions);

    }

    /**
     * @param string $fqcn
     * @param array  $config
     *
     * @return string
     */
    private function getRetrievableEntityJsonKey(string $fqcn, array $config): string
    {
        return $config['jsonKey'] ?? $this->fqcnToJsonKeyTransformer->convert($fqcn);
    }

    /**
     * @param array $config
     *
     * @return string
     */
    private function getRetrievableEntityIdentifierJsonKey(array $config): string
    {
        return $config['identifier'] ?? self::DEFAULT_IDENTIFIER;
    }

    /**
     * @param Request $request
     * @param string  $retrievableEntityJsonKey
     * @param string  $identifierKey
     *
     * @return mixed
     */
    private function getRetrievableEntityIdentifierValue(
        Request $request,
        string $retrievableEntityJsonKey,
        string $identifierKey
    ) {
        return $request->request->get($retrievableEntityJsonKey)[$identifierKey];
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

    /**
     * @param array $array
     *
     * @return bool
     */
    function isNumericallyIndexed(array $array): bool {
        return 0 === count(array_filter(array_keys($array), 'is_string'));
    }
}
