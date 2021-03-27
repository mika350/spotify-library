<?php

declare(strict_types=1);

namespace App\Controller;

use App\Facade\ArtistFacade;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArtistController
 *
 * @author Mika Bertels <mail@mikabertels.de>
 * @package App\Controller
 */
class ArtistController extends AbstractController
{
    /**
     * Instance of ArtistFacade.
     *
     * @var ArtistFacade
     */
    private ArtistFacade $artistFacade;

    /**
     * ArtistController constructor.
     *
     * @param ArtistFacade $artistFacade
     */
    public function __construct(ArtistFacade $artistFacade)
    {
        $this->artistFacade = $artistFacade;
    }

    /**
     * Artist details.
     *
     * @param string $artistId
     *
     * @Route("/artist/{artistId}", name="app_artist_detail")
     *
     * @return Response
     */
    public function artistDetailAction(string $artistId): Response
    {
        return $this->render('artist/artist-detail.html.twig', [
            'controller_name' => 'ArtistController',
            'artist' => $this->artistFacade->getArtistDetails($artistId),
        ]);
    }
}
