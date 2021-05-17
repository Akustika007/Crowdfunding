<?php


namespace App\Controller\User\Profile;


use App\Entity\Crowdfunding;
use App\Entity\User;
use App\Form\CampaignFormType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProfileController extends AbstractController
{
    private const FLASH_INFO = 'info';

    private const STATUS_DELETED = 0;

    /**
     * @Route ("user/profile", name="profile")
     */
    public function profile(PaginatorInterface $paginator, Request $request): Response
    {
        $user = $this->getUser();
        $campaigns = $user->getCrowdfunding();

        $campaigns = $paginator->paginate(
            $campaigns,
            $request->query->getInt('page', 1),
            5/*limit per page*/
        );

        return $this->render('user/profile/profile.html.twig', ['user' => $this->getUser(), 'campaigns' => $campaigns]);
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
     * @Route("/campaign/{id<\d+>}/edit", name="camp_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Crowdfunding $campaign, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CampaignFormType::class, $campaign);

        $form->handleRequest($request);
        $user = $this->getUser();
        if ($form->isSubmitted() && $form->isValid())
        {
            $campaign->setUpdatedAt(new DateTimeImmutable());
            $em->persist($campaign);
            $em->flush();
            return $this->redirectToRoute('camp_edit', ['id' => $campaign->getId()]);
        }

        return $this->render('user/campaign/edit.html.twig', [
            'campaign' => $campaign,
            'create_campaign' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/campaign/{id<\d+>}/delete", name="camp_delete")
     */
    public function deleteShop(Crowdfunding $campaign, EntityManagerInterface $em): Response
    {
        $campaign->setStatus(self::STATUS_DELETED);
        $campaign->setUpdatedAt(new DateTimeImmutable());
        $em->persist($campaign);
        $em->flush();
        return $this->redirectToRoute('profile');
    }


}