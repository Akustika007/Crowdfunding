<?php


namespace App\Controller\Security;


use App\Entity\User;
use App\Form\UserType;
use App\Security\AppAuthenticator;
use App\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class UserSignupController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route ("/signup", name="app_signup")
     */
    public function create(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, AppAuthenticator $authenticator): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setStatus(User::STATUS_NEW);
            $user->setRoles(["ROLE_USER"]);
            $em->persist($user);
            $em->flush();

            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('ilearningDev@gmail.com', 'ILearning Mail Bot'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route ("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request): Response
    {
    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

    // validate email confirmation link, sets User::isVerified=true and persists
    try {
        $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
    } catch (VerifyEmailExceptionInterface $exception) {
        $this->addFlash('verify_email_error', $exception->getReason());

        return $this->redirectToRoute('app_signup');
    }

    // @TODO Change the redirect on success and handle or remove the flash message in your templates
    $this->addFlash('success', 'Your email address has been verified.');

    return $this->redirectToRoute('profile');
    }
}