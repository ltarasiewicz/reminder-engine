<?php

namespace AppBundle\Controller;

use AppBundle\Document\Event;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Document\Participant;
use AppBundle\Form\Type\ParticipantType;
use FOS\RestBundle\Controller\Annotations as FOS;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class EventController extends BaseRestController
{
    /**
     * @ApiDoc(
     *     description="Return all Events.",
     *     resource=true
     * )
     * @View()
     */
    public function cgetAction()
    {
        /** @var ManagerRegistry $doctrine */
        $doctrine = $this->getDoctrine();
        $eventRepository = $doctrine->getRepository(Event::class);
        $events = $eventRepository->findAll();

        return $events;
    }

    /**
     * @ApiDoc(
     *     description="Create an Event or update an existing Event.",
     *      parameters={
     *          {"name"="title", "dataType"="string", "required"=true, "format"="", "description"=""},
     *          {"name"="start_time", "dataType"="datetime", "required"=false, "format"="datetime string", "description"=""},
     *          {"name"="end_time", "dataType"="datetime", "required"=false, "format"="datetime string", "description"=""},
     *          {"name"="venue", "dataType"="array", "required"=false, "format"="", "description"=""}
     *  }
     * )
     * @ParamConverter("event", converter="fos_rest.request_body")
     * @FOS\View()
     * @FOS\NoRoute()
     * @FOS\Post("/events")
     */
    public function cpostAction(Event $event, ConstraintViolationListInterface $validation)
    {
        //$this->guardAgainstInretrievableEntity($event);

        if (!$this->hasValidationErrors($validation)) {
            $dm = $this->getDocumentManager();
            $dm->persist($event);
            $dm->flush();

            return new Response('', Response::HTTP_CREATED);
        }

        return new Response('Wrong?');
    }

    /**
     * @ApiDoc(
     *     description="Edit an Event"
     * )
     *
     * @ParamConverter("event", converter="doctrine.odm", class="AppBundle\Document\Event")
     * @ParamConverter("newEvent", converter="fos_rest.request_body")
     *
     * @FOS\View()
     * @FOS\NoRoute()
     * @FOS\Patch("/event/{id}/edit")
     *
     * @param Event $event    Doctrine entity, representation of the edited Event
     * @param Event $newEvent Deserialized Event class, representation of the edit changes
     */
    public function patchAction(Event $event, Event $newEvent)
    {
        $objectPropertyMapper = $this->get('app.util.object_property_mapper');
        $objectPropertyMapper->mapObjectProperties($event, $newEvent);
        $this->getDocumentManager()->flush();
    }

    /**
     * @View
     * @ApiDoc(
     *     description="Remove a participant from an event",
     *     requirements={
     *         {
     *              "name"="eventId",
     *              "dataType"="string",
     *              "requirement"="[^\s]+",
     *              "description"="The ID of event to modify."
     *         },
     *         {
     *              "name"="participantId",
     *              "dataType"="string",
     *              "requirement"="[^\s]+",
     *              "description"="The ID of event to modify."
     *         }
     *     }
     * )
     */ // ToDo: User a ParamConverter to inject an Event and Participant objects as controller arguments
    public function deleteParticipantAction($eventId, $participantId)
    {
        $dm = $this->getDocumentManager();

        $eventRepository = $dm->getRepository(Event::class);
        $participantRepository = $dm->getRepository(Participant::class);

        $event = $eventRepository->find($eventId);
        $participant = $participantRepository->find($participantId);

        $this->guardAgainstUnknownEntity($event);
        $this->guardAgainstUnknownEntity($participant);

        $event->removeParticipant($participant);

        $dm->flush();
    }

    ///**
    // * @View
    // *
    // * @ApiDoc(
    // *     description="Create a participant and add him to an event as a guest.",
    // *     input="AppBundle\Form\Type\ParticipantType"
    // *
    // * )
    // *
    // * @param string  $eventId
    // * @param Request $request
    // * @return FormInterface|Response
    // */
    //public function patchAction($eventId, Request $request)
    //{
    //    $participant = new Participant();
    //    $form = $this->createForm(ParticipantType::class, $participant, ['method' => 'PATCH']);
    //    $form->handleRequest($request);
    //
    //    if ($form->isValid()) {
    //        $dm = $this->getDocumentManager();
    //        $eventRepository = $dm->getRepository(Event::class);
    //        $event = $eventRepository->find($eventId);
    //        $this->guardAgainstUnknownEntity($event);
    //        $event->addGuest($participant);
    //        $dm->flush();
    //
    //        return new Response('Added a nes participant to an event', Response::HTTP_OK);
    //    }
    //    return $form;
    //}
}
