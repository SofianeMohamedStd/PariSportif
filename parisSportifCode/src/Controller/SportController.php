<?php


namespace App\Controller;


use App\Repository\BetRepository;
use App\Repository\CompetitionRepository;
use App\Repository\EvenementSportRepository;
use App\Repository\SportRepository;
use App\Repository\WalletRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SportController extends AbstractController
{
    /**
     * @Route("/sports/{sport}", name="choice_sport")
     * @param string $sport
     * @param WalletRepository $walletRepository
     * @param SportRepository $sportRepository
     * @param BetRepository $betRepository
     * @param EvenementSportRepository $evenementSportRepository
     * @param CompetitionRepository $competitionRepository
     * @return Response
     */
    public function index(string $sport, WalletRepository $walletRepository,
                          SportRepository $sportRepository,
                          BetRepository $betRepository,
                          EvenementSportRepository $evenementSportRepository,
                          CompetitionRepository $competitionRepository): Response
    {
        $user = $this->getUser();
        $credit = $walletRepository->find($user->getWallet()->getId());
        $sportP = $sportRepository->findOneBy(["name" => $sport])->getId();
        $listEvenement = $evenementSportRepository->findBy(["sport"=> $sportP]);
        $lisBet = $betRepository->findAll ();
        $competition = $competitionRepository->findAll();
        return $this->render('sports/index.html.twig',[
            'sport' => $sport,
            'users' => $user,
            'wallet' => $credit,
            'ListEvenements' => $listEvenement,
            'listBets' => $lisBet,
            'competitions' => $competition,
        ]);

    }

}