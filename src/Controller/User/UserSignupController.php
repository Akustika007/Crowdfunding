<?php


namespace App\Controller\User;


use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserSignupController extends AbstractController
{
    /**
     * @Route ("/signup", name="app_signup")
     */
    public function create(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);

        if(($form->isSubmitted()) && ($form->isValid()))
        {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRoles(["ROLE_USER"]);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_admin_dashboard_index');
        }

        return $this->render('user/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}