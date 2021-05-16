<?php

namespace App\Controller;

use App\Repository\CrowdfundingRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @return Response
     * @Route("/", name="app_homepage")
     */
    public function index(CrowdfundingRepository $crowdfundingRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $campaigns = $crowdfundingRepository->findAll();

        $campaigns = $paginator->paginate(
            $campaigns,
            $request->query->getInt('page', 1),
            9/*limit per page*/
        );

        return $this->render('home/index.html.twig', [
            'campaigns' => $campaigns, ['user' => $this->getUser()]
        ]);
    }

    /**
     * @Route("/switch-locale/{locale}", name="switch_locale", methods={"GET"})
     */
    public function switchLocale(Request $request, string $locale): Response
    {
        $request->getSession()->set('_locale', $locale);

        return $this->redirectToRoute('app_homepage');
    }
}
