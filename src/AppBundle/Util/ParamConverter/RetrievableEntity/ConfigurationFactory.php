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
    /** @var NumericToAssociativeArrayTransformer */
    private $numericToAssociativeArrayTransformer;

    /**
     * @param FqcnToJsonKeyTransformer             $fqcnToJsonKeyTransformer
     * @param NumericToAssociativeArrayTransformer $transformer
     */
    public function __construct(
        FqcnToJsonKeyTransformer $fqcnToJsonKeyTransformer,
        NumericToAssociativeArrayTransformer $transformer
    ) {
        $this->fqcnToJsonKeyTransformer = $fqcnToJsonKeyTransformer;
        $this->numericToAssociativeArrayTransformer = $transformer;
    }

    public function create(Request $request, array $configuration)
    {
        $retrievableEntityDefinitions = [];

        //ToDo: Validate passed configuration with the validator service

        foreach ($this->numericToAssociativeArrayTransformer->transform($configuration) as $fqcn => $config) {
            $retrievableEntityPropertyName = $this->getRetrievableEntityPropertyName($fqcn, $config);
            // ToDo: this is a quick fix to the issue in the comment below
            // ToDo: request does not have json_kyes at this point but normal properties, e.g. firstName!!! That 'venue' work was just a conincidence. venue_name would not work
            if (!$request->request->has($retrievableEntityPropertyName)) {
                continue;
            }
            $retrievableEntityIdentifierKey = $this->getRetrievableEntityIdentifierName($config);
            $retrievableEntityIdentifierValue = $this->getRetrievableEntityIdentifierValue(
                $request,
                $retrievableEntityPropertyName,
                $retrievableEntityIdentifierKey
            );
            // ToDo: there can be 2 retrieveble entities configured but only one passed in the request - this should not be an exception
            if (empty($retrievableEntityIdentifierValue)) {
                throw new Exception('Retrievable entity identifier was not found in the request content.');
            }
            $retrievableEntityDefinitions[] = new Definition(
                $fqcn,
                $retrievableEntityPropertyName,
                $retrievableEntityIdentifierValue
            );
        }

        return new Configuration($retrievableEntityDefinitions);

    }

    /**
     *
     * ToDo: Convert into a service, handle single element namespaces, test
     *
     * @param string $fqcn
     * @param array  $config
     *
     * @return string
     */
    private function getRetrievableEntityPropertyName(string $fqcn, array $config): string
    {
        return $config['propertyName'] ?? lcfirst($this->getClassShortName($fqcn));
    }

    /**

     *
     * @param string $fqcn
     *
     * @return string
     */
    private function getClassShortName(string $fqcn): string
    {
        $fqcnParts = explode('\\', $fqcn);

        return end($fqcnParts);
    }

    /**
     * @param array $config
     *
     * @return string
     */
    private function getRetrievableEntityIdentifierName(array $config): string
    {
        return $config['identifier'] ?? self::DEFAULT_IDENTIFIER;
    }

    /**
     * @param Request $request
     * @param string  $retrievableEntityPropertyName
     * @param string  $identifierKey
     *
     * @return mixed
     */
    private function getRetrievableEntityIdentifierValue(
        Request $request,
        string $retrievableEntityPropertyName,
        string $identifierKey
    ) {
        return $request->request->get($retrievableEntityPropertyName)[$identifierKey];
    }
}
