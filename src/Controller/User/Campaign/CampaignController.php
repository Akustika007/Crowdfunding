<?php


namespace App\Controller\User\Campaign;


use App\Entity\Crowdfunding;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CampaignController extends AbstractController
{

    /**
     * @return Response
     * @Route ("/campaign/{id<\d+>}", name="camp_view")
     */
    public function viewCampaigns(Crowdfunding $campaign): Response
    {
        return $this->render('user/campaign/view.html.twig',
            [
                'campaign' => $campaign
            ]
        );
    }
}