<?php

namespace App\Controller;

use App\Repository\BetRepository;
use App\Repository\BetUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BetListController extends AbstractController
{
    /**
     * @param BetUserRepository $betUserRepository
     * @param BetRepository $betRepository
     * @return Response
     * @Route("/bet/list", name="bet_list")
     */
    public function index(BetUserRepository $betUserRepository, BetRepository $betRepository): Response
    {
        $user = $this->getUser();
        $walletAmount = $user->getWallet()->getCredit();
        
        $id = $user->getId();
        $betsUser = $betUserRepository->findBy(
            ['user' => $id]
        );
        


        return $this->render('bet_list/index.html.twig', [
            'controller_name' => 'BetListController',
            'user' => $user,
            'betsUser' => $betsUser,
            'credit' => $walletAmount
        ]);
    }
}
