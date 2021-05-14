<?php


namespace App\Controller\User\Profile;


use App\Entity\Crowdfunding;
use App\Entity\User;
use App\Form\CampaignFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProfileController extends AbstractController
{
    private const FLASH_INFO = 'info';

    /**
     * @Route ("user/profile", name="profile")
     */
    public function profile(): Response
    {
        return $this->render('user/profile/profile.html.twig', ['user' => $this->getUser()]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/user/campaign/create", name="camp_create")
     */
    public function create(Request $request, EntityManagerInterface $em, TranslatorInterface $trans) : Response
    {
        $campaign = new Crowdfunding();
        $form = $this->createForm(CampaignFormType::class, $campaign);
        $form->handleRequest($request);
        $user = $this->getUser();


        if ($user instanceof User && $form->isSubmitted() && $form->isValid())
        {
            $campaign->setUser($user);
            $campaign->setStatus($campaign::STATUS_NEW);
            $em->persist($campaign);
            $em->flush();

            $this->addFlash(self::FLASH_INFO, $trans->trans('campaign_created'));
            return $this->redirectToRoute('profile');
        }

        return $this->render('user/campaign/create.html.twig',
            [
                'create_campaign' => $form->createView(), 'user' => $user
            ]
        );
    }

    /**
     * @return Response
     * @Route ("/user/campaign/list", name="camp_list")
     */
    public function listCampaigns(): Response
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();

        return $this->render('user/campaign/list.html.twig',
            [
                'campaigns' => $user->getCrowdfunding(),
            ]
        );
    }

}