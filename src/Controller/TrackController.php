<?php

declare(strict_types=1);

namespace App\Controller;

use App\Facade\TrackFacade;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TrackController
 *
 * @author Mika Bertels <mail@mikabertels.de>
 * @package App\Controller
 */
class TrackController extends AbstractController
{
    /**
     * Instance of TrackFacade.
     *
     * @var TrackFacade
     */
    private TrackFacade $trackFacade;

    /**
     * TrackController constructor.
     *
     * @param TrackFacade $trackFacade
     */
    public function __construct(TrackFacade $trackFacade)
    {
        $this->trackFacade = $trackFacade;
    }

    /**
     * Track details.
     *
     * @param string $trackId
     *
     * @Route("/track/{trackId}", name="app_track_detail")
     *
     * @return Response
     */
    public function trackDetailAction(string $trackId): Response
    {
        return $this->render('track/track-detail.html.twig', [
            'controller_name' => 'TrackController',
            'trackDetails' => $this->trackFacade->getTrackDetails($trackId),
        ]);
    }
}
