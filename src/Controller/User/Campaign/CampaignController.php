<?php


namespace App\Controller\User\Campaign;


use App\Entity\Bonus;
use App\Entity\Comment;
use App\Entity\Crowdfunding;
use App\Entity\User;
use App\Form\BonusFormType;
use App\Form\CampaignFormType;
use App\Form\CommentFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class CampaignController extends AbstractController
{
    private const FLASH_INFO = 'info';

    /**
     * @return Response
     * @Route ("/campaign/{id<\d+>}", name="camp_view")
     */
    public function viewCampaigns(Crowdfunding $campaign): Response
    {
        $createdAt = $campaign->getCreatedAt()->format('F d, Y \a\t H:i');
        $leftTime = (date_diff($campaign->getFinishedAt(), $campaign->getCreatedAt()))->format('%d');
        return $this->render('user/campaign/view.html.twig',
            [
                'leftTime' => $leftTime,
                'createdTime' => $createdAt,
                'campaign' => $campaign,
            ]
        );
    }

    public function commentForm(Crowdfunding $campaign): Response
    {
        $form = $this->createForm(CommentFormType::class);

        return $this->render('user/campaign/_comment_form.html.twig', [
            'form' => $form->createView(),
            'campaign' => $campaign,
        ]);
    }

    /**
     * @Route("/campaign/{id<\d+>}/comment/new", name="comment_new", methods={"POST"})
     */
    public function newComment(Request $request, Crowdfunding $campaign): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $campaign->addComment($comment);
            $user->addComment($comment);

            $em->persist($comment);
            $em->flush();
        }

        return $this->redirectToRoute('camp_view', ['id' => $campaign->getId()]);
    }

    public function bonusForm(Crowdfunding $campaign): Response
    {
        $form = $this->createForm(BonusFormType::class);

        return $this->render('user/campaign/_create_bonus.html.twig', [
            'create_bonus' => $form->createView(),
            'campaign' => $campaign,
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/campaign/{id<\d+>}/create_bonus", name="bonus_create")
     */
    public function createBonus(Crowdfunding $campaign, Request $request)  : Response
    {
        $bonus = new Bonus();
        $form = $this->createForm(BonusFormType::class, $bonus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $campaign->addBonus($bonus);
            $em->persist($bonus);
            $em->flush();
        }

        return $this->redirectToRoute('camp_view', ['id' => $campaign->getId()]);
    }
}