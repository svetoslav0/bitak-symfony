<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdStatusController extends AbstractController
{
    /**
     * @Route("/ad/status", name="ad_status")
     */
    public function index()
    {
        return $this->render('ad_status/index.html.twig', [
            'controller_name' => 'AdStatusController',
        ]);
    }
}
