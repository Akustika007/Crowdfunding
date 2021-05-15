<?php


namespace App\Controller\Service;



use Doctrine\ORM\EntityManagerInterface;

class CampaignManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
}