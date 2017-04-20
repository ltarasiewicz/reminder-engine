<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\ParticipantType;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use FOS\RestBundle\Controller\Annotations\View;
use AppBundle\Document\Participant;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use FOS\RestBundle\Controller\Annotations as FOS;

class ParticipantController extends BaseRestController
{
    /**
     * @View
     * @ApiDoc(
     *     description="Return all participants",
     *     resource=true
     * )
     */
    public function cgetAction()
    {
        /** @var ManagerRegistry $doctrine */
        $doctrine = $this->getDoctrine();
        $participantRepository = $doctrine->getRepository(Participant::class);
        $participants = $participantRepository->findAll();

        return $participants;
    }

    /**
     * @View
     *
     * @ApiDoc(
     *     description="Create a participant",
     *     input="AppBundle\Form\Type\ParticipantType",
     *     statusCodes={
     *         201="Successfully created a resource",
     *         400="Submitted data did not pass validation",
     *         200="No data was submitted"
     *     }
     * )
     * @FOS\NoRoute()
     * @FOS\Post("/participants")
     *
     * @param Participant                      $participant
     * @param ConstraintViolationListInterface $validation
     * @return Response|FormInterface
     */
    public function cpostAction(Participant $participant, ConstraintViolationListInterface $validation)
    {
        if (!$this->hasValidationErrors($validation)) {
            $dm = $this->getDocumentManager();
            $dm->persist($participant);
            $dm->flush();

            return new Response('', Response::HTTP_CREATED);
        }

        return new Response('Wrong?');
    }

    /**
     * @ApiDoc(
     *     description="Get a participant by email address."
     * )
     *
     * @param $emailAddress string
     * @return Participant
     */
    public function getEmailAction($emailAddress)
    {
        $participantRepository = $this->getDocumentManager()->getRepository(Participant::class);

        /** @var Participant $participant */
        $participant = $participantRepository->findOneBy(['emailAddress' => $emailAddress]);

        if (!$participant) {
            throw $this->createNotFoundException(
                sprintf('Participant with an email address %s has not been found', $emailAddress)
            );
        }

        return $participant;
    }
}
