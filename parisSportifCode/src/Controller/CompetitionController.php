<?php


namespace App\Controller;


use App\Repository\BetRepository;
use App\Repository\CompetitionRepository;
use App\Repository\EvenementSportRepository;
use App\Repository\WalletRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompetitionController extends AbstractController
{
    /**
     * @Route("/indexuser/competition/{idCompetition}", name="competition_choice")
     * @param int $idCompetition
     * @param WalletRepository $walletRepository
     * @param BetRepository $betRepository
     * @param EvenementSportRepository $evenementSportRepository
     * @param CompetitionRepository $competitionRepository
     * @return Response
     */
    public function index(int $idCompetition, WalletRepository $walletRepository,
                          BetRepository $betRepository,
                          EvenementSportRepository $evenementSportRepository,
                          CompetitionRepository $competitionRepository): Response
    {
        $user = $this->getUser();
        $credit = $walletRepository->find($user->getWallet()->getId());

        $listEvenement = $evenementSportRepository->findBy(["sport"=> $idCompetition]);
        $lisBet = $betRepository->findAll ();
        $competition = $competitionRepository->findAll();

        return $this->render('competitions/index.html.twig',[
            'users' => $user,
            'wallet' => $credit,
            'ListEvenements' => $listEvenement,
            'listBets' => $lisBet,
            'competitions' => $competition,
        ]);
    }

}