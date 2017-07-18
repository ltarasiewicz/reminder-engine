<?php
declare(strict_types=1);

namespace AppBundle\JMS;

use AppBundle\Document\EmailAddress;
use Doctrine\Common\Persistence\ObjectManager;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonDeserializationVisitor;
use Exception;

class RetrievableEntityDeserializationHandler implements SubscribingHandlerInterface
{
    /** @var ObjectManager */
    private $documentManager;

    /**
     * @param ObjectManager $documentManager
     */
    public function __construct(ObjectManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    public static function getSubscribingMethods()
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format'    => 'json',
                'type'      => 'RetrievableEntity223<AppBundle\Document\EmailAddress>',
                'method'    => 'deserializeRetrievableEntity',
            ],
            [
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format'    => 'json',
                'type'      => 'RetrievableEntity223<AppBundle\Document\PhoneNumber>',
                'method'    => 'deserializeRetrievableEntity',
            ],
        ];
    }
    // ToDo: Clean that up, add checking if @Type has expected format - throw an exception if it does not
    public function deserializeRetrievableEntity(
        JsonDeserializationVisitor $visitor,
        $entityRepresentation,
        array $type,
        Context $context
    ) {

        $deserializationTargetClass = $this->extractDeserializationTargetFQCN($type);
        $emailAddressRepository = $this->documentManager->getRepository($deserializationTargetClass);
        $retrievedEmailAddress = $emailAddressRepository->find($entityRepresentation);

        if (!is_null($retrievedEmailAddress)) {
            return $retrievedEmailAddress;
        }

        $type['name'] = $deserializationTargetClass;

        return $visitor->getNavigator()->accept($entityRepresentation, $type, $context);
    }

    /**
     * @param array $type
     *
     * @return string
     * @throws Exception
     */
    private function extractDeserializationTargetFQCN(array $type): string
    {
        if (empty(preg_match('/<(.+)>/', $type['name'], $matches))) {
            throw new Exception('Retrievable Entity @Type declaration is incorrect.');
        }

        return $matches[1];
    }
}
