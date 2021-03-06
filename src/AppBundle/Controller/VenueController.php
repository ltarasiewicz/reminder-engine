<?php

namespace AppBundle\Controller;

use AppBundle\Document\Venue;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VenueController extends BaseRestController
{
    /**
     * @ApiDoc(
     *     resource=true,
     *     resourceDescription="Creating, editing and retrieving venues",
     *     description="Return all venues.",
     * )
     * @View
     */
    public function cgetAction()
    {
        /** @var ManagerRegistry $doctrine */
        $doctrine = $this->getDoctrine();
        $venueRepository = $doctrine->getRepository(Venue::class);
        $venues = $venueRepository->findAll();

        return $venues;
    }

    /**
     * @ApiDoc(
     *     description="Create a venue.",
     *     requirements={
     *         {
     *             "name"="short_name",
     *             "dataType"="string",
     *             "requirement"=".+",
     *             "description"="Short representation of the venue"
     *         }
     *     },
     *     parameters={
     *         {
     *              "name"="country",
     *              "dataType"="string",
     *              "required"=false, "format"=".+",
     *              "description"=""
     *          },
     *         {
     *              "name"="city",
     *              "dataType"="string",
     *              "required"=false,
     *              "format"=".+",
     *              "description"=""
     *          },
     *         {
     *              "name"="province",
     *              "dataType"="string",
     *              "required"=false,
     *              "format"=".+",
     *              "description"=""
     *          },
     *         {
     *              "name"="street_address",
     *              "dataType"="string",
     *              "required"=false,
     *              "format"=".+",
     *              "description"=""
     *          },
     *         {
     *              "name"="contact_number",
     *              "dataType"="string",
     *              "required"=false,
     *              "format"="\d+",
     *              "description"=""
     *          }
     *     }
     * )
     * @View
     */
    public function cpostAction(Request $request)
    {
        $venue = $this->getSerializer()->deserialize($request->getContent(), Venue::class, 'json');
        $validation = $this->getValidator()->validate($venue);

        if (!$this->hasValidationErrors($validation)) {
            $dm = $this->getDocumentManager();
            $dm->persist($venue);
            $dm->flush();

            return new Response('', Response::HTTP_CREATED);
        }

        return new Response('Wrong?');
    }
}
