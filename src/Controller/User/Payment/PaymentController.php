<?php

namespace App\Controller\User\Payment;

use App\Entity\Crowdfunding;
use App\Entity\Payment;
use App\Form\PaymentFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    public function paymentForm(Crowdfunding $campaign): Response
    {
        $form = $this->createForm(PaymentFormType::class);

        return $this->render('user/payment/_pay_donation.html.twig', [
            'pay_donation' => $form->createView(),
            'campaign' => $campaign,
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/campaign/{id<\d+>}/payDonation", name="pay_donation")
     */
    public function payDonation(Crowdfunding $campaign, Request $request)  : Response
    {
        $donation = new Payment();
        $form = $this->createForm(PaymentFormType::class, $donation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();

            $money_collected = $campaign->getMoneyCollected();
            $new_money_collected = $money_collected + $donation->getAmount() * 100;
            $campaign->setMoneyCollected($new_money_collected);

            $campaign->addPayment($donation);
            $user->addPayment($donation);
            $em->persist($donation);
            $em->flush();
        }

        return $this->redirectToRoute('camp_view', ['id' => $campaign->getId()]);
    }
}