<?php


namespace App\Controller\Profile;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route ("user/profile", name="profile")
     */
    public function profile(): Response
    {
        return $this->render('profile/profile.html.twig', ['user' => $this->getUser()]);
    }

    /**
     * @return Response
     * @Route ("user/projects", name="projects")
     */
    public function projects(): Response
    {
        return $this->render('profile/projects.html.twig', ['user' => $this->getUser()]);
    }

    /**
     * @return Response
     * @Route ("user/purchased-projects", name="purchased-projects")
     */
    public function purchased_projects(): Response
    {
        return $this->render('profile/purchased-projects.html.twig', ['user' => $this->getUser()]);
    }
}