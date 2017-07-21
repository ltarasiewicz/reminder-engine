<?php
namespace AppBundle\Controller;

use AppBundle\Document\Abstraction\IdentifiableInterface;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\Serializer;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use AppBundle\Document\Event;

class BaseRestController extends FOSRestController implements ClassResourceInterface
{
    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return ManagerRegistry
     *
     * @throws \LogicException If DoctrineBundle is not available
     */
    protected function getDoctrine()
    {
        if (!$this->container->has('doctrine_mongodb')) {
            throw new \LogicException('The MongoDBBundle is not registered in your application.');
        }

        return $this->container->get('doctrine_mongodb');
    }

    /**
     * @return ObjectManager
     */
    protected function getDocumentManager(): ObjectManager
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * @param $entity
     */
    protected function guardAgainstUnknownEntity($entity): void
    {
        if (!$entity) {
            throw new NotFoundHttpException();
        }
    }

    /**
     * Prevent modifying inretrievable entity
     *
     * If a deserialized object has an ID field populated,
     * we check if that object can be handled as an entity.
     * Deserialized objects have an ID field populated if a user
     * performs an UPDATE operation. If the deserialized object
     * does not have an ID field populated, we treat the request
     * as a CREATE request.
     *
     * // ToDo: turned that into a service
     *
     * @param IdentifiableInterface $object
     */
    protected function guardAgainstInretrievableEntity(IdentifiableInterface $object)
    {
        $id = $object->getId();
        if (null !== $id) {
            if (!$this->entityCanBeRetrieved(get_class($object), $id)) {
                throw new NotFoundHttpException();
            }
        }
    }

    /**
     * Check if a given object can be turned into an entity.
     *
     * @param string $fqcn
     * @param string $id
     *
     * @return bool
     *
     * // ToDo: Turn that into a service.
     */
    protected function entityCanBeRetrieved(string $fqcn, string $id)
    {
        return !(null === $this->getDocumentManager()->find($fqcn, $id));
    }

    /**
     * @param string $formTypeFQCN
     * @param        $entity
     *
     * @return FormInterface
     */
    public function createUnnamedForm(string $formTypeFQCN, $entity): FormInterface
    {
        $formFactory = $this->get('form.factory');

        return $formFactory->createNamed('', $formTypeFQCN, $entity);
    }

    /**
     * @return ValidatorInterface
     */
    protected function getValidator(): ValidatorInterface
    {
        return $this->get('validator');
    }

    /**
     * @return Serializer
     */
    protected function getSerializer(): Serializer
    {
        return $this->get('jms_serializer');
    }

    /**
     * @param ConstraintViolationListInterface $list
     *
     * @return bool
     */
    protected function hasValidationErrors(ConstraintViolationListInterface $list): bool
    {
        return 0 < $list->count();
    }

    /**
     * @param ConstraintViolationListInterface $list
     *
     * @return array
     */
    protected function getValidationErrorMessages(ConstraintViolationListInterface $list): array
    {
        $errorMessages = [];
        /** @var ConstraintViolation $violation */
        foreach ($list as $violation) {
            $errorMessages[] = $violation->getMessage();
        }

        return $errorMessages;
    }

    /**
     * @param ConstraintViolationListInterface $list
     *
     * @return array
     */
    protected function getConstraintViolations(ConstraintViolationListInterface $list): array
    {
        $violations = [];
        foreach ($list as $constrainViolation) {
            $violations[] = $constrainViolation;
        }

        return $violations;
    }
}
