<?php

declare(strict_types=1);

namespace App\Controller;

use App\Facade\SearchFacade;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SearchController
 *
 * @author Mika Bertels <mail@mikabertels.de>
 * @package App\Controller
 */
class SearchController extends AbstractController
{
    /**
     * Instance of SearchFacade.
     *
     * @var SearchFacade
     */
    private SearchFacade $searchFacade;

    /**
     * SearchController constructor.
     *
     * @param SearchFacade $searchFacade
     */
    public function __construct(SearchFacade $searchFacade)
    {
        $this->searchFacade = $searchFacade;
    }

    /**
     * Search action.
     *
     * @param Request $request
     *
     * @Route("/search", name="app_search")
     *
     * @return Response
     */
    public function searchResultAction(Request $request): Response
    {
        $searchQuery = $request->get('searchQuery');

        return $this->render('search/search.html.twig', [
            'controller_name' => 'SearchController',
            'searchResult' => $this->searchFacade->search($searchQuery),
        ]);
    }
}
