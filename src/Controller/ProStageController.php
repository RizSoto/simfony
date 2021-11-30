<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="pro_stage")
     * @Route("/entreprises", name="entrprises")
     * @Route("/formations", name="formations")
     * @Route("/stages/{id}", name="stages")
     */
    public function index(): Response
    {
        return $this->render('pro_stage/index.html.twig', [
            'controller_name' => 'ProStageController',
        ]);}
    public function entreprises(): Response
    {
        return $this->render('pro_stage/entreprises.html.twig' );}


}
