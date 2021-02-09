<?php

namespace App\Controller;


use App\Repository\BetRepository;
use App\Repository\CompetitionRepository;
use App\Repository\EvenementSportRepository;
use App\Repository\WalletRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexUserController extends AbstractController
{
    /**
     * @Route("/indexuser", name="index_user")
     * @param BetRepository $betRepository
     * @param WalletRepository $walletRepository
     * @param EvenementSportRepository $evenementSportRepository
     * @param CompetitionRepository $competitionRepository
     * @return Response
     */
    public function index(BetRepository $betRepository,
                          WalletRepository $walletRepository,
    EvenementSportRepository $evenementSportRepository,
    CompetitionRepository $competitionRepository): Response
    {
        $user = $this->getUser();
        $credit = $walletRepository->find($user->getWallet()->getId());
        $listEvenement = $evenementSportRepository->findAll();
        $lisBet = $betRepository->findAll ();
        $competition = $competitionRepository->findAll();
        return $this->render('index_user/index.html.twig', [
            'users' => $user,
            'wallet' => $credit,
            'ListEvenements' => $listEvenement,
            'listBets' => $lisBet,
            'competitions' => $competition,
        ]);
    }
}
