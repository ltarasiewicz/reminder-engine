<?php
declare(strict_types=1);

namespace AppBundle\Util\ParamConverter\RetrievableEntity;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Request\RequestBodyParamConverter as FOSRequestBodyParamConverter;
use Exception;
use FOS\RestBundle\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\Common\Persistence\ObjectManager;

class RequestBodyParamConverter extends FOSRequestBodyParamConverter
{
    /** @var ObjectManager */
    private $documentManager;
    /** @var RequestParametersRemover */
    private $requestParametersRemover;
    /** @var ConfigurationFactory */
    private $configurationFactory;

    /**
     * {@inheritdoc}
     *
     * @param ObjectManager             $documentManager
     * @param RequestParametersRemover $requestContentKeysRemover
     * @param ConfigurationFactory      $configurationFactory
     */
    public function __construct(
        Serializer $serializer,
        $groups = null,
        $version = null,
        ValidatorInterface $validator = null,
        $validationErrorsArgument = null,
        ObjectManager $documentManager,
        RequestParametersRemover $requestParametersRemover,
        ConfigurationFactory $configurationFactory
    )
    {
        parent::__construct($serializer, $groups, $version, $validator, $validationErrorsArgument);
        $this->documentManager = $documentManager;
        $this->requestParametersRemover = $requestParametersRemover;
        $this->configurationFactory = $configurationFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $options = $configuration->getOptions();
        if (!isset($options['retrievableEntities'])) {
            throw new Exception('retrievableEntities option is required.');
        }

        $retrievableEntitiesConfiguration = $this->configurationFactory
            ->create($request, $options['retrievableEntities'])
        ;

        $classToIdMap = $this->requestParametersRemover->remove($request, $retrievableEntitiesConfiguration);

        parent::apply($request, $configuration);

        $baseObject = $request->attributes->get($configuration->getName());
        $this->setRetrievableEntitiesOnTheBaseObject($baseObject, $classToIdMap);
    }

    /**
     * ToDo: Could be converted into a service
     *
     * @param object $baseObject
     * @param array  $fqcnToIdMap
     */
    private function setRetrievableEntitiesOnTheBaseObject($baseObject, array $fqcnToIdMap)
    {
        foreach ($fqcnToIdMap as $fqcn => $id) {
            $retrievedEntity = $this->documentManager->getRepository($fqcn)->find($id);
            $setter = 'set' . substr(strrchr($fqcn, '\\'), 1);
            $baseObject->$setter($retrievedEntity);
        }
    }
}
