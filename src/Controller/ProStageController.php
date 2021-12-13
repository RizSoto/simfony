<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="pro_stage")
     */
    public function index(): Response
    {
        return $this->render('pro_stage/index.html.twig', [
            'controller_name' => 'ProStageController',
        ]);}
    /**
     * @Route("/entreprises", name="entreprises")
     */
    public function entreprises() 
    {
        return $this->render('pro_stage/entreprises.html.twig' );}
    /**
     * @Route("/formations", name="formations")
     */
    public function formations() 
    {
        return $this->render('pro_stage/formations.html.twig' );}
    /**
     * @Route("/stages/{id}", name="stages")
     */
    public function stages($id) 
    {
        return $this->render('pro_stage/stages.html.twig',['idStages'=>$id] );}


}
