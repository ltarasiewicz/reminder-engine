<?php
declare(strict_types=1);

namespace AppBundle\Util\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Request\RequestBodyParamConverter as FOSRequestBodyParamConverter;
use Exception;
use FOS\RestBundle\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\Common\Persistence\ObjectManager;

class RetrievableEntityRequestBodyParamConverter extends FOSRequestBodyParamConverter
{
    /** @var ObjectManager */
    private $documentManager;
    /** @var RetrievableObjectKeysRemover */
    private $retrievableObjectKeysRemover;
    /**
     * {@inheritdoc}
     *
     * @param ObjectManager                $documentManager
     * @param RetrievableObjectKeysRemover $retrievableObjectKeysRemover
     */
    public function __construct(
        Serializer $serializer,
        $groups = null,
        $version = null,
        ValidatorInterface $validator = null,
        $validationErrorsArgument = null,
        ObjectManager $documentManager,
        RetrievableObjectKeysRemover $retrievableObjectKeysRemover
    )
    {
        parent::__construct($serializer, $groups, $version, $validator, $validationErrorsArgument);
        $this->documentManager = $documentManager;
        $this->retrievableObjectKeysRemover = $retrievableObjectKeysRemover;
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

        $classToIdMap = $this->retrievableObjectKeysRemover->removeKeys($request, $options['retrievableEntities']);

        parent::apply($request, $configuration);

        $baseObject = $request->attributes->get($configuration->getName());
        $this->setRetrievableEntitiesOnTheBaseObject($baseObject, $classToIdMap);

    }

    /**
     * @param object $baseObject
     * @param array  $classToIdMap
     */
    private function setRetrievableEntitiesOnTheBaseObject($baseObject, array $classToIdMap)
    {
        foreach ($classToIdMap as $fqcn => $id) {
            $retrievedEntity = $this->documentManager->getRepository($fqcn)->find($id);
            $setter = 'set' . substr(strrchr($fqcn, '\\'), 1);
            $baseObject->$setter($retrievedEntity);
        }
    }
}
